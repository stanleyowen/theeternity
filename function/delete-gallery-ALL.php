<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$back = 'en-us/dashboard/admin/edit-gallery.php';

if (input('code') !== 'CONFIRM') {
    flash_back('Confirmation Code Mismatch', $back);
}

$names = db_query('SELECT file_name FROM gallery')->fetchAll(PDO::FETCH_COLUMN);
db_query('DELETE FROM gallery'); // SQLite has no TRUNCATE
foreach ($names as $name) {
    delete_upload('gallery', (string) $name);
}
flash_back('Record Deleted Successfully!', $back);
