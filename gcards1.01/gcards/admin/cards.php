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

if ($action == 'delete')
{
	$cardInfoSQL = "SELECT * FROM cardinfo WHERE imageid=$imageid";
	$deleteInfo = $conn->GetRow($cardInfoSQL);
	$deleteimagepath = "../images/".$deleteInfo[imagepath];
	$deletethumbpath = "../images/".$deleteInfo[thumbpath];
	$deletesql = "DELETE from cardinfo WHERE imageid=$imageid";
	if ($conn->Execute($deletesql))
		{
			echo "Card deleted from database...";
			if (unlink($deleteimagepath))
				echo "<br>Image deleted from server...";
			else
				echo "<br>Could not delete image ($deleteimagepath) from server...";
			if (unlink($deletethumbpath))
				echo "<br>Thumbnail deleted from server...";
			else
				echo "<br>Could not delete thumbnail ($deletethumbpath) from server...";
				
		}
	else
		echo "<br><br>Error: Card could not be deleted from database"; 
}

if ($action == 'edit')
{
	$editsql = "UPDATE cardinfo set cardname='$cardname', catid=$catid WHERE imageid=$imageid";
	if ($conn->Execute($editsql))
		echo "<br><br>Card information updated";
	else
		echo "<br><br>Error: Card could not be updated";
}



$sqlstmt = 'select category, catid from categories';
$recordSet = &$conn->Execute("$sqlstmt" );
?>

<table width="100%">
	<tr>
		<td align="left" valign="top" width="200">
			<? include('../inc/getcategories.php');  // show the eCard Categories ?>
		</td>
		<td>
		
<table>
	<tr>
		<td colspan="2" class="bold">Add a new eCard</th>
	</tr>
	<form enctype="multipart/form-data" action="upload.php" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="<? echo ($maxFileSize * 1000);?>">
	<tr>
		<td>Card Name:</td>
		<td><input type="text" name="cardname"></td>
	</tr>
	<tr>
		<td>Cateogry:</td>
		<td><? print $recordSet->GetMenu2('catid', "$catSearch"); ?></td>
	</tr>
	<tr>
		<td>Upload file:</td>
		<td><input type="file" name="userfile"></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="Upload!"><br><br></td>
	</tr>
	</form>
</table>

<?
horizontalLine();

if (!$catSearch) $cardsql = "SELECT cardinfo.imageid, cardinfo.cardname, categories.category, cardinfo.imagepath, cardinfo.thumbpath, cardinfo.senttimes from cardinfo, categories WHERE cardinfo.catid=categories.catid order by cardinfo.imageid";
else $cardsql = "SELECT cardinfo.imageid, cardinfo.cardname, categories.category, cardinfo.imagepath, cardinfo.thumbpath, cardinfo.senttimes from cardinfo, categories WHERE cardinfo.catid=categories.catid AND cardinfo.catid=$catSearch order by cardinfo.imageid";
$cardRecordSet = &$conn->Execute("$cardsql" );
if (!$cardRecordSet)
		echo "No eCards in Database";
else
{
	?>
<br>
<table cellspacing="2" cellpadding="2">
	<tr>
		<th>Card ID</th><th>Card Name</th><th>Category</th><th>Image Name</th><th>Thumbnail Name</th><th>Times Sent</th><th colspan="2">Modify</th>
	</tr>
	<?
while (!$cardRecordSet->EOF) 
			{
				$imageid = $cardRecordSet->fields[imageid];
				$cardname = $cardRecordSet->fields[cardname];
				$category = $cardRecordSet->fields[category];
				$imagepath = $cardRecordSet->fields[imagepath];
				$thumbpath = $cardRecordSet->fields[thumbpath];
				$senttimes = $cardRecordSet->fields[senttimes];
				echo "\n\t<tr>\n\t\t<td>$imageid</td><td>$cardname</td><td>$category</td><td>$imagepath</td><td>$thumbpath</td><td>$senttimes</td><td><a href=\"editCard.php?imageid=$imageid\">Edit</a></td><td><a href=\"$PHP_SELF?imageid=$imageid&action=delete\">Delete</a></td>\n\t</tr>";
				$cardRecordSet->MoveNext();
			}
?>

</table>
</td>
	</tr>
</table>
<?
}


echo "<br><br>Go back to "; showLink('admin.php','Admin Options');
showFooter();
?>
