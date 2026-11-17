<?php
declare(strict_types=1);

/**
 * Runtime configuration. Everything comes from environment variables so that
 * no secret ever lives in the repository (the 2020 build hard-coded DB
 * credentials and encryption keys in PHP files).
 */

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

function env_bool(string $key, bool $default): bool
{
    $value = env($key);
    if ($value === null) {
        return $default;
    }
    return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true);
}

/** Load a local .env file (development convenience; real deployments use real env vars). */
(function (): void {
    $file = APP_ROOT . '/.env';
    if (!is_file($file) || !is_readable($file)) {
        return;
    }
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"'");
        if ($k !== '' && getenv($k) === false) {
            putenv("$k=$v");
        }
    }
})();

final class Config
{
    public static function isProduction(): bool
    {
        return env('APP_ENV', 'production') === 'production';
    }

    /**
     * Archive mode (default ON): the site is a read-only museum piece.
     * - every state-changing request is refused centrally,
     * - the database connection is opened read-only (SQLite),
     * - visitors can explore the dashboards through demo sessions.
     */
    public static function archiveMode(): bool
    {
        return env_bool('ARCHIVE_MODE', true);
    }

    /**
     * Static export (implies archive mode): pages are rendered once by
     * tools/export-static.sh and published as plain files (e.g. on Netlify).
     * Session-based bits (demo sign-in, logout, form posts) render static equivalents.
     */
    public static function staticExport(): bool
    {
        return self::archiveMode() && env_bool('STATIC_EXPORT', false);
    }

    public static function dbDsn(): string
    {
        return env('DB_DSN', 'sqlite:' . APP_ROOT . '/storage/database/eternity.sqlite');
    }

    public static function dbUser(): ?string
    {
        return env('DB_USER');
    }

    public static function dbPass(): ?string
    {
        return env('DB_PASS');
    }

    /** Honour X-Forwarded-Proto only when explicitly running behind a trusted proxy. */
    public static function trustProxy(): bool
    {
        return env_bool('TRUST_PROXY', false);
    }

    public static function storagePath(string $sub = ''): string
    {
        return APP_ROOT . '/storage' . ($sub !== '' ? '/' . ltrim($sub, '/') : '');
    }

    /**
     * 32-byte key used for AES-256-GCM encryption of personal data at rest
     * (contact-form name, email and message). Provide APP_KEY as base64; if it
     * is missing a random key is generated once and kept in storage/.
     */
    public static function appKey(): string
    {
        static $key = null;
        if ($key !== null) {
            return $key;
        }
        $raw = env('APP_KEY');
        if ($raw !== null) {
            $decoded = base64_decode(preg_replace('/^base64:/', '', $raw), true);
            if ($decoded === false || strlen($decoded) !== 32) {
                throw new RuntimeException('APP_KEY must be 32 bytes, base64-encoded.');
            }
            return $key = $decoded;
        }
        $file = self::storagePath('.app_key');
        if (is_file($file)) {
            $decoded = base64_decode(trim((string) file_get_contents($file)), true);
            if ($decoded !== false && strlen($decoded) === 32) {
                return $key = $decoded;
            }
        }
        $key = random_bytes(32);
        if (@file_put_contents($file, base64_encode($key), LOCK_EX) !== false) {
            @chmod($file, 0600);
        }
        return $key;
    }
}
