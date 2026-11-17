<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(403, '403 Forbidden', '403 - Forbidden', 'Make sure you do have the right to access this page.');
