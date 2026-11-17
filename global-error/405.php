<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(405, '405 Method Not Allowed', '405 - Method Not Allowed', 'The requested METHOD is not allowed in this URL');
