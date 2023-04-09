<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
include "../config.inc.php";


$FULL_OUTPUT.=MakeBox("Installation Information", 'Welcome to Max-eMail.<!--CyKuH [WTN]-->');

if($QuickMsg=="all" || $QuickMsg=="group"){
	$FULL_OUTPUT.=MakeBox("Admin Messages", 'You have '.mysql_num_rows(mysql_query("SELECT * FROM admin_messages WHERE ToAdminID='$AdminID' && Received='0'")).' new messages!<P>'.MakeLink("admin_messages.php?action=readnew", "Read New").' | '.MakeLink("admin_messages.php?", "Read All").' | '.MakeLink("admin_account.php", "Send Message"));
}


include "admin.inc.php";

?>