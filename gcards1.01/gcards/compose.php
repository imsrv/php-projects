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
include('inc/UIfunctions.php');
include_once('config.php');

if (!$imageid)
	{
		showHeader('No card chosen');
		echo 'Card not chosen!  Go <a href="index.php">back</a> to choose a card';
		showFooter();
		exit;
	}
else
	{
		showHeader($siteName,'',1, 1);
		include('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
		include('config.php');
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$conn = &ADONewConnection('mysql');	# create a connection
		$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
		$sqlstmt = "select * from cardinfo where imageid='$imageid'";
		
		
		$recordSet = &$conn->Execute($sqlstmt);
		if (!$recordSet) 
			print $conn->ErrorMsg();
		else
			{
				while (!$recordSet->EOF) 
					{
						$imageid = $recordSet->fields[imageid];
						$cardname = $recordSet->fields[cardname];
						$category = $recordSet->fields[category];
						$imagepath = $recordSet->fields[imagepath];
						$thumbpath = $recordSet->fields[thumbpath];
						$recordSet->MoveNext();
					}
				?>
Add text below to send your eCard!<br><br>
<table align="center" cellpadding="10">
	<form action="preview.php" method="post">
	<input type="hidden" name="imageid" value="<? echo $imageid; ?>">
	<tr>
		<td bgcolor="white" align="center">
			<span class="bold"><? echo $cardname; ?></span><br>
			<img src="images/<? echo rawurlencode($imagepath); ?>" border="0">
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr class="smalltext">
					<td class="smalltext">&nbsp;</td>
					<td class="smalltext">Name</td>
					<td class="smalltext">Email Address</td>
				</tr>
				<tr>
					<td class="bold">From:</td>
					<td><input type="text" name="from_name" value="<? echo $from_name; ?>"></td>
					<td><input type="text" name="from_email" size="30" value="<? echo $from_email; ?>"></td>
				</tr>
				<tr class="smalltext">
					<td class="smalltext">&nbsp;</td>
					<td class="smalltext">Name</td>
					<td class="smalltext">Email Address</td>
				</tr>
				<tr>
					<td class="bold">To:</td>
					<td><input type="text" name="to_name" value="<? echo $to_name; ?>"></td>
					<td><input type="text" name="to_email" size="30" value="<? echo $to_email; ?>"></td>
				</tr>			
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<textarea cols="50" rows="8" name="cardtext" wrap="virtual"><? echo stripslashes($cardtext); ?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" name="sendOnPickup" value="send" <? if ($sendOnPickup == 'send') echo 'checked';?>> Notify me when the card is picked up
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" value="Preview">
		</td>
	</tr>			
	</form>
</table>				
				
				<?
			}
		$recordSet->Close(); # optional
		$conn->Close(); # optional
	

?>

<script language="javascript1.2">
var config = new Object();    // create new config object

config.width = "500";
config.height = "200px";
config.bodyStyle = 'background-color: white; font-family: "Verdana"; font-size: x-small;';
config.debug = 0;

config.toolbar = [
    ['fontname'],
    ['fontsize'],
    ['bold','italic','underline','separator'],
    ['forecolor','separator'],
    ['htmlmode','separator'],
    ['about'],
];


editor_generate('cardtext',config);
</script>
<?
showFooter();
	}
?>
