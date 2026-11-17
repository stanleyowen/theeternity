<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$name = input('name');
if ($name !== '') {
    db_query('DELETE FROM present_participant WHERE name = ?', [$name]);
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/present-participant.php');
