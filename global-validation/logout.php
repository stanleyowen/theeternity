<?php
declare(strict_types=1);

define('ALLOW_IN_ARCHIVE', true);
require __DIR__ . '/../app/bootstrap.php';

// Logout links carry the CSRF token so other sites cannot sign visitors out.
$lang = current_lang();
if (csrf_valid($_GET['_csrf'] ?? $_POST['_csrf'] ?? null)) {
    logout_user();
}
header('Location: ' . url(lang_dir($lang) . '/index.php'), true, 303);
exit;
