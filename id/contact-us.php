<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';
set_lang('id');

public_header('Hubungi Kami', [
    'meta_title'  => 'Eternity Esports | Contact Us',
    'description' => 'Welcome to Eternity Esports Official Website. Besides providing interesting scrim events, we provide 24/7/365 support.',
    'lang_links'  => ['en' => 'contact-us.php', 'id' => 'contact-us.php'],
]);
public_nav('contact');

$days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
?>

    <section class="page-section cta">
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
              <h2 class="section-heading mb-5">
                <span class="section-heading-upper">Obrolan Online Tersedia Pada :</span>
              </h2>
              <ul class="list-unstyled list-hours mb-5 text-left mx-auto">
<?php foreach ($days as $day): ?>
                <li class="list-unstyled-item list-hours-item d-flex">
                  <?= e($day) ?>

                  <span class="ml-auto">9:00 AM sd 9:00 PM</span>
                </li>
<?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php public_footer();
