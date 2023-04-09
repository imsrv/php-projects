<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Mirko Giese                                    **
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

//start session
if($ENABLE_SESSION){
  @session_start();
}

//Check for access permissions of this page
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser doesn't refresh his content
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">
<HTML>
<HEAD>
 <TITLE><? echo $FORUM[title];?></TITLE>
</HEAD>

<BODY>
<?$nickcode=urldecode($nick);
/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}
if($kommentar!="")
{
  $kommentar=htmlspecialchars($kommentar);
  $Vorname=htmlspecialchars($Vorname);
  $email=htmlspecialchars($email);
  $Homepage=htmlspecialchars($Homepage);
  $eintrag=mysql_query("insert into chat_forum ( DATE,NAME, VORNAME, EMAIL,HOMEPAGE,EIGENE_URL,KOMMENTAR,HOST,THEMA) values (now(),'$nickcode', '$Vorname','$email', '$Homepage', '$Path_Dir', '$kommentar','$REMOTE_ADDR','$thema')",$db_handle);
  echo "$FORUM[save_message]<BR>";
}
else
{
  echo "$FORUM[save_message_empty]<BR>";
}
?>

<?echo $FORUM[save_nickname].$nickcode;?><BR>
<? echo $FORUM[save_email];?> <a href="mailto:<?echo $email?>"><? echo $email?></a><BR>
<?echo $FORUM[save_homepage];?> <a href="<?echo $Homepage?>"><?echo $Homepage?></a><BR>
<?echo $FORUM[save_comment];?> <?echo $kommentar?><BR>
<?echo $FORUM[save_topic].$thema?><P><STRONG>
<?
if($ENABLE_SESSION){
  echo "$FORUM[save_next] <a href=\"$INSTALL_DIR/forum/forum.$FILE_EXTENSION?".session_name()."=".session_id()."&amp;thema=$thema\">$FORUM[title]</a> $FORUM[save_read]</STRONG><BR>";
}else{
  echo "$FORUM[save_next] <a href=\"$INSTALL_DIR/forum/forum.$FILE_EXTENSION?nick=$nick&amp;pruef=$pruef&amp;thema=$thema\">$FORUM[title]</a> $FORUM[save_read]</STRONG><BR>";
}
?>
</BODY>
</HTML>
