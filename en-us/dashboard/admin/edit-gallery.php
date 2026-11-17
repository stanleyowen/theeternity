<?php
declare(strict_types=1);

require __DIR__ . '/../../../app/bootstrap.php';
set_lang('en');
$user = require_admin();

$photos = db_all('SELECT id, file_name, uploaded_on FROM gallery ORDER BY id');

dashboard_header('Edit Gallery', 'admin', 'gallery', $user);
?>
		<div class="col-sm-9">
<?php admin_intro(); ?>

		  <div class="table-scroll">
		  <table class="data-table" border=1>
			<caption class="title">Gallery Photos</caption>
			<thead>
				<tr>
					<th>File Name</th>
					<th>Uploaded</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($photos as $row): ?>
				<tr>
					<td><a href="<?= e(media_url('gallery', $row['file_name'])) ?>" target="_blank" rel="noopener noreferrer"><?= e($row['file_name']) ?></a></td>
					<td><?= e($row['uploaded_on']) ?></td>
					<td>
						<?= action_button('delete-gallery-id.php', ['id' => $row['id']], 'Delete', 'Are You Sure want to Delete This Data?') ?>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		  </table>
		  </div>
		  <br><br>
		  <h4><small><font color="red">Delete ALL DATA :</font></small></h4>
		  <form action="<?= e(url('function/delete-gallery-ALL.php')) ?>" method="post">
			<?= csrf_field() ?>
			<label for="code"><b>CODE :</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" id="code" name="code" autocomplete="off" required>
			<button class="btn first" type="submit">Delete</button>
		  </form>
		  <h4><small><font color="green">Edit Gallery :</font></small></h4>
		  <form action="<?= e(url('function/upload-certificate.php')) ?>" method="post" enctype="multipart/form-data">
			<?= csrf_field() ?>
			<input type="file" name="file" accept="image/jpeg,image/png" required>
			<button class="btn first" type="submit" name="submit">Upload</button>
		  </form>
		</div>
<?php dashboard_footer();
