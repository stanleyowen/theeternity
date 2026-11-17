<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back         = 'en-us/dashboard/admin/edit-event.php';
$name         = input('name');
$scrimId      = input('scrim_id');
$link         = validate_url(input('link'));
$token        = input('token');
$confirmToken = input('confirmtoken');

if ($name === '' || mb_strlen($name) > 100
    || $scrimId === '' || mb_strlen($scrimId) > 50
    || $link === null
    || $token === '' || mb_strlen($token) > 50
    || $confirmToken === '') {
    flash_back('All of the form must be filled (event name max 100, scrim ID and token max 50, valid http(s) WhatsApp link).', $back);
}
if (!hash_equals($token, $confirmToken)) {
    flash_back('Confirmation Token Mismatch', $back);
}

db_query('INSERT INTO scrim_token (event_name, scrim_id, token, wa_link) VALUES (?, ?, ?, ?)', [$name, $scrimId, $token, $link]);
flash_back('Scrim Event Created Successfully', $back);
