<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user       = require_player();
$membership = require_membership($user, current_lang());

dashboard_header('Absensi', 'player', 'attendance', $user);
?>
		<div class="col-sm-9">
		  <h2>Cara Melakukan Absensi</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Pilihlah scrim yang akan dilakukan User untuk absensi</li>
			<li>Scrim Token dibagikan oleh Admin 3-12 jam sebelum Scrim</li>
			<li>Masukkan Scrim Token yang dikirim oleh Admin di WhatsApp Grup</li>
			<li>Jika Anda sudah menerima notifikasi 'Attendance was successfully done! Thank You', User telah berhasil dalam melakukan Absensi</li>
			<li>User yang terlambat melakukan Absensi, sama dengan ABSEN, dan digantikan dengan SLOT WAITING LIST</li>
		  </ol>

		  <form action="<?= e(url('function/attendance-user.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="id"><b>Absensi &nbsp; &nbsp; &nbsp;:</b></label>
				<select name="id" id="id" required>
					<option value="<?= e($membership['event_id']) ?>"><?= e($membership['event_name']) ?></option>
				</select><br>
			<label for="token"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="password" placeholder="Enter Token Provided by Administrator" name="token" id="token" autocomplete="off" required><br>
			<button class="btn first" type="submit">Submit</button>
		  </form>
		</div>
<?php dashboard_footer();
