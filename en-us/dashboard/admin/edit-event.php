<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$events = db_all('SELECT id, event_name, scrim_id, token, wa_link FROM scrim_token ORDER BY id');

dashboard_header('Create Scrim', 'admin', 'scrim', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Scrim Events</caption>
			<thead>
				<tr>
					<th>Event Name</th>
					<th>Scrim ID</th>
					<th>WhatsApp Link</th>
					<th>Token</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($events as $row): ?>
				<tr>
					<td><?= e($row['event_name']) ?></td>
					<td><?= e($row['scrim_id']) ?></td>
					<td><?= external_link($row['wa_link']) ?></td>
					<td><?= e($row['token']) ?></td>
					<td>
						<?= action_button('delete-event-id.php', ['id' => $row['id']], 'Delete', 'Are You Sure want to Delete This Data?') ?>
						<a href="<?= e(url('en-us/dashboard/admin/edit-event-id.php?' . http_build_query(['id' => $row['id']]))) ?>" class="btn first">Edit</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>

		  <h4><small><font color="green">Add Scrim Event</font></small></h4>
		  <form action="<?= e(url('function/add-event.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="name"><b>Event Name &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="text" placeholder="Enter Event Name" id="name" name="name" maxlength="100" required><br>

			<label for="scrim_id"><b>Scrim ID &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="text" placeholder="Enter Scrim ID" id="scrim_id" name="scrim_id" maxlength="50" required><br>

			<label for="link"><b>Link &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="url" placeholder="Enter WA Group Link" id="link" name="link" maxlength="500" required><br>

			<label for="token"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="password" placeholder="Enter Token" id="token" name="token" maxlength="50" autocomplete="off" required><br>

			<label for="confirmtoken"><b>Confirm Token :</b></label>
			<input type="password" placeholder="Re-Type Token" id="confirmtoken" name="confirmtoken" maxlength="50" autocomplete="off" required><br>
			<button class="btn first" type="submit">Add Scrim</button>
		  </form>
		</div>
<?php dashboard_footer();
