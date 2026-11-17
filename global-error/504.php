<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(504, '504 Gateway Timeout', '504 - Gateway Timeout', 'The webserver reported that an error occured while trying to access the website.');
