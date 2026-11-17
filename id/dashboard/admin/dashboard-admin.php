<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('id');

// The admin console was English-only; send everyone to the right place.
$user = current_user();
redirect($user !== null ? dashboard_path($user, 'id') : login_url('id'));
