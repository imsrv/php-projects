
<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Mailing List</h3>
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
		<b>Mailing List</b>&nbsp;|
		<a href="prospects_removals.php">Removals</a>&nbsp;|
		<a href="prospects_undeliverables.php">Undeliverables</a>&nbsp;|
		<a href="prospects_tracking.php">Tracking</a>&nbsp;|
		<a href="prospects_variables.php">Variables</a>&nbsp;|
		<a href="prospects_htmlform.php">HTML&nbsp;form</a>
	</td>
</tr>

<form name="form_search_prospect" action="prospects_mailinglist.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Search for a prospect:</b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="100"><b>Date Range:</b></td>
			<td>
				<input type="text" name="mm_start" value="" size="2" maxlength="2"> /
				<input type="text" name="dd_start" value="" size="2" maxlength="2"> /
				<input type="text" name="yyyy_start" value="" size="4" maxlength="4"> to

				<input type="text" name="mm_end" value="" size="2" maxlength="2"> /
				<input type="text" name="dd_end" value="" size="2" maxlength="2"> /
				<input type="text" name="yyyy_end" value="" size="4" maxlength="4"> 
			</td>
		</tr>
		<tr><td></td><td height="20" valign="bottom">(date must be in MM/DD/YYYY format)</td></tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td width="100"><b>Name:</b></td>
			<td><input type="text" name="subscriber_name" value="" size="35"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>E-mail:</b></td>
			<td><input type="text" name="subscriber_email" value="" size="35"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Search!">
				{SHOW_ENTIRE_LIST}
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
	</td>
	<td align="left" valign="top" bgColor="white">
		Number of prospects:
		<b>{SUBSCRIBERS_NUMBER}</b>
	</td>
</tr>

<form name="form_mailing_list" action="do_on_mailing_list.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Mailing List:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="0" cellSpacing="1" border="0">
		<tr height="20">
			<td width="7%" align="center" bgColor="#FFFFFF"><input type="checkbox" name="check_all" class="noborder" onClick="CheckAll();"></td>
			<td width="33%" align="center" bgColor="#FFFFFF"><b>Name</b></td>
			<td width="30%" align="center" bgColor="#FFFFFF"><b>E-mail</b></td>
			<td width="20%" align="center" bgColor="#FFFFFF"><b>Date</b></td>
			<td width="10%" align="center" bgColor="#FFFFFF"><b>Status</b></td>
		</tr>
		{SUBSCRIBER_LIST}
		{LIST_MENU}
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
