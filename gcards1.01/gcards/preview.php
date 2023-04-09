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
include_once('inc/formFunctions.php');
include_once('inc/UIfunctions.php');
include_once('config.php');

if (!filledPost($HTTP_POST_VARS))
{
	showHeader();
	?>Please fill in all values of the form!  Go <a href="javascript:history.go(-1);">back</a><?
	showFooter();
	exit;
}

if (!validEmail($to_email))
{
	showHeader();
	?>Please enter a valid email address!  Go <a href="javascript:history.go(-1);">back</a><?
	showFooter();
	exit;
}
session_start();
if (!(session_is_registered('imageid'))) session_register('imageid');
if (!(session_is_registered('to_name'))) session_register('to_name');
if (!(session_is_registered('from_name'))) session_register('from_name');
if (!(session_is_registered('to_email'))) session_register('to_email');
if (!(session_is_registered('from_email'))) session_register('from_email');
if (!(session_is_registered('cardtext'))) session_register('cardtext');
if (!(session_is_registered('sendOnPickup'))) session_register('sendOnPickup');

$imageid = $HTTP_POST_VARS['imageid'];
$to_name = $HTTP_POST_VARS['to_name'];
$from_name = $HTTP_POST_VARS['from_name'];
$to_email = $HTTP_POST_VARS['to_email'];
$from_email = $HTTP_POST_VARS['from_email'];
$cardtext = $HTTP_POST_VARS['cardtext'];
$sendOnPickup = $HTTP_POST_VARS['sendOnPickup'];

showHeader();

if (!($sendOnPickup == 'send')) $sendOnPickup = 'no';

include('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb


$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$conn = &ADONewConnection('mysql');	# create a connection
	$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
	$sqlstmt = "select imagepath from cardinfo where imageid='$imageid'";
	$recordSet = &$conn->Execute($sqlstmt);
	if (!$recordSet) 
		print $conn->ErrorMsg();
	else
		{
			while (!$recordSet->EOF) 
				{
					$imagepath = $recordSet->fields[imagepath];
					$recordSet->MoveNext();
				}
		}

include('showcard.php'); 

?>
<br><br>
<div align="center">
<a href="compose.php">Back</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sendcard.php">Send</a>
</div>


<?
showFooter();
?>

