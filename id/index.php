<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

if (input('lang', '', $_GET) === 'en') {
    redirect('en-us/index.php?lang=en');
}
set_lang('id');
$errors = handle_feedback_form();

public_header('Beranda', [
    'meta_title'  => 'Eternity Esports | Official Scrim website',
    'description' => "Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia.",
    'css'         => ['style-login.css'],
    'lang_links'  => ['en' => 'index.php?lang=en', 'id' => 'index.php?lang=id'],
]);
public_nav('home');
?>

  <section class="page-section clearfix">
    <div class="container">
        <div class="intro-text left-0 text-center bg-faded p-5 rounded">
          <h2 class="section-heading mb-4">
            <span class="section-heading-upper">Selamat Datang di</span>
            <span class="section-heading-lower">Eternity Esports</span>
          </h2>
          <p class="mb-3" align="left">
      			Selamat datang di Situs Resmi Eternity Esports. Kami berdedikasi untuk memberi Anda pengalaman scrim terbaik, dengan fokus pada acara scrim dan mengembangkan keterampilan.
      			Didirikan pada tahun 2019 oleh Owen Tristan, Eternity Esports telah berkembang jauh dari awalnya di Medan, Indonesia.
      			Ketika Eternity Esports pertama kali dimulai, semangat kami untuk berkembang mendorong kami untuk membuat situs web online dengan keamanan tingkat lanjut, sehingga kami dapat menawarkan Anda
      			samaran yang adil dan kompetitif. Kami siap melayani pelanggan di seluruh dunia, dan sangat senang karena kami dapat mengubah hasrat kami menjadi situs web kami sendiri.
      			Kami harap Anda menikmati layanan yang kami berikan. Jika Anda memiliki pertanyaan atau komentar, jangan ragu untuk menghubungi kami / tinggalkan pesan untuk kami.
          </p>
          <div class="intro-button mx-auto">
            <a class="btn btn-primary btn-xl" href="<?= e(lang_url('event/release-notes.php')) ?>">Catatan Rilis</a>
            <a class="btn btn-primary btn-xl" href="<?= e(url('global-validation/redirect.php?lang=id')) ?>">Gabung Scrim</a>
          </div>
        </div>
    </div>
  </section>

  <style>
	.responsive {
		width: 100%;
		height: 0;
		padding-bottom: 56.25%;
		position: relative;
	}
	.responsive iframe {
		width: 100%;
		height: 100%;
		position: absolute;
	}
	.error {
		width: 92%;
		margin: 0px auto;
		padding: 10px;
		border: 1px solid #a94442;
		color: #a94442;
		background: #f2dede;
		border-radius: 5px;
		text-align: left;
    }
  </style>

  <div class="bg-faded p-5 rounded">
	<div class="responsive">
		<h2>Informasi Terbaru</h2>
		<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/kAiU9rj74_o" title="Eternity Esports — informasi terbaru" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
  </div>

  <section class="page-section cta" id="message-us">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded">
            <h2 class="section-heading mb-4">
              <span class="section-heading-upper">TINGGALKAN</span>
              <span class="section-heading-lower">PESAN UNTUK KAMI</span>
            </h2>
            <form action="<?= e(lang_url('index.php')) ?>#message-us" method="post">
              <font color='red'><i class="fa fa-lock" aria-hidden="true"></i> Dienkripsi dengan Algoritma AES 256</font><br><br>

			  <?php form_errors($errors); ?>
			  <div class="container">
				<?= csrf_field() ?>
				<input name="honeypot" type="text" id="honeypot" style="display: none" tabindex="-1" autocomplete="off" aria-hidden="true">

				<label for="_name"><b>Nama Lengkap :</b></label>
				<input type="text" placeholder="Masukkan Nama Lengkap" id="_name" name="_name" maxlength="40" required/>

				<label for="_email"><b>Email :</b></label>
				<input type="email" placeholder="Masukkan Alamat Email" id="_email" name="_email" maxlength="100" required/>

				<label for="_type"><b>Jenis Tanggapan :</b></label>
				<select id="_type" name="_type">
					<option value='improvement'>Perbaikan</option>
					<option value='report-bug'>Melaporkan Bug</option>
					<option value='comment'>Komentar</option>
					<option value='others'>Lainnya</option>
				</select>

				<label for="_comment"><b>Messages :</b></label>
				<div class="comment">
					<textarea id="_comment" class="textinput" placeholder="Ketikkan Komentar Anda disini (Maksimum 2000 karakter)" name="_comment" maxlength="2000" required></textarea>
				</div>

				<button type="submit" class="submit" name="send_feedback">Submit</button>
			  </div>
			</form>
          </div>
        </div>
      </div>
  </section>

<?php public_footer();
