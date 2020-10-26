<?php
	session_start();
    include('../../global-validation/validation-dashboard.php');
    include('../../global-validation/validate-feature.php');

	if(isset($_SESSION['username'])){
		$username  = $_SESSION['username'];
		$username  = decrypt($username,$key);
	}else if(isset($_COOKIE['sessionid-1'])){
		$username = mysqli_real_escape_string($connect, $_COOKIE['sessionid-1']);
	}

	$validate = "SELECT * FROM scrim_member WHERE username='$username'";
	$status = mysqli_query($connect, $validate);
	$sql = 'SELECT * FROM scrim_token';	
	$query = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Pusat Pengunggahan</title>
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
			<li class="active"><a href="">3. Pusat Pengunggahan</a></li>
			<li><a href="attendance.php">4. Absensi</a></li>
			<li><a href="submit-result.php">5. Mengirim Hasil Akhir</a></li>
			<li><a href="certificate.php">6. Unduh E-Sertifikat</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/Keluar.php">Keluar</a></li>
		  </ul><br>
		</div>

		<div class="col-sm-9">
		  <h2>Cara Menggungah Foto</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Diposting oleh Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Prosedur :</font><br>
		  <ol>
			<li>Pemain membutuhkan total 5 foto yang diharus diupload di masing-masing tempat yaitu :
				<ul type="disc">
					<li>1 Logo Squad dengan format NamaSquad
					<li>2 SS Bukti Follow Instagram
				</ul>
			<li>User mengunggah foto sesuai dengan tempatnya.
			<li>Pastikan nama file yang akan diupload memiliki panjang kurang dari 50 karakter
			<li>Pastikan file anda memiliki ukuran dibawah 500kb [Jika melebihi maka akan terjadi error]
			<li>User hanya diperbolehkan menguplaod foto dengan extension JPEG, JPG, dan PNG.
			<li>Jika file yang diupload telah berhasil, nama file yang diupload akan ditampilkan di tabel.
			<li>User hanya boleh mengupload 1x di setiap tempat yang disediakan.
			<li>User yang melakukan upload lebih dari 1x, maka akan DIELIMINASI.
			<li>Jika terjadi kesalahan seperti kesalahan upload, silahkan hubungi Admin.
		  </ol>
		  
		  <table class="data-table" border=1>
			<caption class="title">Status Unggah</caption>
			<thead>
				<tr>
					<th>Squad Logo</th>
					<th>IG Proof (1)</th>
					<th>IG Proof (2)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			while($d = mysqli_fetch_array($status)){?>
				<tr>
					<td><?php echo $d['squad_pic']?></td>
					<td><?php echo $d['ig_proof']?></td>
					<td><?php echo $d['ig_proof_2']?></td>
				</tr>
			
			<?php } ?>
			</tbody>
		  </table>
		  
		  <h4><small><font color="red">UNGGAH LOGO SQUAD [SEKALI][LEBIH KECIL DARI 500kB]:</font></small></h4>
		  <form action="../../function/upload-squad-picture.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Unggah</button>
		  </form>
		  
		  <h4><small><font color="red">
		  <a href="https://www.instagram.com/eternity_esports.id/">https://www.instagram.com/eternity_esports.id/</a>
		  <br>UNGGAH BUKTI FOLLOW IG [SEKALI][LEBIH KECIL DARI 500kB]:</font></small></h4>
		  <form action="../../function/upload-instagram-picture.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Unggah</button>
		  </form>
		  
		  <h4><small><font color="red">
		  <a href="https://www.instagram.com/eternity_esports.id/">https://www.instagram.com/eternity_esports.id/</a>
		  <br>UNGGAH BUKTI FOLLOW IG [SEKALI][LEBIH KECIL DARI 500kB]:</font></small></h4>
		  <form action="../../function/upload-instagram-picture-2.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Unggah</button>
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
