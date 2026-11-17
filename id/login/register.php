<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');

if (($user = current_user()) !== null) {
    redirect(dashboard_path($user, 'id'));
}
$errors = handle_register_form();

public_header('Daftar', [
    'css'        => ['style-login.css'],
    'lang_links' => ['en' => 'login/register.php', 'id' => 'login/register.php'],
]);
?>
  <style>
  .error {
	width: 92%;
	margin: 0px auto;
	padding: 10px;
	border: 1px solid #a94442;
	color: #a94442;
	background: #f2dede;
	border-radius: 5px;
	text-align: left;
  }
  .container-footer {
    padding: 16px;
  }
  </style>
<?php public_nav('register', false); ?>
    <div class="container">
	  <div class="intro-text left-0 text-center bg-faded p-2 rounded">
            <div class="cta-inner text-center rounded">
				<h2 class="section-heading mb-4">
				  <span class="section-heading-upper">Daftar</span>
				</h2>
<?php demo_access_panel(); ?>
				<form action="<?= e(lang_url('login/register.php')) ?>" method="post">
				  <p><font color='red'>Buat Akun Squad Anda untuk Masuk ke Dashboard<br>
				  <i class="fa fa-lock" aria-hidden="true"></i> Dienkripsi dengan Algoritma AES 256</font></p><br>

				  <?php form_errors($errors); ?>

				  <div class="container">
					<?= csrf_field() ?>
					<input name="honeypot" type="text" id="honeypot" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true">

					<label for="_username"><b>Clan Username :</b></label>
					<input type="text" placeholder="Masukkan Clan Username" id="_username" name="_username" maxlength="50" autocomplete="username" required>

					<label for="_password"><b>Kata Sandi :</b></label>
					<input type="password" placeholder="Masukkan Kata Sandi (min. 8 karakter)" id="_password" name="_password" minlength="8" maxlength="128" autocomplete="new-password" required>

					<label for="_confirmpassword"><b>Konfirmasi Kata Sandi :</b></label>
					<input type="password" placeholder="Ketik Ulang Kata Sandi" id="_confirmpassword" name="_confirmpassword" minlength="8" maxlength="128" autocomplete="new-password" required>
					<br>
					<button type="submit" class="submit" name="reg_user">Daftar</button>
				  </div>
				</form>
				<br><br>
            </div>
	  </div>
    </div>

<?php public_footer('login');
