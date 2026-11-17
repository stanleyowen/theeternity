<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user       = require_player();
$back       = lang_dir(current_lang()) . '/dashboard/upload-center.php';
$membership = require_membership($user, current_lang());

// "Each User can ONLY upload ONCE" — now enforced on the server, not with a cookie.
if (!empty($membership['squad_pic'])) {
    flash_back('Each User can ONLY upload ONCE', $back);
}

try {
    $name = store_image_upload('file', 'logo-squad', 500 * 1024);
} catch (UploadError $e) {
    flash_back($e->getMessage(), $back);
}

$updated = db_query('UPDATE scrim_member SET squad_pic = ? WHERE id = ? AND squad_pic IS NULL', [$name, $membership['id']])->rowCount();
if ($updated === 0) {
    delete_upload('logo-squad', $name); // lost a race with a parallel upload
    flash_back('Each User can ONLY upload ONCE', $back);
}
flash_back('Photo Uploaded Successfully.', $back);
