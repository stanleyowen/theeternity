<?php
	include('../global-validation/security-crud.php');
	$id		= mysqli_real_escape_string($connect, $_GET['id']);

  	$query = "DELETE FROM gallery WHERE id='$id'";
  	mysqli_query($connect,$query);
  	echo '<script>alert("Data Deleted Successfully!");window.history.back();</script>';
?>