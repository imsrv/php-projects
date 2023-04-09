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

checkUser('admin');

showHeader('eCards Administration Console','../');

include_once('../inc/adodb300/adodb.inc.php');	   # load code common to ADOdb

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$conn = &ADONewConnection('mysql');	# create a connection
$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);

if ($action == 'add')
{
	$addsql = "INSERT INTO cardusers (username, userpass, email, role) VALUES ('$username',password('$userpass'),'$email','$role')";
	if ($conn->Execute($addsql))
		echo "User \"$username\" added to database";
	else
		echo "Error: could not add \"$username\" to database";
}

if ($action == 'delete')
{
	$deletesql = "DELETE from cardusers WHERE userid=$userid";
	if ($conn->Execute($deletesql))
		echo "User deleted from database";
	else
		echo "Error: could not delete user from database";
}

if ($action == 'edit')
{
	if ($userpass) $passUpdate = "userpass = password('$userpass'),";
	$editsql = "UPDATE cardusers SET username='$username', $passUpdate email='$email', role='$role' WHERE userid=$userid";
	if ($conn->Execute($editsql))
		echo "User $username updated successfully";
	else
		echo "Error: could not update user: $username";
}
?>

<table cellspacing="2" cellpadding="2">
	<form action="<? echo $PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="add">
	<tr>
		<td colspan="2" class="bold">Add a new user</td>
	</tr>
	<tr>
		<td>Username:</td>
		<td><input type="text" name="username" size="20"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="Password" name="userpass" size="20"></td>
	</tr>
	<tr>
		<td>Email Address:</td>
		<td><input type="text" name="email" size="30"></td>
	</tr>
	<tr>
		<td>Role:</td>
		<td>
			<select name="role">
				<option value="standard" selected>standard</option>
				<option value="admin">admin</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="Add User"></td>
	</tr>
	</form>
</table>


<?
$sqlstmt = 'select userid, username, email, role from cardusers';
$recordSet = &$conn->Execute("$sqlstmt" );
if (!$recordSet)
	echo "No Users in Database";
else
{
	?>
<br><br>
<table cellspacing="2" cellpadding="2">
	<tr>
		<th>User ID</th><th>Username</th><th>Email Address</th><th>Role</th><th colspan="2">Modify</th>
	</tr>
	<?
			while (!$recordSet->EOF) 
				{
					$userid = $recordSet->fields[userid];
					$username = $recordSet->fields[username];
					$email = $recordSet->fields[email];
					$role = $recordSet->fields[role];					
					
					echo "\n\t<tr>\n\t\t<td>$userid</td><td>$username</td><td>$email</td><td>$role</td><td><a href=\"editUser.php?userid=$userid\">Edit</a></td><td><a href=\"$PHP_SELF?action=delete&userid=$userid\">Delete</a></td>\n\t</tr>";
					$recordSet->MoveNext();
				}
	?>

</table>
	<?
	$recordSet->Close();
}

echo "<br><br>Go back to "; showLink('admin.php','Admin Options');

showFooter();
?>
