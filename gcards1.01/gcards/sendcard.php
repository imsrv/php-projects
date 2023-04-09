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
$cardid = time();
include_once('inc/UIfunctions.php');
include_once('config.php');

if (!$imageid || !$cardtext || !$from_email || !$from_name || !$to_name || !$to_email)
{
	showHeader('Error');
	?>Error!  Form not filled out correctly.  Please go <a href="javascript:history.go(-1);">back</a><?
	showFooter();
	exit;
}

include_once('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb

showHeader();

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$conn = &ADONewConnection('mysql');	# create a connection
$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);

$sqlstmt = "INSERT into sentcards (cardid,imageid,to_name,to_email,from_name,from_email,cardtext,sendonpickup) values ($cardid,$imageid,'$to_name','$to_email','$from_name','$from_email','$cardtext','$sendOnPickup')";
if ($conn->Execute($sqlstmt) === false) {
	print 'error inserting: '.$conn->ErrorMsg().'<BR>';
}

$from = "From: $from_email";
	$counterSQL = "UPDATE cardinfo set senttimes=(senttimes + 1) WHERE imageid=$imageid";
	$conn->Execute($counterSQL);
if (mail($to_email, $subject, $message, $from))
{
	echo "eCard sent...<br><br>";
	showLink('index.php', "Return to $siteName home");

}
else echo "eCard could not be sent...";

showFooter();

?>

