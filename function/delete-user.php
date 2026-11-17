<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$admin = require_admin();

$back = 'en-us/dashboard/admin/edit-user.php';
$id   = input_int('id');

if ($id === null) {
    flash_back('User not found.', $back);
}
if ($id === (int) $admin['id']) {
    flash_back('You cannot ban your own account.', $back);
}

$target = db_one('SELECT id, username FROM users WHERE id = ?', [$id]);
if ($target === null) {
    flash_back('User not found.', $back);
}

$member = db_one('SELECT squad_pic, ig_proof, ig_proof_2 FROM scrim_member WHERE username = ?', [$target['username']]);

$pdo = db();
$pdo->beginTransaction();
try {
    db_query('DELETE FROM present_participant WHERE name = ?', [$target['username']]);
    // scrim_member cascades from users via FK, but delete explicitly for MySQL setups without it.
    db_query('DELETE FROM scrim_member WHERE username = ?', [$target['username']]);
    db_query('DELETE FROM users WHERE id = ?', [$target['id']]);
    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
}

// Remove the uploaded files only once the rows are gone.
if ($member !== null) {
    delete_upload('logo-squad', $member['squad_pic']);
    delete_upload('ig-proof', $member['ig_proof']);
    delete_upload('ig-proof-2', $member['ig_proof_2']);
}
flash_back('Data Deleted Successfully!', $back);
