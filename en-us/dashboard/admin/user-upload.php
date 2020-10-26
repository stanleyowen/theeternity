<?php
	session_start();
	include('../../../global-validation/validation-dashboard-admin.php');
	$sql = 'SELECT * FROM scrim_member';
	$query = mysqli_query($connect, $sql);
	$status = 'SELECT * scrim_token';
	$query_status = mysqli_query($connect,$status);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Participant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../../assets/css/dashboard-style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="short icon" href="../../../assets/img/etr-img-1.jpeg">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
			<li><a href="dashboard-admin.php">DashBoard</a></li>
			<li><a href="scrim-info.php">Create Post</a></li>
			<li><a href="edit-alert.php">Edit Alert</a></li>
			<li><a href="edit-gallery.php">Edit Gallery</a></li>
			<li><a href="message.php">Message</a></li>
			<li><a href="edit-user.php">User Account</a></li>
		  </ul>
		  <h4>Scrim Settings :</h4>
		  <ul class="nav nav-pills nav-stacked">
			<li><a href="edit-event.php">Create Scrim</a></li>
			<li class="active"><a href="">Participant</a></li>
			<li><a href="present-participant.php">Present Participant</a></li>
			<li><a href="scrim-result.php">Scrim Result</a></li>
			<li><a href="create-certificate-list.php">Link Certificate</a></li>
			<li><a href="../../../global-validation/logout.php">Logout</a></li>
		  </ul>
		</div>

		<div class="col-sm-9">
		  <h4><small>RECENT POSTS</small></h4>
		  <hr>
		  <h2>Welcome to Eternity Gaming Club</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <p>Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia. When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website. We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.</p>
		  
		  <table class="data-table" border=1>
			<thead>
				<tr>
					<th>Participant</th>
					<th>Date</th>
					<th>Squad Logo</th>
					<th>Instagram Proof</th>
					<th>Instagram Proof 2</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
			<?php
				while ($row = mysqli_fetch_array($query))
				{
					$message = "Are You Sure want to Delete This Data?";
					echo "<tr>
							<td>".$row['username']."</td>
							<td>".$row['date']."</td>
							<td>".$row['squad_pic']."</td>
							<td>".$row['ig_proof']."</td>
							<td>".$row['ig_proof_2']."</td>
							<td>
								<a href=\"view-upload.php?username=".$row['username']."\"class=\"btn first\">View</a>
								<a href=\"../../../function/ban-player.php?username=".$row['username']."\"class=\"btn first\" onClick=\"javascript: return confirm('$message')\">Ban Player</a>
						</tr>";
				}
			?>
			</tbody>
		  </table>
		  <br>
		  
		  <h4><small><font color="red">Delete ALL Scrim Participant :</font></small></h4>
		  <form action="../../../function/delete-scrim-participant-ALL.php" method="post">
			<label for="code"><b>CODE &nbsp;:</b></label>
			<input type="text" placeholder="Type 'CONFIRM' to DELETE ALL DATA" name="code" required>
			<button class="btn first" type="submit">Delete All</button></p>
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
