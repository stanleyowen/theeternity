<?php
	session_start();
    include('../../global-validation/validation-dashboard.php');
    include('../../global-validation/validate-feature.php');
	$sql = 'SELECT * FROM scrim_token';
	$query = mysqli_query($connect, $sql);
	$query1 = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Submit Result</title>
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
			<li><a href="attendance.php">4. Attendance</a></li>
			<li class="active"><a href="">5. Submit Result</a></li>
			<li><a href="certificate.php">6. Download Certificates</a></li>
			<li><a href="support.php">Customer Service</a></li>
			<li><a href="../../global-validation/logout.php">Logout</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h2>How to Submit a Result</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Before submit a result, double check the Event Name you participated in.
			<li>Enter the result of the match.
			<li>Each user are only ALLOWED to fill ONCE per MATCH
			<li>Only type NUMBERS inside the form
			<li>If success, you will receive 'Result Submitted'
		  </ol>
		  <br>
		  <p><font color="red"># Result Match 1 #</font></p>
		  <form action="../../function/submit-result.php" method="post">
		  	<input name="honeypot" type="text" id="honeypot" style="display: none">
			<label for="id"><b>Event Name :</b></label>
				<select name='id'>
					<?php
						while ($row = mysqli_fetch_array($query))
						{
							echo '<option value='.$row['id'].'>'.$row['event_name'].'</option>';
						}
					?>
				</select><br>
			<label for="rank"><b>Rank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : #</b></label>
			<input type="number" placeholder="Enter Rank Result Match 1" name="rank" required><br>
			<label for="rank"><b>Kill &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </b></label>
			<input type="number" placeholder="Enter Total Kill Match 1" name="kill" required><br>
			<button class="btn first" type="submit">Submit</button></p>
		  </form>
		  <br>
		  <p><font color="red"># Result Match 2 #</font></p>
		  <form action="../../function/submit-result-2.php" method="post">
		    <input name="honeypot" type="text" id="honeypot" style="display: none">
		    <label for="id"><b>Event Name :</b></label>
				<select name='id'>
					<?php
						while ($row = mysqli_fetch_array($query1))
						{
							echo '<option value='.$row['id'].'>'.$row['event_name'].'</option>';
						}
					?>
				</select><br>
			<label for="rank"><b>Rank &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : #</b></label>
			<input type="number" placeholder="Enter Rank Result Match 1" name="rank" required><br>
			<label for="rank"><b>Kill &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </b></label>
			<input type="number" placeholder="Enter Total Kill Match 1" name="kill" required><br>
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
