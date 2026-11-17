<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
set_lang('id');

$photos = db_all('SELECT file_name FROM gallery ORDER BY uploaded_on DESC');

public_header('Galeri', [
    'meta_title'  => 'Eternity Esports | Gallery',
    'description' => 'Welcome to Eternity Esports Official Website. Here are all of our certificates and appreciation made by our members.',
    'lang_links'  => ['en' => 'gallery.php', 'id' => 'gallery.php'],
]);
public_nav('gallery');

foreach ($photos as $row):
    $src = media_url('gallery', $row['file_name']);
    if ($src === '') {
        continue;
    } ?>
  <section class="page-section cta">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded">
			<img src="<?= e($src) ?>" class="container gallery-image" alt="Foto galeri Eternity Esports" loading="lazy">
		  </div>
		</div>
	</div>
  </section>
<?php endforeach;

if ($photos === []): ?>
  <section class="page-section cta">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded"><p class="m-0"><?= e(t('gallery_empty')) ?></p></div>
		</div>
	</div>
  </section>
<?php endif;

public_footer();
