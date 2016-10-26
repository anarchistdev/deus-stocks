<?php
session_start();

require_once('../mail/class.phpmailer.php');
date_default_timezone_set('America/New_York');
$current_time = strftime('%r');


$mail_time = "10:30:00 AM";

if ($current_time === $mail_time) {
	//echo 'if statement working';
	send_gmail();
} else {
	print $current_time;
}


function send_gmail() {
	$sourceURL = "http://finance.yahoo.com/d/quotes.csv?s=SPY+AAPL+ETF+SE+UDN&f=snc"; // p2 for percent change
	$sourceData  = file_get_contents( $sourceURL );
	$sourceLines = str_getcsv($sourceData, "\n"); 
	foreach( $sourceLines as $line ) {
    	$contents = str_getcsv( $line );
    
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "deusinvestments@gmail.com";
		$mail->Password = "azlan3522";
		$mail->SetFrom("deusinvestments@gmail.com");
		$mail->Subject = "Daily Investments";
		$mail->Body = 'Our daily investments:<br><pre>'. prettify($contents) . '</pre><br>Please do not respond to this message.';
		$mail->AddAddress("deusinvestments@gmail.com");
 		if(!$mail->Send()){
    		echo "Mailer Error: " . $mail->ErrorInfo;
    	} else {}
	}
}

function prettify($a) {
	
      $content = str_replace('Array','',print_r($a,true));
      $newContent = str_replace('(','', $content);
      $box = str_replace('[','<span style="color: gray">[</span>',$newContent);
      $newBox = str_replace(']','<span style="color: gray">]</span>',$box);
      $na = str_replace('N/A','<span style="color: red">N/A</span>',$newBox);
	  $new = str_replace('0.00%','<span style="color: lightgray">0.00%</span>',$na);
      
      // regex for all negative numbers   /-[.\d%]+$/
      
      // regex for all positive numbers   /\+[.\d%]+$/
            
      $paren = str_replace(')','', $new);
      
      
      return $paren;
      
}

?>