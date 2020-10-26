<?php
  error_reporting(0);
  session_start();
	include('../global-validation/config.php');
	include('../global-validation/validation-message.php');
	$alert = "SELECT * FROM alerts_info";
	$result_alert = mysqli_query($connect,$alert);
	$language  = $_GET['lang'];
	if ($language == "en"){
		$_SESSION['language'] = $language;
	}else if($language == "id"){
		$_SESSION['language'] = "id";
		header('Location: ../id/index.php?lang=id');
	}

	$length = 32;
	$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	$cookie_name = "token";
	$cookie_value = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Eternity Esports | Home</title>
  <meta name="title" content="Eternity Esports | Official Scrim website">
  <meta name="description" content="Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia. When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website. We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.">
  <link rel="short icon" href="../assets//img/etr-img-1.jpeg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"/>
  <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css"/>
  <link rel="stylesheet" href="../assets/css/button.css"/>
  <link rel="stylesheet" href="../assets/css/style-login.css"/>
</head>

<body oncontextmenu = "return false">
  <footer class="footer text-faded text-center py-3 fixed-top">
    <div class="container">
      <p class="m-0 large" align="left">Eternity Esports</p>
	  <p class="m-0 large" align="right">Languages <i class="fa fa-globe" aria-hidden="true"></i> : <a href="../en-us/index.php?lang=en">EN</a> | <a href="../id/index.php?lang=id">ID</a></p>
    </div>
  </footer>
  <br><br><br><br>

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
          <li class="nav-item active px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="event.php">Event</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="gallery.php">Gallery</a>
          </li>
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="contact-us.php">Contact Us</a>
          </li>
		      <?php include('../global-validation/transform-menu.php'); ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="page-section clearfix">
    <div class="container">
        <div class="intro-text left-0 text-center bg-faded p-5 rounded">
          <h2 class="section-heading mb-4">
            <span class="section-heading-upper">Welcome to</span>
            <span class="section-heading-lower">Eternity Esports</span>
          </h2>
          <p class="mb-3" align="left">
      			Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill.
      			Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia. 
      			When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you 
      			a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website.
      			We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.
      			<div class="intro-button mx-auto">
      			  <a class="btn btn-primary btn-xl" href="./event/release-notes.php">Release Notes</a>
      			  <a class="btn btn-primary btn-xl" href="../global-validation/redirect.php?lang=en">Join Scrim</a>
    		    </div>
    		  </p>
        </div>
    </div>
  </section>
  
  <style>
	.responsive {
		width: 100%;
		height: 0;
		padding-bottom: 56.25%;
		position: relative;
	}
	.responsive iframe {
		width: 100%;
		height: 100%;
		position: absolute;
	}
	.error {
		width: 92%; 
		margin: 0px auto; 
		padding: 10px; 
		border: 1px solid #a94442; 
		color: #a94442; 
		background: #f2dede; 
		border-radius: 5px; 
		text-align: left;
    }
  </style>
  
  <div class="bg-faded p-5 rounded">
	<div class="responsive">
		<h2>Our Latest Information</h2>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/kAiU9rj74_o" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
  </div>

  <section class="page-section cta" id="message-us">
    <div class="container">
        <div class="col-xl-9 mx-auto">
          <div class="cta-inner text-center rounded">
            <h2 class="section-heading mb-4">
              <span class="section-heading-upper">LEAVE</span>
              <span class="section-heading-lower">Some Messages to Us</span>
            </h2>
            <form action="index.php" method="post">
              <font color='red'><i class="fa fa-lock" aria-hidden="true"></i> Encrypted with AES 256 Algorithm</font><br><br>

			  <?php	include('../global-validation/errors.php');?>
			  <div class="container">
				<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
        <input name="honeypot" type="text" id="honeypot" style="display: none">
				
				<label><b>Full Name :</b></label>
				<input type="text" placeholder="Enter Full Name" name="_name" maxlength="40"/>
				
				<label><b>Email :</b></label>
				<input type="email" placeholder="Enter Your Email" name="_email" maxlength="40"/>
				
				<label><b>Feedback Type :</b></label>
				<select name="_type">
					<option value='improvement'>Improvement</option>
					<option value='report-bug'>Report Bugs</option>
					<option value='comment'>Comment</option>
					<option value='others'>Others</option>
				</select>
				
				<label><b>Messages :</b></label>
				<div class="comment">
					<textarea id="_comment" class="textinput" placeholder="Type your comment here (Max 200 characters and no special characters are allowed)" name="_comment" max=200></textarea>
				</div>
				
				<button type="submit" class="submit" name="send_feedback">Submit</button>
			  </div>
			</form>
          </div>
        </div>
      </div>
  </section>
  
  <div class="button" title="Contact Us">
    <a href="https://wa.me/message/SGOS5RUB46CUA1" class="hvr-float-shadow">
  	  <img src="../assets//img/whatsapp-logo.png" width="60">
    </a>
  </div>
  <div class="button1" title="Follow Us On">
    <a href="https://instagram.com/eternity_esports.id" class="hvr-float-shadow1">
	  <img src="../assets//img/instagram-logo.webp" width="60">
    </a>
  </div>
  <div class="button2" title="Mail Us">
    <a href="mailto:theeternity.esports.id@gmail.com" class="hvr-float-shadow2">
	  <img src="../assets//img/gmail-logo.png" width="60">
    </a>
  </div>
  
  <footer class="footer text-faded text-center py-3 fixed-bottom">
    <div class="container">
      <p class="m-0 small">Copyright &copy; 2020 Eternity Esports | Designed by <a href="https://instagram.com/stanley_owenn/">Stanley Owen</a></p>
    </div>
  </footer>
  
	<script src="../assets//vendor/jquery/jquery.min.js"></script>
	<script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
