<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('id');

public_header('Info', [
    'css'    => ['dashboard-style.css'],
    'topbar' => false,
]);
public_nav('event');
?>
  <section class="page-section clearfix">
    <div class="container">
		<div class="intro-text left-0 bg-faded p-5 rounded">
		  <h2 class="section-heading mb-4">
			<span class="section-heading-upper">Syarat dan Ketentuan Scrim</span>
		  </h2>
		  <p>
			Diposting oleh : <font color="red">Admin</font><br>
			Diposting pada : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
			Dengan berpartisipasi dalam Our Scrim, Anda menerima perjanjian di bawah ini: <br>
			<ol type="disc">
				<li> Bermain Adil TANPA:
					<ul align = "left">
						<li> CHEAT
						<li> EMULATOR
						<li> TIM
						<li> JOKI
					</ul>
				<li> Pemain TIDAK diperbolehkan melakukan kerusuhan atau melakukan demo di Grup WhatsApp atau media chat lainnya
				<li> Pemain DIPERBOLEHKAN untuk:
					<ol>
						<li> Laporkan Pemain jika kedapatan menyontek [DENGAN BUKTI]
						<li> Berbagi Informasi Scrim setelah acara berakhir
					</ol>
				<li> Pemain yang TERLAMBAT = ABSEN = TIDAK ADA SERTIFIKAT
				<li> Pemain yang bisa bergabung dengan scrim max 25 regu [TERCEPAT] dan 5 regu untuk DAFTAR TUNGGU
				<li> Seperti yang disebutkan di nomor 4, jika ada pemain yang absen, maka akan digantikan dengan REGU DAFTAR TUNGGU [TERCEPAT]
				<li> Pemain yang melanggar aturan seperti yang disebutkan secara diatas, sertifikat akan hangus dan Pemain akan dieliminasi scrim kedepannya oleh Eternity Esports.
			</ol>
			<p> Kami berharap dapat melakukan perilaku yang adil dan kompetitif bagi semua Anggota Scrim dengan menerapkan peraturan yang berlaku.
			<br> <br> <b> Hormat Kami, <br> <br> Tim Eternity </b>
		  </p>
		</div>
    </div>
  </section>

<?php public_footer();
