<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user = require_player();

dashboard_header('Customer Service', 'player', 'support', $user);
?>
		<div class="col-sm-9">
		  <hr>
		  <h2>Customer Service</h2>
		  <p>We are here to help and answer any questions you might have. We offer support for the following :</p>
		  <ol type="disc">
			<li>Technical Support</li>
			<li>Login &amp; Register Support</li>
		  </ol>
		  <p>Contact Us On :</p>
		  <ol type="disc">
			<li>Eternity Esports Website : <a href="<?= e(lang_url('index.php') . '#message-us') ?>">Click Here</a></li>
			<li>Email : <a href="mailto:theeternity.esports.id@gmail.com">theeternity.esports.id@gmail.com</a></li>
			<li>WhatsApp : <?= external_link('https://wa.me/message/SGOS5RUB46CUA1', 'wa.me/message/SGOS5RUB46CUA1') ?></li>
			<li>Instagram : <?= external_link('https://instagram.com/eternity_esports.id', 'eternity_esports.id') ?></li>
		  </ol>
		</div>
<?php dashboard_footer();
