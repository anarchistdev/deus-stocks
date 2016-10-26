

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="invest.css" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300' rel='stylesheet' type='text/css'>

</head>
<body>
<?php
session_start();

$contents = $_SESSION['content'];
$symbol = $_SESSION['symbol'];
$url = $_SESSION['url'];

$ticker = $_GET['s'];


if (isset($_POST['chart_time'])) {
	$chart_time = $_POST['chart_time'];
	$url = 'http://chart.finance.yahoo.com/z?s='. $ticker .'&t=' . $chart_time . '&q=c&z=l';
}


$cnn = $_SESSION['cnn'];
$news = $_SESSION['news'];

$rules = array('Symbol', 'Name', 'Change - Percent Change' 
);

echo '<div id="search-data">';
echo '<table border="0">';
echo '<td valign="top">
<pre>
';
printToWindow($rules);
echo '</pre>
</td>';
echo '<td>';
printToWindow($contents);
echo '</td>';
echo "</table>";
echo '</div>';


echo '<br>';

?>
<form action="" method="POST">
<br>
<br>
<span style='margin-left: 190px;'><span class="txt">Time span: </span><input type="text" name="chart_time" size="5" class="mini-textfield" autocomplete="off" /></span>
<br>
<br>
</form>
<?php
echo "<img src='". $url . ".gif' style='display: block;
    margin-left: auto;
    margin-right: auto;'/>";
echo "<br>";


// Create an XML parser
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


	 	$xml = parseRSS($news);
	 	echo "<div class='rss-feed'>";
	 	echo "<p style='text-align: center; font-size: 40px; margin-top: 10px;'>News Feed</p>";
	 	foreach($xml['RSS']['CHANNEL']['ITEM'] as $item) {
	        echo("<p style='margin-left: 40px;'><a href=\"{$item['LINK']}\" target=\"_blank\" class=\"indexBoxNews\">{$item['TITLE']}{$link}</a></p>");
	}
		echo "</div>";







function printToWindow($a) {
     
      echo "<pre>";
      $content = str_replace('Array','',print_r($a,true));
      $newContent = str_replace('(','', $content);
      $box = str_replace('[','<span style="color: gray">[</span>',$newContent);
      $newBox = str_replace(']','<span style="color: gray">]</span>',$box);
      $na = str_replace('N/A','<img src="na.png" />',$newBox);
	  $new = str_replace('0.00%','<span style="color: lightgray">0.00%</span>',$na);
      
      // regex for all negative numbers   /-[.\d%]+$/
      
      // regex for all positive numbers   /\+[.\d%]+$/
            
      $paren = str_replace(')','', $new);
      
      
      echo $paren;
      echo "</pre>";
  
      
}
?>
</body>
</html>
