<html>
<head>
<title>Autoresponder</title>
<link rel="stylesheet" type="text/css" href="slim.css">
</head>
<body>
<table border="0" width="600" align="center">
<tr>
	<td>
		<h3>Thank you for purchasing Autoresponder Installation!</h3>
	</td>
</tr>
<tr>
	<td>
		<br><b>Please fill in the fields bellow:</b><br><br>
		<form name="focker" action="pay_installation_send_mail.php" method="post">
		<table border="0" cellPadding="5" cellSpacing="0">
		<tr>
			<td align="left" width="100">Your name:</td>
			<td align="left" width="300"><input type="text" name="smart_name" size="30"></td>
		</tr>
		<tr>
			<td align="left">Your e-mail:</td>
			<td align="left"><input type="text" name="smart_email" size="30"></td>
		</tr>
		<tr>
			<td align="left">Your address:</td>
			<td align="left"><input type="text" name="smart_address" size="30"></td>
		</tr>
		<tr>
			<td align="left">City:</td>
			<td align="left"><input type="text" name="smart_city" size="30"></td>
		</tr>
		<tr>
			<td align="left">State:</td>
			<td align="left"><input type="text" name="smart_state" size="30"></td>
		</tr>
		<tr>
			<td align="left">Zip:</td>
			<td align="left"><input type="text" name="smart_zip" size="10"></td>
		</tr>
		<tr>
			<td align="left">Your phone:</td>
			<td align="left"><input type="text" name="smart_phone" size="30"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="bottom" align="left" height="35"><input type="submit" value=" Send "></td>
		</tr>
		</table>
		<input type="hidden" name="fool_name" value="{FOOL_NAME}">
		<input type="hidden" name="fool_email" value="{FOOL_EMAIL}">
		<input type="hidden" name="fool_address" value="{FOOL_ADDRESS}">
		<input type="hidden" name="fool_city" value="{FOOL_CITY}">
		<input type="hidden" name="fool_state" value="{FOOL_STATE}">
		<input type="hidden" name="fool_zip" value="{FOOL_ZIP}">
		<input type="hidden" name="fool_phone" value="{FOOL_PHONE}">
		</form>
	</td>
</tr>
</table>
</body>
</html>