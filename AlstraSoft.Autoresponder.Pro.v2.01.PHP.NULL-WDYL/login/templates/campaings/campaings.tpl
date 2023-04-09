<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Campaigns</h3>
	</td>
	<td align="middle" align="right" width="30%">
		User logged in: <br><b>{USER_NAME}</b>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa">

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="controlpanel.php">Home</a>&nbsp;|
		<b>Campaigns</b>&nbsp;|		
		<a href="messages.php">Autoresponders</a>&nbsp;|
		<a href="newsletters.php">Newsletters</a>&nbsp;|
		<a href="prospects.php">Prospects</a>&nbsp;|
		<a href="account.php">Account</a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>

<form name="form" action="do_add_campaign.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="2" bgColor="white">
		<b>All your campaigns: </b><br><br>
	
	</td>
	<td bgColor="white" valign="top">
		<table cellSpacing="1" bgColor="#aaaaaa">
		<tr align="center">
			<td bgColor="#FFFFFF" width="200">
			Campaign
			</td>
			<td bgColor="#FFFFFF" width="100">
			Action
			</td>
			<td bgColor="#FFFFFF" width="100">
			Login
			</td>
		</tr>
		{CAMPAIGNS_LIST}
		</table>
		
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="white">
	Add new campaign: 
			<input name="name" type="text" id="name" {dis}>
			<input type="submit" name="Submit" value="Submit" {dis}><br>
			{why}

	</td>
</tr>
</form>




<tr>
	<td align="left" valign="top" bgColor="white" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>

