<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user       = require_player();
$back       = lang_dir(current_lang()) . '/dashboard/submit-result.php';
$membership = require_membership($user, current_lang());

if (honeypot_tripped()) {
    redirect_back($back); // bots get no feedback
}

$eventId = input_int('id');
$rank    = input_int('rank');
$kill    = input_int('kill');

if ($eventId === null || $rank === null || $kill === null) {
    flash_back('All of the Form must be Filled!', $back);
}
if ($eventId !== (int) $membership['event_id']) {
    flash_back('Please choose the scrim event you participated in.', $back);
}
if ($rank < 1 || $rank > 100 || $kill < 0 || $kill > 99) {
    flash_back('Rank must be between 1 and 100, and Kill between 0 and 99.', $back);
}

// "Each User can ONLY fill ONCE" — enforced in the database (was a deletable cookie).
$updated = db_query(
    'UPDATE scrim_member SET rank_1 = ?, kill_1 = ? WHERE id = ? AND rank_1 IS NULL',
    [$rank, $kill, $membership['id']]
)->rowCount();
if ($updated === 0) {
    flash_back('Each User can ONLY fill ONCE', $back);
}
flash_back('Result Submitted', $back);
