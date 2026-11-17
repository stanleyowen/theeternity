<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$id = input_int('id', $_GET);
$d  = $id !== null ? db_one('SELECT id, event_name, scrim_id, token, wa_link FROM scrim_token WHERE id = ?', [$id]) : null;

dashboard_header('Create Scrim', 'admin', 'scrim', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>
		  <br><br>

		  <h4><small><font color="green">Edit Scrim :</font></small></h4>
<?php if ($d === null): ?>
		  <p>Scrim not found. <a href="<?= e(url('en-us/dashboard/admin/edit-event.php')) ?>">Back to scrims</a></p>
<?php else: ?>
		  <form action="<?= e(url('function/update-scrim.php')) ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="id" value="<?= e($d['id']) ?>">
			<label for="event_name"><b>Scrim Name &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" id="event_name" value="<?= e($d['event_name']) ?>" disabled><br>

			<label for="scrim_id"><b>Scrim ID &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" id="scrim_id" value="<?= e($d['scrim_id']) ?>" disabled><br>

			<label for="token"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" id="token" value="<?= e($d['token']) ?>" name="token" maxlength="50" autocomplete="off" required><br>

			<label for="link"><b>WhatsApp Link &nbsp; :</b></label>
			<input type="url" id="link" value="<?= e($d['wa_link']) ?>" name="link" maxlength="500" required><br>
			<button class="btn first" type="submit">Update</button>
		  </form>
<?php endif; ?>
		</div>
<?php dashboard_footer();
