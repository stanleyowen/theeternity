<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');
$user       = require_player();
$membership = require_membership($user, current_lang());

$matches = [
    1 => ['submit-result.php', '# Hasil Match 1 #'],
    2 => ['submit-result-2.php', '# Hasil Match 2 (Jika Ada) #'],
];

dashboard_header('Mengirim Hasil Akhir', 'player', 'result', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Submit a Result</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Sebelum mengirim hasil akhir match, cek kembali nama event yang diikuti</li>
			<li>Masukkan Hasil Akhir Match [Hanya Input Angka]</li>
			<li>Juara dan Kill adalah TOTAL 1 Squad per MATCH BUKAN PER ORANG</li>
			<li>Setiap User hanya Bisa menginput 1x per MATCH</li>
			<li>User Hanya Boleh Menginput Angka [MAKS 2 DIGIT]</li>
			<li>Jika berhasil, maka akan muncul pesan 'Result Submitted'</li>
			<li>Pemain yang asal-asalan isi Juara dan Kill akan DIELIMINASI</li>
		  </ol>
<?php foreach ($matches as $n => [$action, $heading]): ?>
		  <br>
		  <p><font color="red"><?= e($heading) ?></font></p>
		  <form action="<?= e(url('function/' . $action)) ?>" method="post">
			<?= csrf_field() ?>
			<input name="honeypot" type="text" id="honeypot-<?= e($n) ?>" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true">
			<label for="id-<?= e($n) ?>"><b>Event Name :</b></label>
				<select name="id" id="id-<?= e($n) ?>" required>
					<option value="<?= e($membership['event_id']) ?>"><?= e($membership['event_name']) ?></option>
				</select><br>
			<label for="rank-<?= e($n) ?>"><b>Rank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : #</b></label>
			<input type="number" placeholder="Enter Rank Result Match <?= e($n) ?>" name="rank" id="rank-<?= e($n) ?>" min="1" max="100" required><br>
			<label for="kill-<?= e($n) ?>"><b>Kill &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </b></label>
			<input type="number" placeholder="Enter Total Kill Match <?= e($n) ?>" name="kill" id="kill-<?= e($n) ?>" min="0" max="99" required><br>
			<button class="btn first" type="submit">Submit</button>
		  </form>
<?php endforeach; ?>
		</div>
<?php dashboard_footer();
