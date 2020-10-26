<?php
	include('../global-validation/security-crud.php');
	date_default_timezone_set('Asia/Jakarta');

	$id    			= mysqli_real_escape_string($connect, $_POST['id']);
    $header    		= enter(mysqli_real_escape_string($connect, $_POST['header']));
    $code   		= mysqli_real_escape_string($connect, $_POST['code']);
    $description    = enter(mysqli_real_escape_string($connect, $_POST['description']));
    $date		    = date("Y-m-d H:i:s");

    if(isset($_SESSION['username'])){
		$name  = $_SESSION['username'];
		$name  = decrypt($username,$key);
	}else if(isset($_COOKIE['sessionid-1'])){
		$name = $_COOKIE['sessionid-1'];
	}

    if (!empty($code)){
    	$type	= "hidden";
    }else {
    	$code	= NULL;
    	$type	= "public";
    }

	if(!empty($id) && !empty($header) && !empty($description)){
		$query = "UPDATE scrim_info SET posted_by='$name',type='$type',code='$code',date='$date',header='$header',description='$description' WHERE id='$id'";
		mysqli_query($connect, $query);
		echo '<script>alert("Scrim Info Updated Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the form must be filled.");window.history.back();</script>';
	}
?>