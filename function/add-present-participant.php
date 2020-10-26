<?php
	include('../global-validation/security-crud.php');
	date_default_timezone_set('Asia/Jakarta');
	
    $username 		= mysqli_real_escape_string($connect, $_POST['username']);
	$date_created 	= date("Y-m-d H:i:s");
	
	if(!empty($username)) {
	  $checking = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM present_participant WHERE name='$username'"));
	  if ($checking > 0){
		echo '<script>alert("Cannot do 2 times attendance. Thank You");window.history.back();</script>';
	  }else {
		$query = "INSERT INTO present_participant(name,date) VALUES('$username','$date_created');";
		mysqli_query($connect, $query);
		echo '<script>alert("Attendance was successfully done! Thank You");window.history.back();</script>';
	  }
	}
?>