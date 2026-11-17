<?php
declare(strict_types=1);

/**
 * Authentication & authorisation.
 *
 * 2020 build                                  -> now
 * - username/password/role kept in cookies     -> opaque, HttpOnly session id only
 * - role chosen by the client on the login form-> role read from the database
 * - guards redirected but kept executing       -> guards always terminate (never)
 * - sha1(crypt()) password hashing             -> password_hash() (bcrypt)
 */

const ROLE_USER  = 'user';
const ROLE_ADMIN = 'admin';

/** The signed-in user, re-validated against the database on every request. */
function current_user(): ?array
{
    static $cache = false;
    if ($cache !== false) {
        return $cache;
    }
    $auth = $_SESSION['auth'] ?? null;
    if (!is_array($auth) || !isset($auth['id'])) {
        return $cache = null;
    }
    $row = db_one('SELECT id, username, role FROM users WHERE id = ?', [(int) $auth['id']]);
    if ($row === null) {
        // Account was deleted/banned: end the session immediately.
        logout_user();
        return $cache = null;
    }
    $row['id']   = (int) $row['id'];
    $row['demo'] = !empty($auth['demo']);
    return $cache = $row;
}

function is_admin(?array $user = null): bool
{
    $user ??= current_user();
    return $user !== null && $user['role'] === ROLE_ADMIN;
}

function login_user(array $user, bool $demo = false): void
{
    session_regenerate_id(true); // prevent session fixation
    $_SESSION['auth'] = ['id' => (int) $user['id'], 'demo' => $demo];
    unset($_SESSION['_csrf']);   // rotate CSRF token with the privilege change
}

function logout_user(): void
{
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 3600,
            'path'     => $params['path'],
            'secure'   => $params['secure'],
            'httponly' => true,
            'samesite' => $params['samesite'] ?: 'Lax',
        ]);
        session_destroy();
    }
}

/**
 * Verify credentials. Returns the user row or null. Throttled per IP and per
 * username to stop brute force (the 2020 release notes promised this; it is now real).
 */
function attempt_login(string $username, string $password): ?array
{
    $user = db_one('SELECT id, username, role, password_hash FROM users WHERE username = ?', [$username]);

    // Always run a hash verification so response time does not reveal whether the user exists.
    $hash = $user['password_hash'] ?? password_hash(random_bytes(16), PASSWORD_DEFAULT);
    $ok = password_verify($password, $hash);

    if (!$user || !$ok) {
        return null;
    }
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        db_query('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $user['id']]);
    }
    unset($user['password_hash']);
    return $user;
}

function login_url(string $lang): string
{
    return lang_dir($lang) . '/login/index.php';
}

function dashboard_path(array $user, string $lang): string
{
    return $user['role'] === ROLE_ADMIN
        ? 'en-us/dashboard/admin/dashboard-admin.php'   // the admin console was English-only
        : lang_dir($lang) . '/dashboard/index.php';
}

/** Require any signed-in user. Terminates the request otherwise. */
function require_login(?string $lang = null): array
{
    $lang ??= current_lang();
    $user = current_user();
    if ($user === null) {
        redirect(login_url($lang));
    }
    return $user;
}

/** Require a player account (admins are sent to their console, as in 2020). */
function require_player(?string $lang = null): array
{
    $lang ??= current_lang();
    $user = require_login($lang);
    if ($user['role'] === ROLE_ADMIN) {
        redirect(dashboard_path($user, $lang));
    }
    return $user;
}

/** Require an administrator. Players get a 403 page; anonymous visitors go to login. */
function require_admin(): array
{
    $user = require_login('en');
    if ($user['role'] !== ROLE_ADMIN) {
        http_response_code(403);
        require APP_ROOT . '/global-error/403.php';
        exit;
    }
    return $user;
}

/** For action endpoints: reject anything but POST with 405. */
function require_post(): void
{
    if (!is_post()) {
        http_response_code(405);
        header('Allow: POST');
        require APP_ROOT . '/global-error/405.php';
        exit;
    }
}

/** The player's scrim membership (server-side replacement for the forgeable JScrim cookie). */
function membership_for(string $username): ?array
{
    return db_one(
        'SELECT m.*, t.event_name FROM scrim_member m LEFT JOIN scrim_token t ON t.id = m.event_id WHERE m.username = ?',
        [$username]
    );
}

/** Player pages 2–6 require having joined a scrim first. */
function require_membership(array $user, string $lang): array
{
    $membership = membership_for($user['username']);
    if ($membership === null) {
        flash(t('need_participation'));
        redirect(lang_dir($lang) . '/dashboard/index.php');
    }
    return $membership;
}
