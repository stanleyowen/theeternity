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