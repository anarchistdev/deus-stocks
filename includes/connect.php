<?php

// Retrieve information from database.txt
$mysql_host = "---";
$mysql_user = "---";
$mysql_pass = "---";
$mysql_db = "---";

global $link;
$link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if ($link == false) {
	die('error connecting: '. mysqli_connect_error());
}

function connect() {
	global $link;
	return $link;
}

function custom_query($query, $error_message=null) {
	global $link;
	$sqler = mysqli_query($link, $query);
	
	if ($sqler == false) {
		error_log('mysql error: ' . mysqli_error($link));
		if ($error_message != null) {
			//die("Error: query failed  " . mysqli_error($link));
		} 
		else {
			//die("query failed: $error_message" . mysqli_error($link));
		}
		
	} elseif ($sqler == true) {
		return $sqler;
	}
}

function custom_escape_string($str) {
	global $link;
	return mysqli_real_escape_string($link, $str);
}

function error_message() {
	global $link;
	return mysqli_error($link);
}

?>

