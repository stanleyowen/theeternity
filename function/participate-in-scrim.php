<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
$user = require_player();
$lang = current_lang();
$back = lang_dir($lang) . '/dashboard/participate-scrim.php';

$eventId = input_int('event_id');
if ($eventId === null || input('term1') === '' || input('term2') === '') {
    flash_back('All Scrim Form Must be Checked.', $back);
}
if (!db_value('SELECT 1 FROM scrim_token WHERE id = ?', [$eventId])) {
    flash_back('This scrim event does not exist.', $back);
}
if (membership_for($user['username']) !== null) {
    flash_back('You have participated in a SCRIM before.', $back);
}

db_query('INSERT INTO scrim_member (event_id, username, date) VALUES (?, ?, ?)', [$eventId, $user['username'], now_string()]);
flash('Successfully Participated The Scrim');
redirect(lang_dir($lang) . '/dashboard/join-group.php');
