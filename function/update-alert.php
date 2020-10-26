<?php
	include('../global-validation/security-crud.php');
	date_default_timezone_set('Asia/Jakarta');

	$id    			= mysqli_real_escape_string($connect, $_POST['id']);
    $link			= mysqli_real_escape_string($connect, $_POST['link']);
    $description	= mysqli_real_escape_string($connect, $_POST['description']);
	$type			= mysqli_real_escape_string($connect, $_POST['alert_type']);

	if(!empty($id) && !empty($link) && !empty($description) && !empty($type)){
		$query = "UPDATE alerts_info SET description='$description', link='$link', type='$type' WHERE id='$id'";
		mysqli_query($connect, $query);
		echo '<script>alert("Alert Updated Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the form must be filled.");window.history.back();</script>';
	}
?>