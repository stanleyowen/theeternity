<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

// The password hash column is deliberately never selected or displayed.
$accounts = db_all('SELECT id, username, role, created_at FROM users ORDER BY id');

dashboard_header('User Account', 'admin', 'user', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">User Accounts</caption>
			<thead>
				<tr>
					<th>Username</th>
					<th>Level</th>
					<th>Date Created</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($accounts as $row): ?>
				<tr>
					<td><?= e($row['username']) ?></td>
					<td><?= e($row['role']) ?></td>
					<td><?= e($row['created_at']) ?></td>
					<td>
<?php if ((int) $row['id'] !== (int) $user['id']): ?>
						<?= action_button('delete-user.php', ['id' => $row['id']], 'Ban User', 'Are You Sure want to Ban this User?') ?>
<?php endif; ?>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>

		  <h4><small><font color="green">Add User</font></small></h4>
		  <form action="<?= e(url('function/add-user.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="username"><b>Username &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" placeholder="Enter Username" id="username" name="username" minlength="3" maxlength="50" autocomplete="off" required><br>

			<label for="role"><b>Role/Level &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<select name="role" id="role">
				<option value="<?= e(ROLE_USER) ?>">User</option>
				<option value="<?= e(ROLE_ADMIN) ?>">Administrator</option>
			</select><br>

			<label for="password"><b>Password &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="password" placeholder="Enter Password" id="password" name="password" minlength="8" maxlength="128" autocomplete="new-password" required><br>

			<label for="confirmpassword"><b>Confirm Password :</b></label>
			<input type="password" placeholder="Re-Type Your Password" id="confirmpassword" name="confirmpassword" minlength="8" maxlength="128" autocomplete="new-password" required><br>

			<button class="btn first" type="submit">Add User</button>
		  </form>
		</div>
<?php dashboard_footer();
