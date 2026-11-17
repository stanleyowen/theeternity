<?php
declare(strict_types=1);

/**
 * Front controller bootstrap — every PHP entry point requires this file first.
 * It sets up error handling, a hardened session, security headers, and the two
 * central request guards: CSRF verification and the archive (read-only) gate.
 */

define('APP_ROOT', dirname(__DIR__));
date_default_timezone_set('Asia/Jakarta');

require APP_ROOT . '/app/config.php';
require APP_ROOT . '/app/db.php';
require APP_ROOT . '/app/security.php';
require APP_ROOT . '/app/i18n.php';
require APP_ROOT . '/app/auth.php';
require APP_ROOT . '/app/uploads.php';
require APP_ROOT . '/app/views.php';
require APP_ROOT . '/app/forms.php';

/* ---- Errors: never leak details to visitors, always log ------------------ */
error_reporting(E_ALL);
ini_set('display_errors', Config::isProduction() ? '0' : '1');
ini_set('log_errors', '1');

set_exception_handler(static function (Throwable $e): void {
    error_log('[eternity] ' . $e::class . ': ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, $e . PHP_EOL);
        exit(1);
    }
    while (ob_get_level() > 0) {
        ob_end_clean(); // discard the half-rendered page
    }
    if (!headers_sent()) {
        http_response_code(500);
    }
    if (!Config::isProduction()) {
        echo '<pre>' . e((string) $e) . '</pre>';
        return;
    }
    require APP_ROOT . '/global-error/500.php';
});

if (PHP_SAPI === 'cli') {
    return; // CLI scripts (bin/) only need config + database.
}

ob_start();

/* ---- Session: opaque id only, HttpOnly, SameSite, Secure on HTTPS --------- */
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_trans_sid', '0');
ini_set('session.gc_maxlifetime', '7200');
session_name('eternity_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => base_path() . '/',
    'secure'   => is_https(),
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

send_security_headers();

/* ---- Central guard 1: CSRF on every POST ---------------------------------- */
if (is_post() && !csrf_valid($_POST['_csrf'] ?? null)) {
    // An oversized upload empties $_POST entirely; give a clearer message for that case.
    $tooLarge = empty($_POST) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0;
    flash($tooLarge ? 'File size too large.' : t('csrf_failed'));
    redirect_back(lang_dir(current_lang()) . '/index.php');
}

/* ---- Central guard 2: archive mode is read-only --------------------------- */
// Only endpoints that explicitly opt in (demo sign-in, logout) may accept POSTs.
if (is_post() && Config::archiveMode() && !defined('ALLOW_IN_ARCHIVE')) {
    flash(t('archive_write'));
    redirect_back(lang_dir(current_lang()) . '/index.php');
}
