<?php
  error_reporting(0);
  session_start();
	include('../global-validation/config.php');
	include('../global-validation/validation-message.php');
	$alert = "SELECT * FROM alerts_info";
	$result_alert = mysqli_query($connect,$alert);
	$language  = $_GET['lang'];
	if ($language == "id"){
		$_SESSION['language'] = $language;
	}else if($language == "en"){
		$_SESSION['language'] = $language;
		header('Location: ../en-us/index.php?lang=en');
	}

	$length = 32;
	$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	$cookie_name = "token";
	$cookie_value = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Eternity Esports | Beranda</title>
  <meta name="title" content="Eternity Esports | Official Scrim website">
  <meta name="description" content="Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia. When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website. We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.">
  <link rel="short icon" href="../assets//img/etr-img-1.jpeg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"/>
  <link rel="stylesheet" href="../assets//vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets//css/style.css"/>
  <link rel="stylesheet" href="../assets//css/button.css"/>
  <link rel="stylesheet" href="../assets//css/style-login.css"/>
</head>

<body oncontextmenu = "return false">
  <footer class="footer text-faded text-center py-3 fixed-top">
    <div class="container">
      <p class="m-0 large" align="left">Eternity Esports</p>
	  <p class="m-0 large" align="right">Bahasa <i class="fa fa-globe" aria-hidden="true"></i> : <a href="../en-us/index.php?lang=en">EN</a> | <a href="../id/index.php?lang=id">ID</a></p>
    </div>
  </footer>
  <br><br><br><br>
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
          <li class="nav-item active px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="index.php">Beranda
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="event.php">Info</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="gallery.php">Galeri</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="contact-us.php">Hubungi Kami</a>
          </li>
          <?php include('../global-validation/transform-menu-id.php'); ?>
        </ul>
      </div>
    </div>
  </nav>

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
            <div class="intro-button mx-auto">
      			  <a class="btn btn-primary btn-xl" href="./event/release-notes.php">Catatan Rilis</a>
      			  <a class="btn btn-primary btn-xl" href="../global-validation/redirect.php?lang=id">Gabung Scrim</a>
      		  </div>
    		  </p>
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
		<iframe width="560" height="315" src="https://www.youtube.com/embed/kAiU9rj74_o" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
  </div>
  
  <section class="page-section cta">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded">
            <h2 class="section-heading mb-4">
              <span class="section-heading-upper">TINGGALKAN</span>
              <span class="section-heading-lower">PESAN UNTUK KAMI</span>
            </h2>
            <form action="index.php" method="post">
              <font color='red'><i class="fa fa-lock" aria-hidden="true"></i> Dienkripsi dengan Algoritma AES 256</font><br><br>

			  <?php	include('../global-validation/errors.php');?>
			  <div class="container">
				  <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
				  <input name="honeypot" type="text" id="honeypot" style="display: none">

				  <label><b>Nama Lengkap :</b></label>
				  <input type="text" placeholder="Masukkan Nama Lengkap" name="_name" maxlength="40"/>
				
				  <label><b>Email :</b></label>
				  <input type="email" placeholder="Masukkan Alamat Email" name="_email" maxlength="40"/>
				
				  <label><b>Jenis Tanggapan :</b></label>
				  <select name="_type">
					<option value='improvement'>Perbaikan</option>
					<option value='report-bug'>Melaporkan Bug</option>
					<option value='comment'>Komentar</option>
					<option value='others'>Lainnya</option>
				  </select>
				
				  <label><b>Messages :</b></label>
				  <div class="comment">
					<textarea id="_comment" name="_comment" class="textinput" placeholder="Ketikkan Komentar Anda disini dengan panjang karakter maksimum 200 dan tidak menggunakan karakter khusus." name="_comment" max="200"></textarea>
				  </div>
				
				  <button type="submit" class="submit" name="send_feedback">Submit</button>
			  </div>
			</form>
          </div>
        </div>
      </div>
  </section>
  
  <div class="button" title="Contact Us">
    <a href="https://wa.me/message/SGOS5RUB46CUA1" class="hvr-float-shadow">
  	  <img src="../assets//img/whatsapp-logo.png" width="60">
    </a>
  </div>
  <div class="button1" title="Follow Us On">
    <a href="https://instagram.com/eternity_esports.id" class="hvr-float-shadow1">
	  <img src="../assets//img/instagram-logo.webp" width="60">
    </a>
  </div>
  <div class="button2" title="Mail Us">
    <a href="mailto:theeternity.esports.id@gmail.com" class="hvr-float-shadow2">
	  <img src="../assets//img/gmail-logo.png" width="60">
    </a>
  </div>
  
  <footer class="footer text-faded text-center py-3 fixed-bottom">
    <div class="container">
      <p class="m-0 small">Hak Cipta &copy; 2020 Eternity Esports | Dirancang oleh <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
    </div>
  </footer>
  
	<script src="../assets//vendor/jquery/jquery.min.js"></script>
	<script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
