<?php
declare(strict_types=1);

/**
 * Archive seed data.
 *
 * The original 2020 production database no longer exists, so this file
 * recreates representative content that matches how the site was used:
 * scrim announcements, a scrim event, participating squads, results and
 * attendance. It lets visitors explore every page of the archive.
 *
 * Seeded accounts get random, unknowable passwords: nobody can sign in with
 * them. The archive is explored through demo sessions instead (see
 * global-validation/demo-login.php). Loaded by bin/init-db.php --seed.
 */

if (!defined('APP_ROOT')) {
    exit;
}

$pdo = db();
$pdo->beginTransaction();

$unusablePassword = static fn (): string => password_hash(bin2hex(random_bytes(24)), PASSWORD_DEFAULT);

/* ---- Accounts ------------------------------------------------------------ */
$users = [
    ['Eternity Admin', 'admin', '2020-08-01 10:00:00'],
    ['Demo Squad', 'user', '2020-09-08 19:12:44'],
    ['Crimson Wolves', 'user', '2020-09-08 20:03:10'],
    ['Medan Raiders', 'user', '2020-09-09 08:41:57'],
    ['Nightfall', 'user', '2020-09-09 13:27:05'],
    ['Phoenix Rise', 'user', '2020-09-10 16:55:31'],
    ['Silent Storm', 'user', '2020-09-11 21:09:18'],
];
foreach ($users as [$name, $role, $created]) {
    db_query('INSERT INTO users (username, password_hash, role, created_at) VALUES (?, ?, ?, ?)', [$name, $unusablePassword(), $role, $created]);
}

/* ---- Site alert ---------------------------------------------------------- */
db_query('INSERT INTO alerts_info (description, link, type) VALUES (?, ?, ?)', [
    'Eternity v0.11 is live: SSL, multi-language support and new security layers.',
    'https://instagram.com/eternity_esports.id',
    'success',
]);

/* ---- Event posts --------------------------------------------------------- */
$posts = [
    ['public', null, '2020-09-08 07:45:00', 'Eternity Scrim Season 1 — Registration Open',
        "Registration for our first PUBG Mobile scrim season is now open!\nSlots: 25 squads + 5 waiting list (first come, first served).\nRegister your squad account, then open Dashboard > Participate in a Scrim.\nPlease read the Terms and Conditions before joining."],
    ['public', null, '2020-09-12 18:30:00', 'Scrim Schedule & Room Rules',
        "Match 1: Erangel — 19:30 WIB\nMatch 2: Miramar — 20:15 WIB\nThe scrim token will be shared in the WhatsApp group 3–12 hours before the scrim. Late attendance = absent.\nCheating, emulators, teaming and joki are strictly prohibited."],
    ['public', null, '2020-09-16 22:05:00', 'Season 1 Results & E-Certificates',
        "Thank you to every squad that joined Eternity Scrim Season 1!\nResults have been verified by the admin team. E-Certificates for the TOP #10 squads are available in the Dashboard under 'Download Certificates'.\nUnited We Stand, Divided We Fall."],
    ['hidden', '20200915', '2020-09-15 09:00:00', 'Room ID & Password (Participants Only)',
        "This post was only visible to registered squads through its private code.\nRoom details were shared here 30 minutes before each match."],
];
foreach ($posts as [$type, $code, $date, $header, $description]) {
    db_query('INSERT INTO scrim_info (type, code, posted_by, date, header, description) VALUES (?, ?, ?, ?, ?, ?)', [$type, $code, 'Admin', $date, $header, $description]);
}

/* ---- Scrim event --------------------------------------------------------- */
db_query('INSERT INTO scrim_token (event_name, scrim_id, token, wa_link, certi_link) VALUES (?, ?, ?, ?, ?)', [
    'Eternity Scrim Season 1', 'ETR-S1', 'ETR2020', 'https://wa.me/message/SGOS5RUB46CUA1', null,
]);
$eventId = (int) $pdo->lastInsertId();

/* ---- Squads, results, attendance ----------------------------------------- */
$demoLogo = null;
$source = APP_ROOT . '/assets/img/etr-img-1.jpeg';
if (is_file($source)) {
    // Deterministic names keep static exports reproducible (real uploads still get random names).
    $demoLogo = substr(hash('sha256', 'logo-squad:' . hash_file('sha256', $source)), 0, 32) . '.jpg';
    copy($source, upload_dir('logo-squad') . '/' . $demoLogo);
}

$members = [
    // username,        joined,                logo,      r1, k1, r2, k2
    ['Demo Squad',      '2020-09-09 20:15:02', $demoLogo, 4,  7,  2,  11],
    ['Crimson Wolves',  '2020-09-09 21:40:19', null,      1,  14, 3,  9],
    ['Medan Raiders',   '2020-09-10 09:02:48', null,      2,  10, 1,  16],
    ['Nightfall',       '2020-09-10 14:33:51', null,      3,  8,  5,  6],
    ['Phoenix Rise',    '2020-09-11 17:20:06', null,      6,  5,  4,  8],
    ['Silent Storm',    '2020-09-12 10:08:37', null,      5,  6,  6,  4],
];
foreach ($members as [$name, $joined, $logo, $r1, $k1, $r2, $k2]) {
    db_query(
        'INSERT INTO scrim_member (event_id, username, date, squad_pic, rank_1, kill_1, rank_2, kill_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        [$eventId, $name, $joined, $logo, $r1, $k1, $r2, $k2]
    );
}

$present = [
    ['Crimson Wolves', '2020-09-15 18:02:11'],
    ['Medan Raiders', '2020-09-15 18:05:40'],
    ['Demo Squad', '2020-09-15 18:11:27'],
    ['Nightfall', '2020-09-15 18:20:03'],
    ['Silent Storm', '2020-09-15 18:47:55'],
    ['Phoenix Rise', '2020-09-15 19:01:32'],
];
foreach ($present as [$name, $date]) {
    db_query('INSERT INTO present_participant (name, event_id, date) VALUES (?, ?, ?)', [$name, $eventId, $date]);
}

/* ---- Gallery --------------------------------------------------------------- */
if (is_file($source)) {
    $galleryName = substr(hash('sha256', 'gallery:' . hash_file('sha256', $source)), 0, 32) . '.jpg';
    copy($source, upload_dir('gallery') . '/' . $galleryName);
    db_query('INSERT INTO gallery (file_name, uploaded_on) VALUES (?, ?)', [$galleryName, '2020-09-08 07:40:00']);
}

/* ---- Inbox (encrypted at rest, like real submissions) --------------------- */
$messages = [
    ['Archive Sample', 'player@example.com', 'improvement', 'Could you add a match 3 slot to the result form for longer scrims?', '2020-09-13 21:14:09'],
    ['Archive Sample', 'squad@example.com', 'comment', 'First scrim was super smooth, the attendance token system is great. See you next season!', '2020-09-16 23:02:47'],
];
foreach ($messages as [$name, $email, $type, $comment, $date]) {
    db_query('INSERT INTO message (name, email, comment, type, date) VALUES (?, ?, ?, ?, ?)', [
        encrypt_text($name), encrypt_text($email), encrypt_text($comment), $type, $date,
    ]);
}

$pdo->commit();
