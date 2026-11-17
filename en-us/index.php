<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

if (input('lang', '', $_GET) === 'id') {
    redirect('id/index.php?lang=id');
}
set_lang('en');
$errors = handle_feedback_form();

public_header('Home', [
    'meta_title'  => 'Eternity Esports | Official Scrim website',
    'description' => "Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia.",
    'css'         => ['style-login.css'],
    'lang_links'  => ['en' => 'index.php?lang=en', 'id' => 'index.php?lang=id'],
]);
public_nav('home');
?>

  <section class="page-section clearfix">
    <div class="container">
        <div class="intro-text left-0 text-center bg-faded p-5 rounded">
          <h2 class="section-heading mb-4">
            <span class="section-heading-upper">Welcome to</span>
            <span class="section-heading-lower">Eternity Esports</span>
          </h2>
          <p class="mb-3" align="left">
      			Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill.
      			Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia.
      			When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you
      			a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website.
      			We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.
          </p>
          <div class="intro-button mx-auto">
            <a class="btn btn-primary btn-xl" href="<?= e(lang_url('event/release-notes.php')) ?>">Release Notes</a>
            <a class="btn btn-primary btn-xl" href="<?= e(url('global-validation/redirect.php?lang=en')) ?>">Join Scrim</a>
          </div>
        </div>
    </div>
  </section>

  <style>
	.responsive {
		width: 100%;
		height: 0;
		padding-bottom: 56.25%;
		position: relative;
	}
	.responsive iframe {
		width: 100%;
		height: 100%;
		position: absolute;
	}
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
  </style>

  <div class="bg-faded p-5 rounded">
	<div class="responsive">
		<h2>Our Latest Information</h2>
		<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/kAiU9rj74_o" title="Eternity Esports — latest information" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
  </div>

  <section class="page-section cta" id="message-us">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded">
            <h2 class="section-heading mb-4">
              <span class="section-heading-upper">LEAVE</span>
              <span class="section-heading-lower">Some Messages to Us</span>
            </h2>
            <form action="<?= e(lang_url('index.php')) ?>#message-us" method="post">
              <font color='red'><i class="fa fa-lock" aria-hidden="true"></i> Encrypted with AES 256 Algorithm</font><br><br>

			  <?php form_errors($errors); ?>
			  <div class="container">
				<?= csrf_field() ?>
				<input name="honeypot" type="text" id="honeypot" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true">

				<label for="_name"><b>Full Name :</b></label>
				<input type="text" placeholder="Enter Full Name" id="_name" name="_name" maxlength="40" required/>

				<label for="_email"><b>Email :</b></label>
				<input type="email" placeholder="Enter Your Email" id="_email" name="_email" maxlength="100" required/>

				<label for="_type"><b>Feedback Type :</b></label>
				<select id="_type" name="_type">
					<option value='improvement'>Improvement</option>
					<option value='report-bug'>Report Bugs</option>
					<option value='comment'>Comment</option>
					<option value='others'>Others</option>
				</select>

				<label for="_comment"><b>Messages :</b></label>
				<div class="comment">
					<textarea id="_comment" class="textinput" placeholder="Type your comment here (Max 2000 characters)" name="_comment" maxlength="2000" required></textarea>
				</div>

				<button type="submit" class="submit" name="send_feedback">Submit</button>
			  </div>
			</form>
          </div>
        </div>
      </div>
  </section>

<?php public_footer();
