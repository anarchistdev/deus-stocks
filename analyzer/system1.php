<?php
/*
SMA: 10 day| 20 day| 50 day| If 10 day surpasses 20 and 50 day, increment up. if 10 day surpasses by 1-5,
increment + 2. if 6-10, increment + 3. if 10+, increment +4
. next column = number x volatility

SMA: 10 day| 20 day| 50 day| If 10 day goes under 20 and 50 day, increment down. if 10 day goes under by 1-5,
increment - 2. if 6-10, increment -3. if 10+, increment -4.
  next column= number x volatility
  
  TODO: change the system so it reacts more to positive and negative trends
*/

function system_calc($ten_day, $twenty_day, $fifty_day) {
	$i = 5;
	if ($ten_day > $twenty_day && $ten_day > $fifty_day) {
		$i++; // 6
		if ($ten_day >= $twenty_day + 0.5) {
			$i++; // 7
			if ($ten_day >= $twenty_day + 1) {
				$i++; // 8
					if ($ten_day >= $twenty_day + 1.5) {
					$i++; // 9
					if ($ten_day >= $twenty_day + 2) {
						$i++; // 10
					if ($ten_day >= $twenty_day + 10) {
						$i = "-10*";
					}
				}
			}} 
		}
	} else if ($ten_day < $twenty_day && $ten_day < $fifty_day) {
		$i--;
		if ($ten_day <= $twenty_day - 0.5) {
			$i--;
			if ($ten_day <= $twenty_day - 1) {
				$i--;
				if ($ten_day <= $twenty_day - 1.5) {
					$i--;
					if ($ten_day <= $twenty_day - 2) {
						$i--;
						if ($ten_day <= $twenty_day - 10) {
						$i = "10*";
					}
					}
				}
			}
		}
	}
		
	return $i;
}

if (isset($_POST['ten'])) {
	$color = "black";
	$number = system_calc($_POST['ten'], $_POST['twenty'], $_POST['fifty']);
	if ($number < 5) {
		$color = "red";
	} else if ($number > 5) {
		$color = "lightgreen";
	} else if ($number == 5) {
		$color = "gray";
	}
	if (!empty($_POST['ten']) || !empty($_POST['twenty']) || !empty($_POST['fifty'])) {
		echo "<span class='txt'>Rating: ";
		echo "<span style='color: $color; font-size:20px;'><b><i>$number</i></b></span></span>";
	} else {
		die('<span class="txt">Please fill out the text areas</span>');
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../invest.css" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300' rel='stylesheet' type='text/css'>
</head>
<br><br>
<body>
<form action="" method="POST">
	<input type="text" placeholder="10 Day" size="5" name="ten" class="mini-textfield" autocomplete="off" />
	<input type="text" placeholder="20 Day" size="5" name="twenty" class="mini-textfield" autocomplete="off" />
	<input type="text" placeholder="50 Day" size="5" name="fifty" class="mini-textfield" autocomplete="off" />
	<br>
	<input type="submit" value="Caculate" name="button" class="reg-button" />
</form>
</body>
</html>