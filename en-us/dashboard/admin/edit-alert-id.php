<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$id = input_int('id', $_GET);
$d  = $id !== null ? db_one('SELECT id, description, link, type FROM alerts_info WHERE id = ?', [$id]) : null;

dashboard_header('Edit Alert', 'admin', 'alert', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>
		  <br><br>

		  <h4><small><font color="green">Edit Alert :</font></small></h4>
<?php if ($d === null): ?>
		  <p>Alert not found. <a href="<?= e(url('en-us/dashboard/admin/edit-alert.php')) ?>">Back to alerts</a></p>
<?php else: ?>
		  <form action="<?= e(url('function/update-alert.php')) ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="id" value="<?= e($d['id']) ?>">
			<label for="alert_type"><b>Alert Type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<select name="alert_type" id="alert_type">
<?php foreach (['success' => 'Success', 'warning' => 'Warning', 'danger' => 'Danger'] as $value => $label): ?>
				<option value="<?= e($value) ?>"<?= $d['type'] === $value ? ' selected' : '' ?>><?= e($label) ?></option>
<?php endforeach; ?>
			</select><br>

			<label for="link"><b>Link (max 500) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="url" placeholder="Enter Alert's Link" value="<?= e($d['link']) ?>" id="link" name="link" maxlength="500" required><br>

			<label for="description"><b>Description (max 500) :</b></label><br>
			<textarea name="description" id="description" maxlength="500" required><?= e($d['description']) ?></textarea><br>
			<button class="btn first" type="submit">Update</button>
		  </form>
<?php endif; ?>
		</div>
<?php dashboard_footer();
