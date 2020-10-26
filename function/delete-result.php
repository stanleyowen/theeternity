<?php
	include('../global-validation/security-crud.php');
	$username	= mysqli_real_escape_string($connect, $_GET['username']);

  	$query = "DELETE FROM scrim_member WHERE username='$username'";
  	mysqli_query($connect,$query);
  	echo '<script>alert("Data Deleted Successfully!");window.history.back();</script>';
?>