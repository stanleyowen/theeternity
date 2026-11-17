<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back     = 'en-us/dashboard/admin/edit-user.php';
$username = input('username');
$role     = input('role');
$password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
$confirm  = is_string($_POST['confirmpassword'] ?? null) ? $_POST['confirmpassword'] : '';

if ($username === '' || $password === '' || $confirm === '') {
    flash_back('All of the form must be filled!', $back);
}
if (!preg_match(USERNAME_PATTERN, $username)) {
    flash_back('Username must be 3–50 characters: letters, numbers, spaces, dot, dash or underscore', $back);
}
if (mb_strlen($password) < 8 || mb_strlen($password) > 128) {
    flash_back('Password must be between 8 and 128 characters', $back);
}
if (!hash_equals($password, $confirm)) {
    flash_back('Confirmation Password Mismatch', $back);
}
if (!in_array($role, [ROLE_USER, ROLE_ADMIN], true)) {
    flash_back('Please choose a valid Role/Level.', $back);
}
if (db_value('SELECT 1 FROM users WHERE username = ?', [$username])) {
    flash_back('Username have been used. Please try Another.', $back);
}

try {
    db_query(
        'INSERT INTO users (username, password_hash, role, created_at) VALUES (?, ?, ?, ?)',
        [$username, password_hash($password, PASSWORD_DEFAULT), $role, now_string()]
    );
} catch (PDOException $e) {
    if ((string) $e->getCode() === '23000') { // unique constraint: lost a race with a parallel insert
        flash_back('Username have been used. Please try Another.', $back);
    }
    throw $e;
}
flash_back('User Created Successfully', $back);
