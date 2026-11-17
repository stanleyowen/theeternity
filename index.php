<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

// Returning visitors skip the language chooser (as in 2020).
if (isset($_SESSION['language'])) {
    $lang = current_lang();
    $user = current_user();
    redirect($user !== null ? dashboard_path($user, $lang) : lang_dir($lang) . '/index.php?lang=' . $lang);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Languages | Eternity Esports</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Eternity Esports (est. 2019, Medan, Indonesia) — archived scrim platform. Choose your language.">
	<link rel="icon" href="<?= e(asset('img/etr-img-1.jpeg')) ?>">
	<link rel="stylesheet" href="<?= e(asset('css/language-style.css')) ?>">
</head>

<body<?= body_attrs() ?>>
	<div class="container-login100" style="background-image: url('<?= e(asset('img/etr-img-1.jpeg')) ?>');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form">
				<p align="center">
					<b>
					<br>Please Choose a Language<br>
					Silahkan Pilih Bahasa yang Diinginkan<br><br><br></b>
				</p>
				<div class="container-login100-form-btn">
					<input class="login100-form-btn" type="button" value="ENGLISH [US]" data-href="<?= e(url('en-us/index.php?lang=en')) ?>"/>
					<br><br><br><br><br>
					<input class="login100-form-btn" type="button" value="INDONESIA [ID]" data-href="<?= e(url('id/index.php?lang=id')) ?>"/>
				</div><br><br>
			</form>
		</div>
	</div>
	<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
