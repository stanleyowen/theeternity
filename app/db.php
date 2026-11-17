<?php
declare(strict_types=1);

/**
 * Single lazily-created PDO connection.
 *
 * Every query in the application goes through prepared statements with bound
 * parameters; string-concatenated SQL (the 2020 build's mysqli_* calls) is gone.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = Config::dbDsn();
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $isSqlite = str_starts_with($dsn, 'sqlite:');
    if ($isSqlite && Config::archiveMode() && !defined('DB_WRITABLE')) {
        // Defence in depth: in archive mode the database file itself is opened
        // read-only, so even a missed code path cannot modify the archive.
        if (class_exists(\Pdo\Sqlite::class) && defined(\Pdo\Sqlite::class . '::ATTR_OPEN_FLAGS')) {
            $options[\Pdo\Sqlite::ATTR_OPEN_FLAGS] = \Pdo\Sqlite::OPEN_READONLY;
        } elseif (defined('PDO::SQLITE_ATTR_OPEN_FLAGS')) {
            $options[constant('PDO::SQLITE_ATTR_OPEN_FLAGS')] = constant('PDO::SQLITE_OPEN_READONLY');
        }
    }

    $pdo = new PDO($dsn, Config::dbUser(), Config::dbPass(), $options);

    if ($isSqlite) {
        $pdo->exec('PRAGMA foreign_keys = ON');
        $pdo->exec('PRAGMA busy_timeout = 3000');
    } elseif (str_starts_with($dsn, 'mysql:')) {
        $pdo->exec("SET NAMES utf8mb4, time_zone = '+07:00'");
        if (Config::archiveMode() && !defined('DB_WRITABLE')) {
            $pdo->exec('SET SESSION TRANSACTION READ ONLY');
        }
    }

    return $pdo;
}

/** Run a parameterised query and return the statement. */
function db_query(string $sql, array $params = []): PDOStatement
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function db_all(string $sql, array $params = []): array
{
    return db_query($sql, $params)->fetchAll();
}

function db_one(string $sql, array $params = []): ?array
{
    $row = db_query($sql, $params)->fetch();
    return $row === false ? null : $row;
}

function db_value(string $sql, array $params = []): mixed
{
    $value = db_query($sql, $params)->fetchColumn();
    return $value === false ? null : $value;
}

/** Current time in the club's timezone (Asia/Jakarta), as stored in the DB. */
function now_string(): string
{
    return (new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
}
