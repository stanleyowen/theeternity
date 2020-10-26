<?php
    include('../global-validation/security-crud.php');
    date_default_timezone_set('Asia/Jakarta');
    
    $username 		 = mysqli_real_escape_string($connect, $_POST['username']);
    $name 			 = $username;
    $password 		 = mysqli_real_escape_string($connect, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($connect, $_POST['confirmpassword']);
	$level			 = mysqli_real_escape_string($connect, $_POST['level']);
	
	$date_created 	 	= encrypt(date("Y-m-d H:i:s"), $key);
	$password			= hashword($password, $salt);
	$confirmpassword	= hashword($confirmpassword, $salt);
	$password			= sha1($password);
	$confirmpassword	= sha1($confirmpassword);
	$level 				= encrypt($level, $key);
	$username			= encrypt($username, $key);
	$name				= $username;

	if(!empty($username) && !empty($password) && !empty($confirmpassword) && !empty($level) && !empty($date_created)) {
	  if ($password != $confirmpassword) {
		echo '<script>alert("Confirmation Password Mismatch");window.history.back();</script>';
	  }
	  
	  $checking = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM user WHERE username='$username'"));
	  
	  if ($checking > 0){
		echo '<script>alert("Username have been used. Please try Another.");window.history.back();</script>';
	  }
	  
	  else {
		$query = "INSERT INTO user(username,name,password,level,date) VALUES('$username','$name', '$password', '$level', '$date_created');";
		mysqli_query($connect, $query);
		echo '<script>alert("User Created Successfully");window.history.back();</script>';
	  }
	}
?>