<?php
declare(strict_types=1);

/**
 * Public form handlers shared by the EN and ID pages (login, register, feedback).
 * CSRF and the archive gate are enforced before these run (see bootstrap.php).
 */

const FEEDBACK_TYPES = ['improvement', 'report-bug', 'comment', 'others'];
const USERNAME_PATTERN = '/^[\p{L}\p{N} _.\-]{3,50}$/u';

/** Bots fill hidden fields; humans do not. */
function honeypot_tripped(): bool
{
    return input('honeypot') !== '';
}

/** @return string[] errors (empty array when nothing was submitted) */
function handle_login_form(): array
{
    if (!is_post() || !isset($_POST['login_user']) || honeypot_tripped()) {
        return [];
    }
    $lang     = current_lang();
    $username = input('_username');
    $password = (string) ($_POST['_password'] ?? '');
    $errors   = [];

    if ($username === '') {
        $errors[] = 'Username is required';
    }
    if ($password === '') {
        $errors[] = 'Password is required';
    }
    if ($errors !== []) {
        return $errors;
    }

    $userKey = hash_hmac('sha256', mb_strtolower($username), Config::appKey());
    if (rate_limited('login', 10, 900) || rate_limited('login-user', 5, 900, $userKey)) {
        return ['Too many failed login attempts. Please wait 15 minutes and try again.'];
    }

    $user = attempt_login($username, $password);
    if ($user === null) {
        rate_hit('login');
        rate_hit('login-user', $userKey);
        // The role is no longer chosen on the form; it always comes from the database.
        return ["Username and Password don't match our credentials. Haven't registered? Sign up on the Register page."];
    }

    login_user($user);
    redirect(dashboard_path($user, $lang));
}

/** @return string[] */
function handle_register_form(): array
{
    if (!is_post() || !isset($_POST['reg_user']) || honeypot_tripped()) {
        return [];
    }
    $lang     = current_lang();
    $username = input('_username');
    $password = (string) ($_POST['_password'] ?? '');
    $confirm  = (string) ($_POST['_confirmpassword'] ?? '');
    $errors   = [];

    if ($username === '') {
        $errors[] = 'Username is required';
    } elseif (!preg_match(USERNAME_PATTERN, $username)) {
        $errors[] = 'Username must be 3–50 characters: letters, numbers, spaces, dot, dash or underscore';
    }
    if ($password === '') {
        $errors[] = 'Password is required';
    } elseif (mb_strlen($password) < 8 || mb_strlen($password) > 128) {
        $errors[] = 'Password must be between 8 and 128 characters';
    }
    if (!hash_equals($password, $confirm)) {
        $errors[] = 'Password and Confirmation Password Mismatch';
    }
    if ($errors === [] && db_value('SELECT 1 FROM users WHERE username = ?', [$username])) {
        $errors[] = 'Username has been used. Try using another username.';
    }
    if ($errors === [] && rate_limited('register', 3, 86400)) {
        $errors[] = 'Too many accounts were registered from your network today. Please try again later.';
    }
    if ($errors !== []) {
        return $errors;
    }

    db_query(
        'INSERT INTO users (username, password_hash, role, created_at) VALUES (?, ?, ?, ?)',
        [$username, password_hash($password, PASSWORD_DEFAULT), ROLE_USER, now_string()]
    );
    rate_hit('register');
    $user = db_one('SELECT id, username, role FROM users WHERE username = ?', [$username]);
    login_user($user);
    flash('User Created Successfully.');
    redirect(lang_dir($lang) . '/dashboard/index.php');
}

/** @return string[] errors or a single success message */
function handle_feedback_form(): array
{
    if (!is_post() || !isset($_POST['send_feedback']) || honeypot_tripped()) {
        return [];
    }
    $name    = input('_name');
    $email   = input('_email');
    $type    = input('_type');
    $comment = input('_comment');
    $errors  = [];

    if ($name === '') {
        $errors[] = 'Name is required';
    } elseif (mb_strlen($name) > 40) {
        $errors[] = 'Name can only contain maximum 40 characters';
    }
    if ($email === '') {
        $errors[] = 'Email is required';
    } elseif (mb_strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    if (!in_array($type, FEEDBACK_TYPES, true)) {
        $errors[] = 'Feedback Type is required';
    }
    if ($comment === '') {
        $errors[] = 'Comment form is required';
    } elseif (mb_strlen($comment) > 2000) {
        $errors[] = 'Comment can only contain maximum 2000 characters';
    }
    if ($errors === [] && rate_limited('feedback', 1, 86400)) {
        $errors[] = 'Each User can only submit 1 Feedback each day.';
    }
    if ($errors !== []) {
        return $errors;
    }

    db_query(
        'INSERT INTO message (name, email, comment, type, date) VALUES (?, ?, ?, ?, ?)',
        [encrypt_text($name), encrypt_text($email), encrypt_text($comment), $type, now_string()]
    );
    rate_hit('feedback');
    flash('Feedback sent! Thank You!');
    redirect_back(lang_dir(current_lang()) . '/index.php');
}
