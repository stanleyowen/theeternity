<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user = require_player();

// One scrim at a time (was enforced by a forgeable "JScrim" cookie). Demo visitors may still look at the page.
if (membership_for($user['username']) !== null && !$user['demo']) {
    flash(t('already_joined'));
    redirect('en-us/dashboard/index.php');
}
$events = db_all('SELECT id, event_name FROM scrim_token ORDER BY id DESC');

dashboard_header('Participate in a Scrim', 'player', 'participate', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Participate in a Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Read our Terms and Condition before participate in a scrim</li>
			<li>Choose the Scrim Event you wanted to participate in</li>
			<li>Make sure you check all the field</li>
			<li>You cannot follow more than 1 event simultaneously</li>
			<li>Click 'Participate' Button</li>
			<li>Once you click the button, you will be able to access 'Upload Center', 'Attendance', and 'Download Certificates' features</li>
			<li>You won't be able to access this tab once you have participated in a scrim, until the event ends</li>
		  </ol>

		  <form action="<?= e(url('function/participate-in-scrim.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="event_id"><b>Participate in :</b></label>
				<select name="event_id" id="event_id" required>
<?php foreach ($events as $row): ?>
					<option value="<?= e($row['id']) ?>"><?= e($row['event_name']) ?></option>
<?php endforeach; ?>
				</select><br>
			<label class="container">I agree to the <a href="<?= e(lang_url('event/terms-and-conditions-scrim.php')) ?>">Term and Conditions</a> of the Scrim Rules
			  <input type="checkbox" name="term1" value="1" required>
			  <span class="checkmark"></span>
			</label>

			<label class="container">I agree that The Eternity Esports can collect my Personal Information
			  <input type="checkbox" name="term2" value="1" required>
			  <span class="checkmark"></span>
			</label>
			<button class="btn first" type="submit">PARTICIPATE</button>
		  </form>
		</div>
<?php dashboard_footer();
