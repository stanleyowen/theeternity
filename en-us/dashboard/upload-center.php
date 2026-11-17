<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user       = require_player();
$membership = require_membership($user, current_lang());

$uploadForms = [
    ['upload-squad-picture.php', 'UPLOAD SQUAD IMAGE [ONCE][not larger than 500 kB]:'],
    ['upload-instagram-picture.php', 'UPLOAD INSTAGRAM PROOF 1 [ONCE][not larger than 500 kB]:'],
    ['upload-instagram-picture-2.php', 'UPLOAD INSTAGRAM PROOF 2 [ONCE][not larger than 500 kB]:'],
];

dashboard_header('Upload Center', 'player', 'upload', $user);
?>
		<div class="col-sm-9">
		  <h2>How to Upload a Picture</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Player needs 3 photos to be uploaded, which is :
				<ul type="disc">
					<li>1 Squad Logo with the format SquadName</li>
					<li>2 SS Instagram Proof format SquadName_IG_(1/2)</li>
				</ul>
			</li>
			<li>Upload the photo according to the uploaded place</li>
			<li>Make sure your file name [LENGTH] doesn't longer than 50 characters [&lt;50 chars]</li>
			<li>Make sure your file is under 500kB</li>
			<li>Only file with extension JPEG, JPG, and PNG are allowed</li>
			<li>Once file was uploaded successfully, file name will be displayed in the table.</li>
			<li>Each User can only upload ONCE per place</li>
			<li>User who upload more than ONCE will be ELIMINATED</li>
			<li>If something went wrong, contact our Admin to get support</li>
		  </ol>

		  <table class="data-table" border=1>
			<caption class="title">Upload Status</caption>
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
<?php foreach ($uploadForms as [$action, $label]): ?>

		  <h4><small><font color="red"><?= e($label) ?></font></small></h4>
		  <form action="<?= e(url('function/' . $action)) ?>" method="post" enctype="multipart/form-data">
			<?= csrf_field() ?>
			<input type="file" name="file" accept="image/jpeg,image/png" required>
			<button class="btn first" type="submit" name="submit">Upload</button>
		  </form>
<?php endforeach; ?>
		</div>
<?php dashboard_footer();
