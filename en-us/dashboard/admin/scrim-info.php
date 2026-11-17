<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$posts = db_all('SELECT id, type, code, posted_by, date, header, description FROM scrim_info ORDER BY id');

dashboard_header('Create Post', 'admin', 'post', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Scrim Info Posts</caption>
			<thead>
				<tr>
					<th>Type</th>
					<th>Code</th>
					<th>Posted By</th>
					<th>Date</th>
					<th>Header</th>
					<th>Description</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($posts as $row): ?>
				<tr>
					<td><?= e($row['type']) ?></td>
					<td><?= e($row['code']) ?></td>
					<td><?= e($row['posted_by']) ?></td>
					<td><?= e($row['date']) ?></td>
					<td><?= e($row['header']) ?></td>
					<td><?= e_multiline($row['description']) ?></td>
					<td>
						<?= action_button('delete-scrim-info.php', ['id' => $row['id']], 'Delete', 'Are You Sure want to Delete This Data?') ?>
						<a href="<?= e(url('en-us/dashboard/admin/edit-scrim-info.php?id=' . $row['id'])) ?>" class="btn first">Edit</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
		  <h4><small><font color="green">Add Post :</font></small></h4>
		  <form action="<?= e(url('function/add-scrim-info.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="header"><b>Header &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" placeholder="Enter Event's Header" id="header" name="header" maxlength="255" required><br>

			<label for="code"><b>Code [Hidden] :</b></label>
			<input type="text" placeholder="Enter Event's Code [XXXXX]" id="code" name="code" maxlength="20" pattern="[A-Za-z0-9]{1,20}" title="Letters and numbers only (max 20)"><br>

			<label for="description"><b>Description (max 5000) :</b></label><br>
			<textarea name="description" id="description" maxlength="5000" required></textarea><br>
			<button class="btn first" type="submit">Add</button>
		  </form>
		</div>
<?php dashboard_footer();
