<?php
	session_start();
	include('../../../global-validation/validation-dashboard-admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="short icon" href="../../../assets/img/etr-img-1.jpeg">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .row.content {height: 1500px}
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>

<body>
	<div class="container-fluid">
	  <div class="row content">
		<div class="col-sm-3 sidenav">
		  <h4>Welcome Back : <?php include('../../../global-validation/username-callback.php'); ?></h4>
		  <h4><font color="green">Online</font></h4>
		  <br>
		  <h4>Web Configuration :</h4>
		  <ul class="nav nav-pills nav-stacked">
		  	<li><a href="../../">Home</a></li>
			<li class="active"><a href="">DashBoard</a></li>
			<li><a href="scrim-info.php">Create Post</a></li>
			<li><a href="edit-alert.php">Edit Alert</a></li>
			<li><a href="edit-gallery.php">Edit Gallery</a></li>
			<li><a href="message.php">Message</a></li>
			<li><a href="edit-user.php">User Account</a></li>
		  </ul>
		  <h4>Scrim Settings :</h4>
		  <ul class="nav nav-pills nav-stacked">
			<li><a href="edit-event.php">Create Scrim</a></li>
			<li><a href="user-upload.php">Participant</a></li>
			<li><a href="present-participant.php">Present Participant</a></li>
			<li><a href="scrim-result.php">Scrim Result</a></li>
			<li><a href="create-certificate-list.php">Link Certificate</a></li>
			<li><a href="../../../global-validation/logout.php">Logout</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <hr>
		  <h2>What is a Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span> <span class="label label-primary">Orientation</span></h5><br>
		  <p>A scrim is an online practice match against several players or teams. The word scrim comes from the shortening of “scrimmage”. It is basically a competitive game you play against other competitive players or teams for practicing in unranked matches. The word is most used between clan members in online first-person shooter games.Scrims are conducted in almost any game, most popular include PUBG Mobile</p>
		</div>
		<div class="col-sm-9">
		  <hr>
		  <h2>How to Participate / Join A Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <p>
			<font color="red">Requirements :</font><br>
			Make sure you have read our <a href="../../event/terms-and-conditions-scrim.php">Term and Conditions</a> about Scrim<br><br>
			<font color="red">Procedure :</font><br>
			<ol>
				<li>Participate in a Scrim
				<li>Join our WhatsApp Group to get out newest Information
				<li>Upload your Squad Logo, Instagram Proof, Scrim Proof
				<li>Submit your attendance to join our SCRIM, otherwise you will regarded as Absent.
				<li>Download your E-Certificates
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
