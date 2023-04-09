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
include('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
include('config.php');
include('inc/UIfunctions.php');

showHeader();

if (!$cardid)
{
	echo "Error - no card id.";
	showFooter();
	exit;
}

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$conn = &ADONewConnection('mysql');	# create a connection
	$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
	$sqlstmt = "select sentcards.imageid, sentcards.from_name, sentcards.from_email, sentcards.to_name, sentcards.to_email, sentcards.cardtext, cardinfo.imagepath, sentcards.sendonpickup from sentcards, cardinfo where sentcards.imageid=cardinfo.imageid and sentcards.cardid=$cardid";
	
	$recordSet = &$conn->Execute($sqlstmt);
	if (!$recordSet) 
		print $conn->ErrorMsg();
	else
		{
			while (!$recordSet->EOF) 
				{
					$imageid = $recordSet->fields[imageid];
					$from_name = $recordSet->fields[from_name];
					$from_email = $recordSet->fields[from_email];
					$to_name = $recordSet->fields[to_name];
					$to_email = $recordSet->fields[to_email];
					$cardtext = $recordSet->fields[cardtext];
					$imagepath = $recordSet->fields[imagepath];
					$sendOnPickup = $recordSet->fields[sendonpickup];
					$recordSet->MoveNext();
				}
		}
?>

<? include('showcard.php'); 

if ($sendOnPickup == 'send')
{
	$subject = "$to_name picked up your eCard";
	$message = "$to_name picked up your eCard";
	$from = "From: $siteName <$siteEmail>";
	if (mail($from_email, $subject, $message, $from))
	{
		$updateSendOnPickupSQL = "UPDATE sentcards set sendonpickup='sent' where cardid=$cardid";
		$conn->Execute($updateSendOnPickupSQL);
	}
}

showFooter();
?>




