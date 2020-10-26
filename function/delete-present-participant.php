<?php
	include('../global-validation/security-crud.php');
	$name	= mysqli_real_escape_string($connect, $_GET['name']);

  	$query = "DELETE FROM present_participant WHERE name='$name'";
  	mysqli_query($connect,$query);
  	echo '<script>alert("Data Deleted Successfully!");window.history.back();</script>';
?>