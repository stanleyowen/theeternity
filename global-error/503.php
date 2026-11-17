<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(503, '503 Service Currently Unavailable', '503 - Service Currently Unavailable', 'Our server is unable to service your request due to maintenance downtime. We are sorry that this service is currently unavailable and we will be back as soon as possible.');
