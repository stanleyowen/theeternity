<?php
	include('../global-validation/security-crud.php');
	date_default_timezone_set('Asia/Jakarta');
	
    $header    		= enter(mysqli_real_escape_string($connect, $_POST['header']));
    $code   		= mysqli_real_escape_string($connect, $_POST['code']);
    $description    = enter(mysqli_real_escape_string($connect, $_POST['description']));
    $date		    = date("Y-m-d H:i:s");

	if(isset($_COOKIE['sessionid-1'])){
		$name = $_COOKIE['sessionid-1'];
	}

    if (!empty($code)){
    	$type	= "hidden";
    }else {
    	$code	= 0;
    	$type	= "public";
    }
    
	if(!empty($header) && !empty($description)) {
		$query = "INSERT INTO scrim_info(type,code,posted_by,date,header,description) VALUES('$type','$code','$name','$date','$header','$description');";
		mysqli_query($connect, $query);
		echo '<script>alert("Scrim Info Created Successfully");window.history.back(2);</script>';
	}else{
		echo '<script>alert("All of the form must be filled!");</script>';
	}
?>