<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');

if (($user = current_user()) !== null) {
    redirect(dashboard_path($user, 'en'));
}
$errors = handle_login_form();

public_header('Login', [
    'css'        => ['style-login.css'],
    'lang_links' => ['en' => 'login/index.php', 'id' => 'login/index.php'],
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
<?php public_nav('login', false); ?>
    <div class="container">
	  <div class="intro-text left-0 text-center bg-faded p-2 rounded">
          <div class="cta-inner text-center rounded">
			<h2 class="section-heading mb-4">
				<span class="section-heading-upper">Login</span>
            </h2>
<?php demo_access_panel(); ?>
            <form action="<?= e(lang_url('login/index.php')) ?>" method="post">

			  <p><font color='red'>Login with the account you registered, not Gmail Account<br>
			  <i class="fa fa-lock" aria-hidden="true"></i> Encrypted with AES 256 Algorithm</font></p><br>

			  <?php form_errors($errors); ?>

			  <div class="container">
				<?= csrf_field() ?>
				<input name="honeypot" type="text" id="honeypot" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true" />

				<label for="_username"><b>Clan Username :</b></label>
				<input type="text" placeholder="Enter Clan Username" id="_username" name="_username" maxlength="50" autocomplete="username" required>

				<label for="_password"><b>Password :</b></label>
				<input type="password" placeholder="Enter Password" id="_password" name="_password" maxlength="128" autocomplete="current-password" required>

				<button type="submit" class="submit" name="login_user">Login</button>
			  </div>
			</form>
			<br><br>
          </div>
	  </div>
    </div>

<?php public_footer('login');
