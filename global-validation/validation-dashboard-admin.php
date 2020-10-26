<?php
	include('config.php');

	if(isset($_SESSION['username']) && isset($_SESSION['role'])){
		if($_SESSION['role'] == encrypt("admin",$key)){
			//passed
		}else if($_SESSION['role'] == encrypt("user",$key)){
			header('Location:../');
		}
	}
	else if(isset($_COOKIE['sessionid-1']) && isset($_COOKIE['sessionid-2']) && isset($_COOKIE['sessionid-3'])){
		$username	= mysqli_real_escape_string($connect,$_COOKIE['sessionid-1']);
		$password	= mysqli_real_escape_string($connect,$_COOKIE['sessionid-2']);
		$level		= mysqli_real_escape_string($connect,$_COOKIE['sessionid-3']);
		$username	= encrypt($username,$key);
		$password	= hashword($password,$salt);
		$password   = sha1($password);
		if ($level == "admin"){
			$level = encrypt("admin",$key);
		}
		else if($level == "user"){
			$level = encrypt("user",$key);
		}
		$result		= mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password' AND level='$level'");
		if(mysqli_num_rows($result)>0){
			if($level == encrypt("admin",$key)){
				//passed
			}else if ($level = encrypt("user",$key)){
				header('Location:../');
			}else{
				header('Location:../../../global-validation/logout.php');
			}
		}else {
			echo '<script>alert("Invalid Cookies Format!");document.location="../../../global-validation/logout.php"</script>';
		}
	}else {
		header('Location:../../../global-validation/logout.php');
	}
?>