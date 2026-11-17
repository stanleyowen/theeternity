<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/scrim-result.php';
if (input('code') !== 'CONFIRM') {
    flash_back('Confirmation Code Mismatch', $back);
}

// Clears every result but keeps the participants (the 2020 handler wiped scrim_member entirely).
db_query('UPDATE scrim_member SET rank_1 = NULL, kill_1 = NULL, rank_2 = NULL, kill_2 = NULL');
flash_back('Data Deleted Successfully', $back);
