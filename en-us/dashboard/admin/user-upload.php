<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$members = db_all('SELECT username, date, squad_pic, ig_proof, ig_proof_2 FROM scrim_member ORDER BY date, id');

$status = static fn (?string $file): string => $file !== null && $file !== '' ? 'Uploaded' : 'Not uploaded';

dashboard_header('Participant', 'admin', 'participant', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Scrim Participants</caption>
			<thead>
				<tr>
					<th>Participant</th>
					<th>Date</th>
					<th>Squad Logo</th>
					<th>Instagram Proof</th>
					<th>Instagram Proof 2</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($members as $row): ?>
				<tr>
					<td><?= e($row['username']) ?></td>
					<td><?= e($row['date']) ?></td>
					<td><?= e($status($row['squad_pic'])) ?></td>
					<td><?= e($status($row['ig_proof'])) ?></td>
					<td><?= e($status($row['ig_proof_2'])) ?></td>
					<td>
						<a href="<?= e(url('en-us/dashboard/admin/view-upload.php?' . http_build_query(['username' => $row['username']]))) ?>" class="btn first">View</a>
						<?= action_button('ban-player.php', ['username' => $row['username']], 'Ban Player', 'Are You Sure want to Delete This Data?') ?>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br>

		  <h4><small><font color="red">Delete ALL Scrim Participant :</font></small></h4>
		  <form action="<?= e(url('function/delete-scrim-participant-ALL.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="code"><b>CODE &nbsp;:</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" id="code" name="code" autocomplete="off" required>
			<button class="btn first" type="submit">Delete All</button>
		  </form>
		</div>
<?php dashboard_footer();
