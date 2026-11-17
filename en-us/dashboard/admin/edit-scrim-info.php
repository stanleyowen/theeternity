<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$id = input_int('id', $_GET);
$d  = $id !== null ? db_one('SELECT id, code, header, description FROM scrim_info WHERE id = ?', [$id]) : null;

dashboard_header('Create Post', 'admin', 'post', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <h4><small><font color="green">Update :</font></small></h4>
<?php if ($d === null): ?>
		  <p>Post not found. <a href="<?= e(url('en-us/dashboard/admin/scrim-info.php')) ?>">Back to posts</a></p>
<?php else: ?>
		  <form action="<?= e(url('function/update-scrim-info.php')) ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="id" value="<?= e($d['id']) ?>">

			<label for="header"><b>Header &nbsp; :</b></label>
			<input type="text" value="<?= e($d['header']) ?>" id="header" name="header" maxlength="255" required><br>

			<label for="code"><b>CODE &nbsp; &nbsp; :</b></label>
			<input type="text" value="<?= e($d['code']) ?>" id="code" name="code" maxlength="20" pattern="[A-Za-z0-9]{1,20}" title="Letters and numbers only (max 20)"><br>

			<label for="description"><b>Description (max 5000) :</b></label><br>
			<textarea name="description" id="description" maxlength="5000" required><?= e($d['description']) ?></textarea><br>
			<button class="btn first" type="submit">Update</button>
		  </form>
<?php endif; ?>
		</div>
<?php dashboard_footer();
