<?php
declare(strict_types=1);

/* -------------------------------------------------------------------------
 * Output escaping
 * ---------------------------------------------------------------------- */

/** Escape for HTML text and attribute context. Use on EVERY dynamic value. */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/** Escape multi-line text and keep its line breaks (replaces the old enter() helper). */
function e_multiline(mixed $value): string
{
    return nl2br(e($value), false);
}

/** Only http(s) URLs may be rendered as links; anything else (javascript:, data:) becomes '#'. */
function safe_url(?string $url): string
{
    $url = trim((string) $url);
    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        return '#';
    }
    $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
    return in_array($scheme, ['http', 'https'], true) ? $url : '#';
}

/** Validate an admin-entered link. Returns the normalised URL or null. */
function validate_url(?string $url, int $max = 500): ?string
{
    $url = trim((string) $url);
    if ($url === '' || strlen($url) > $max) {
        return null;
    }
    return safe_url($url) === '#' ? null : $url;
}

/* -------------------------------------------------------------------------
 * Request helpers
 * ---------------------------------------------------------------------- */

function is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if (Config::trustProxy()) {
        return strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
    }
    return false;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/** Read a trimmed string from $_POST / $_GET, never an array. */
function input(string $key, string $default = '', ?array $source = null): string
{
    $source ??= is_post() ? $_POST : $_GET;
    $value = $source[$key] ?? $default;
    return is_string($value) ? trim($value) : $default;
}

function input_int(string $key, ?array $source = null): ?int
{
    $value = input($key, '', $source);
    if ($value === '' || !preg_match('/^-?\d{1,9}$/', $value)) {
        return null;
    }
    return (int) $value;
}

function client_ip(): string
{
    // Behind a trusted reverse proxy (e.g. Caddy), the real client is the last
    // address the proxy appended to X-Forwarded-For; earlier entries are client-controlled.
    if (Config::trustProxy() && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $hops = array_map('trim', explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']));
        $last = end($hops);
        if ($last !== false && filter_var($last, FILTER_VALIDATE_IP)) {
            return $last;
        }
    }
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

/** Privacy-preserving identifier for rate limiting (we never store raw IPs). */
function ip_fingerprint(): string
{
    return hash_hmac('sha256', client_ip(), Config::appKey());
}

/* -------------------------------------------------------------------------
 * CSRF protection — one random token per session, compared in constant time.
 * Every POST is verified centrally in bootstrap.php.
 * ---------------------------------------------------------------------- */

function csrf_token(): string
{
    if (empty($_SESSION['_csrf']) || !is_string($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(?string $token): bool
{
    return is_string($token)
        && !empty($_SESSION['_csrf'])
        && hash_equals((string) $_SESSION['_csrf'], $token);
}

/* -------------------------------------------------------------------------
 * Flash messages & redirects.
 * The 2020 site used alert(...) + history.back(); we keep the same alert UX
 * (rendered by assets/js/app.js) without inline scripts.
 * ---------------------------------------------------------------------- */

function flash(string $message): void
{
    $_SESSION['_flash'][] = $message;
}

function take_flash(): array
{
    $messages = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return is_array($messages) ? $messages : [];
}

/** Redirect to an application-relative path and stop. */
function redirect(string $path): never
{
    header('Location: ' . url($path), true, 303);
    exit;
}

/**
 * Redirect back to the referring page when it is on this site, else to $fallback.
 * Never redirects off-site (no open redirect).
 */
function redirect_back(string $fallback): never
{
    $referer = (string) ($_SERVER['HTTP_REFERER'] ?? '');
    if ($referer !== '') {
        $parts = parse_url($referer);
        $host  = $_SERVER['HTTP_HOST'] ?? '';
        $refHost = ($parts['host'] ?? '') . (isset($parts['port']) ? ':' . $parts['port'] : '');
        $path  = $parts['path'] ?? '';
        if ($refHost !== '' && hash_equals($host, $refHost) && str_starts_with($path, '/') && !str_starts_with($path, '//')) {
            $location = $path . (isset($parts['query']) ? '?' . $parts['query'] : '');
            header('Location: ' . $location, true, 303);
            exit;
        }
    }
    redirect($fallback);
}

/** Flash a message and go back — the server-side equivalent of alert() + history.back(). */
function flash_back(string $message, string $fallback): never
{
    flash($message);
    redirect_back($fallback);
}

/* -------------------------------------------------------------------------
 * Encryption at rest (AES-256-GCM, random IV, authenticated).
 * Replaces AES-256-CBC with an empty IV, which was deterministic and unauthenticated.
 * ---------------------------------------------------------------------- */

function encrypt_text(string $plain): string
{
    $iv  = random_bytes(12);
    $tag = '';
    $cipher = openssl_encrypt($plain, 'aes-256-gcm', Config::appKey(), OPENSSL_RAW_DATA, $iv, $tag);
    if ($cipher === false) {
        throw new RuntimeException('Encryption failed.');
    }
    return 'v1:' . base64_encode($iv . $tag . $cipher);
}

function decrypt_text(?string $payload): string
{
    if ($payload === null || !str_starts_with($payload, 'v1:')) {
        return '';
    }
    $raw = base64_decode(substr($payload, 3), true);
    if ($raw === false || strlen($raw) < 28) {
        return '';
    }
    $plain = openssl_decrypt(substr($raw, 28), 'aes-256-gcm', Config::appKey(), OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16));
    return $plain === false ? '' : $plain;
}

/* -------------------------------------------------------------------------
 * Server-side rate limiting.
 * The 2020 build enforced "once per day" rules with client cookies (LIC,
 * ULD-568, ...) that anyone could delete. These limits live in the database.
 * ---------------------------------------------------------------------- */

function rate_limited(string $bucket, int $max, int $windowSeconds, ?string $key = null): bool
{
    $key ??= ip_fingerprint();
    $since = (new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))
        ->modify("-{$windowSeconds} seconds")->format('Y-m-d H:i:s');
    $count = (int) db_value(
        'SELECT COUNT(*) FROM rate_limits WHERE bucket = ? AND key_hash = ? AND created_at >= ?',
        [$bucket, $key, $since]
    );
    return $count >= $max;
}

function rate_hit(string $bucket, ?string $key = null): void
{
    db_query(
        'INSERT INTO rate_limits (bucket, key_hash, created_at) VALUES (?, ?, ?)',
        [$bucket, $key ?? ip_fingerprint(), now_string()]
    );
}

/* -------------------------------------------------------------------------
 * HTTP security headers
 * ---------------------------------------------------------------------- */

function send_security_headers(): void
{
    if (headers_sent()) {
        return;
    }
    $csp = implode('; ', [
        "default-src 'self'",
        "script-src 'self'",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data:",
        "frame-src https://www.youtube-nocookie.com",
        "connect-src 'self'",
        "form-action 'self'",
        "frame-ancestors 'none'",
        "base-uri 'self'",
        "object-src 'none'",
    ]);
    header('Content-Security-Policy: ' . $csp);
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    if (is_https()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    header_remove('X-Powered-By');
}
