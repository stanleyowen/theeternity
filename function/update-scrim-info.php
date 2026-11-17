<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user = require_admin();

$back        = 'en-us/dashboard/admin/scrim-info.php';
$id          = input_int('id');
$header      = input('header');
$code        = input('code');
$description = input('description');

if ($id === null || $header === '' || $description === '') {
    flash_back('All of the form must be filled.', $back);
}
if (mb_strlen($header) > 255 || mb_strlen($description) > 5000) {
    flash_back('Header can be max 255 characters and Description max 5000 characters.', $back);
}
if ($code !== '' && !preg_match('/^[A-Za-z0-9]{1,20}$/', $code)) {
    flash_back('Code may only contain letters and numbers (max 20 characters).', $back);
}

$type = $code !== '' ? 'hidden' : 'public';

// As in 2020, an update re-stamps the post with the editing admin and the current time.
db_query(
    'UPDATE scrim_info SET type = ?, code = ?, posted_by = ?, date = ?, header = ?, description = ? WHERE id = ?',
    [$type, $code !== '' ? $code : null, $user['username'], now_string(), $header, $description, $id]
);
flash('Scrim Info Updated Successfully');
redirect($back); // back to the list, not to the edit form
