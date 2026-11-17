<?php
declare(strict_types=1);

/**
 * Image uploads.
 *
 * 2020 build: kept the client's filename (overwrites, path tricks), checked only
 * the extension, stored files inside the web root, and the gallery upload had
 * no authentication at all.
 *
 * Now: size + MIME sniffing + real image decode, random server-side names,
 * re-encoding through GD when available (strips metadata / polyglot payloads),
 * and storage outside the web root, served only through media.php.
 */

const UPLOAD_BUCKETS = [
    'gallery'    => ['public' => true],
    'logo-squad' => ['public' => false],
    'ig-proof'   => ['public' => false],
    'ig-proof-2' => ['public' => false],
];

const UPLOAD_MIME_EXT = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
];

const UPLOAD_NAME_PATTERN = '/^[a-f0-9]{32}\.(jpg|png)$/';

final class UploadError extends RuntimeException {}

function upload_dir(string $bucket): string
{
    if (!isset(UPLOAD_BUCKETS[$bucket])) {
        throw new InvalidArgumentException('Unknown upload bucket.');
    }
    $dir = Config::storagePath('uploads/' . $bucket);
    if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
        throw new RuntimeException('Upload directory is not writable.');
    }
    return $dir;
}

/**
 * Validate and store an uploaded image. Returns the generated file name.
 * @throws UploadError with a user-facing message
 */
function store_image_upload(string $field, string $bucket, int $maxBytes): string
{
    $file = $_FILES[$field] ?? null;
    if (!is_array($file) || !isset($file['error']) || is_array($file['error'])) {
        throw new UploadError('Please choose a photo to be uploaded');
    }
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        throw new UploadError('Please choose a photo to be uploaded');
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > $maxBytes) {
        throw new UploadError(sprintf('File size too large. Please upload a file under %d kB', intdiv($maxBytes, 1024)));
    }
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        throw new UploadError('Sorry, there was an error uploading the file.');
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) ?: '';
    $info = @getimagesize($file['tmp_name']);
    if (!isset(UPLOAD_MIME_EXT[$mime]) || $info === false || ($info['mime'] ?? '') !== $mime) {
        throw new UploadError('Only photo with extension JPEG, JPG, and PNG are allowed.');
    }
    if ($info[0] < 1 || $info[1] < 1 || $info[0] * $info[1] > 40_000_000) {
        throw new UploadError('Image dimensions are not supported.');
    }

    $name   = bin2hex(random_bytes(16)) . '.' . UPLOAD_MIME_EXT[$mime];
    $target = upload_dir($bucket) . '/' . $name;

    if (!reencode_image($file['tmp_name'], $target, $mime) && !move_uploaded_file($file['tmp_name'], $target)) {
        throw new UploadError('Sorry, there was an error uploading the file.');
    }
    @chmod($target, 0640);
    return $name;
}

/** Re-encode through GD to drop anything that is not pixel data. Returns false if GD is unavailable. */
function reencode_image(string $source, string $target, string $mime): bool
{
    if (!extension_loaded('gd')) {
        return false;
    }
    $img = $mime === 'image/png' ? @imagecreatefrompng($source) : @imagecreatefromjpeg($source);
    if ($img === false) {
        throw new UploadError('The image could not be read. Please upload a valid JPEG or PNG.');
    }
    if ($mime === 'image/png') {
        imagesavealpha($img, true);
        $ok = imagepng($img, $target, 6);
    } else {
        $ok = imagejpeg($img, $target, 88);
    }
    imagedestroy($img);
    return $ok;
}

function delete_upload(string $bucket, ?string $name): void
{
    if ($name === null || !preg_match(UPLOAD_NAME_PATTERN, $name)) {
        return;
    }
    $path = upload_dir($bucket) . '/' . $name;
    if (is_file($path)) {
        @unlink($path);
    }
}

/** URL for an uploaded file, served by media.php (never directly from disk). */
function media_url(string $bucket, ?string $name): string
{
    if ($name === null || !preg_match(UPLOAD_NAME_PATTERN, $name)) {
        return '';
    }
    return url('media.php') . '?' . http_build_query(['b' => $bucket, 'f' => $name]);
}
