<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user       = require_player();
$back       = lang_dir(current_lang()) . '/dashboard/attendance.php';
$membership = require_membership($user, current_lang());

$eventId = input_int('id');
$token   = input('token');

if ($token === '') {
    flash_back('Token Field is required', $back);
}
// Players can only check in to the scrim they actually joined.
if ($eventId === null || $eventId !== (int) $membership['event_id']) {
    flash_back('Please choose the scrim event you participated in.', $back);
}

// Scrim tokens are short; stop players from guessing them.
$rateKey = hash_hmac('sha256', $user['username'], Config::appKey());
if (rate_limited('attendance', 10, 3600, $rateKey)) {
    flash_back('Too many wrong tokens. Please wait 1 hour and try again.', $back);
}

$expected = db_value('SELECT token FROM scrim_token WHERE id = ?', [$eventId]);
if (!is_string($expected) || $expected === '' || !hash_equals($expected, $token)) {
    rate_hit('attendance', $rateKey);
    flash_back('Token Mismatch, please try again', $back);
}

if (db_value('SELECT 1 FROM present_participant WHERE name = ?', [$user['username']])) {
    flash_back('Cannot do 2 times attendance. Thank You', $back);
}

try {
    db_query('INSERT INTO present_participant (name, event_id, date) VALUES (?, ?, ?)', [$user['username'], $eventId, now_string()]);
} catch (PDOException $e) {
    if (str_starts_with((string) $e->getCode(), '23')) { // UNIQUE(name): lost a race with a parallel submit
        flash_back('Cannot do 2 times attendance. Thank You', $back);
    }
    throw $e;
}
flash_back('Attendance was successfully done! Thank You', $back);
