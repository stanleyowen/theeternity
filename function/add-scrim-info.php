<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user = require_admin();

$back        = 'en-us/dashboard/admin/scrim-info.php';
$header      = input('header');
$code        = input('code');
$description = input('description');

if ($header === '' || $description === '') {
    flash_back('All of the form must be filled!', $back);
}
if (mb_strlen($header) > 255 || mb_strlen($description) > 5000) {
    flash_back('Header can be max 255 characters and Description max 5000 characters.', $back);
}
if ($code !== '' && !preg_match('/^[A-Za-z0-9]{1,20}$/', $code)) {
    flash_back('Code may only contain letters and numbers (max 20 characters).', $back);
}

// A code makes the post hidden (only visible to players who enter it).
$type = $code !== '' ? 'hidden' : 'public';

db_query(
    'INSERT INTO scrim_info (type, code, posted_by, date, header, description) VALUES (?, ?, ?, ?, ?, ?)',
    [$type, $code !== '' ? $code : null, $user['username'], now_string(), $header, $description]
);
flash_back('Scrim Info Created Successfully', $back);
