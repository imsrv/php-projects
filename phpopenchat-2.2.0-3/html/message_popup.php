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

include "defaults_inc.php";

//Check for access permissions of this page
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser don't refresh his content
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
  <head>
    <title>Chat-<?echo $MESSAGES?></title>
  </head>

  <body onLoad="window.focus()" bgcolor="#284628" text="#66B886" link="#88dede" vlink="#88dede">
      <FONT color="#CCFF33"><h2 align=center>Chat-<?echo $MESSAGES?></h2></FONT>
<?
/*
 * Open a database connection
 * The following include 'returns' a database identifyer '$db_handle'
 * for some database querys.
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}

$result=mysql_query("SELECT SENDER,BODY,TIME FROM chat_mail WHERE Nick='$nick' && UNREAD=1",$db_handle);
if(mysql_num_rows($result)>0){
  $nickcode = urlencode($nick);
  echo "<FORM>";
  while($row=mysql_fetch_object($result)){
    //format chat line
    echo "<P STYLE=\"margin-bottom:4px;margin-top:0px;\"><b><font color=\"#88EFEF\">".$row->SENDER."</font></b> [".$row->TIME."]: ".$row->BODY."<BR />";
    if($row->SENDER!=$MODERATOR_NAME){
      echo "\n<INPUT style=\"margin-top:4px;\" type=\"button\" Value=\" $REPLY_TO ".$row->SENDER." \" 
          onClick=\"window.open('chat_mail.$FILE_EXTENSION?nick=$nickcode&pruef=$pruef&adr=".urlencode($row->SENDER)."','','scrollbars=yes,directories=no,width=640,height=480')\">";
    }
    echo "\n</P>";
  }
  echo "</FORM>";
}
mysql_free_result($result);
mysql_close($db_handle);
?>
<HR>

<FORM><INPUT type="button" Value=" <?echo $CLOSE_WINDOW?> " onClick="window.close()"></FORM>
</FONT>
  </body>
</html>
