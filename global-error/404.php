<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(404, '404 Not Found', '404 - Page not found', 'The page you are looking for might have been removed had its name changed or is temporarily unavailable.');
