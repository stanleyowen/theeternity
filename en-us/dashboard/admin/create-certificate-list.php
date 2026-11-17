<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$events = db_all('SELECT id, event_name, certi_link FROM scrim_token ORDER BY id');

dashboard_header('Link Certificate', 'admin', 'certificate', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Certificate Download Links</caption>
			<thead>
				<tr>
					<th>Event Name</th>
					<th>Download Link</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($events as $row): ?>
				<tr>
					<td><?= e($row['event_name']) ?></td>
					<td><?= ($row['certi_link'] ?? '') !== '' ? external_link($row['certi_link']) : '-' ?></td>
					<td>
						<a href="<?= e(url('en-us/dashboard/admin/edit-certificate-link.php?' . http_build_query(['id' => $row['id']]))) ?>" class="btn first">Edit</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
		</div>
<?php dashboard_footer();
