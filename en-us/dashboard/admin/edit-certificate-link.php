<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$id = input_int('id', $_GET);
$d  = $id !== null ? db_one('SELECT id, event_name, certi_link FROM scrim_token WHERE id = ?', [$id]) : null;

dashboard_header('Edit Certificate', 'admin', 'certificate', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>
		  <br><br>

		  <h4><small><font color="green">Edit Certificate Link :</font></small></h4>
<?php if ($d === null): ?>
		  <p>Scrim not found. <a href="<?= e(url('en-us/dashboard/admin/create-certificate-list.php')) ?>">Back to certificate links</a></p>
<?php else: ?>
		  <form action="<?= e(url('function/update-certificate-link.php')) ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="id" value="<?= e($d['id']) ?>">
			<label for="event"><b>Event Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="text" id="event" value="<?= e($d['event_name']) ?>" disabled><br>

			<label for="link"><b>Link (max 500) &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="url" placeholder="Enter Certificate Download Link" value="<?= e($d['certi_link']) ?>" id="link" name="link" maxlength="500"><br>
			<button class="btn first" type="submit">Update</button>
		  </form>
<?php endif; ?>
		</div>
<?php dashboard_footer();
