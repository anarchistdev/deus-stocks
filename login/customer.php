<?php
session_start();
require 'secure.php';
?>

hello world
<br>
<form action="secure.php" method="POST">
	<input type='submit' value='log out' name='log_out' />
</form>