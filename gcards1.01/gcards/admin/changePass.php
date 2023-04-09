<?
/*
 * gCards - a web-based eCard application
 * Copyright (C) 2003 Greg Neustaetter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
session_start();
include_once('loginfunction.php');
include_once('../inc/UIfunctions.php');
include_once('../config.php');

checkUser();

showHeader('eCards Administration Console','../');

if ($oldPass && $newPass1 && $newPass2)
{
	if (!($newPass1 == $newPass2))
	{
		echo "New passwords do not match, please ";
		showLink($PHP_SELF, 'try again');
		showFooter();
		exit;
	}
	include_once('../inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$conn = &ADONewConnection('mysql');	# create a connection
	$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
	$checkOldPassSQL = "SELECT * FROM cardusers WHERE username='$auth_user' AND userpass=password('$oldPass')";
	$checkOldRecordSet = &$conn->Execute($checkOldPassSQL);
	$numResults = $checkOldRecordSet->RecordCount();
	if (!($numResults > 0))
	{
		echo "Old password does not match your current password, please ";
		showLink($PHP_SELF, 'try again');
		showFooter();
		exit;
	}
	$updatePassSQL = "UPDATE cardusers SET userpass=password('$newPass1') where username='$auth_user'";
	if (!($conn->Execute($updatePassSQL)))
	{
		echo "Could not update password, please ";
		showLink($PHP_SELF, 'try again');
		showFooter();
		exit;
	}
	echo "Password updated successfully!";
	showFooter();
	exit;
}
else
{
?>
<table>
	<form action="<? echo $PHP_SELF?>" method="POST">
	<tr>
		<td colspan="2" class="bold">Change Password</td>
	</tr>
	<tr>
		<td>Old Password:</td>
		<td><input type="Password" name="oldPass"></td>
	</tr>
	<tr>
		<td>New Password:</td>
		<td><input type="Password" name="newPass1"></td>		
	</tr>
	<tr>
		<td>Confirm New Password:</td>
		<td><input type="Password" name="newPass2"></td>		
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="Update"></td>
	</tr>
	</form>	
</table>


<?
}


showFooter();

?>
