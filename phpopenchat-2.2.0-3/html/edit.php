<? /* -*- C -*- */
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

/**
 * Include default values
 */
include ('defaults_inc.php');

//Check for access permissions of this page
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  print ' ';//to prevent an error screen of an empty page
  exit;
}

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ('connect_db_inc.php');
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;//the error message is printed in connect_db_inc.php
}

/**
 * Check, if the nick a moderator
 */
$result=mysql_query("SELECT count(*) AS count FROM vip WHERE Moderator='$nick' AND Channel='$channel'",$db_handle);
if(mysql_result($result,"count") < 1){
  echo ' ';
  exit;
}
@mysql_free_result($result);

include ('write_line_inc.php');
?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
  <head>
    <title>Chatmoderation</title>
    <style type="text/css"><!--
     font {
      font-size: 10px;
     }
-->
    </style>
  </head>
<?
if($checked){
  schreib_zeile($vor_text.htmlspecialchars($text).$nach_text,$channel);
  echo '<BODY bgcolor="#C0C0C0"></BODY></HTML>';
  exit;
}elseif(!$line){
  echo '<BODY  BGCOLOR="#C0C0C0"></BODY></HTML>';
  exit;
}else{
  echo '<body  BGCOLOR="#C0C0C0" text="white" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">';
  
  $tmp=ereg("(.*)<!--(.*)-->(.*</EM>)(.*)(</font>.*)$",$line,$split);


  $spliss=explode("|",$split[2]);
  
  $orig_nick=$spliss[1];
  $spliss[2]=0;
  $spliss[4]=1;//enable the line (the line is now moderated)
  $split[2]=implode("|",$spliss);
  echo "\n<TABLE border=\"0\">\n\t<TR valign=\"top\">\n\t\t<TD align=\"right\"  style=\"font-size:8px;\">";
  echo "\n\t\t\t<FORM ACTION=\"edit.$FILE_EXTENSION\" METHOD=\"POST\">";
  echo "\n\t\t\t\t<STRONG><FONT COLOR=#990000>$orig_nick</FONT></STRONG>".StripSlashes($split[1].$split[3]);
  echo "\n\t\t\t\t<input name=\"vor_text\" type=\"hidden\" value=\"<!-- $split[2]-->".str_replace("<EM>$WISPERS_TO","<EM>$SAYS_TO",str_replace("\"","",stripslashes($split[3])))."\">";

  echo "\n\t\t\t\t<P STYLE=\"margin-top:2px;\"><input type=\"image\" value=\"$ACCEPT_ROW\" SRC=\"images/accept.gif\" ALT=\"$ACCEPT_ROW\" BORDER=\"0\">";
  echo "\n\t\t\t\t<input name=\"checked\" type=\"hidden\" value=\"1\">";
  echo "\n\t\t\t\t<input name=\"".session_name()."\" type=\"hidden\" value=\"".session_id()."\">";
  echo "<A HREF=\"edit.$FILE_EXTENSION\"><IMG SRC=\"images/no_accept.gif\" BORDER=\"0\" ALT=\"$DONT_ACCEPT_ROW\"/></A></P>";
  echo "</TD><TD><TEXTAREA NAME=\"text\" wrap=\"virtual\" rows=2 cols=50>$split[4]</TEXTAREA>";
  echo "\n\t\t\t\t<input name=\"nach_text\" type=\"hidden\" value=\"$split[5]\">";
  echo "\n\t\t\t\t<input name=\"nick\" type=\"hidden\" value=\"$nick\">";
  echo "\n\t\t\t\t<input name=\"pruef\" type=\"hidden\" value=\"$pruef\">";
  echo "\n\t\t\t\t<input name=\"channel\" type=\"hidden\" value=\"$channel\">";
  
  echo "\n\t\t</TD>\n\t";
  echo "\n\t\t\t</FORM>";
  echo "</TR>\n</TABLE>";
}
?>
</body>
</html>
