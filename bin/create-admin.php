<?php
declare(strict_types=1);

/**
 * Create (or reset the password of) an administrator account — live mode only.
 *
 *   php bin/create-admin.php "Admin Name"
 *
 * The password is read from STDIN so it never appears in shell history.
 * (The 2020 build let anyone pick "Administrator" on the login form.)
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('DB_WRITABLE', true);
require __DIR__ . '/../app/bootstrap.php';

$username = trim($argv[1] ?? '');
if ($username === '' || mb_strlen($username) > 50) {
    fwrite(STDERR, "Usage: php bin/create-admin.php \"username\"  (max 50 characters)\n");
    exit(1);
}

fwrite(STDOUT, 'Password (min 12 characters): ');
$tty = DIRECTORY_SEPARATOR === '/' && function_exists('posix_isatty') && posix_isatty(STDIN);
if ($tty) {
    shell_exec('stty -echo');
}
$password = rtrim((string) fgets(STDIN), "\r\n");
if ($tty) {
    shell_exec('stty echo');
}
fwrite(STDOUT, PHP_EOL);

if (mb_strlen($password) < 12) {
    fwrite(STDERR, "Password must be at least 12 characters.\n");
    exit(1);
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$existing = db_one('SELECT id FROM users WHERE username = ?', [$username]);
if ($existing) {
    db_query('UPDATE users SET password_hash = ?, role = ? WHERE id = ?', [$hash, ROLE_ADMIN, $existing['id']]);
    echo "Updated administrator '{$username}'.\n";
} else {
    db_query('INSERT INTO users (username, password_hash, role, created_at) VALUES (?, ?, ?, ?)', [$username, $hash, ROLE_ADMIN, now_string()]);
    echo "Created administrator '{$username}'.\n";
}
