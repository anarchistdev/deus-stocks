<?php
require '../connect.php';
require 'system1.php';
//ini_set('display_errors',1);
//error_reporting(E_ALL);


function masterLoop() {
	$main_ticker_file = fopen("ticketMaster.txt", "r");
	$percent_of_change_array = array();
	$neg_percent_of_change_array = array();
	while (!feof($main_ticker_file)) {
		$company_ticker = fgets($main_ticker_file);
		$company_ticker = trim($company_ticker);
		
		$next_day_increase =  0;
		$next_day_decrease =  0;
		$next_day_no_change = 0; 
		$total = 0;
		
		$sum_of_increases = 0;
		$sum_of_decreases = 0;
		
		
		$sql = "SELECT date, percent_change FROM $company_ticker WHERE percent_change < '0' ORDER BY date ASC";
		$result = custom_query($sql, 'price dropped query failed');
		
		if ($result) {
			while ($row = mysqli_fetch_array($result)) {
				$date = $row['date'];
				$percent_change = $row['percent_change'];
				
				
				$sql2 = "SELECT date, percent_change FROM $company_ticker WHERE date > '$date' ORDER BY date ASC LIMIT 1";
				$result2 = custom_query($sql2);
				$number_of_rows = mysqli_num_rows($result2);
				
				if ($number_of_rows == 1) {
					$row2 = mysqli_fetch_row($result2);
					$tom_date = $row2[0];
					$tom_percent_change = $row2[1];
					
					if ($tom_percent_change > 0) { // goes up
						$next_day_increase++;
						$sum_of_increases += $tom_percent_change;
						$total++;
					} elseif ($tom_percent_change < 0) { // goes down
						$next_day_decrease++;
						$sum_of_decreases += $tom_percent_change;
						$total++;
					} else { // no change
						$next_day_no_change++;
						$total++;
					}
					$next_day_increase_percent = ($next_day_increase/$total) * 100;
					$next_day_decrease_percent = ($next_day_decrease/$total) * 100;
					$average_increase_percent =  $sum_of_increases/$next_day_increase;
					$average_decrease_percent =  $sum_of_decreases/$next_day_decrease;
					
					$percent_of_change_array[] = $next_day_increase_percent;
					$neg_percent_of_change_array[] = $next_day_decrease_percent;

					$main_array = array_merge($percent_of_change_array, $neg_percent_of_change_array);
					$deviation = standard_deviation_population($main_array);
					

					
					insertIntoResultTable($company_ticker, $next_day_increase, $next_day_increase_percent, $average_increase_percent, $next_day_decrease, $next_day_decrease_percent, $average_decrease_percent, $deviation);

				}
			}
		}		
	}
}

function insertIntoResultTable($company_ticker, $next_day_increase, $next_day_increase_percent, $average_increase_percentage, $next_day_decrease, $next_day_decrease_percent, $average_decrease_percent, $deviation){
	$buyValue = $next_day_increase_percent * $average_increase_percentage; // the percentage of days increased times how much it increases when it does
	$sellValue = $next_day_decrease_percent * $average_decrease_percent;
	
	$query = "SELECT * FROM analysisA WHERE ticker='$company_ticker' ";
	$result = custom_query($query);
	$numberOfRows = mysqli_num_rows($result);
	
	if($numberOfRows == 1){
		$sql = "UPDATE analysisA SET ticker='$company_ticker',daysInc='$next_day_increase',pctOfDaysInc='$next_day_increase_percent',avgIncPct='$average_increase_percentage',daysDec='$next_day_decrease',pctOfDaysDec='$next_day_decrease_percent',avgDecPct='$average_decrease_percent',buyValue='$buyValue',sellValue='$sellValue',deviation='$deviation' WHERE ticker='$company_ticker' ";
		custom_query($sql);
	}else{
		$sql = "INSERT INTO analysisA (ticker,daysInc,pctOfDaysInc,avgIncPct,daysDec,pctOfDaysDec,avgDecPct,buyValue,sellValue,deviation) VALUES ('$company_ticker', '$next_day_increase', '$next_day_increase_percent', '$average_increase_percentage', '$next_day_decrease', '$next_day_decrease_percent', '$average_decrease_percent', '$buyValue', '$sellValue', '$deviation')";
		custom_query($sql);
	}
}


echo moving_average("GOOG", 50);

masterLoop();

echo "<Br>";

$var = 1;
while ($var < 5) {
	$var = $var + $var;
	echo $var;
}


?>