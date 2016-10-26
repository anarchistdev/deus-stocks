<?
session_start();

if(isset($_GET['logout'])){	
	
	//Simple exit message
	$fp = fopen("log.html", 'a');
	//fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
	fclose($fp);
	
	session_destroy();
	header("Location: chat.php"); //Redirect the user
}

function loginForm(){
	echo'
	<div id="loginform">
	<form action="chat.php" method="post">
		<p style="text-align: center;">Please enter your name to continue:</p>
		<p style="text-align: center;"><input type="text" name="name" class="name" placeholder="name" /></p>
		<p style="text-align: center;"><input type="submit" name="enter" id="enter" value="Enter" class="reg-button" /></p>
	</form>
	</div>
	';
}

if(isset($_POST['enter'])){
	if($_POST['name'] != ""){
		$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
	}
	else{
		echo '<span class="error">Please type in a name</span>';
	}
}
?>
<?php
include("security.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="invest.css" />
</head>

<?php
if(!isset($_SESSION['name'])){
	loginForm();
}
else{
?>
<div id="wrapper">
	<div id="menu">
		<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
		<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
		<div style="clear:both"></div>
	</div>	
	<div id="chatbox"><?php
	if(file_exists("log.html") && filesize("log.html") > 0){
		$handle = fopen("log.html", "r");
		$contents = fread($handle, filesize("log.html"));
		fclose($handle);
		
		echo $contents;
	}
	?></div>
	
	<form name="message" action="">
		<p style="text-align: center;"><input name="usermsg" type="text" id="usermsg" size="63" class="name" /></p>
		<p style="text-align: center;"><input name="submitmsg" type="submit"  id="submitmsg" value="Send" class="reg-button" /></p>
	</form>
	<div id="emoticons">
    <a href="#" title=":)"><img alt=":)" border="0" src="http://markitup.jaysalvat.com/examples/markitup/sets/bbcode/images/emoticon-happy.png" /></a>
    <a href="#" title=":("><img alt=":(" border="0" src="http://markitup.jaysalvat.com/examples/markitup/sets/bbcode/images/emoticon-unhappy.png" /></a>
    <a href="#" title=":o"><img alt=":o" border="0" src="http://markitup.jaysalvat.com/examples/markitup/sets/bbcode/images/emoticon-surprised.png" /></a>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	//If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
	
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	setInterval (loadLog, 2500);	//Reload file every 2.5 seconds
	
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'chat.php?logout=true';}		
	});
});


$('#emoticons a').click(function() {
    var smiley = $(this).attr('title');
    ins2pos(smiley, 'usermsg');
});

function ins2pos(str, id) {
   var TextArea = document.getElementById(id);
   var val = TextArea.value;
   var before = val.substring(0, TextArea.selectionStart);
   var after = val.substring(TextArea.selectionEnd, val.length);
   TextArea.value = before + str + after;
}


</script>
<?php
}
?>
</body>
</html>