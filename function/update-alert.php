<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back        = 'en-us/dashboard/admin/edit-alert.php';
$id          = input_int('id');
$link        = validate_url(input('link'));
$description = input('description');
$type        = input('alert_type');

if ($id === null || $link === null || $description === '' || mb_strlen($description) > 500 || !in_array($type, ['success', 'warning', 'danger'], true)) {
    flash_back('All of the form must be filled with a valid http(s) link and a description of max 500 characters.', $back);
}

db_query('UPDATE alerts_info SET description = ?, link = ?, type = ? WHERE id = ?', [$description, $link, $type, $id]);
flash('Alert Updated Successfully');
redirect($back); // back to the list, not to the edit form
