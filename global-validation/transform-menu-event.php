<?php
	if(isset($_SESSION['username']) && isset($_SESSION['role'])){
		echo'
		<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../dashboard/admin/dashboard-admin.php">Dashboard</a></li>
		<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../../global-validation/logout.php">Logout</a></li>';
	}else if(isset($_COOKIE['sessionid-1']) && isset($_COOKIE['sessionid-2']) && isset($_COOKIE['sessionid-3'])){
		$username	= mysqli_real_escape_string($connect,$_COOKIE['sessionid-1']);
		$password	= mysqli_real_escape_string($connect,$_COOKIE['sessionid-2']);
		$level		= mysqli_real_escape_string($connect,$_COOKIE['sessionid-3']);
		$username	= encrypt($username,$key);
		$password	= hashword($password,$salt);
		$password	= sha1($password);
		$level		= encrypt($level,$key);
		$result		= mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password' AND level='$level'");
		if(mysqli_num_rows($result)>0){
			echo'
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../dashboard/admin/dashboard-admin.php">Dashboard</a></li>
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../../global-validation/logout.php">Logout</a></li>';
		}else {
			echo'
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../login">Login</a></li>
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../login/register.php">Register</a></li>';
		}
	}else {
		echo'
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../login">Login</a></li>
			<li class="nav-item px-lg-4"><a class="nav-link text-uppercase text-expanded" href="../login/register.php">Register</a></li>';
	}