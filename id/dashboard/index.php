<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user = require_player();

dashboard_header('Dashboard', 'player', 'dashboard', $user);
?>
		<div class="col-sm-9">
		  <hr>
		  <h2>Apa itu Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span> <span class="label label-primary">Orientation</span></h5><br>
		  <p>Scrim adalah pertandingan latihan online melawan beberapa pemain atau tim. Kata scrim berasal dari kependekan dari "scrimmage". Ini pada dasarnya adalah permainan kompetitif yang Anda mainkan melawan pemain atau tim kompetitif lainnya untuk berlatih dalam pertandingan tanpa peringkat. Kata ini paling sering digunakan di antara anggota klan di game first-person shooter online. Scrim sering diadakan di hampir semua game online, termasuk PUBG Mobile</p>
		</div>
		<div class="col-sm-9">
		  <hr>
		  <h2>Bagaimana Cara Mengikuti Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <font color="red">Requirements :</font><br>
		  Pastikan Anda telah membaca <a href="<?= e(lang_url('event/terms-and-conditions-scrim.php')) ?>">Syarat dan Ketentuan</a> mengenai Scrim<br><br>
		  <font color="red">Prosedur :</font><br>
		  <ol>
			<li>Berpartisipasi dalam Scrim</li>
			<li>Bergabung dengan WhatsApp Grup untuk mendapatkan informasi terbaru dari kami</li>
			<li>Unggah 1 Logo Squad dan 2 SS Bukti Instagram</li>
			<li>Absensi di bagian Kehadiran/Absensi guna berpartisipasi dalam Scrim.</li>
			<li>Unduh E-Sertifikat Anda</li>
		  </ol>
		  <br><br>
		</div>
<?php dashboard_footer();
