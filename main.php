<?php
session_start();
//require 'includes/secure.php';
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//$username = $_SESSION['username'];

$username = "test";
$file =  "includes/investments/$username.php";



if (isset($_POST['clear_investments'])) {
	file_put_contents($file, "");
	header('Location: '. $_SERVER['PHP_SELF']);
}

if (isset($_POST['ticker'])) {
	$ticker = $_POST['ticker'];

	$handle = fopen($file, 'ab');
	$ticker = trim(htmlentities($ticker));

	fwrite($handle,"$ticker \n");
	/*
		*/
	fclose($handle);
	header('Location: '. $_SERVER['PHP_SELF']);
}


function prettyPrint($a) {
      $content = str_replace('Array','',print_r($a, TRUE));
      $newContent = str_replace('(','', $content);
      $box = str_replace('[','<span style="color: gray">[</span>',$newContent);
      $newBox = str_replace(']','<span style="color: gray">]</span>',$box);
      $na = str_replace('N/A','<img src="na.png" />',$newBox);
	  $new = str_replace('0.00%','<span style="color: lightgray">0.00%</span>',$na);
      // regex for all negative numbers   /-[.\d%]+$/
      // regex for all positive numbers   /\+[.\d%]+$/
      $paren = str_replace(')','', $new);
      return '<pre>'.$paren.'</pre>';
}

function prettify($a) {
      $content = str_replace('Array','',print_r($a, TRUE));
      $newContent = str_replace('(','', $content);
	  $newContent = str_replace('>', '', $newContent);
	  $newContent = str_replace('=', '', $newContent);

	  $first = reset($a);
	  $newContent = str_replace($first, "$first:&nbsp", $newContent);
	  $newContent = str_replace('NASDAQ-100', 'NASDAQ', $newContent);


	  $newContent = preg_replace('/\[(.*?)\]/', '', $newContent);
	  $bla = trim($newContent);
	  $newContent = preg_replace('/(\+[.\d%]+)/', "<span style='color: green;'>$1</span>", $bla); // get positive percents and numbers
	  $newContent = preg_replace('/(-[.\d%]+)/', "<span style='color: red'>$1</span>", $newContent); // get negative percents and numbers
      $box = str_replace('','',$newContent);
      $newBox = str_replace('','',$box);
      $na = str_replace('N/A','<img src="na.png" />',$newBox);
	  $new = str_replace('0.00%','<span style="color: green">0.00%</span>',$na);
      // regex for all negative numbers   /-[.\d%]+$/
      // regex for all positive numbers   /\+[.\d%]+$/
      $paren = str_replace(')','', $new);
      return $paren;
}


if (isset($_POST['search'])){
	$symbol = $_POST['symbol'];
	$symbol = strtoupper($symbol);
	$sourceURL = 'http://finance.yahoo.com/d/quotes.csv?s=' . $symbol . '&f=sncb4c8d2e7f6k5m2m8or2r7s7ya2b2dee8gkj3j6k3m3m6pp5r5t1t8w4b3e9hk1mm4p1p6r1r6vwx';
	$imgURL = 'http://chart.finance.yahoo.com/z?s='. $symbol .'&t=12m&q=c&z=l';

	$gmailURL = 'http://finance.yahoo.com/d/quotes.csv?s=GOOG+WMT+CCF+FLML&f=snl1d1t1ohgdrc6p2p5j1db2b3'; // p2 for percent change


	$newsURL = 'http://markets.financialcontent.com/stocks/action/rssfeed?Symbol=' . $symbol;

	$sourceData  = file_get_contents( $sourceURL );

	$_SESSION['url'] = $imgURL;
	$_SESSION['symbol'] = $symbol;
	$_SESSION['news'] = $newsURL;

	// separate into lines
	$sourceLines = str_getcsv($sourceData, "\n");

	foreach( $sourceLines as $line ) {

		$contents = str_getcsv( $line );
		$_SESSION['content'] = $contents;

	$window = "<SCRIPT>
	if (screen.width <= 699) {
		document.location = 'core/window.php?s=$symbol';
	} else {
		newwindow=window.open('core/window.php?s=$symbol','','width=900, height=715');
		newdocument.close();
	}
	</SCRIPT>
	";
	echo $window;
	}
	echo '<script>window.location = "main.php"';
}

if (isset($_POST['remove-ticker'])) {
	$ticker_remove = trim(htmlentities($_POST['remove-ticker']));
	$filer = file_get_contents($file);
	$str = str_replace($ticker_remove, '', $filer);
	file_put_contents($file, $str);
	header('Location: '. $_SERVER['PHP_SELF']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Main Content page - <?php echo $username ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<meta charset='utf-8'>

	<script src="Dependencies/jquery.js"></script>
	<script src="Dependencies/jquery-ui.js"></script>
	<script src="Dependencies/selectboxit.js"></script>

	<link rel="stylesheet" type="text/css" href="invest.css" media="screen" />
	<link rel='stylesheet' media='screen and (max-device-width: 700px)' href='mobile.css' />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="Dependencies/selectboxit.css" />

	<script type="text/javascript">
	$( document ).ready(function() {
		function update() {
		  $.ajax({
		   type: 'POST',
		   url: 'includes/time.php',
		   timeout: 1000,
		   success: function(data) {
			  $(".timer").html(data);
			  window.setTimeout(update, 1000);
		   },
		  });
		 }
		update();

		 var actions = $("#actions");
		 actions.selectBoxIt({
			defaultText: "Choose an action"
		 });
		 actions.on("change", function() {
			if ($(this).val() == "Add Investment") {
				$("#dialog").dialog();
			} else if ($(this).val() == "Log Out") {
				document.getElementById('logout').click();
			} else if ($(this).val() == "Clear All Investments") {
				$("#deleteInvestments").dialog();
			} else if ($(this).val() == "Remove Investment") {
				$('#investment-remove').dialog();
			}
		 });



		 });


var int=self.setInterval(function(){clocker()}, 3000);

function clocker() {
	$('#indices').load('main.php #indices');
}

	</script>

</head>
<body id="main">
<!-- Make all the dialogs -->
<div id="deleteInvestments" style="display: none; font-size: 20px;" title="<span class='txt'>Delete Investments</span>">
<span class="txt">
Are you sure you want to delete <i>all</i> your investments?
</span>
<form action="" method="POST">
	<input type="submit" value="Delete" name="clear_investments" class="reg-button" />
</form>
</div>

<div id="investment-remove" style="display: none; font-size: 20px;" title="<span class='txt'>Remove an Investment</span>">
	<span class="txt">
	Enter a ticker to remove.
	</span>
	<form action="" method="POST">
		<input type="text" size="5" autocomplete="off" name="remove-ticker" class="mini-textfield" />
	</form>
</div>

<div id="dialog" style="display: none;" title="<span class='txt' style='font-size: 20px;'>Add an Investment</span>">
<span class="txt">
Enter a valid ticker:
<br>
<form action="" method="POST">
	<input type="text" size="5" autocomplete="off" name="ticker" class="mini-textfield" />
</form>
</span>
</div>
<!-- End dialogs -->

<!-- Search bar -->
<div class="search-bar">
<form action="" method="POST">
	<br>
	<input type="text" name="symbol" placeholder="enter a symbol" id="search" autocomplete="off"  />
	<input type="submit" value="Search" name="search" id="search-button">
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<select id="actions">
		<option>Add Investment</option>
		<option>Remove Investment</option>
		<option>Clear All Investments</option>
		<option>Log Out</option>
	</select>
	<span class='timer' style='float: right;'></span>
	<img style="float: right;" src="logo.png" id="logo" />
</form>
</div>
<!-- End search bar -->

<br><br><br><br>
<br><br><br>
<span class="big">Welcome, <b><?php echo htmlentities($username); ?></b> </span>
<br><br><br>
<br><br><br>
<span class="titles investments">Your Investments</span>
<table border="0">
<td>
<div class="investment-panel">
	<span class="txt">Name&nbsp; |&nbsp; Percent Change&nbsp; |&nbsp; Change&nbsp; |&nbsp;  Ask  &nbsp;|&nbsp;  Bid  &nbsp;|</span><hr>
	<?php
		$handler = fopen($file, "r");
		$company_boolean = true;
		global $company_boolean;
		while (!feof($handler)) {
			$company = fgets($handler);
			$company = trim($company);
			if ($company !== "") {
				global $company_boolean;
				$company_boolean = false;
				$sourceURL = 'http://finance.yahoo.com/d/quotes.csv?s='. $company .'&f=np2c1ab'; // p2 for percent change
				$sourceData  = file_get_contents( $sourceURL );
				$sourceLines = str_getcsv($sourceData, "\n");
				foreach( $sourceLines as $line ) {
					$contents = str_getcsv( $line );
					echo '<div class="hover"><span style="word-spacing: 10px;" class="txt">' . prettify($contents) . '<hr></div></span>';
				}
			}
		}
		if ($company_boolean == true) {
			echo '<span class="no-investments">You have no investments</span>';
		}

		fclose($handler);

	?>
</div>
</td>
<span class="titles market">World Indices</span>
<td class="market_row">
<span class="mobile-title"><br>World Indices<br></span>
<div class="marketplace">
<span class="txt">Index&nbsp; |&nbsp; Percent Change&nbsp; |&nbsp; Change&nbsp; |&nbsp; Day's Range  &nbsp;|</span>
<hr>
<div id="indices">
<?php
$sourceURL = 'http://finance.yahoo.com/d/quotes.csv?s=^GSPC+^NDX+^XAX+^MXX+^BVSP+^GSPTSE+^MERV+^N225&f=np2c1m'; // p2 for percent change
$sourceData  = file_get_contents( $sourceURL );
$sourceLines = str_getcsv($sourceData, "\n");
foreach( $sourceLines as $line ) {
	echo '<div class="hover">';
	$contents = str_getcsv( $line );
	echo '<span style="word-spacing: 10px;" class="txt">';
	echo prettify($contents);
	echo '<hr></div></span>';
}
?>
</div> <!-- End indices -->
</div>
</td>
</table>
<br><br><br><br>
<table>
<td>
<span class="titles news">Latest Market News</span>
<div class="news-panel">
	<?php
		function parseRSS($url) {

		//PARSE RSS FEED
			$feedeed = implode('', file($url));
			$parser = xml_parser_create();
			xml_parse_into_struct($parser, $feedeed, $valueals, $index);
			xml_parser_free($parser);

		//CONSTRUCT ARRAY
			foreach($valueals as $keyey => $valueal){
				if($valueal['type'] != 'cdata') {
					$item[$keyey] = $valueal;
				}
			}

			$i = 0;

			foreach($item as $key => $value){

				if($value['type'] == 'open') {

					$i++;
					$itemame[$i] = $value['tag'];

				} elseif($value['type'] == 'close') {

					$feed = $values[$i];
					$item = $itemame[$i];
					$i--;

					if(count($values[$i])>1){
						$values[$i][$item][] = $feed;
					} else {
						$values[$i][$item] = $feed;
					}

				} else {
					$values[$i][$value['tag']] = $value['value'];
				}
			}

		//RETURN ARRAY VALUES
			return $values[0];
		}

				$url = "http://finance.yahoo.com/news/?format=rss";
				$xml = parseRSS($url);
				echo '<span class="txt">';
				$i = 0;
				foreach($xml['RSS']['CHANNEL']['ITEM'] as $item) {
					echo '<a href="'.$item['LINK'].'" class="titles news-links" target="_blank">' . $item['TITLE'] . '</a><p>' . trim($item['DESCRIPTION']) . '</p><hr>';
					if (++$i == 10) break;
				}
				echo '</span>';

	?>
</div>
</td>
</table>
<br><br>
<form action="includes/secure.php" method="POST">
<input type="submit" value="Log Out" class="reg-button" name="log_out" id="logout" style="display: none;" />
</form>
</body>
</html>
