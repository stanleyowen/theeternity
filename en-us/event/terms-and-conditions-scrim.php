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
			<span class="section-heading-upper">Terms and Conditions Scrim</span>
		  </h2>
		  <p>
			Published by : <font color="red">Admin</font><br>
			Published on : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
			By participate in Our Scrim, you accept the agreement below :<br>
			<ol>
				<li>Playing Fair WITHOUT :
					<ul type="disc">
						<li>CHEAT
						<li>EMULATOR
						<li>TEAMING
						<li>JOKI
					</ul>
				<li>Players are NOT allow to riot or held a demo in the WhatsApp Group or other chat media
				<li>Players are ALLOWED to :
					<ol>
						<li>Report Player(s) if caught cheating [WITH EVIDENCE]
						<li>Sharing Scrim Information after the event ended
					</ol>
				<li>Players who are LATE = ABSENT = NO CERTIFICATE
				<li>Players who can join the scrim max 25 squads [FASTEST] and 5 squads for WAITING LIST
				<li>As mentioned in number 4, if there is an absent player, it will be changed with WAITING LIST MEMBERS [FASTEST]
				<li>Players who break the rules as mentioned upside, the certificate will be forfeited and will be eliminated in the future scrim.
			</ol>
			<p>We hope we can conduct a fair and competitive for all Scrim Member by implementing the applicable regulations.
			<br><br><b>Our Regards,<br><br>Eternity's Team</b>
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