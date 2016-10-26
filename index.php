<?php

?>


<!DOCTYPE html>
<html>
<head>
	<title>Deus Investments</title>
	
	
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Deus">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	
	
	<script type="text/javascript" src="Dependencies/jquery.js"></script>
	<script type="text/javascript" src="Dependencies/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="sheet/invest.css" media="screen" />
	<link rel='stylesheet' media='screen and (max-device-width: 700px)' href='sheet/mobile.css' />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="icon/favicon.ico" type="image/x-icon">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300' rel='stylesheet' type='text/css'>



</head>
<body>

<header>
<div id="big-box">
    <div id="clock1"></div>
<form method="POST" action="http://www.stevenazlan.com/test/login/login.php">
<input type='text' name='username' placeholder='username' id='field' />
<br>
<br>
<input type='password' name='password' placeholder='password' id='field-password' />
<br>
<br>
<input type='submit' name='submit' value='Log in' class='login-button' /> 
</form>
<img src="title.png" id="main-title"/>
<blockquote id="main-quote"><p>If morality represents the ideal world then economics represents the actual world </p></blockquote>
<br>
</header>
<br>
<br>
<div class="about-me">
<span class="title">About</span>
<p>
Lorem ipsum dolor sit amet, his an duis pericula accusamus. Vix ut assum mnesarchum. Clita tation eum at, ius id decore populo interpretaris. Ex legimus interesset sed, pro facete dictas insolens an. Enim eripuit intellegam vis ea, persius consectetuer in per, menandri patrioque et vim.

Iusto maiorum iudicabit an his, pri iusto dissentiunt ei. Eu dicunt aperiri omittantur eum. Expetendis voluptatum nam eu, ea mei tincidunt conclusionemque, no choro repudiandae sea. Appetere reprehendunt ei duo, sea tacimates definitionem ut. Ius ea odio appareat, simul decore eloquentiam ut pri. Per ea modo fabellas.
</p>
<p>
Lorem ipsum dolor sit amet, his an duis pericula accusamus. Vix ut assum mnesarchum. Clita tation eum at, ius id decore populo interpretaris. Ex legimus interesset sed, pro facete dictas insolens an. Enim eripuit intellegam vis ea, persius consectetuer in per, menandri patrioque et vim.

Iusto maiorum iudicabit an his, pri iusto dissentiunt ei. Eu dicunt aperiri omittantur eum. Expetendis voluptatum nam eu, ea mei tincidunt conclusionemque, no choro repudiandae sea. Appetere reprehendunt ei duo, sea tacimates definitionem ut. Ius ea odio appareat, simul decore eloquentiam ut pri. Per ea modo fabellas.
</p>
<br>
<span class="title">Contact</span>
<p>
Lorem ipsum dolor sit amet, his an duis pericula accusamus. Vix ut assum mnesarchum. Clita tation eum at, ius id decore populo interpretaris. Ex legimus interesset sed, pro facete dictas insolens an. Enim eripuit intellegam vis ea, persius consectetuer in per, menandri patrioque et vim.

Iusto maiorum iudicabit an his, pri iusto dissentiunt ei. Eu dicunt aperiri omittantur eum. Expetendis voluptatum nam eu, ea mei tincidunt conclusionemque, no choro repudiandae sea. Appetere reprehendunt ei duo, sea tacimates definitionem ut. Ius ea odio appareat, simul decore eloquentiam ut pri. Per ea modo fabellas.
</p>
</div>

<br>
<br>
<br>
<div id="footer">
&copy; <?php 
$copyYear = 2013; 
$curYear = date('Y'); 
echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
?> Deus Investments
<br>
All rights reserved
</div>


<script type="text/javascript">
/* Sets time in clock div and calls itself every second */
/**
 * Clock plugin
 * Copyright (c) 2010 John R D'Orazio (donjohn.fmmi@gmail.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * 
 * Turns a jQuery dom element into a dynamic clock
 *  
 * @timestamp defaults to clients current time
 *   $("#mydiv").clock();
 *   >> will turn div into clock using client computer's current time
 * @timestamp server-side example:
 *   Say we have a hidden input with id='timestmp' the value of which is determined server-side with server's current time
 *   $("#mydiv").clock({"timestamp":$("#timestmp").val()});
 *   >> will turn div into clock passing in server's current time as retrieved from hidden input
 *    
 * @format defaults to 12 hour format,
 *   or if langSet is indicated defaults to most appropriate format for that langSet
 *   $("#mydiv").clock(); >> will have 12 hour format
 *   $("#mydiv").clock({"langSet":"it"}); >> will have 24 hour format
 *   $("#mydiv").clock({"langSet":"en"}); >> will have 12 hour format 
 *   $("#mydiv").clock({"langSet":"en","format":"24"}); >> will have military style 24 hour format
 *   $("#mydiv").clock({"calendar":true}); >> will include the date with the time, and will update the date at midnight
 *         
 */

(function($){$.clock={version:"2.0.1",locale:{}};t=[];$.fn.clock=function(d){var c={it:{weekdays:["Domenica","Luned\93","Marted\93","Mercoled\93","Gioved\93","Venerd\93","Sabato"],months:["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"]},en:{weekdays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],months:["January","February","March","April","May","June","July","August","September","October","November","December"]},es:{weekdays:["Domingo","Lunes","Martes","Mi\8Ercoles","Jueves","Viernes","S\87bado"],months:["Enero","Febrero","Marzo","Abril","May","junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]},de:{weekdays:["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"],months:["Januar","Februar","M\8Arz","April","k\9Annte","Juni","Juli","August","September","Oktober","November","Dezember"]},fr:{weekdays:["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"],months:["Janvier","F\8Evrier","Mars","Avril","May","Juin","Juillet","Ao\9Et","Septembre","Octobre","Novembre","D\8Ecembre"]},ru:{weekdays:["???????????","???????????","???????","?????","???????","???????","???????"],months:["??????","???????","????","??????","???","????","????","??????","????????","???????","??????","???????"]}};return this.each(function(){$.extend(c,$.clock.locale);d=d||{};d.timestamp=d.timestamp||"z";y=new Date().getTime();d.sysdiff=0;if(d.timestamp!="z"){d.sysdiff=d.timestamp-y}d.langSet=d.langSet||"en";d.format=d.format||((d.langSet!="en")?"24":"12");d.calendar=d.calendar||"true";if(!$(this).hasClass("jqclock")){$(this).addClass("jqclock");}var e=function(g){if(g<10){g="0"+g}return g;},f=function(j,n){var r=$(j).attr("id");if(n=="destroy"){clearTimeout(t[r]);}else{m=new Date(new Date().getTime()+n.sysdiff);var p=m.getHours(),l=m.getMinutes(),v=m.getSeconds(),u=m.getDay(),i=m.getDate(),k=m.getMonth(),q=m.getFullYear(),o="",z="",w=n.langSet;if(n.format=="12"){o=" AM";if(p>11){o=" PM"}if(p>12){p=p-12}if(p===0){p=12}}p=e(p);l=e(l);v=e(v);if(n.calendar!="false"){z=((w=="en")?"<span class='clockdate'>"+c[w].weekdays[u]+", "+c[w].months[k]+" "+i+", "+q+"</span>":"<span class='clockdate'>"+c[w].weekdays[u]+", "+i+" "+c[w].months[k]+" "+q+"</span>");}$(j).html(z+"<br><span class='clocktime'>"+p+":"+l+":"+v+o+"</span>");t[r]=setTimeout(function(){f($(j),n)},1000);}};f($(this),d);});};return this;})(jQuery);

/* Now apply on document ready to jsbin page */
$(document).ready(function(){

$.clock.locale = {"pt":{"weekdays":["Domingo","Segunda-feira", "Ter\8Da-feira","Quarta-feira","Quinta-feira","Sexta-feira", "S\87bado"],"months":["Janeiro","Fevereiro","Mar\8Do","Abril", "Maio","Junho","Julho","Agosto","Setembro","October","Novembro", "Dezembro"] } };

$("#clock1").clock();
$("#clock2").clock({"langSet":"it"});
$("#clock3").clock({"langSet":"pt"});
$("#clock4").clock({"format":"24","calendar":"false"});

customtimestamp = new Date().getTime() + 1123200000+10800000+14000;
$("#clock5").clock({"timestamp":customtimestamp});
                                     
});

</script>
</body>
</html>
