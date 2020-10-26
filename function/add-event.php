<?php
    include('../global-validation/security-crud.php');
    $name 			 = mysqli_real_escape_string($connect, $_POST['name']);
    $scrim_id		 = mysqli_real_escape_string($connect, $_POST['scrim_id']);
    $link   		 = mysqli_real_escape_string($connect, $_POST['link']);
    $token  		 = mysqli_real_escape_string($connect, $_POST['token']);
    $confirmtoken    = mysqli_real_escape_string($connect, $_POST['confirmtoken']);

	if(!empty($name) && !empty($scrim_id) && !empty($link) && !empty($token) && !empty($confirmtoken)) {
	  if ($token != $confirmtoken) {
		echo '<script>alert("Confirmation Token Mismatch");window.history.back();</script>';
	  }
	  else {
		$query = "INSERT INTO scrim_token(event_name,scrim_id,token,wa_link) VALUES('$name','$scrim_id','$token','$link');";
		mysqli_query($connect, $query);
		echo '<script>alert("Scrim Event Created Successfully");window.history.back();</script>';
	  }
	}else{
		echo '<script>alert("All of the form must be filled.");window.history.back();</script>';
	}
?>