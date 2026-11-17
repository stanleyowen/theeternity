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
			<span class="section-heading-upper">Catatan RIlis</span>
		  </h2>
		  <p>
			Diposting oleh : <font color="red">Admin</font><br>
			Diposting pada : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
			<center><b id="archive-edition">Eternity v1.0 &mdash; Edisi Arsip (2026)</b></center>
			<br>
			<p>Eternity Esports tidak lagi mengadakan scrim. Situs ini dipulihkan sebagai arsip baca-saja agar proyek ini tetap dapat dilihat, dan kodenya dibangun ulang dengan standar keamanan modern tanpa mengubah desain asli tahun 2020.</p>
			<ol>
				<li>Mode arsip: situs bersifat baca-saja, dan pendaftaran, scrim, serta pesan telah ditutup. Pengunjung tetap dapat menjelajahi dashboard Pemain dan Administrator melalui akses demo di halaman Masuk.
				<li>Dibangun ulang dengan PHP 8 dan prepared statement untuk setiap query database (perlindungan dari SQL injection)
				<li>Kata sandi di-hash dengan bcrypt, dan proses masuk hanya menggunakan cookie sesi yang aman. Kredensial tidak pernah disimpan di cookie.
				<li>Peran pengguna diverifikasi di server untuk setiap halaman dan aksi. Akses Administrator tidak dapat lagi dipilih dari formulir masuk.
				<li>Semua konten pengguna di-escape (perlindungan dari XSS), dan setiap halaman dilindungi Content Security Policy yang ketat
				<li>Perlindungan CSRF di setiap formulir. Aksi hapus memerlukan permintaan POST dengan konfirmasi.
				<li>Foto yang diunggah diverifikasi sebagai gambar asli, diganti namanya, di-encode ulang, dan disimpan secara privat
				<li>Pesan dienkripsi dengan AES-256-GCM terautentikasi. Masuk, pendaftaran, dan pesan dibatasi lajunya di server.
				<li>Diperbarui ke Bootstrap 4.6.2 / 3.4.1, jQuery 3.7.1, dan Font Awesome 4.7, semuanya disajikan secara lokal
			</ol>
			<br>
			<center><b>Eternity v0.11</b></center>
			<br>
			<ol>
				<li>Menambahkan 3+ lapisan keamanan ke Situs Web Eternity :
					<ul type="disc">
						<li>Menambahkan Sertifikat SSL untuk Mengamankan Informasi Klien ketika data berpindah dari Komputer Klien ke WebServer
						<li>Menambahkan fitur keamanan di Pesan, Masuk, Daftar, dll. Untuk mencegah dari Bot dan Spam
						<li>Mengubah beberapa logika dalam Validasi Login dan Formulir Pendaftaran
						<li>Pesan Kesalahan Dinonaktifkan untuk mencegah kerentanan, kebocoran data, dll.
					</ul>
				<li>Menambahkan Fitur MultiLanguage yaitu Indonesia (ID)
				<li>Menambahkan Halaman Error :
					<ul type="disc">
						<li>403 Forbidden
						<li>404 Not Found
						<li>405 Method Not Allowed
						<li>408 Request Time Out
						<li>500 Internal Server Error
						<li>502 Bad Gateway
						<li>503 Service Currently Unavailable
						<li>504 Gateway Timeout
					</ul>
				<li>Memperbaiki Bug pada Validasi Pesan, Validasi Login, dan Validasi Registrasi
				<li>Changed Style of :
					<ul type="disc">
						<li>Formulir Pesan
						<li>Formulir Masuk
						<li>Formulir Daftar
					</ul>
				</li>
				<li>Memperbaiki User Interface (UI) dalam Formulir Login dan Pendaftaran
				<li>Pembatasan permintaan dalam Formulir Pesan, Login, dan Pendaftaran dihapus dan diubah dengan reCAPTCHA
			</ol>
			<center><b>Eternity v0.10</b></center>
			<p>Eternity Esports berisi 5 fitur untuk Pengguna, yaitu:</p>
			<ol>
				<li> Masuk dan Keluar dengan Aman dengan Tingkat Validasi (Akses 24/7/365)
				<li> Pengguna Dashboard
				<li> Fitur Kehadiran
				<li> Unggah Fitur
				<li> Unduh Fitur Sertifikat
			</ol>
			<p>Eternity Esports berisi lebih dari 10 fitur untuk Administrator, yaitu:<br></p>
			<ol>
				<li> Masuk dan Keluar dengan Aman dengan Tingkat Validasi (Akses 24/7/365)
				<li> Edit Acara Scrim
				<li> Edit Lansiran untuk Situs Web
				<li> Fitur Unggah untuk Sertifikat dan Tab Galeri
				<li> Kelola, Edit, Hapus, dan Memblokir Pengguna
				<li> Lihat Unggahan Pengguna
				<li> Adakan Acara
				<li> Lihat Daftar Kehadiran
				<li> Lihat Pesan
				<li> Memantau Log Keamanan
				<li> Memantau Aktivitas Pengguna
			</ol>
			<p>Beberapa Fitur Keamanan yang kami sediakan, seperti :</p>
			<ol>
				<li> Mencegah dari Brute Attack
				<li> Log Aktivitas Pengguna
				<li> IP Blocker
			</ol>
			<p><b>Moto Kami : "<i>Bersatu Kita Teguh, Bercerai Kita Runtuh</i>"
			<br>Salam Kami,<br><br>Tim Eternity</b></p>
		  </p>
		</div>
    </div>
  </section>

<?php public_footer();
