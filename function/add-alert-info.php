<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back        = 'en-us/dashboard/admin/edit-alert.php';
$link        = validate_url(input('link'));
$description = input('description');
$type        = input('alert_type');

if ($link === null || $description === '' || mb_strlen($description) > 500 || !in_array($type, ['success', 'warning', 'danger'], true)) {
    flash_back('All of the Form must be Filled with a valid http(s) link and a description of max 500 characters!', $back);
}

db_query('INSERT INTO alerts_info (description, link, type) VALUES (?, ?, ?)', [$description, $link, $type]);
flash_back('Alert Added Successfully', $back);
