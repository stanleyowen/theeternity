<?php
	include('config.php');
	date_default_timezone_set('Asia/Jakarta');
	$errors   	= array();
	if(isset($_POST['reg_user'])) {
		$honeypot	= mysqli_real_escape_string($connect, $_POST['honeypot']);
		if(empty($honeypot)){
		  if(isset($_COOKIE['token'])){
			if ($_SESSION['token'] == $_POST['token']) {
			  $level				= "user";
			  $username 	   		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_username']))));
			  $password 	   		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_password']))));
			  $confirmpassword 		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_confirmpassword']))));
			  $name            		= $username;
			  
			  if (empty($username)) {
				array_push($errors, "Username is required");
			  }
			  if (empty($password)) {
				array_push($errors, "Password is required");
			  }
			  if (empty($confirmpassword)) {
				array_push($errors, "Confirm Password is required");
			  }
			  if (strlen($username) > 50) {
				array_push($errors, "Username can only contain maximum 50 characters");
			  }
			  if (strlen($password) > 50) {
				array_push($errors, "Password can only contain maximum 50 characters");
			  }
			  if (strlen($confirmpassword) > 50) {
				array_push($errors, "Confirmation Password can only contain maximum 50 characters");
			  }
			  if ($password != $confirmpassword) {
				array_push($errors, "Confirmation Password and Confirmation Password Mismatch");
			  }
			  
			  $password		 = hashword($password, $salt);
			  $password		 = sha1($password);
			  $username		 = encrypt($username, $key);
			  $name 	  	 = encrypt($name, $key);
			  $level 	 	 = encrypt($level, $key);
			  $date_created  = encrypt(date("Y-m-d H:i:s"), $key);
					
			  $checking = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM user WHERE username='$username'"));
			  if ($checking > 0) {
				array_push($errors, "Username has been used. Try using another username. <a href='index.php'>Is it you?</a>");
			  }
			  if (count($errors) == 0) {
				if(isset($_COOKIE['ULD-568'])) {
					array_push($errors, "Each User can only register once. Please Try Again later.");
				}else{
					$value_1 = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_username']))));
					$value_2 = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_password']))));
					$value_3 = 'user';
					setcookie('sessionid-1',$value_1, time() + (86400 * 30),"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					setcookie('sessionid-2',$value_2, time() + (86400 * 30),"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					setcookie('sessionid-3',$value_3, time() + (86400 * 30),"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					setcookie('ULD-	568',md5("Complete"), time() + (86400 * 30),"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					
					$insert = "INSERT INTO user(username,name,password,level,date) VALUES('$username','$name', '$password', '$level', '$date_created');";
					mysqli_query($connect, $insert);
					$_SESSION['role']		= "user";
					$_SESSION['username']	= $username;
					echo '<script>alert("User Created Successfully.");document.location="../dashboard/"</script>';
				}
			  }
			}else {
	            array_push($errors, "CSRF verification failed. Request aborted.");
			}
		  }
		  else {
			array_push($errors, "CSRF verification failed. Request aborted.<br><br>You are seeing this message because this site requires a CSRF cookie when submitting forms. This cookie is required for security reasons, to ensure that your browser is not being hijacked by third parties.<br><br>If you have configured your browser to disable cookies, please re-enable them, at least for this site, or for “same-origin” requests.");
		  }
		}
	}
?>