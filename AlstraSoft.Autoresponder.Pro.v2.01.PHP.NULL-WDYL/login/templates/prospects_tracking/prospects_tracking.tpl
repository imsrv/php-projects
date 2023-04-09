
<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Tracking</h3>
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
		<a href="newsletters.php">Newsletters</a>&nbsp;|
		<a href="prospects.php"><b>Prospects</b></a>&nbsp;|
		<a href="account.php">Account</a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="prospects_active.php">Active Prospects</a>&nbsp;|
		<a href="prospects_mailinglist.php">Mailing List</a>&nbsp;|
		<a href="prospects_removals.php">Removals</a>&nbsp;|
		<a href="prospects_undeliverables.php">Undeliverables</a>&nbsp;|
		<b>Tracking</b>&nbsp;|
		<a href="prospects_variables.php">Variables</a>&nbsp;|
		<a href="prospects_htmlform.php">HTML&nbsp;form</a>
	</td>
</tr>

<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
	</td>
	<td align="left" valign="top" bgColor="white">
		<b>Where Your Prospects Came From:</b>
		<br>
		<br>
		<table width="100%" cellPadding="3" cellSpacing="1" border="0">
		<tr height="20">
			<td width="80%" align="center" bgColor="#FFFFFF"><b>Address</b></td>
			<td width="20%" align="center" bgColor="#FFFFFF"><b>Count</b></td>
		</tr>
		{ADDRESS_LIST}
		</table>
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>
