<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user       = require_player();
$membership = require_membership($user, current_lang());

$matches = [
    1 => ['submit-result.php', '# Result Match 1 #'],
    2 => ['submit-result-2.php', '# Result Match 2 #'],
];

dashboard_header('Submit Result', 'player', 'result', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Submit a Result</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Before submit a result, double check the Event Name you participated in.</li>
			<li>Enter the result of the match.</li>
			<li>Each user are only ALLOWED to fill ONCE per MATCH</li>
			<li>Only type NUMBERS inside the form</li>
			<li>If success, you will receive 'Result Submitted'</li>
		  </ol>
<?php foreach ($matches as $n => [$action, $heading]): ?>
		  <br>
		  <p><font color="red"><?= e($heading) ?></font></p>
		  <form action="<?= e(url('function/' . $action)) ?>" method="post">
			<?= csrf_field() ?>
			<input name="honeypot" type="text" id="honeypot-<?= e($n) ?>" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true">
			<label for="id-<?= e($n) ?>"><b>Event Name :</b></label>
				<select name="id" id="id-<?= e($n) ?>" required>
					<option value="<?= e($membership['event_id']) ?>"><?= e($membership['event_name']) ?></option>
				</select><br>
			<label for="rank-<?= e($n) ?>"><b>Rank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : #</b></label>
			<input type="number" placeholder="Enter Rank Result Match <?= e($n) ?>" name="rank" id="rank-<?= e($n) ?>" min="1" max="100" required><br>
			<label for="kill-<?= e($n) ?>"><b>Kill &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </b></label>
			<input type="number" placeholder="Enter Total Kill Match <?= e($n) ?>" name="kill" id="kill-<?= e($n) ?>" min="0" max="99" required><br>
			<button class="btn first" type="submit">Submit</button>
		  </form>
<?php endforeach; ?>
		</div>
<?php dashboard_footer();
