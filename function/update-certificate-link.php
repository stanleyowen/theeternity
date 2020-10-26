<?php
	include('../global-validation/security-crud.php');

	$id    			= mysqli_real_escape_string($connect, $_POST['id']);
    $link			= mysqli_real_escape_string($connect, $_POST['link']);

	if(!empty($id) && !empty($link)){
		$query = "UPDATE scrim_token SET certi_link='$link' WHERE id='$id'";
		mysqli_query($connect, $query);
		echo '<script>alert("Data Updated Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the form must be filled.")</script>';
	}
?>