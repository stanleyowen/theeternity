<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user       = require_player();
$membership = require_membership($user, current_lang());

dashboard_header('Attendance', 'player', 'attendance', $user);
?>
		<div class="col-sm-9">
		  <h2>How to do an Attendance</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Choose the scrim event you want to participate in (According to the event you participated in before)</li>
			<li>Enter the Scrim Token Provided by Administrator through WhatsApp Group Chat</li>
			<li>Once you have received a message 'Attendance was successfully done! Thank You', you have success in doing an attendance</li>
		  </ol>

		  <form action="<?= e(url('function/attendance-user.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="id"><b>Attendance for :</b></label>
				<select name="id" id="id" required>
					<option value="<?= e($membership['event_id']) ?>"><?= e($membership['event_name']) ?></option>
				</select><br>
			<label for="token"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="password" placeholder="Enter Token Provided by Administrator" name="token" id="token" autocomplete="off" required><br>
			<button class="btn first" type="submit">Submit</button>
		  </form>
		</div>
<?php dashboard_footer();
