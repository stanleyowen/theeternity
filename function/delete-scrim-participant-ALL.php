<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/user-upload.php';
if (input('code') !== 'CONFIRM') {
    flash_back('Confirmation Code Mismatch', $back);
}

$members = db_all('SELECT squad_pic, ig_proof, ig_proof_2 FROM scrim_member');
db_query('DELETE FROM scrim_member');
// Files are removed after the rows, so a failed DELETE never leaves rows pointing at missing files.
foreach ($members as $m) {
    delete_upload('logo-squad', $m['squad_pic']);
    delete_upload('ig-proof', $m['ig_proof']);
    delete_upload('ig-proof-2', $m['ig_proof_2']);
}
flash_back('Record Deleted Successfully!', $back);
