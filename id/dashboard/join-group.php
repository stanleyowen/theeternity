<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user       = require_player();
$membership = require_membership($user, current_lang());
// Only the group of the scrim this player joined (the 2020 page listed every event's link).
$event = db_one('SELECT event_name, wa_link FROM scrim_token WHERE id = ?', [$membership['event_id']]);

dashboard_header('Bergabung Dengan WhatsApp Grup', 'player', 'join-group', $user);
?>
		<div class="col-sm-9">
		  <h2>Join WhatsApp Group</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Prosedur :</font><br>
		  <ol>
			<li>Pilih Grup WhatsApp sesuai Scrim yang Anda ikuti</li>
			<li><font color="red">Setelah user join Grup WhatsApp, User mengirim format Nama Squad di group. Jika dalam jangka 2x24 jam user tidak memberikan respon, maka user akan dieliminasi.</font></li>
		  </ol>

		  <table class="data-table" border=1>
			<thead>
				<tr>
					<th>Scrim Event</th>
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
