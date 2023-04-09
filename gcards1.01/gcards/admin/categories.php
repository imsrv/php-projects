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

include_once('../inc/adodb300/adodb.inc.php');	   # load code common to ADOdb

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$conn = &ADONewConnection('mysql');	# create a connection
$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);

if ($action == 'add')
{
	$addsql = "INSERT INTO categories (category) VALUES ('$category')";
	if ($conn->Execute($addsql))
		echo "<br><br>\"$category\" added to database";
	else
		echo "<br><br>Error: could not add \"$category\" to database";
}

if ($action == 'delete')
{
	$deletesql = "DELETE from categories WHERE catid=$catid";
	if ($conn->Execute($deletesql))
		echo "<br><br>\"$category\" deleted from database";
	else
		echo "<br><br>Error: could not delete \"$category\" from database";
}

if ($action == 'edit')
{
	$editsql = "UPDATE categories SET category='$category' WHERE catid=$catid";
	if ($conn->Execute($editsql))
		echo "<br><br>Category name changed successfully";
	else
		echo "<br><br>Error: could not change category name";
}
?>
<br><br>
<table cellspacing="2" cellpadding="2">
	<form action="<? echo $PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="add">
	<tr>
		<td>Add a new category:</td>
		<td><input type="text" name="category" size="20"></td>
		<td><input type="submit" value="Add"></td>
	</tr>
	</form>
</table>


<?
$sqlstmt = 'select category, catid from categories';
$recordSet = &$conn->Execute("$sqlstmt" );
if (!$recordSet)
	echo "No Categories in Database";
else
{
	?>
<br><br>
<table cellspacing="2" cellpadding="2">
	<tr>
		<th>Category ID</th><th>Display Name</th><th colspan="2">Modify</th>
	</tr>
	<?
			while (!$recordSet->EOF) 
				{
					$catid = $recordSet->fields[catid];
					$category = $recordSet->fields[category];
					echo "\n\t<tr>\n\t\t<td>$catid</td><td>$category</td><td><a href=\"editCategory.php?catid=$catid&category=$category\">Edit</a></td><td><a href=\"$PHP_SELF?action=delete&catid=$catid&category=$category\">Delete</a></td>\n\t</tr>";
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
