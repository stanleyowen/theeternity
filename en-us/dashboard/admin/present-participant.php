<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$tables = [
    'Sort by Date' => db_all('SELECT name, date FROM present_participant ORDER BY date, id'),
    'Sort by Name' => db_all('SELECT name, date FROM present_participant ORDER BY name, id'),
];

dashboard_header('Present Participant', 'admin', 'present', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

<?php foreach ($tables as $caption => $rows): ?>
		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title"><?= e($caption) ?></caption>
			<thead>
				<tr>
					<th>Participant Name</th>
					<th>Present Time</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($rows as $row): ?>
				<tr>
					<td><?= e($row['name']) ?></td>
					<td><?= e($row['date']) ?></td>
					<td>
						<?= action_button('delete-present-participant.php', ['name' => $row['name']], 'Delete', 'Are You Sure want to Delete This Data?') ?>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
<?php endforeach; ?>

		  <h4><small><font color="red">Delete ALL PARTICIPANT :</font></small></h4>
		  <form action="<?= e(url('function/delete-present-participant-ALL.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="code"><b>CODE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" id="code" name="code" autocomplete="off" required>
			<button class="btn first" type="submit">Delete All</button>
		  </form>
		</div>
<?php dashboard_footer();
