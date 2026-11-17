<?php
declare(strict_types=1);

/**
 * Create the database schema and (optionally) load the archive seed data.
 *
 *   php bin/init-db.php            create tables if missing
 *   php bin/init-db.php --seed     ... and load archive data into an empty database
 *   php bin/init-db.php --fresh    delete the SQLite file first (SQLite only)
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('DB_WRITABLE', true);
require __DIR__ . '/../app/bootstrap.php';

$args  = array_slice($argv, 1);
$dsn   = Config::dbDsn();
$isSql = str_starts_with($dsn, 'sqlite:');

if (in_array('--fresh', $args, true)) {
    if (!$isSql) {
        fwrite(STDERR, "--fresh is only supported for SQLite.\n");
        exit(1);
    }
    $file = substr($dsn, strlen('sqlite:'));
    if (is_file($file)) {
        unlink($file);
    }
}

if ($isSql) {
    $dir = dirname(substr($dsn, strlen('sqlite:')));
    if (!is_dir($dir)) {
        mkdir($dir, 0750, true);
    }
}

$schema = file_get_contents(APP_ROOT . '/database/' . ($isSql ? 'schema.sqlite.sql' : 'schema.mysql.sql'));
$schema = preg_replace('/^\s*--.*$/m', '', (string) $schema);
foreach (array_filter(array_map('trim', explode(';', $schema))) as $statement) {
    db()->exec($statement);
}
echo "Schema ready.\n";

if (in_array('--seed', $args, true)) {
    if ((int) db_value('SELECT COUNT(*) FROM users') > 0) {
        echo "Database already contains data; seed skipped.\n";
    } else {
        require APP_ROOT . '/database/seed.php';
        echo "Archive data loaded.\n";
    }
}
