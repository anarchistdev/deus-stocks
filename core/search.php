<?php

session_start();
?>

		<!DOCTYPE html>
		<html>
		<head>
			<link rel="stylesheet" type="text/css" src="invest.css" />
		</head>
		<body>
		<pre id="data" style="line-height: 150%;">
		<table border="1">
		<?php
		session_start();
$sourceURL = 'http://finance.yahoo.com/d/quotes.csv?s=MS+WMT&f=snl1d1t1ohgdrc6p2p5j1db2b3a'; // p2 for percent change

$sourceData  = file_get_contents( $sourceURL );

// separate into lines
$sourceLines = str_getcsv($sourceData, "\n"); 

foreach( $sourceLines as $line ) {

    $contents = str_getcsv( $line );
    $_SESSION['data'] = $contents;
	
    // Now, is an array of the comma-separated contents of a line


	/*
	
	[0] - Symbol of company
	[1] - Name of company
	[2] - unknown 
	[3] - Today's date
	[4] - Last trade(the time)
	[5] - unknown
	[6] - unknown
	[7] - unknown
	[8] - unknown
	[9] - unknown
	[10]- Change
	[11]- Change and percent
	[12]- unknown
	[13]- Price of company's stocks (market capitlization)
	[14]- Dividen
	[15]- Ask (the lowest price of the company's stock)
	[16]- Bid (the highest price of the company's stock)
	
	*/
	echo prettyPrint($contents);
		
}
?>
</pre>
</table>

<?php
function prettyPrint($a) {

      $content = str_replace('Array','',print_r($a,true));
      $newContent = str_replace('(','', $content);
      $box = str_replace('[','<span style="color: gray">[</span>',$newContent);
      $newBox = str_replace(']','<span style="color: gray">]</span>',$box);
      $na = str_replace('N/A','<img src="../icon/na.png" />',$newBox);
	  $new = str_replace('0.00%','<span style="color: lightgray">0.00%</span>',$na);
      
      // regex for all negative numbers   /-[.\d%]+$/
      
      // regex for all positive numbers   /\+[.\d%]+$/
            
      $paren = str_replace(')','', $new);
      
      
      return '<pre><td class="hover">'.$paren.'</td></pre>';
}
?>


</body>
</html>
