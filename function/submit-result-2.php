<?php
	include('../global-validation/security-user.php');

	if(isset($_SESSION['username'])){
		$name  = $_SESSION['username'];
		$name  = decrypt($username,$key);
	}else if(isset($_COOKIE['sessionid-1'])){
		$name = $_COOKIE['sessionid-1'];
	}

    $honeypot	= mysqli_real_escape_string($connect, $_POST['honeypot']);
    $rank		= mysqli_real_escape_string($connect, $_POST['rank']);
	$kill		= mysqli_real_escape_string($connect, $_POST['kill']);
	
	if(empty($honeypot)){
		if(!empty($name) && !empty($rank) && !empty($kill)) {
		  if(isset($_COOKIE['ULD_453'])){
		  	  echo '<script>alert("Each User can ONLY fill ONCE");window.history.back();</script>';
		  }else {
			  $query = "UPDATE scrim_member SET rank_2='$rank', kill_2='$kill' WHERE username='$name'";
			  mysqli_query($connect, $query);
			  echo '<script>alert("Result Submitted");window.history.back();</script>';
	  		  setcookie('ULD_453',sha1(md5("match1")),time()+(15*8400),'/');
		  }
		}else{
			echo '<script>alert("All of the Form must be Filled!");window.history.back();</script>';
		}
	}
?>