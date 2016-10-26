<?php
session_start();

if ($_SESSION['loggedin']) {
	
} else {
	echo 'please log in';
	exit();
}

if (isset($_POST['log_out'])) {
	session_destroy();
	$_SESSION = array();
	redirect('http://www.stevenazlan.com/test/login/login.php');
	//redirect('index.php');

}

function redirect($url) {
	echo "<script type='text/javascript'>window.top.location='$url';</script>";
}


?>