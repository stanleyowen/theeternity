<?php
declare(strict_types=1);

/**
 * Archive-only: start a read-only demo session as the seeded player or admin
 * so visitors can explore the dashboards. Disabled when ARCHIVE_MODE is off.
 */

define('ALLOW_IN_ARCHIVE', true);
require __DIR__ . '/../app/bootstrap.php';

require_post();
$lang = input('lang') === 'id' ? 'id' : 'en';
set_lang($lang);

if (!Config::archiveMode()) {
    http_response_code(404);
    require APP_ROOT . '/global-error/404.php';
    exit;
}

$role = input('as') === ROLE_ADMIN ? ROLE_ADMIN : ROLE_USER;
$demoAccounts = [ROLE_USER => 'Demo Squad', ROLE_ADMIN => 'Eternity Admin'];
$user = db_one('SELECT id, username, role FROM users WHERE username = ? AND role = ?', [$demoAccounts[$role], $role]);
if ($user === null) {
    flash_back('The demo account is not available.', login_url($lang));
}

login_user($user, true);
redirect(dashboard_path($user, $lang));
