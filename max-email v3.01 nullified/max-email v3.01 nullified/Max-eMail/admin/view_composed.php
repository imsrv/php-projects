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

if(CanPerformAction("edit|compose|$ComposeID")!=1){
	echo "Illegal operation, you are not authorised to do this!";
	exit;
}

$t=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));

if($Version=="HTML"){
	echo '<HTML>
<HEAD>
<TITLE>'.$t[HTML_Subject].'</TITLE>
</HEAD>
	'.ParseFields("NONE",$t[HTML_Version],"").'
</HTML>';
}elseif($Version=="Text"){
echo '<HTML>
		<HEAD>
		<TITLE>'.$t[Text_Subject].'</TITLE>
		</HEAD>
		<BODY bgcolor="#ffffff">
		<font face="courier,verdana" size="2">
		'.ParseFields("NONE",nl2br($t[Text_Version]),"").'
		</BODY></HTML>';
}


?>

