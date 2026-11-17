<?php
declare(strict_types=1);

/*
 * Gallery photo upload. In 2020 this endpoint had no authentication at all and
 * kept the client's file name inside the web root; it is now admin-only and
 * goes through the hardened upload pipeline (see app/uploads.php).
 */

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/edit-gallery.php';

try {
    $name = store_image_upload('file', 'gallery', 2 * 1024 * 1024);
} catch (UploadError $e) {
    flash_back($e->getMessage(), $back);
}

try {
    db_query('INSERT INTO gallery (file_name, uploaded_on) VALUES (?, ?)', [$name, now_string()]);
} catch (Throwable $e) {
    delete_upload('gallery', $name); // do not leave an orphaned file behind
    throw $e;
}
flash_back('Photo Uploaded Successfully.', $back);
