<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user       = require_player();
$back       = lang_dir(current_lang()) . '/dashboard/upload-center.php';
$membership = require_membership($user, current_lang());

// "Each User can ONLY upload ONCE" — now enforced on the server, not with a cookie.
if (!empty($membership['ig_proof'])) {
    flash_back('Each User can ONLY upload ONCE', $back);
}

try {
    $name = store_image_upload('file', 'ig-proof', 500 * 1024);
} catch (UploadError $e) {
    flash_back($e->getMessage(), $back);
}

$updated = db_query('UPDATE scrim_member SET ig_proof = ? WHERE id = ? AND ig_proof IS NULL', [$name, $membership['id']])->rowCount();
if ($updated === 0) {
    delete_upload('ig-proof', $name); // lost a race with a parallel upload
    flash_back('Each User can ONLY upload ONCE', $back);
}
flash_back('Photo Uploaded Successfully.', $back);
