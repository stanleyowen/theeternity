<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$id = input_int('id');
if ($id !== null) {
    // Deleting the event cascades to its scrim_member rows; remove their uploaded files too.
    $members = db_all('SELECT squad_pic, ig_proof, ig_proof_2 FROM scrim_member WHERE event_id = ?', [$id]);
    db()->beginTransaction();
    db_query('DELETE FROM scrim_member WHERE event_id = ?', [$id]);
    db_query('DELETE FROM scrim_token WHERE id = ?', [$id]);
    db()->commit();
    foreach ($members as $m) {
        delete_upload('logo-squad', $m['squad_pic']);
        delete_upload('ig-proof', $m['ig_proof']);
        delete_upload('ig-proof-2', $m['ig_proof_2']);
    }
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/edit-event.php');
