<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back  = 'en-us/dashboard/admin/edit-event.php';
$id    = input_int('id');
$token = input('token');
$link  = validate_url(input('link'));

if ($id === null || $token === '' || mb_strlen($token) > 50 || $link === null) {
    flash_back('All of the form must be filled (token max 50, valid http(s) WhatsApp link).', $back);
}

db_query('UPDATE scrim_token SET token = ?, wa_link = ? WHERE id = ?', [$token, $link, $id]);
flash('Data Updated Successfully');
redirect($back); // back to the list, not to the edit form
