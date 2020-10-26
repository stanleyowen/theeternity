<?php
	session_start();
    include('../../global-validation/validation-dashboard.php');
    
    if (isset($_COOKIE['JScrim'])) {
    	if ($_COOKIE['JScrim'] == sha1(md5('Joined'))){
			echo '<script>alert("Each User can only Berpartisipasi Dalam Scrim. User can participate in other scrim events after the event was ended. If the event has ended, but you still cannot access here, please Keluar and Login Again.");document.location="../dashboard/index.php"</script></script>';
		}else{
			echo '<script>alert("Invalid JScrim Cookie Format");document.location="../dashboard/index.php"</script></script>';
		}
	}

	$sql = 'SELECT * FROM scrim_token';
	$query = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Berpartisipasi Dalam Scrim</title>
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
			<li class="active"><a href="">1. Berpartisipasi Dalam Scrim</a></li>
			<li><a href="join-group.php">2. Bergabung Di Grup WA</a></li>
			<li><a href="upload-center.php">3. Pusat Pengunggahan</a></li>
			<li><a href="attendance.php">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Keluar</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h2>Cara Berpartisipasi Dalam Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Baca Syarat dan Ketentuan yang berlaku
			<li>Pilih Scrim yang akan User ikuti
			<li>Pastikan User mencentang semua Syarat dan Ketentuan
			<li>User tidak diperbolehkan mengikuti lebih dari 1 Scrim yang diadakan Eternity secara bersamaan
			<li>User menekan Partisipasi
			<li>Jika User telah menekan tombol Partisipasi dan muncul notifikasi 'Successfully Participated the Scrim', User berhasil register dan dapat mengakses fitur-fitur seperti 'Pusat Pengunggahan', 'Kehadiraan / Absensi', and 'Unduh E-Sertifikat'.
			<li>User tidak akan mengakses Tab ini sampai Event yang diikuti User Berakhir.
		  </ol>

		  <form action="../../function/participate-in-scrim.php" method="post">
			<label for="event_id"><b>Participate in :</b></label>
				<select name='event_id'>
					<?php
						while ($row = mysqli_fetch_array($query))
						{
							echo '
							<option value="'.$row['scrim_id'].'">'.$row['event_name'].'</option><br>
							';
						}
					?>
				</select><br>
			<label class="container">Saya setuju denngan <a href="../event/terms-and-conditions-scrim.php">Syarat dan Ketentuan</a> yang berlaku
			  <input type="checkbox" name="term1">
			  <span class="checkmark"></span>
			</label>

			<label class="container">Saya setuju dengan Eternity Esports dapat mengumpulkan Informasi Pribadi untuk memonitor user dengan tujuan untuk mencegah terjadinya kecurangan selama Scrim.
			  <input type="checkbox" name="term2">
			  <span class="checkmark"></span>
			</label>
			<button class="btn first" type="submit">PARTICIPATE</button></p>
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
