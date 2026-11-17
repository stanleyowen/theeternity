<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');
$user = require_player();

dashboard_header('Dashboard', 'player', 'dashboard', $user);
?>
		<div class="col-sm-9">
		  <hr>
		  <h2>What is a Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span> <span class="label label-primary">Orientation</span></h5><br>
		  <p>A scrim is an online practice match against several players or teams. The word scrim comes from the shortening of “scrimmage”. It is basically a competitive game you play against other competitive players or teams for practicing in unranked matches. The word is most used between clan members in online first-person shooter games. Scrims are conducted in almost any game, most popular include PUBG Mobile</p>
		</div>
		<div class="col-sm-9">
		  <hr>
		  <h2>How to Participate / Join A Scrim</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Tutorial</span></h5><br>
		  <font color="red">Requirements :</font><br>
		  Make sure you have read our <a href="<?= e(lang_url('event/terms-and-conditions-scrim.php')) ?>">Term and Conditions</a> about Scrim<br><br>
		  <font color="red">Procedure :</font><br>
		  <ol>
			<li>Participate in a Scrim</li>
			<li>Join our WhatsApp Group to get our newest Information</li>
			<li>Upload your Squad Logo, Instagram Proof, Scrim Proof</li>
			<li>Submit your attendance to join our SCRIM, otherwise you will regarded as Absent.</li>
			<li>Download your E-Certificates</li>
		  </ol>
		  <br><br>
		</div>
<?php dashboard_footer();
