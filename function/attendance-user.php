<?php
	date_default_timezone_set('Asia/Jakarta');
	
    include("../global-validation/config.php");
	if(isset($_SESSION['username'])){
		$username  = $_SESSION['username'];
		$username  = decrypt($username,$key);
	}else if(isset($_COOKIE['sessionid-1'])){
		$username = $_COOKIE['sessionid-1'];
	}
	$id          = mysqli_real_escape_string($connect, $_POST['id']);
	$token       = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['token']))));
	$date_attend = date("Y-m-d H:i:s");
	
	if(!empty($token)){
		  $validate = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM scrim_token where id='$id' and token='$token'"));
		  if ($validate > 0){
			  $checking = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM present_participant WHERE name='$username'"));
			  if ($checking > 0){
				echo '<script>alert("Cannot do 2 times attendance. Thank You");window.history.back();</script>';
			  }else {
				$query = "INSERT INTO present_participant(name,date) VALUES('$username','$date_attend');";
				mysqli_query($connect, $query);
				echo '<script>alert("Attendance was successfully done! Thank You");window.history.back();</script>';
			  }
		  }else{
			  echo '<script>alert("Token Mismatch, please try again");window.history.back();</script>';
		  }
	}
	else{
		echo '<script>alert("Token Field is required");window.history.back();</script>';
	}
?>