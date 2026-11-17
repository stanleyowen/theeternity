<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/present-participant.php';
if (input('code') !== 'CONFIRM') {
    flash_back('Confirmation Code Mismatch', $back);
}

db_query('DELETE FROM present_participant');
flash_back('Record Deleted Successfully!', $back);
