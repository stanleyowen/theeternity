<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user       = require_player();
$membership = require_membership($user, current_lang());
// Only the group of the scrim this player joined (the 2020 page listed every event's link).
$event = db_one('SELECT event_name, wa_link FROM scrim_token WHERE id = ?', [$membership['event_id']]);

dashboard_header('Join WhatsApp Group', 'player', 'join-group', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Join WhatsApp Group</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Choose the WhatsApp Group Link which you participate (According to the event you participated in before)</li>
			<li><font color="red">Once you join the WhatsApp Group Link, please chat us YOUR SQUAD NAME, otherwise player will be eliminated</font></li>
		  </ol>

		  <table class="data-table" border=1>
			<thead>
				<tr>
					<th>Event Name</th>
					<th>WhatsApp Group Link</th>
				</tr>
			</thead>
			<tbody>
<?php if ($event !== null): ?>
				<tr>
					<td><?= e($event['event_name']) ?></td>
					<td><?= external_link($event['wa_link']) ?></td>
				</tr>
<?php endif; ?>
			</tbody>
		  </table>
		</div>
<?php dashboard_footer();
