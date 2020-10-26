<?php
	include('../global-validation/security-crud.php');
	$code = mysqli_real_escape_string($connect, $_POST['code']);
	$sql = "TRUNCATE TABLE scrim_token";

	if ($code == 'CONFIRM') {
	  if ($connect->query($sql) === TRUE) {
		echo '<script>alert("Confirmation Code Mismatch");window.history.back();</script>';
	  }
	  else {
	    echo '<script>alert("Error, cannot delete the record. Please try again!");window.history.back();</script>';
	  }
	}else {
	  echo '<script>alert("Confirmation Code Mismatch");window.history.back();</script>';
	}

	$connect->close();
?>