<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
require_post();
require_admin();

$id = input_int('id');
if ($id !== null) {
    $name = db_value('SELECT file_name FROM gallery WHERE id = ?', [$id]);
    db_query('DELETE FROM gallery WHERE id = ?', [$id]);
    if (is_string($name)) {
        delete_upload('gallery', $name);
    }
}
flash_back('Data Deleted Successfully!', 'en-us/dashboard/admin/edit-gallery.php');
