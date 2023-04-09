
<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Variables</h3>
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
		<a href="prospects_tracking.php">Tracking</a>&nbsp;|
		<b>Variables</b>&nbsp;|
		<a href="prospects_htmlform.php">HTML&nbsp;form</a>
	</td>
</tr>

<form name="form_add_variable" action="do_add_variable.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Add new predefined variable:</b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="100"><b>Variable Name:</b></td>
			<td><b>[[pre_<input type="text" name="variable_name" value="" size="28">]]</b></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Predefined Value:</b></td>
			<td><input type="text" name="variable_value" value="" size="35"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Add Variable">
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
		Number of predefined variables:
		<b>{VARIABLES_NUMBER}</b>
	</td>
</tr>

<form name="form_variables_list" action="do_on_variables_list.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Variables List:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="0" cellSpacing="1" border="0">
		<tr height="20">
			<td width="7%" align="center" bgColor="#FFFFFF"><input type="checkbox" name="check_all" class="noborder" onClick="CheckAll();"></td>
			<td width="43%" align="center" bgColor="#FFFFFF"><b>Variable Name</b></td>
			<td width="50%" align="center" bgColor="#FFFFFF"><b>Predefined Value</b></td>
		</tr>
		{VARIABLES_LIST}
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
