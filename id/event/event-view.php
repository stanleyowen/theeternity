<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');

// Hidden posts are shared with participants through a private code (?encryption=CODE).
$code  = input('encryption', '', $_GET);
$posts = ($code !== '' && strlen($code) <= 20)
    ? db_all("SELECT header, posted_by, date, description FROM scrim_info WHERE type = 'hidden' AND code = ? ORDER BY date DESC", [$code])
    : [];

public_header('Info', [
    'css'    => ['dashboard-style.css'],
    'topbar' => false,
]);
public_nav('event');
?>

  <section class="page-section clearfix">
    <div class="container">
<?php foreach ($posts as $d): ?>
		<div class="intro-text left-0 bg-faded p-5 rounded">
		  <h2 class="section-heading mb-4">
			<span class="section-heading-upper"><?= e($d['header']) ?></span>
		  </h2>
		  <p>
			Diposting oleh : <font color="red"><?= e($d['posted_by']) ?></font><br>
			Diposting pada : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> <?= e($d['date']) ?></font><br>
			<?= e_multiline($d['description']) ?>
		  </p>
		</div><br>
<?php endforeach; ?>
<?php if ($posts === []): ?>
		<div class="intro-text left-0 bg-faded p-5 rounded"><p><?= e(t('events_empty')) ?></p></div>
<?php endif; ?>
    </div>
  </section>

<?php public_footer();
