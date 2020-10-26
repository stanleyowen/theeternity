<?php
	include('../global-validation/security-crud.php');
    $link			= mysqli_real_escape_string($connect, $_POST['link']);
    $description	= mysqli_real_escape_string($connect, $_POST['description']);
	$type			= mysqli_real_escape_string($connect, $_POST['alert_type']);
	
	if(!empty($link) && !empty($description) && !empty($type)) {
	  $query = "INSERT INTO alerts_info(description,link,type) VALUES('$description','$link','$type');";
	  mysqli_query($connect, $query);
	  echo '<script>alert("Alert Added Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the Form must be Filled!");window.history.back();</script>';
	}
?>