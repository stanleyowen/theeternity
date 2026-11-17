<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$username = input('username', '', $_GET);
$d = $username !== ''
    ? db_one('SELECT username, squad_pic, ig_proof, ig_proof_2 FROM scrim_member WHERE username = ?', [$username])
    : null;

// [label, alt text, upload bucket, scrim_member column]; \u{00A0} keeps the 2020 label alignment.
$images = [
    ["Logo Squad \u{00A0} \u{00A0} \u{00A0} :", 'Logo Squad', 'logo-squad', 'squad_pic'],
    ['Instagram Proof :', 'Instagram Proof', 'ig-proof', 'ig_proof'],
    ['Instagram Proof 2 :', 'Instagram Proof 2', 'ig-proof-2', 'ig_proof_2'],
];

dashboard_header('Participant', 'admin', 'participant', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>
<?php if ($d === null): ?>
		  <p>Participant not found. <a href="<?= e(url('en-us/dashboard/admin/user-upload.php')) ?>">Back to participants</a></p>
<?php else: ?>
		  Squad Name &nbsp; &nbsp; : <?= e($d['username']) ?><br>
<?php foreach ($images as [$label, $alt, $bucket, $column]): ?>
<?php $src = media_url($bucket, $d[$column]); ?>
		  <?= e($label) ?><br>
<?php if ($src === ''): ?>
		  Not uploaded<br>
<?php else: ?>
		  <img class="upload-preview" src="<?= e($src) ?>" alt="<?= e($alt) ?>"><br>
<?php endif; ?>
<?php endforeach; ?>
		  <hr>
<?php endif; ?>
		  <br><br>
		  <br><br>
		</div>
<?php dashboard_footer();
