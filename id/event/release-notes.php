<?php
	session_start();
	include('../../global-validation/config.php');
	$query = "SELECT * FROM scrim_info";
	$results = mysqli_query($connect, $query);
	$alert = "SELECT * FROM alerts_info";
	$result_alert = mysqli_query($connect,$alert);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="short icon" href="../../assets/img/etr-img-1.jpeg">
  <link rel="stylesheet" href="../../assets/css/dashboard-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"/>
  <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css"/>
  <link rel="stylesheet" href="../../assets/css/button.css"/>
</head>

<body oncontextmenu = "return false">
	<?php foreach ($result_alert as $row) {
	  echo'
	  <div class="alert alert-'.$row['type'].'">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		'.$row['description'].'
		<a href="'.$row['link'].'">Click here <i class="fa fa-external-link"></i></a>
	  </div>';
    }
  ?>
  
  <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
      <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Menu</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../index.php">Beranda</a>
          </li>
          <li class="nav-item active px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../event.php">Info</a>
            <span class="sr-only">(current)</span>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../gallery.php">Galeri</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../contact-us.php">Hubungi Kami</a>
          </li>
          <?php include('../../global-validation/transform-menu-id-event.php'); ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="page-section clearfix">
    <div class="container">
		<div class="intro-text left-0 bg-faded p-5 rounded">
		  <h2 class="section-heading mb-4">
			<span class="section-heading-upper">Catatan RIlis</span>
		  </h2>
		  <p>
			Diposting oleh : <font color="red">Admin</font><br>
			Diposting pada : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
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

  <footer class="footer text-faded text-center py-3 fixed-bottom">
    <div class="container">
      <p class="m-0 small">Copyright &copy; 2020 Eternity Esports | Designed by <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
    </div>
  </footer>
  
  <div class="button" title="Contact Us">
    <a href="https://wa.me/message/SGOS5RUB46CUA1" class="hvr-float-shadow">
  	  <img src="../../assets/img/whatsapp-logo.png" width="60">
    </a>
  </div>

  <div class="button1" title="Follow Us On">
    <a href="https://instagram.com/eternity_esports.id" class="hvr-float-shadow1">
	  <img src="../../assets/img/instagram-logo.webp" width="60">
    </a>
  </div>

  <div class="button2" title="Mail Us">
    <a href="mailto:theeternity.esports.id@gmail.com" class="hvr-float-shadow2">
	  <img src="../../assets/img/gmail-logo.png" width="60">
    </a>
  </div>
  
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>