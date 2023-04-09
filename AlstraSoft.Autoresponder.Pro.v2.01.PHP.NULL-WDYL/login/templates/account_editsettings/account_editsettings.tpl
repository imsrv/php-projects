

<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Edit Settings</h3>
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
		<a href="prospects.php">Prospects</a>&nbsp;|
		<a href="account.php"><b>Account</b></a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<b>Edit&nbsp;Settings</b>&nbsp;|
	    <a href="account_affiliates.php">Affiliates</a>&nbsp;|
		<!--<a href="account_freebonuses.php">Free&nbsp;Bonuses</a>-->
	</td>
</tr>

<form name="form_change_password" action="do_change_password.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Change Your Password:</b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="140"><b>Old password:</b></td>
			<td><input type="password" name="old_password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td width="140"><b>New password:</b></td>
			<td><input type="password" name="password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Confirm password:</b></td>
			<td><input type="password" name="confirm_password" value="" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Change">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<form name="form_change_name" action="do_change_name.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Change Your Name and E-Mail:</b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="140"><b>Your Name:</b></td>
			<td><input type="text" name="name" value="{NAME}" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Your E-Mail:</b></td>
			<td><input type="text" name="email" value="{EMAIL}" size="25"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Change">
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

