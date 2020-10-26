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
  <title>Eternity Esports | Upload Center</title>
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
		  <h4>Welcome Back : <?php include('../../global-validation/username-callback.php'); ?></h4>
		  <h4><font color="green">Online</font></h4>
		  <br>
		  <h4>Menus :</h4>
		  <ul class="nav nav-pills nav-stacked">
		  	<li><a href="../">Home</a></li>
			<li><a href="index.php">DashBoard</a></li>
			<li><a href="participate-scrim.php">1. Participate in a Scrim</a></li>
			<li><a href="join-group.php">2. Join WhatsApp Group</a></li>
			<li class="active"><a href="">3. Upload Center</a></li>
			<li><a href="attendance.php">4. Attendance</a></li>
			<li><a href="submit-result.php">5. Submit Result</a></li>
			<li><a href="certificate.php">6. Download Certificates</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Logout</a></li>
		  </ul><br>
		</div>

		<div class="col-sm-9">
		  <h2>How to Upload a Picture</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Player needs at least 5 photos to be uploaded, which is :
				<ul type="disc">
					<li>1 Squad Logo with the format SquadName
					<li>2 SS Instagram Proof format SquadName_IG_(1/2)
				</ul>
			<li>Upload the photo according to the uploaded place
			<li>Make sure your file name [LENGTH] doesn't longer than 50 characters [<50 chars]
			<li>Make sure your file is under 500kB
			<li>Only file with extension JPEG, JPG, and PNG are allowed
			<li>Once file was uploaded successfully, file name will be displayed in the table.
			<li>Each User can only upload ONCE per place
			<li>User who upload more than ONCE will be ELIMINATED
			<li>If something went wrong, contact our Admin to get support
		  </ol>
		  
		  <table class="data-table" border=1>
			<caption class="title">Upload Status</caption>
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
		  
		  <h4><small><font color="red">UPLOAD SQUAD IMAGE [ONCE][not larger than 1 MB]:</font></small></h4>
		  <form action="../../function/upload-squad-picture.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Upload</button>
		  </form>
		  
		  <h4><small><font color="red">UPLOAD INSTAGRAM PROOF 1 [ONCE][not larger than 1 MB]:</font></small></h4>
		  <form action="../../function/upload-instagram-picture.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Upload</button>
		  </form>
		  
		  <h4><small><font color="red">UPLOAD INSTAGRAM PROOF 2 [ONCE][not larger than 1 MB]:</font></small></h4>
		  <form action="../../function/upload-instagram-picture-2.php" method="post" enctype="multipart/form-data">
		    <input type="file" name="file">
			<button class="btn first" type="submit" name="submit">Upload</button>
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
