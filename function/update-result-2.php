<?php
	include('../global-validation/security-crud.php');

	$username		= mysqli_real_escape_string($connect, $_POST['username']);
    $rank			= mysqli_real_escape_string($connect, $_POST['rank']);
    $kill			= mysqli_real_escape_string($connect, $_POST['kill']);

	if(!empty($username) && !empty($rank) && !empty($kill)){
		$query = "UPDATE scrim_member SET rank_2='$rank',kill_2='$kill' WHERE username='$username'";
		mysqli_query($connect, $query);
		echo '<script>alert("Data Updated Successfully");window.history.back();</script>';
	}else{
		echo '<script>alert("All of the form must be filled.")</script>';
	}
?>