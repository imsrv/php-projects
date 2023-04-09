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
$client=1;
include "config.inc.php";

$link=mysql_fetch_array($l=mysql_query("SELECT * FROM links WHERE LinkID='$LinkID'"));

if(mysql_num_rows($l)!=1){
	echo "Invalid link";
}else{
	//record the info!
	$IP=$REMOTE_ADDR;
	$TraceBy=$link[TraceBy];
	mysql_query("INSERT INTO link_clicks SET TimeStamp='".time()."', IPAddress='$IP', LinkID='$LinkID', TraceCode='$TraceCode', TracedBy='$TraceBy'");
	header("Location: ".$link[Link]);
}




?>