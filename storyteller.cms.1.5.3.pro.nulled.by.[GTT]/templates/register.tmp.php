<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template register -->

<form action="register.php" method="post">

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000" colspan="2">
			<font face="Arial" color="#ffffff" size="2">
				<b>Register</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff" colspan="2">
			<font face="Arial" size="2">
				<br />Registration is completely free and takes only a few seconds.<br /><br /> 
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Username:</b>
			</font>
		</td>
  		<td bgcolor="#ffffff">
			<input name="username" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Password:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="password1" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Verify Password:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="password2" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Enter Security Code:</b><br />
				<img src="scode.php?in=0" width="50" hight="50" border="1">
				<img src="scode.php?in=1" width="50" hight="50" border="1">
				<img src="scode.php?in=2" width="50" hight="50" border="1">
				<img src="scode.php?in=3" width="50" hight="50" border="1">
				<img src="scode.php?in=4" width="50" hight="50" border="1">
			</font>
		</td>
  		<td bgcolor="#ffffff">
			<input name="scode" size="32">
		</td>
		</tr>		
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Email:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="email" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Birthday (DD.MM.YYYY):</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<input name="birthd" size="2">.<input name="birthm" size="2">.<input name="birthy" size="4">
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>I am 13 years or older</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<input type="checkbox" name="year13" value="1">Yes
			</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Terms of use</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
You agree not to post any abusive, hateful, obscene, sexually-orientated, slanderous, threatening, vulgar, or any other material that may violate any applicable laws. The IP address of all posts is recorded to aid in enforcing these conditions. <br /><br />
<input type="checkbox" name="readrules" value="1">Yes, I agree to these terms</b>
			</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />
<center>
	<input type="submit" value="Submit">
</center>
</form>

<br />

TEMPLATE;
?>