<?php
	session_start();
    include('../../global-validation/validation-dashboard.php');
    include('../../global-validation/validate-feature.php');
	$sql = 'SELECT * FROM scrim_token';
	$query = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Absensi</title>
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
			<li class="active"><a href="">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Keluar</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h2>Cara Melakukan Absensi</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Pilihlah scrim yang akan dilakukan User untuk absensi
			<li>Scrim Token dibagikan oleh Admin 3-12 jam sebelum Scrim
			<li>Masukkan Scrim Token yang dikirim oleh Admin di WhatsApp Grup
			<li>Jika Anda sudah menerima notifikasi 'Attendance was successfully done! Thank You', User telah berhasil dalam melakukan Absensi
			<li>User yang terlambat melakukan Absensi, sama dengan ABSEN, dan digantikan dengan SLOT WAITING LIST
		  </ol>
		  
		  <form action="../../function/attendance-user.php" method="post">
			<label for="id"><b>Absensi &nbsp; &nbsp; &nbsp;:</b></label>
				<select name='id'>
					<?php
						while ($row = mysqli_fetch_array($query))
						{
							echo '<option value='.$row['id'].'>'.$row['event_name'].'</option>';
						}
					?>
				</select><br>
			<label for="password"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; :</b></label>
			<input type="password" placeholder="Enter Token Provided by Administrator" name="token" required><br>
			<button class="btn first" type="submit">Submit</button></p>
		  </form>
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
