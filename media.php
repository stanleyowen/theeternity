<?php
declare(strict_types=1);

/**
 * Serves uploaded images from storage/ (outside the web root).
 * Gallery images are public; squad logos and Instagram proofs are admin-only
 * (in 2020 they sat in a public folder with guessable names).
 */

require __DIR__ . '/app/bootstrap.php';

$bucket = input('b', '', $_GET);
$name   = input('f', '', $_GET);

if (!isset(UPLOAD_BUCKETS[$bucket]) || !preg_match(UPLOAD_NAME_PATTERN, $name)) {
    require APP_ROOT . '/global-error/404.php';
    exit;
}
if (!UPLOAD_BUCKETS[$bucket]['public'] && !is_admin()) {
    require APP_ROOT . '/global-error/403.php';
    exit;
}

$path = upload_dir($bucket) . '/' . $name;
if (!is_file($path)) {
    require APP_ROOT . '/global-error/404.php';
    exit;
}

while (ob_get_level() > 0) {
    ob_end_clean();
}
header('Content-Type: ' . (str_ends_with($name, '.png') ? 'image/png' : 'image/jpeg'));
header('Content-Length: ' . filesize($path));
header('Content-Disposition: inline; filename="' . $name . '"');
header('Cache-Control: ' . (UPLOAD_BUCKETS[$bucket]['public'] ? 'public, max-age=86400' : 'private, no-store'));
readfile($path);
