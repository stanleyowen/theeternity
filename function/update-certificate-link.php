<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/create-certificate-list.php';
$id   = input_int('id');
$raw  = input('link');
$link = $raw === '' ? null : validate_url($raw); // an empty link clears it

if ($id === null || ($raw !== '' && $link === null)) {
    flash_back('Please enter a valid http(s) link of max 500 characters, or leave it empty to remove the link.', $back);
}

db_query('UPDATE scrim_token SET certi_link = ? WHERE id = ?', [$link, $id]);
flash('Data Updated Successfully');
redirect($back);
