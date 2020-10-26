<?php
	include('config.php');
	
	$lang	= mysqli_real_escape_string($connect, $_GET['lang']);

	if(isset($_SESSION['username']) && isset($_SESSION['role'])){
		if($lang == "en"){
			header('Location:../en-us/dashboard/participate-scrim.php');
		}else if($lang == "id"){
			header('Location:../id/dashboard/participate-scrim.php');
		}
	}else if(isset($_COOKIE['sessionid-1']) && isset($_COOKIE['sessionid-2']) && isset($_COOKIE['sessionid-3'])){
		if($lang == "en"){
			header('Location:../en-us/dashboard/participate-scrim.php');
		}else if($lang == "id"){
			header('Location:../id/dashboard/participate-scrim.php');
		}
	}else {
		if($lang == "en"){
			header('Location:../en-us/login/');
		}else if($lang == "id"){
			header('Location:../id/login/');
		}
	}