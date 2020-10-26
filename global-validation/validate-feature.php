<?php	
	if (isset($_COOKIE['JScrim'])) {
    	if ($_COOKIE['JScrim'] == sha1(md5('Joined'))){
			//passed
		}else{
			echo '<script>alert("Invalid Jscrim Cookie Format");document.location="logout.php"</script>';
		}
	}else {
		echo '<script>alert("Please Participate in a Scrim in order to Access this Feature");document.location="../";</script>';
	}
?>