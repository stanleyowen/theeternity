<?php
	session_start();
	if (isset($_SESSION['language'])){
		if($_SESSION['language'] == "en"){
			if(isset($_SESSION['username'])){
				header('Location: ./en-us/dashboard/admin/dashboard-admin.php');
			}else{
				header('Location: ./en-us/index.php?lang=en');
			}
		}else if($_SESSION['language'] == "id"){
			if(isset($_SESSION['username'])){
				header('Location: ./id/dashboard/admin/dashboard-admin.php');
			}else{
				header('Location: ./id/index.php?lang=id');
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Languages | Eternity Esports</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="short icon" href="assets/img/etr-img-1.jpeg">
	<link rel="stylesheet" href="assets/css/language-style.css">
</head>

<body oncontextmenu = "return false">
	<div class="container-login100" style="background-image: url('assets/img/etr-img-1.jpeg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form">
				<p align="center">
					<b>
					<br>Please Choose a Language<br>
					Silahkan Pilih Bahasa yang Diinginkan<br><br><br></b>
				</p>
				<div class="container-login100-form-btn">
					<input class="login100-form-btn" type="button" value="ENGLISH [US]" onclick="window.location.href='en-us/index.php?lang=en';"/>
					<br><br><br><br><br>
					<input class="login100-form-btn" type="button" value="INDONESIA [ID]" onclick="window.location.href='id/index.php?lang=id';"/>
				</div><br><br>
			</form>
		</div>
	</div>
</body>
</html>