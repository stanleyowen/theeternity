<?php
include '../global-validation/config.php';

$targetDir = "../assets/img/";
$fileName = basename($_FILES["file"]["name"]);
$fileSize = basename($_FILES["file"]["size"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(!empty($_FILES["file"]["name"])){
	if (($fileSize > 2097150)){
			echo '<script>alert("File size too large. Please try again file size under 2 mb");window.history.back();</script>';
	}else {
		$allowTypes = array('jpg','jpeg','png');
		if(in_array($fileType, $allowTypes)){
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
				$insert = $connect->query("INSERT into gallery (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
				if($insert){
					echo '<script>alert("Photo Uploaded Successfully.");window.history.back();</script>';
				}else{
				   echo '<script>alert("File Upload Failed, please try again");window.history.back();</script>';
				}
			}else{
				echo '<script>alert("Sorry, there was an error uploading the files.");window.history.back();</script>';
			}
		}else{
			echo '<script>alert("Only photo with extension JPEG, JPG, and PNG allowed.");window.history.back();</script>';
		}}
}else{
    echo '<script>alert("Please choose a file to be uploaded");window.history.back();</script>';
}
?>