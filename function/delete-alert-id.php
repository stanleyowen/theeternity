<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$id = input_int('id');
if ($id !== null) {
    db_query('DELETE FROM alerts_info WHERE id = ?', [$id]);
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/edit-alert.php');
