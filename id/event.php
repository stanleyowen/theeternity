<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
set_lang('id');

$posts = db_all("SELECT header, posted_by, date, description FROM scrim_info WHERE type = 'public' ORDER BY date DESC");

public_header('Info', [
    'meta_title'  => 'Eternity Esports | Events',
    'description' => 'Welcome to Eternity Esports Official Website. We have a consistent schedule of fair and exciting scrim events every month. Check it out now!',
    'lang_links'  => ['en' => 'event.php', 'id' => 'event.php'],
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
					Dipublikasikan Oleh : <font color="red"><?= e($d['posted_by']) ?></font><br>
					Dipublikasikan Pada : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> <?= e($d['date']) ?></font><br>
					Deskripsi &nbsp; :<br>
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
