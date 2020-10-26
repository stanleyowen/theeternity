<?php
	session_start();
	include('../../global-validation/validation-dashboard.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Customer Service</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../assets/css/dashboard-style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="short icon" href="../../assets/img/etr-img-1.jpeg">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body oncontextmenu = "return false">
	<div class="container-fluid">
	  <div class="row content">
		<div class="col-sm-3 sidenav">
		  <h4>Selamat Datang : <?php include('../../global-validation/username-callback.php'); ?></h4>
		  <h4><font color="green">Online</font></h4>
		  <br>
		  <h4>Menus :</h4>
		  <ul class="nav nav-pills nav-stacked">
			<li><a href="../">Home</a></li>
			<li><a href="index.php">DashBoard</a></li>
			<li><a href="participate-scrim.php">1. Berpartisipasi Dalam Scrim</a></li>
			<li><a href="join-group.php">2. Bergabung Di Grup WA</a></li>
			<li><a href="upload-center.php">3. Pusat Pengunggahan</a></li>
			<li><a href="attendance.php">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li class="active"><a href="">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Keluar</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <hr>
		  <h2>Customer Service</h2>
		  <p>We are here to help and answer any questions you might have. We offer support for the following :</p>
		  <ol type="disc">
		  	<li>Technical Support</li>
		  	<li>Login & Register Support</li>
		  </ol>
		  <p>Contact Us On :</p>
		  <ol type="disc">
		  	<li>Eternity Esports Website : <a href="../index.php#message-us">Click Here</a></li>
		  	<li>Email : <a href="mailto:theeternity.esports.id@gmail.com">theeternity.esports.id@gmail.com</a></li>
		  	<li>WhatsApp : <a href="https://wa.me/message/SGOS5RUB46CUA1">wa.me/message/SGOS5RUB46CUA1</a></li>
		  	<li>Instagram : <a href="https://instagram.com/eternity_esports.id">eternity_esports.id</a></li>
		  </ol>
		</div>
	  </div>
	</div>

	<footer class="footer text-faded text-center py-0">
    <div class="container">
      <p class="m-0 small">Copyright &copy; 2020 Eternity Esports | Designed by <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
    </div>
  </footer>
</body>
</html>
