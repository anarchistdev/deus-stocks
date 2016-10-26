<?
session_start();
if(isset($_SESSION['name'])){
	$text = $_POST['text'];
	
	$fp = fopen("log.html", 'a');
	fwrite($fp, "<br><div class='msgln'>(" . date('Y-m-d') .") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br><br><hr></div>");
	fclose($fp);
}
?>