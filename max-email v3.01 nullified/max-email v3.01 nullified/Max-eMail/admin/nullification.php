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
GLOBAL $FULL_OUTPUT;
	$BO.='<TABLE width="100%">';
        $BO.='<TR><TD><font face="Arial" size="2">Program Name</TD><TD><font face="Arial" size="2">: Max-eMail Elite</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Release Version</TD><TD><font face="Arial" size="2">: 3.01</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Program Author</TD><TD><font face="Arial" size="2">: SiteOptions Corp.</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Home Page</TD><TD><font face="Arial" size="2">: http://www.siteoptions.com</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Supplied by</TD><TD><font face="Arial" size="2">: WTN Team</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Nullified by</TD><TD><font face="Arial" size="2">: WTN Team</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Packaged by</TD><TD><font face="Arial" size="2">: WTN Team</TD></tr>';
        $BO.='<TR><TD><font face="Arial" size="2">Distribution</TD><TD><font face="Arial" size="2">: via WebForum, ForumRU and associated file dumps</TD></tr>';
	$BO.='</table>';
	$FULL_OUTPUT.=MakeBox("Nullification INFO", $BO);
	//now the add admin group box!

FinishOutput();
?>

