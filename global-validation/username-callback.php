<?php
	if(isset($_SESSION['username'])){
		$username  = $_SESSION['username'];
		$decrypted = decrypt($username,$key);
		echo $decrypted;
	}else if(isset($_COOKIE['sessionid-1'])){
		echo $_COOKIE['sessionid-1'];
	}else {
		echo 'Missing $_SESSION and $_COOKIE as a parameter!';
		header('Location:../../../logout.php');
	}