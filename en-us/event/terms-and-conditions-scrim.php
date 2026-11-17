<?php
declare(strict_types=1);

require __DIR__ . '/../../app/bootstrap.php';
set_lang('en');

public_header('Event', [
    'css'    => ['dashboard-style.css'],
    'topbar' => false,
]);
public_nav('event');
?>
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

<?php public_footer();
