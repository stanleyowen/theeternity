<?php
	date_default_timezone_set('Asia/Jakarta');
	$errors   = array();

	if(isset($_POST['send_feedback'])) {
	  $honeypot	= mysqli_real_escape_string($connect, $_POST['honeypot']);
	  if(empty($honeypot)) {
		  if(isset($_COOKIE['token'])){
			if ($_SESSION['token'] == $_POST['token']) {
			  $name		 	   = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_name']))));
			  $email           = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_email']))));
			  $type            = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_type']))));
			  $comment 		   = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_comment']))));
			  $date		 	   = date("Y-m-d H:i:s");
			  
			  if (empty($name)) {
				array_push($errors, "Name is required");
			  }
			  if (empty($email)) {
				array_push($errors, "Email is required");
			  }
			  if (empty($type)) {
				array_push($errors, "Feedback Type is required");
			  }
			  if (empty($comment)) {
				array_push($errors, "Comment form is required");
			  }
			  if (strlen($name) > 40) {
				array_push($errors, "Username can only contain maximum 40 characters");
			  }
			  if (strlen($email) > 40) {
				array_push($errors, "Email can only contain maximum 40 characters");
			  }
			  if (strlen($comment) > 2000) {
				array_push($errors, "Comment can only contain maximum 2000 characters");
			  }
			  if (count($errors) == 0) {
			  	if (isset($_COOKIE['LIC']) && $_COOKIE['LIC'] == md5("TRUE")) {
			  		array_push($errors, "Each User can only submit 1 Feedback each day.");
			  	}else {
				  	setcookie('LIC',md5("TRUE"), time() + 86400, "/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					$name 		= encrypt($name, $key);
					$email		= encrypt($email, $key);
					$type		= encrypt($type, $key);
					$comment 	= encrypt($comment, $key);
					$date 		= encrypt($date, $key);
					$insert 	= "INSERT INTO message(name,email,comment,type,date) VALUES('$name','$email','$comment','$type','$date')";
					mysqli_query($connect, $insert);
					array_push($errors, "Feedback sent! Thank You!");
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