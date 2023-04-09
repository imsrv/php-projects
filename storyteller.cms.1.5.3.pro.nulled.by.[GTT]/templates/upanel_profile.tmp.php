<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template upanel_profile -->

<form action="upanel.php" method="post">

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>UPanel - Update Profile</b>
			</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>New Password:</b>
			</font>
		</td>
  		<td bgcolor="#ffffff">
			<input type="password" name="password1" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Verify Password:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input type="password" name="password2" size="32">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Email:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="email" size="32" value="$insert[user_email]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Homepage (with http://):</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="homepage" size="32" value="$insert[user_homepage]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>ICQ:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="icq" size="32" value="$insert[user_icq]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>AOL Instant Messanger:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="aim" size="32" value="$insert[user_aim]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Yahoo Instant Messanger:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="yam" size="32" value="$insert[user_yam]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>MS Messanger:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="ms" size="32" value="$insert[user_ms]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Jabber:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="jabber" size="32" value="$insert[user_jabber]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Location:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="location" size="32" value="$insert[user_location]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Occupation:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="occupation" size="32" value="$insert[user_occupation]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Interests:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<input name="interests" size="32" value="$insert[user_interests]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Picture (URL with http://):</b>
			</font>
		</td>		
		<td bgcolor="#ffffff">
			<input name="picture" size="32" value="$insert[user_picture]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Computer Configuration:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<textarea cols="38" name="cconfig" rows="6">$insert[user_cconfig]</textarea>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Signature:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<textarea cols="38" name="signature" rows="6">$insert[user_signature]</textarea>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<input type="hidden" name="aform" value="updprofile">
		</td>
		<td bgcolor="#ffffff">
			<input type="submit" value="Submit">
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>