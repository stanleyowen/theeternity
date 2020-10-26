<?php
	include('security-system.php');
	
	$server = "";//Your Server / Host
	$user = "";//Your User
	$pass = "";//Your Database Password
    $database = "";//Your Database Name
	$connect = mysqli_connect($server, $user, $pass, $database);
?>