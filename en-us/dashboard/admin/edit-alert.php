<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$alerts = db_all('SELECT id, description, link, type FROM alerts_info ORDER BY id');

dashboard_header('Edit Alert', 'admin', 'alert', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Website Alerts</caption>
			<thead>
				<tr>
					<th>Description</th>
					<th>Type</th>
					<th>Link</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($alerts as $row): ?>
				<tr>
					<td><?= e($row['description']) ?></td>
					<td><?= e($row['type']) ?></td>
					<td><?= external_link($row['link']) ?></td>
					<td>
						<?= action_button('delete-alert-id.php', ['id' => $row['id']], 'Delete', 'Are You Sure want to Delete This Data?') ?>
						<a href="<?= e(url('en-us/dashboard/admin/edit-alert-id.php?id=' . $row['id'])) ?>" class="btn first">Edit</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>

		  <h4><small><font color="green">Add Alert :</font></small></h4>
		  <form action="<?= e(url('function/add-alert-info.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="alert_type"><b>Alert Type &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<select name="alert_type" id="alert_type">
				<option value='success'>Success</option>
				<option value='warning'>Warning</option>
				<option value='danger'>Danger</option>
			</select><br>

			<label for="link"><b>Link (max 500) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="url" placeholder="Enter Alert's Link" id="link" name="link" maxlength="500" required><br>

			<label for="description"><b>Description (max 500) :</b></label><br>
			<textarea name="description" id="description" maxlength="500" required></textarea><br>
			<button class="btn first" type="submit">Add</button>
		  </form>
		</div>
<?php dashboard_footer();
