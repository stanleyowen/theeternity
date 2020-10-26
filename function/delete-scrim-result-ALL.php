<?php
	include('../global-validation/security-crud.php');
	$code = mysqli_real_escape_string($connect, $_POST['code']);

	if ($code == 'CONFIRM') {
	  $query = "TRUNCATE TABLE scrim_member";
	  mysqli_query($connect, $query);
	  echo '<script>alert("Data Deleted Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("Confirmation CODE Mismatch");window.history.back();</script>';
	}
?>