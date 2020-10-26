<?php
	include('config.php');
	date_default_timezone_set('Asia/Jakarta');
	$errors   	= array();

	if(isset($_POST['login_user'])) {
		$honeypot	= mysqli_real_escape_string($connect, $_POST['honeypot']);
		if(empty($honeypot)){
		  if(isset($_COOKIE['token'])){
			if ($_SESSION['token'] == $_POST['token']) {
	            $username		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_username']))));
				$password		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_password']))));
				$level   		= mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['validation_role']))));
				if (empty($username)) {
					array_push($errors, "Username is required");
				}
				if (empty($password)) {
					array_push($errors, "Password is required");
				}
				if (strlen($username) > 50) {
					array_push($errors, "Username can only contain maximum 50 characters");
				}
				if (strlen($password) > 50) {
					array_push($errors, "Password can only contain maximum 50 characters");
				}
				if (count($errors) == 0) {
					$password	= hashword($password, $salt);
					$password	= sha1($password);
					$level 		= encrypt($level, $key);
					$username	= encrypt($username, $key);
					$query 		= "SELECT * FROM user WHERE username='$username' AND password='$password' AND level='$level'";
					$results	= mysqli_query($connect, $query);
		
					if (mysqli_num_rows($results) == 1) {
						$value_1 = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_username']))));
						$value_2 = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['_password']))));
						$value_3 = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_POST['validation_role']))));
						setcookie('sessionid-1',$value_1, time() + (86400 * 30), "/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
						setcookie('sessionid-2',$value_2, time() + (86400 * 30), "/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
						setcookie('sessionid-3',$value_3, time() + (86400 * 30), "/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
						$validation_event = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM scrim_member WHERE username=decrypt('$username',$key)"));
						if ($validation_event > 0){
							setcookie('JScrim',sha1(md5("Joined")),time()+(30*8400),'/',"000webhostapp.com",isset($_SERVER["HTTPS"]), true);
						}else {
							setcookie('JScrim',sha1(md5("Joined")),time()-3600,'/',"000webhostapp.com",isset($_SERVER["HTTPS"]), true);
						}
						header('location: ../dashboard/admin/dashboard-admin.php');
						
					}else {
						array_push($errors, "Username and Password doen't match our credentials. Haven't Register? <a href='register.php'>Signup Here</a>");
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