<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Send Broadcast</h3>
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
		<a href="messages.php"><b>Autoresponders</b></a>&nbsp;|
		<a href="newsletters.php">Newsletters</a>&nbsp;|
		<a href="prospects.php">Prospects</a>&nbsp;|
		<a href="account.php">Account</a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="messages_edit.php">Edit Autoresponders</a>&nbsp;|
		<a href="messages_test.php">Test Autoresponders</a>&nbsp;|
		<b>Send Broadcast</b>
	</td>
</tr>

{MESSAGE}

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF">
		<b>Broadcast History:</b>
		<br>{CLEAR_HISTORY}
	</td>
	<td bgColor="white" valign="top">
		<ul style="margin: 0px 0px 0px 20px;">{BROADCAST_HISTORY}</ul>
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF">
		<b>Future Broadcasts: </b>
	</td>
	<td bgColor="white" valign="top">
		<ul style="margin: 0px 0px 0px 20px;">{FUTURE_BROADCASTS}</ul>
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>
