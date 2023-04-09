<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Test Newsletters</h3>
	</td>
	<td align="middle" align="right" width="30%">
		User logged in: <br><b>{USER_NAME}</b>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa" >

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="controlpanel.php">Home</a>&nbsp;|
		<a href="campaigns.php">Campaigns</a>&nbsp;|		
		<a href="messages.php">Autoresponders</a>&nbsp;|
		<a href="newletters.php"><b>Newsletters</b></a>&nbsp;|
		<a href="prospects.php">Prospects</a>&nbsp;|
		<a href="account.php">Account</a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="newsletters_edit.php">Edit Newsletters</a>&nbsp;|
		<b>Test Newsletters</b>&nbsp;|
		<a href="newsletters_broadcast.php">Send Broadcast</a>
	</td>
</tr>

<form name="form_messages_test" action="do_test_messages.php" method="post">
<input type="hidden" name="test_newsletters" value="1">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		
	</td>
	<td bgColor="white" valign="top">
		You may test functionality of your AutoResponder without having to wait several days before all of your follow ups arrive.<br><br>
		Put your e-mail address in the field below and press Test button.<br><br>
		Our system will deliver all of your autoresponses instantly, regardless of time intervals.<br><br>
		<br>
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="30%"><b>Your e-mail:</b></td>
			<td><input type="text" name="email" value="" size="35"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Chose newsletter:</b></td>
			<td>
				<select name="message_id" width="300">
					<option value="">-- all newsletters --</option>
					{MESSAGE_LIST}
				</select>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Send test newsletter!">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>
