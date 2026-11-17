<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
    require __DIR__ . '/../app/bootstrap.php';
}

render_error_page(408, '408 Request Time Out', '408 - Request Time Out', 'The request takes too long to process, it is timed out by the server.<br>If it should not be timed out, please contact Administrator of this web to increase \'Connection Timeout\'.');
