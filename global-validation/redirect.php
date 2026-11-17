<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

// "Join Scrim" button: signed-in players go to the scrim sign-up page, everyone else to login.
$lang = ($_GET['lang'] ?? '') === 'id' ? 'id' : 'en';
set_lang($lang);

$user = current_user();
if ($user === null) {
    redirect(login_url($lang));
}
redirect($user['role'] === ROLE_ADMIN ? dashboard_path($user, $lang) : lang_dir($lang) . '/dashboard/participate-scrim.php');
