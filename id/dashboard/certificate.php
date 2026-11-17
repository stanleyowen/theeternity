<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user       = require_player();
$membership = require_membership($user, current_lang());
// Only the certificate of the scrim this player joined.
$event = db_one('SELECT event_name, certi_link FROM scrim_token WHERE id = ?', [$membership['event_id']]);

dashboard_header('Unduh E-Sertifikat', 'player', 'certificate', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Download Scrim Certificate</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Announcement and E-Certificate will be announced no later than 2 days after scrim at 24.00 WIB</li>
			<li>E-Certificate Link will be redirected to Google Drive</li>
		  </ol>

		  <table class="data-table" border=1>
			<caption class="title">TOP #10 WINNER WINNER CHICKEN DINNER CERTIFICATES</caption>
			<thead>
				<tr>
					<th>Event Name</th>
					<th>Download Link</th>
				</tr>
			</thead>
			<tbody>
<?php if ($event !== null): ?>
				<tr>
					<td><?= e($event['event_name']) ?></td>
					<td><?= trim((string) $event['certi_link']) === '' ? e('Belum tersedia') : external_link($event['certi_link']) ?></td>
				</tr>
<?php endif; ?>
			</tbody>
		  </table>
		</div>
<?php dashboard_footer();
