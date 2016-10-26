<?php
require '../connect.php'; // real path is ../includes/connect.php
ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

function createURL($ticker) {
	$current_month = date("n");
	$current_month = $current_month - 1;
	$current_day = date("j");
	$current_year = date("Y");
	$data_from_date = "2012";
	return "http://ichart.finance.yahoo.com/table.csv?s=$ticker&d=$current_month&e=$current_day&f=$current_year&g=d&a=2&b=26&c=$data_from_date&ignore=.csv";
}

function getCSVFile($url, $output_file) {
	$content = file_get_contents($url);
	$content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close", "", $content);
	$content = trim($content);
	file_put_contents($output_file, $content);
}

function fileToDatabase($txt_file, $table_name) {
	$file = fopen($txt_file, "r");
	while (!feof($file)) {
		$line = fgets($file); // gets each line
		$pieces = explode(",", $line); // array of elements separated by a comma
		
		// make stuff we can use out if it
		$date =   $pieces[0];
		$open =   $pieces[1];
		$high =   $pieces[2];
		$low =    $pieces[3];
		$close =  $pieces[4];
		$volume = $pieces[5];
		$amount_change =  $close-$open;
		$percent_change = ($amount_change/$open)*100;
		
		
		$sql = "SELECT * FROM $table_name";
		$result = custom_query($sql);
		
		if (!$result) {
			$sql2 = "CREATE TABLE $table_name (date DATE, PRIMARY KEY(date), open FLOAT, high FLOAT, low FLOAT, close FLOAT, volume INT, amount_change FLOAT, percent_change FLOAT)";
			custom_query($sql2, 'sql2 is failing');
		}
		
		$sql3 = "INSERT INTO $table_name (date, open, high, low, close, volume, amount_change, percent_change) VALUES ('$date','$open','$high','$low','$close','$volume','$amount_change', '$percent_change')";
		custom_query($sql3);
	}
	fclose($file);
}

function main() {
	$main_ticker_file = fopen("ticketMaster.txt", "r");
	while (!feof($main_ticker_file)) {
		$company_ticker = fgets($main_ticker_file);
		$company_ticker = trim($company_ticker);
		
		$fileURL = createURL($company_ticker);
		$company_txt_file = "txtFiles/".$company_ticker.".txt";
		getCSVFile($fileURL, $company_txt_file);
		fileToDatabase($company_txt_file, $company_ticker);
	}
}

main();
$url = createURL("MSFT");
echo $url;

?>
