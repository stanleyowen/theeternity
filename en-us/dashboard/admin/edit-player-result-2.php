<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$username = input('username', '', $_GET);
$d = $username !== ''
    ? db_one('SELECT username, rank_2 AS rank_value, kill_2 AS kills FROM scrim_member WHERE username = ?', [$username])
    : null;

dashboard_header('Edit Players Result', 'admin', 'result', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>
		  <br><br>

		  <h4><small><font color="green">Edit Player Result Match 2 :</font></small></h4>
<?php if ($d === null): ?>
		  <p>Participant not found. <a href="<?= e(url('en-us/dashboard/admin/scrim-result.php')) ?>">Back to scrim results</a></p>
<?php else: ?>
		  <form action="<?= e(url('function/update-result-2.php')) ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="username" value="<?= e($d['username']) ?>">
			<label for="player"><b>Player Name &nbsp; :</b></label>
			<input type="text" id="player" value="<?= e($d['username']) ?>" disabled><br>

			<label for="rank"><b>Rank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="number" id="rank" value="<?= e($d['rank_value']) ?>" name="rank" min="1" max="100" step="1" required><br>

			<label for="kill"><b>Total Kill &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="number" id="kill" value="<?= e($d['kills']) ?>" name="kill" min="0" max="99" step="1" required><br>
			<button class="btn first" type="submit">Update</button>
		  </form>
<?php endif; ?>
		</div>
<?php dashboard_footer();
