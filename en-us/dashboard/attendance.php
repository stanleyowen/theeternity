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
  <title>Eternity Esports | Attendance</title>
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
			<li><a href="upload-center.php">3. Upload Center</a></li>
			<li class="active"><a href="">4. Attendance</a></li>
			<li><a href="submit-result.php">5. Submit Result</a></li>
			<li><a href="certificate.php">6. Download Certificates</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Logout</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h2>How to do an Attendance</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Choose the scrim event you want to participate in (According to the event you participated in before)
			<li>Enter the Scrim Token Provided by Administrator through WhatsApp Group Chat
			<li>Once you have received a message 'Attendance was successfully done! Thank You', you have success in doing an attendance
		  </ol>
		  
		  <form action="../../function/attendance-user.php" method="post">
			<label for="id"><b>Attendance for :</b></label>
				<select name='id'>
					<?php
						while ($row = mysqli_fetch_array($query))
						{
							echo '<option value='.$row['id'].'>'.$row['event_name'].'</option>';
						}
					?>
				</select><br>
			<label for="password"><b>Token &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</b></label>
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
