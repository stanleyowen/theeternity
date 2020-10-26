<?php
include ('../global-validation/security-user.php');
date_default_timezone_set('Asia/Jakarta');

if(isset($_SESSION['username'])){
	$username  = $_SESSION['username'];
	$username  = decrypt($username,$key);
}else if(isset($_COOKIE['sessionid-1'])){
	$username = mysqli_real_escape_string($connect, $_COOKIE['sessionid-1']);
}

$targetDir 		= "../upload-data/ig-proof/";
$fileName 		= basename($_FILES["file"]["name"]);
$fileSize 		= basename($_FILES["file"]["size"]);
$targetFilePath = $targetDir . $fileName;
$fileType 		= pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_COOKIE['ULD-156'])){
	echo '<script>alert("Each User can ONLY upload ONCE");window.history.back();</script>';
}else {
	if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
		if (($fileSize > 557150)){
			echo '<script>alert("File size too large. Please try again file size under 500kb");window.history.back();</script>';
		}else {
			$allowTypes = array('jpg','jpeg','png');
			if(in_array($fileType, $allowTypes)){
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					$insert = $connect->query("UPDATE scrim_member SET ig_proof='".$fileName."' WHERE username='$username'");
					if($insert){
						echo '<script>alert("Photo Uploaded Successfully.");window.history.back();</script>';
						setcookie('ULD-156',sha1(md5("Completed")),time()+(15*8400),'/',"000webhostapp.com",isset($_SERVER["HTTPS"]), true);
					}else{
						echo '<script>alert("Error, Make Sure You have Joined the Scrim");window.history.back();</script>';
					}
				}else{
				   echo '<script>alert("File Upload Failed, please try again");window.history.back();</script>';
				}
			}else{
					echo '<script>alert("Only photo with extension JPEG, JPG, and PNG are allowed.");window.history.back();</script>';
				}
		}
	}else{
		echo '<script>alert("Please choose a photo to be uploaded");window.history.back();</script>';
	}
}