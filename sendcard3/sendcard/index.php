<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard - a PHP postcard script using a database to store the cards</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a {  text-decoration: none;}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<h1><font color="#99CC33">Test Design</font></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td width="145" valign="top" bgcolor="#9999CC"> 
	  <p><a href="#">Your menu</a></p>
	  <p><a href="#">Here</a></p>
	  <p><font color="#9999CC">Powered by sendcard</font></p>
	</td>
	<td width="20">&nbsp;</td>
	<td width="10">&nbsp;</td>
	<td>
	  <h1 align="center">Send a Virtual Postcard!</h1>
	  <p align="left">Sending a postcard is very easy, just follow the steps below. 
	  <p align="left">1. Click on the image that you want to send. 
	  <p align="left">2. Fill in the form that appears.&nbsp; Make sure that you 
		get the recipient's email address correct! 
	  <p align="left">3. Preview the card. You can still make any changes if you 
		want to. 
	  <p align="left">4. Send it! 
	  <p align="left">&nbsp; 
	  <table width="560" border="0" cellspacing="5" cellpadding="0" align="center">
		<tr align="center"> 
		  <td valign="top"> 
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_mapledesign.jpg" width="200" height="140" name="image">
			  <input type="hidden" name="image" value="mapledesign.jpg">
			  <input type="hidden" name="caption" value="Get yourself a <a href=http://www.mapledesign.co.uk>Maple Design</a> website!">
			</form>
		  </td>
		  <td valign="top"><form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_sponsor.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="sponsor.gif">
			  <input type="hidden" name="caption" value="">
			</form></td>
		</tr>
		<tr align="center"> 
		  <td valign="top"> Alternative des
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_stars.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="stars.gif">
			  <input type="hidden" name="caption" value="Drunk in Leicester Square, <br>by Peter Bowyer">
			  <input type="hidden" name="des" value="test">
			</form>
		  </td>
		  <td valign="top">Java game - To use, download JTed from http://www.jted.com and extract into a directory named JTed underneath the directory containing sendcard.php
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_starburst.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="">
			  <input type="hidden" name="applet_name" value="Jted.class">
			  <input type="hidden" name="caption" value="Left: j<br>Right: l<br>Turn: k<br> Down: spacebar">
			</form>
		 </td>
		</tr>
		<tr align="center"> 
		  <td valign="top">Java test 1 
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_starburst.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="sunset.jpg">
			  <input type="hidden" name="applet_name" value="PlasmaImage.class">
			  <input type="hidden" name="caption" value="I must be going crazy...">
			</form></td>
		  <td valign="top">Java test 2
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/sunset.jpg" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="sunset.jpg">
			  <input type="hidden" name="img_width" value="251">
			  <input type="hidden" name="img_height" value="260">
			  <input type="hidden" name="applet_name" value="Lake.class">
			  <input type="hidden" name="caption" value="">
			</form></td>
		</tr>
		<tr align="center"> 
		  <td valign="top"> SWF test
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_stars.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="froggie02.swf">
			  <input type="hidden" name="caption" value="Will he get the fly?">
			</form>
		  </td>
		  <td valign="top">Using the fancy template 
			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_mapledesign.jpg" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="mapledesign.jpg">
			  <input type="hidden" name="caption" value="">
			  <input type="hidden" name="template" value="fancy">
			</form></td>
		</tr>	  </table>
	</td>
	<td width="10%">&nbsp;</td>
  </tr>
</table>
<p align="center"><a href="http://www.sendcard.f2s.com/"><img src="poweredbysendcard102x47.gif" width="102" height="47" border="0" alt="Powered by sendcard - an advanced PHP e-card program"></a></p>
<!--			<form method="post" action="sendcard.php">
			  <input type="image" border="0" value="Submit" src="images/tn_starburst.gif" width="200" height="120" name="image">
			  <input type="hidden" name="image" value="Lake.class">
			  <input type="hidden" name="img_width" value="251">
			  <input type="hidden" name="img_height" value="260">
			  <input type="hidden" name="param[]" value="image|images/sunset.jpg">
			  <input type="hidden" name="caption" value="">
			</form> -->
</body>
</html>
