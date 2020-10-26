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
  <title>Eternity Esports | Bergabung Dengan WhatsApp Grup</title>
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
			<li class="active"><a href="">2. Bergabung Di Grup WA</a></li>
			<li><a href="upload-center.php">3. Pusat Pengunggahan</a></li>
			<li><a href="attendance.php">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Keluar</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h2>Join WhatsApp Group</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Prosedur :</font><br>
		  <ol>
			<li>Pilih Grup WhatsApp sesuai Scrim yang Anda ikuti
			<li><font color="red">Setelah user join Grup WhatsApp, User mengirim format Nama Squad di group. Jika dalam jangka 2x24 jam user tidak memberikan respon, maka user akan dieliminasi.</font>
		  </ol>
		  
		  <table class="data-table" border=1>
			<thead>
				<tr>
					<th>Scrim Event</th>
					<th>WhatsApp Group Link</th>
				</tr>
			</thead>
			<tbody>
			<?php
				while ($row = mysqli_fetch_array($query))
				{
					echo '<tr>
							<td>'.$row['event_name'].'</td>
							<td><a href="'.$row['wa_link'].'">'.$row['wa_link'].'</a></td>
						</tr>';}
			?>
			</tbody>
		  </table>
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