<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user       = require_player();
$membership = require_membership($user, current_lang());

$instagram   = 'https://www.instagram.com/eternity_esports.id/';
$uploadForms = [
    ['upload-squad-picture.php', 'UNGGAH LOGO SQUAD [SEKALI][LEBIH KECIL DARI 500kB]:', false],
    ['upload-instagram-picture.php', 'UNGGAH BUKTI FOLLOW IG [SEKALI][LEBIH KECIL DARI 500kB]:', true],
    ['upload-instagram-picture-2.php', 'UNGGAH BUKTI FOLLOW IG [SEKALI][LEBIH KECIL DARI 500kB]:', true],
];

dashboard_header('Pusat Pengunggahan', 'player', 'upload', $user);
?>
		<div class="col-sm-9">
		  <h2>Cara Mengunggah Foto</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Prosedur :</font><br>
		  <ol>
			<li>Pemain membutuhkan total 3 foto yang diharus diupload di masing-masing tempat yaitu :
				<ul type="disc">
					<li>1 Logo Squad dengan format NamaSquad</li>
					<li>2 SS Bukti Follow Instagram</li>
				</ul>
			</li>
			<li>User mengunggah foto sesuai dengan tempatnya.</li>
			<li>Pastikan nama file yang akan diupload memiliki panjang kurang dari 50 karakter</li>
			<li>Pastikan file anda memiliki ukuran dibawah 500kb [Jika melebihi maka akan terjadi error]</li>
			<li>User hanya diperbolehkan mengupload foto dengan extension JPEG, JPG, dan PNG.</li>
			<li>Jika file yang diupload telah berhasil, nama file yang diupload akan ditampilkan di tabel.</li>
			<li>User hanya boleh mengupload 1x di setiap tempat yang disediakan.</li>
			<li>User yang melakukan upload lebih dari 1x, maka akan DIELIMINASI.</li>
			<li>Jika terjadi kesalahan seperti kesalahan upload, silahkan hubungi Admin.</li>
		  </ol>

		  <table class="data-table" border=1>
			<caption class="title">Status Unggah</caption>
			<thead>
				<tr>
					<th>Squad Logo</th>
					<th>IG Proof (1)</th>
					<th>IG Proof (2)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= e($membership['squad_pic'] ?: '-') ?></td>
					<td><?= e($membership['ig_proof'] ?: '-') ?></td>
					<td><?= e($membership['ig_proof_2'] ?: '-') ?></td>
				</tr>
			</tbody>
		  </table>
<?php foreach ($uploadForms as [$action, $label, $showInstagram]): ?>

		  <h4><small><font color="red">
<?php if ($showInstagram): ?>
		  <?= external_link($instagram) ?>
		  <br>
<?php endif; ?>
		  <?= e($label) ?></font></small></h4>
		  <form action="<?= e(url('function/' . $action)) ?>" method="post" enctype="multipart/form-data">
			<?= csrf_field() ?>
			<input type="file" name="file" accept="image/jpeg,image/png" required>
			<button class="btn first" type="submit" name="submit">Unggah</button>
		  </form>
<?php endforeach; ?>
		</div>
<?php dashboard_footer();
