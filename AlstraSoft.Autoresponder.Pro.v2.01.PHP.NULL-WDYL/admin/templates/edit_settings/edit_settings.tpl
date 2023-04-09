<html>
<head>
<title>Administrative Area :: Edit Settings</title>
<link rel="stylesheet" type="text/css" href="../slim.css">
</head>
<body>

<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td valign="middle" align="center" height="40">
		<h3>Edit Settings</h3>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa">

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="main.php">Menu</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>

<form name="form_change_password" action="do_change_password.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Change Administrator Password:</b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="140">Old password:</td>
			<td><input type="password" name="old_password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>New password:</td>
			<td><input type="password" name="password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>Confirm password:</td>
			<td><input type="password" name="confirm_password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colSpan="2">
				<input type="submit" value="Change">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<form name="form_change_freeaccount_settings" action="do_change_freeaccount_settings.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Free Account Settings: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="250">Number of autoresponse messages:</td>
			<td width="200"><input type="text" name="nr_autoresponse_messages" value="{FREEACCOUNT_NR_AUTORESPONSE_MESSAGES}" size="7"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>Number of follow up messages:</td>
			<td><input type="text" name="nr_followup_messages" value="{FREEACCOUNT_NR_FOLLOWUP_MESSAGES}" size="7"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>Number of subscribers:</td>
			<td><input type="text" name="nr_subscribers" value="{FREEACCOUNT_NR_SUBSCRIBERS}" size="7"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td width="100%" colSpan="2">Text Ad: <br>
			<textarea name="text_ad" cols="60" rows="5">{FREEACCOUNT_TEXT_AD}</textarea>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td width="100%" colSpan="2">Banner Ad: <br>
			<textarea name="banner_ad" cols="60" rows="5">{FREEACCOUNT_BANNER_AD}</textarea>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colSpan="2">
				<input type="submit" value="Change">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<form name="form_change_paidaccount_settings" action="do_change_paidaccount_settings.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Paid Account Settings: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="250">Number of autoresponse messages:</td>
			<td width="200"><input type="text" name="nr_autoresponse_messages" value="{PAIDACCOUNT_NR_AUTORESPONSE_MESSAGES}" size="7"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>Number of follow up messages:</td>
			<td><input type="text" name="nr_followup_messages" value="{PAIDACCOUNT_NR_FOLLOWUP_MESSAGES}" size="7"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colSpan="2">
				<input type="submit" value="Change">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<form name="form_affiliate_levels" action="do_change_affiliate_levels.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Affiliate Levels: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="200" cellPadding="2" cellSpacing="1" border="0">
		<tr height="20">
			<td width="30%" align="center" bgColor="#FFFFFF"><b>Level</b></td>
			<td width="60%" align="center" bgColor="#FFFFFF"><b>Ammount</b></td>
		</tr>
		{AFFILIATE_LEVELS_LIST}
		</table>
		<br>
		<input type="submit" value="Change" name="modify">&nbsp;
		<input type="submit" value="Add Level {NEW_AFFILIATE_LEVEL}" name="add">&nbsp;
		<input type="submit" value="Remove Level {MAX_AFFILIATE_LEVEL}" name="remove">
	</td>
</tr>
</form>

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>

</body>
</html>
