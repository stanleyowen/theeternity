<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back     = 'en-us/dashboard/admin/scrim-result.php';
$username = input('username');
$rank     = input_int('rank');
$kill     = input_int('kill');

if ($username === '' || $rank === null || $rank < 1 || $rank > 100 || $kill === null || $kill < 0 || $kill > 99) {
    flash_back('All of the form must be filled (rank 1-100, total kill 0-99).', $back);
}
if (db_value('SELECT 1 FROM scrim_member WHERE username = ?', [$username]) === null) {
    flash_back('Participant not found', $back);
}

db_query('UPDATE scrim_member SET rank_2 = ?, kill_2 = ? WHERE username = ?', [$rank, $kill, $username]);
flash('Data Updated Successfully');
redirect($back);
