<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(502, '502 Bad Gateway', '502 - Bad Gateway', 'The server received an invalid response from an upstream server.<br>Contact your Administrator if the problem persists after retrying the URL.');
