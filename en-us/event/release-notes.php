<?php
	session_start();
	include('../../global-validation/config.php');
	$query = "SELECT * FROM scrim_info";
	$results = mysqli_query($connect, $query);
	$alert = "SELECT * FROM alerts_info";
	$result_alert = mysqli_query($connect,$alert);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eternity Esports | Event</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="short icon" href="../../assets/img/etr-img-1.jpeg">
  <link rel="stylesheet" href="../../assets/css/dashboard-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"/>
  <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css"/>
  <link rel="stylesheet" href="../../assets/css/button.css"/>
</head>

<body oncontextmenu = "return false">
	<?php foreach ($result_alert as $row) {
	  echo'
	  <div class="alert alert-'.$row['type'].'">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		'.$row['description'].'
		<a href="'.$row['link'].'">Click here <i class="fa fa-external-link"></i></a>
	  </div>';
    }
  ?>
  
  <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
      <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Menus</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../index.php">Home</a>
          </li>
          <li class="nav-item active px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../event.php">Event
               <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../gallery.php">Gallery</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="../contact-us.php">Contact Us</a>
          </li>
          <?php include('../../global-validation/transform-menu-event.php'); ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="page-section clearfix">
    <div class="container">
		<div class="intro-text left-0 bg-faded p-5 rounded">
		  <h2 class="section-heading mb-4">
			<span class="section-heading-upper">Release Notes</span>
		  </h2>
		  <p>
			Published by : <font color="red">Admin</font><br>
			Published on : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
			<center><b>Eternity v0.11</b></center>
			<br>
			<ol>
				<li>Added 3+ layers of security to Eternity Website :
					<ul type="disc">
						<li>Added SSL Certificates to Secure Clients' Information when the data travelling from Clients' Computer to WebServer
						<li>Added security features in Messages, Login, Register, etc to prevent from Bots and Spam
						<li>Changed some logics in Validation Login and Register Form
						<li>Disabled Error Messages to prevent from vulnerabilities, data breaches, etc.
					</ul>
				<li>Added MultiLanguage Features which is Indonesia (ID)
				<li>Added Error Pages :
					<ul type="disc">
						<li>403 Forbidden
						<li>404 Not Found
						<li>405 Method Not Allowed
						<li>408 Request Time Out
						<li>500 Internal Server Error
						<li>502 Bad Gateway
						<li>503 Service Currently Unavailable
						<li>504 Gateway Timeout
					</ul>
				<li>Fixed Minor Bugs on Message Validation, Login Validation, and Register Validation
				<li>Changed Style of :
					<ul type="disc">
						<li>Message Form
						<li>Login Form
						<li>Register Form
					</ul>
				</li>
				<li>Fixed User Interface (UI) in Login and Register Form
				<li>Limitation of requests in Message, Login, and Register Form are Removed and changed with reCAPTCHA
			</ol>
			<center><b>Eternity v0.10</b></center>
			<p>Eternity Esports contains 5 features for User, which is :</p>
			<ol>
				<li>Login and Logout Securely with Validation Level (Access 24/7/365)
				<li>Dashboard User
				<li>Attendance Features
				<li>Upload Features
				<li>Download Certificate Features
			</ol>
			<p>Eternity Esports contains more than 10 features for Administrator, which is :<br></p>
			<ol>
				<li>Login and Logout Securely with Validation Level (Access 24/7/365)
				<li>Edit Scrim Event
				<li>Edit Alert for Websites
				<li>Upload Features for Certificates and Gallery Tab
				<li>Manage, Edit, Delete, and Ban User
				<li>View User's Upload
				<li>Conduct an Event
				<li>See Attendance List
				<li>View Messages
				<li>View and Edit Security Log
				<li>View User's Activity Log
			</ol>
			<p>Some Security Features we provide, such as :</p>
			<ol>
				<li>Prevent from Brute Attack
				<li>User's Activity Log
				<li>IP Banner
			</ol>
			<p><b>Our Motto : "<i>United We Stand, Divided We Fall</i>"
			<br>Our Regards,<br><br>Eternity's Team</b></p>
		  </p>
		</div>
    </div>
  </section>

  <footer class="footer text-faded text-center py-3 fixed-bottom">
    <div class="container">
      <p class="m-0 small">Copyright &copy; 2020 Eternity Esports | Designed by <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
    </div>
  </footer>
  
  <div class="button" title="Contact Us">
    <a href="https://wa.me/message/SGOS5RUB46CUA1" class="hvr-float-shadow">
  	  <img src="../../assets/img/whatsapp-logo.png" width="60">
    </a>
  </div>

  <div class="button1" title="Follow Us On">
    <a href="https://instagram.com/eternity_esports.id" class="hvr-float-shadow1">
	  <img src="../../assets/img/instagram-logo.webp" width="60">
    </a>
  </div>

  <div class="button2" title="Mail Us">
    <a href="mailto:theeternity.esports.id@gmail.com" class="hvr-float-shadow2">
	  <img src="../../assets/img/gmail-logo.png" width="60">
    </a>
  </div>
  
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>