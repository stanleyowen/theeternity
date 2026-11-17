<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$messages = db_all('SELECT id, name, email, type, comment, date FROM message ORDER BY date DESC, id DESC');

dashboard_header('Messages', 'admin', 'message', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Visitor Messages</caption>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Message Type</th>
					<th>Comment</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($messages as $row): ?>
				<tr>
					<td><?= e(decrypt_text($row['name'])) ?></td>
					<td><?= e(decrypt_text($row['email'])) ?></td>
					<td><?= e($row['type']) ?></td>
					<td><?= e_multiline(decrypt_text($row['comment'])) ?></td>
					<td><?= e($row['date']) ?></td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
		  <form action="<?= e(url('function/delete-message-ALL.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="code"><b>CODE &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" id="code" name="code" autocomplete="off" required>
			<button class="btn first" type="submit">Delete</button>
		  </form>
		  <br><br>
		</div>
<?php dashboard_footer();
