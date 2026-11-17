<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$username = input('username');
$member   = $username !== ''
    ? db_one('SELECT squad_pic, ig_proof, ig_proof_2 FROM scrim_member WHERE username = ?', [$username])
    : null;

if ($member !== null) {
    db_query('DELETE FROM scrim_member WHERE username = ?', [$username]);
    // Files are removed after the row, so a failed DELETE never leaves a row pointing at missing files.
    delete_upload('logo-squad', $member['squad_pic']);
    delete_upload('ig-proof', $member['ig_proof']);
    delete_upload('ig-proof-2', $member['ig_proof_2']);
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/user-upload.php');
