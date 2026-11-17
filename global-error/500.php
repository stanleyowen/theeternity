<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(500, '500 Internal Server Error', '500 - Internal Server Error', 'The server encountered an internal error or misconfiguration and was unable to complete your requests.<br><br>Please contact the server administrator at theeternity.esports.id@gmail.com to inform them of the time this error occured, and the actions you performed just before this error.');
