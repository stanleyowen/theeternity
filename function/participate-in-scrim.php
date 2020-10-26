<?php
	include('../global-validation/security-user.php');
	date_default_timezone_set('Asia/Jakarta');
	$event_id    = mysqli_real_escape_string($connect, $_POST['event_id']);
	$date        = date("Y-m-d H:i:s");
	
	if(isset($_SESSION['username'])){
		$username  = $_SESSION['username'];
		$username  = decrypt($username,$key);
	}else if(isset($_COOKIE['sessionid-1'])){
		$username = $_COOKIE['sessionid-1'];
	}

	if(!empty($event_id) && !empty($username) && !empty($_POST['term1']) && !empty($_POST['term2'])){
	  $validation = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM scrim_member WHERE username='$username' AND event_id='$event_id'"));
	  if ($validation > 0){
	  	$value = sha1(md5("Joined"));
		echo '<script>alert("You have participated this SCRIM before.");window.history.back();</script>';
	  }else {
		$query = "INSERT INTO scrim_member(event_id,username,date) VALUES('$event_id','$username','$date')";
		mysqli_query($connect, $query);
		$value = sha1(md5("Joined"));
	  	setcookie('JScrim',$value,time()+(30*8400),'/',"000webhostapp.com",isset($_SERVER["HTTPS"]), true);
		echo '<script>alert("Successfully Participated The Scrim");window.history.back();</script>';
	  }
	}
	else{
		echo '<script>alert("All Scrim Form Must be Checked.");window.history.back();</script>';
	}
?>