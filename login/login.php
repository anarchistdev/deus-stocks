<?php
session_start();
require 'connect.php';

if ($_SESSION['loggedin']) {
	echo 'welcome,<b> '.htmlspecialchars($_SESSION['username']);
	exit();
}


if (isset($_POST['username'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$password = mysqli_real_escape_string($link, trim($password));
	$username = mysqli_real_escape_string($link, trim($username));
	$password = strip_tags($password);
	$username = strip_tags($username);
	
	if (!empty($username) || !empty($password)) { 

		$password_hash = hash_password($password);
		// TODO - make the salt the username(maybe id num too) if multiple users.

		$sql = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password_hash."' LIMIT 1";
		$res = mysqli_query($link, $sql) or die(mysqli_error());

		if(mysqli_num_rows($res)==1) {
			$row = mysqli_fetch_assoc($res);
			$_SESSION['uid'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
			echo 'welcome, '. htmlspecialchars($_SESSION['username']);
			echo '<br>you are our number '.$row['id'].' user.';

			$_SESSION['loggedin'] = true;
			exit(0);
		} else {
			echo 'Invalid username/password combination';
			exit;
			$_SESSION['loggedin'] = false;
		}
	} else {
		echo 'your username or password is empty';
	}
}

/*
* Hashes and salts string into a one way aglorithim. Uses
* the "whirlpool" and "gost" aglorithims to encrypt
* the string and the salt.
*
* @param $str The string to be encrypted
* @param $salt The salt to salt the string with
* @return $str The new, encrypted string.
*/
function hash_password($str) {
	$str = hash('whirlpool', $str);
	$salt = 'e8b27v9ud4r9iio401l'.substr(hash('gost',$str),0,22);
	$first400 = substr($str, 0, 400);
	$theRest = substr($str, 400);
	$str = $first400 . $salt . $theRest;
	return $str;
}

?>


<form method="POST" action="">
<input type='text' name='username' placeholder='username' id='field' />
<br>
<br>
<input type='password' name='password' placeholder='password' id='field-password' />
<br>
<br>
<input type='submit' name='submit' value='Log in' class='login-button' /> 
</form>
