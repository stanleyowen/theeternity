<?php
	include('../global-validation/security-crud.php');

	$id    			= mysqli_real_escape_string($connect, $_POST['id']);
	$token 			= mysqli_real_escape_string($connect, $_POST['token']);
    $link			= mysqli_real_escape_string($connect, $_POST['link']);

	if(!empty($id) && !empty($token) && !empty($link)){
		$query = "UPDATE scrim_token SET token='$token', wa_link='$link' WHERE id='$id'";
		mysqli_query($connect, $query);
		echo '<script>alert("Data Updated Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the form must be filled.");window.history.back();</script>';
	}
?>