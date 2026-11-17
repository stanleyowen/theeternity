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
			<span class="section-heading-upper">Release Notes</span>
		  </h2>
		  <p>
			Published by : <font color="red">Admin</font><br>
			Published on : <font color="red"><i class="fa fa-calendar" aria-hidden="true"></i> 2020-09-08 07:39:53</font><br><br>
			<center><b id="archive-edition">Eternity v1.0 &mdash; Archive Edition (2026)</b></center>
			<br>
			<p>Eternity Esports is no longer running scrims. The website has been restored as a read-only archive so this project stays online, and its code was rebuilt to modern security standards while keeping the original 2020 design.</p>
			<ol>
				<li>Archive mode: the site is read-only, and registrations, scrims and messages are closed. Visitors can still explore the Player and Administrator dashboards through demo access on the Login page.
				<li>Rebuilt on PHP 8 with prepared statements for every database query (protection against SQL injection)
				<li>Passwords are hashed with bcrypt, and signing in uses a secure session cookie only. Credentials are never stored in cookies.
				<li>Roles are verified on the server for every page and action. Administrator access can no longer be selected from the login form.
				<li>All user content is escaped (protection against XSS), and every page is served with a strict Content Security Policy
				<li>CSRF protection on every form. Delete actions require a confirmed POST request.
				<li>Uploaded photos are verified as real images, renamed, re-encoded and stored privately
				<li>Messages are encrypted with authenticated AES-256-GCM. Login, registration and feedback are rate-limited on the server.
				<li>Updated to Bootstrap 4.6.2 / 3.4.1, jQuery 3.7.1 and Font Awesome 4.7, all served locally
			</ol>
			<br>
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

<?php public_footer();
