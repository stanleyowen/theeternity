<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

// Clears one match's result for one participant (the 2020 handler deleted the whole participant).
$queries = [
    1 => 'UPDATE scrim_member SET rank_1 = NULL, kill_1 = NULL WHERE username = ?',
    2 => 'UPDATE scrim_member SET rank_2 = NULL, kill_2 = NULL WHERE username = ?',
];

$username = input('username');
$match    = input_int('match');
if ($username !== '' && $match !== null && isset($queries[$match])) {
    db_query($queries[$match], [$username]);
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/scrim-result.php');
