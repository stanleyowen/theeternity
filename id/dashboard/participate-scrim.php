<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user = require_player();

// One scrim at a time (was enforced by a forgeable "JScrim" cookie). Demo visitors may still look at the page.
if (membership_for($user['username']) !== null && !$user['demo']) {
    flash(t('already_joined'));
    redirect('id/dashboard/index.php');
}
$events = db_all('SELECT id, event_name FROM scrim_token ORDER BY id DESC');

dashboard_header('Berpartisipasi Dalam Scrim', 'player', 'participate', $user);
?>
		<div class="col-sm-9">
		  <h2>Cara Berpartisipasi Dalam Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Baca Syarat dan Ketentuan yang berlaku</li>
			<li>Pilih Scrim yang akan User ikuti</li>
			<li>Pastikan User mencentang semua Syarat dan Ketentuan</li>
			<li>User tidak diperbolehkan mengikuti lebih dari 1 Scrim yang diadakan Eternity secara bersamaan</li>
			<li>User menekan Partisipasi</li>
			<li>Jika User telah menekan tombol Partisipasi dan muncul notifikasi 'Successfully Participated the Scrim', User berhasil register dan dapat mengakses fitur-fitur seperti 'Pusat Pengunggahan', 'Kehadiran / Absensi', dan 'Unduh E-Sertifikat'.</li>
			<li>User tidak akan mengakses Tab ini sampai Event yang diikuti User Berakhir.</li>
		  </ol>

		  <form action="<?= e(url('function/participate-in-scrim.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="event_id"><b>Participate in :</b></label>
				<select name="event_id" id="event_id" required>
<?php foreach ($events as $row): ?>
					<option value="<?= e($row['id']) ?>"><?= e($row['event_name']) ?></option>
<?php endforeach; ?>
				</select><br>
			<label class="container">Saya setuju dengan <a href="<?= e(lang_url('event/terms-and-conditions-scrim.php')) ?>">Syarat dan Ketentuan</a> yang berlaku
			  <input type="checkbox" name="term1" value="1" required>
			  <span class="checkmark"></span>
			</label>

			<label class="container">Saya setuju dengan Eternity Esports dapat mengumpulkan Informasi Pribadi untuk memonitor user dengan tujuan untuk mencegah terjadinya kecurangan selama Scrim.
			  <input type="checkbox" name="term2" value="1" required>
			  <span class="checkmark"></span>
			</label>
			<button class="btn first" type="submit">PARTICIPATE</button>
		  </form>
		</div>
<?php dashboard_footer();
