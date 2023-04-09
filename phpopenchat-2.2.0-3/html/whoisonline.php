<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

/* 
 * Include some default values
 */
include("defaults_inc.php");

//start session
if($ENABLE_SESSION){
  @session_start();
}

/**
 * Check for access permissions of this page
 *
 * compare the given and the calculated checksum,
 * if they don't match the user has no permissions
 * and the script ends by printing a status header of 204
 * (no content change by client browser)
 */
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK");//browser don't refresh his content
  exit;
}

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}
?>
<HTML>
<HEAD>
<TITLE><?echo $CHATNAME?></TITLE>
<META NAME="distribution" CONTENT="global">
<META NAME="author" CONTENT="Andre Leitenberger; andre.leitenberger@gmx.net">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.text {  font-family: Arial, Helvetica, sans-serif; font-size: 12px;}
-->
</style>
</HEAD>
<BODY BGCOLOR="#FFFFFF" BACKGROUND="<?echo $BG_IMAGE?>" link="#0000FF" vlink="#0000FF" alink="#0000FF" class="text">
<table width="590">
<tr>
<td>
<font face="arial,helvetica,sans-serif" size="5"><b><?echo $WHOISONLINE?></b></font><br><br>
<font face="arial,helvetica,sans-serif" size="2">
<?
$num = mysql_result(mysql_query("SELECT count(*) AS count FROM chat",$db_handle),0,"count");
if ($num>0) {
	if ($num==1){
		echo $WHOISONLINE_NUM_ONE.' ';
	}else{
		echo $WHOISONLINE_NUM_MORE.' ';
	}
	echo '<STRONG>'.$num.'</STRONG> '.$WHOISONLINE_IN_CHAT.'.';
	echo '<HR>';
	echo '<TABLE width="400" border="0" cellspacing="0" cellpadding="0">';
	echo '<TR><TD class="text"><font color="#ff0000">'.$WHOISONLINE_COLOR_RED.'</font> = '.$GODFATHER.'<BR>';
	echo '<font color="#0000ff">'.$WHOISONLINE_COLOR_BLUE.'</font> = '.$MSG_FRIENDS_FRIEND.'</TD></TR>';
	$channelresult = mysql_query("SELECT count(*) as count, Raum FROM chat GROUP BY Raum ORDER BY count desc",$db_handle);
	while($row = mysql_fetch_object($channelresult)){
		$raum = $row->Raum;
		$chatterinroom = mysql_query("SELECT Nick FROM chat WHERE Raum='$raum' ORDER BY Nick");
		echo '<TR><TD width="400" class="text"><br><strong>'.$raum.':</strong></TD></TR><TR><TD width="390" class="text">';
		while($nickrow = mysql_fetch_object($chatterinroom)){
			$shownick=$nickrow->Nick;
			if(mysql_result(mysql_query("SELECT count(*) AS count FROM chat_notify WHERE Nick='$nick' AND Friend='$shownick'",$db_handle),0,"count")){
				$color="#0000ff";
			}else{
				$color="#000000";
			}
			if(mysql_result(mysql_query("SELECT count(*) AS count FROM paten WHERE Nick='$shownick'",$db_handle),0,"count")){
				$color="#ff0000";
			}
			echo '<FONT COLOR="'.$color.'">'.str_replace(" ","&nbsp;",$shownick).' &nbsp; </font>';
		}
		echo '</TD></TR>';
	}
	echo '</TABLE>';
	mysql_close($db_handle);
}
else{
	echo $WHOISONLINE_NUM_MORE.' <STRONG>0</STRONG> '.$WHOISONLINE_IN_CHAT.'.';
}
?>
<BR>
<HR>
<BR>
<FORM>
<DIV ALIGN="CENTER"><INPUT type="button" Value=" <?echo$CLOSE_WINDOW?> " onClick="window.close()"></DIV>
</FORM>
</td>
</tr>
</table>
</BODY>
</HTML>
