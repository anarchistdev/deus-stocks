<?php
session_start();

if ($_SESSION['loggedin']) {
	echo 'welcome, <b>'. htmlspecialchars($_SESSION['username']) . '</b><br>';
	echo 'you are at the '. pageName() .' page';
	echo '<hr>';
} else {
	echo 'please log in';
	exit();
}

if (isset($_POST['log_out'])) {
	session_destroy();
	$_SESSION = array();
	echo "<script type='text/javascript'>window.top.location='http://www.stevenazlan.com/test/login/login.php';</script>";

}

function pageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}


?>