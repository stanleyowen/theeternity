<?php
	session_start();
	include('../../global-validation/validation-reg.php');
	$alert = "SELECT * FROM alerts_info";
	$result_alert = mysqli_query($connect,$alert);

	$length = 32;
	$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	$cookie_name = "token";
	$cookie_value = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Eternity Esports | Daftar</title>
  <link rel="short icon" href="../../assets/img/etr-img-1.jpeg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"/>
  <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css"/>
  <link rel="stylesheet" href="../../assets/css/button.css"/>
  <link rel="stylesheet" href="../../assets/css/style-login.css">
</head>

<body oncontextmenu = "return false">
  <footer class="footer text-faded text-center py-3 fixed-top">
    <div class="container">
      <p class="m-0 large" align="left">Eternity Esports</p>
	  <p class="m-0 large" align="right">Bahasa <i class="fa fa-globe" aria-hidden="true"></i> : <a href="../../en-us/login/register.php">EN</a> | <a href="../../id/login/register.php">ID</a></p>
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

  <style>
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

  .success {
	color: #3c763d; 
	background: #dff0d8; 
	border: 1px solid #3c763d;
	margin-bottom: 20px;
  }

  .container-footer {
    padding: 16px;
  }
  </style>

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
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../event.php">Info</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../gallery.php">Galeri</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../contact-us.php">Hubungi Kami</a>
          </li>
		  <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="index.php">Masuk</a>
          </li>
		  <li class="nav-item active px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="">Daftar
				<span class="sr-only">(current)</span>
			</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container">
	  <div class="intro-text left-0 text-center bg-faded p-2 rounded">
            <div class="cta-inner text-center rounded">
				<h2 class="section-heading mb-4">
				  <span class="section-heading-upper">Daftar</span>
				</h2>
				<form action="register.php" method="post">
				  <p><font color='red'>Buat Akun Squad Anda untuk Masuk ke Dashboard<br>
				  <i class="fa fa-lock" aria-hidden="true"></i> Dienkripsi dengan Algoritma AES 256</font></p><br>
				   
				  <?php	include('../../global-validation/errors.php');?>
				  
				  <div class="container">
				  	<input type="hidden" name="token" value="<?=$_SESSION['token']?>"/>
            <input name="honeypot" type="text" id="honeypot" style="display: none" />

  					<label><b>Clan Username :</b></label>
  					<input type="text" placeholder="Masukkan Clan Username" name="_username" maxlength="50">
  					
  					<label><b>Kata Sandi :</b></label>
  					<input type="password" placeholder="Masukkan Kata Sandi" name="_password" maxlength="50">
  					
  					<label><b>Konfirmasi Kata Sandi :</b></label>
  					<input type="password" placeholder="Ketik Ulang Kata Sandi" name="_confirmpassword" maxlength="50">
  					<br>
  					
  					<button type="submit" class="submit" name="reg_user">Daftar</button>
				  </div>
				</form>
				<br><br>
      </div>
	  </div>
  </div>

  <footer class="footer text-faded text-center py-0 fixed-bottom">
    <div class="container-footer">
      <p class="m-0 small">Hak Cipta &copy; 2020 Eternity Esports | Dirancang oleh <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
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
