<?php
	session_start();
	include('../../global-validation/validation-dashboard.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Dashboard</title>
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
			<li class="active"><a href="">DashBoard</a></li>
			<li><a href="participate-scrim.php">1. Berpartisipasi Dalam Scrim</a></li>
			<li><a href="join-group.php">2. Bergabung Di Grup WA</a></li>
			<li><a href="upload-center.php">3. Pusat Pengunggahan</a></li>
			<li><a href="attendance.php">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Logout</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <hr>
		  <h2>Apa itu Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span> <span class="label label-primary">Orientation</span></h5><br>
		  <p>Scrim adalah pertandingan latihan online melawan beberapa pemain atau tim. Kata scrim berasal dari kependekan dari "scrimmage". Ini pada dasarnya adalah permainan kompetitif yang Anda mainkan melawan pemain atau tim kompetitif lainnya untuk berlatih dalam pertandingan tanpa peringkat. Kata ini paling sering digunakan di antara anggota klan di game first-person shooter online. Scrim sering diadakan di hampir semua game online, termasuk PUBG Mobile</p>
		</div>
		<div class="col-sm-9">
		  <hr>
		  <h2>Bagaimana Cara Mengikuti Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <p>
			<font color="red">Requirements :</font><br>
			Pastikan Anda telah membaca <a href="../event/terms-and-conditions-scrim.php">Syarat dan Ketentuan</a> mengenai Scrim<br><br>
			<font color="red">Prosedur :</font><br>
			<ol>
				<li>Berpartisipasi dalam Scrim
				<li>Bergabung dengan WhatsApp Grup untuk mendapatkan informasi terbaru dari kami
				<li>Unggah 1 Logo Squad dan 2 SS Bukti Instagram
				<li>Absensi di bagian Kehadiran/Absensi guna berpertiisipasi dalam Scrim.
				<li>Unduh E-Sertifikat Anda
			</ol>
		  </p>
		  <br><br>
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
