<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

// The 2020 WHERE clause ("rank_1 AND kill_1 IS NOT NULL") was buggy; only rows with both values are results.
$matches = [
    1 => [
        'rows' => db_all('SELECT username, rank_1 AS rank_value, kill_1 AS kills FROM scrim_member WHERE rank_1 IS NOT NULL AND kill_1 IS NOT NULL ORDER BY rank_1, username'),
        'edit' => 'edit-player-result.php',
    ],
    2 => [
        'rows' => db_all('SELECT username, rank_2 AS rank_value, kill_2 AS kills FROM scrim_member WHERE rank_2 IS NOT NULL AND kill_2 IS NOT NULL ORDER BY rank_2, username'),
        'edit' => 'edit-player-result-2.php',
    ],
];

dashboard_header('Scrim Results', 'admin', 'result', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

<?php foreach ($matches as $match => $m): ?>
		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Scrim Result Match <?= e($match) ?></caption>
			<thead>
				<tr>
					<th>Rank</th>
					<th>Squad Name</th>
					<th>Total Kills</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($m['rows'] as $row): ?>
				<tr>
					<td><?= e($row['rank_value']) ?></td>
					<td><?= e($row['username']) ?></td>
					<td><?= e($row['kills']) ?></td>
					<td>
						<?= action_button('delete-result.php', ['username' => $row['username'], 'match' => $match], 'Delete', 'Are You Sure want to Delete This Data?') ?>
						<a href="<?= e(url('en-us/dashboard/admin/' . $m['edit'] . '?' . http_build_query(['username' => $row['username']]))) ?>" class="btn first">Edit</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
<?php endforeach; ?>

		  <h4><small><font color="red">Delete ALL SCRIM RESULTS :</font></small></h4>
		  <form action="<?= e(url('function/delete-scrim-result-ALL.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="code"><b>CODE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" id="code" name="code" autocomplete="off" required>
			<button class="btn first" type="submit">Delete All</button>
		  </form>
		</div>
<?php dashboard_footer();
