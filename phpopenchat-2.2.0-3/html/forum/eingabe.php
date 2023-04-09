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
if($nick && !check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser doesn't refresh his content
  mysql_close($db_handle);
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">
<HTML>
<HEAD>
 <TITLE><?echo$FORUM[title]?></TITLE>
</HEAD>
<?$nickcode=urlencode($nick);?>
<BODY BACKGROUND="<?echo$BACKGROUNDIMAGE?>" bgcolor="#FFFFFF"><center>
<H1><?echo $FORUM[write_header];?></H1>
<? echo $FORUM[wrote_topic].$thema?> 
<FORM ACTION="eintrag.<?=$FILE_EXTENSION?>" METHOD="POST">
  <TABLE>
   <TR><TD></td><TH> <?echo $FORUM[save_nickname];?></th><TH><?echo $FORUM[save_email];?></th><TH><? echo $FORUM[save_homepage];?></th></tr>
   <TR><TD>&nbsp;</td><TH> 
    <?echo $nick?></td><TD><INPUT TYPE="text" NAME="email"></td><TD><INPUT TYPE="text" NAME="Homepage"></td></tr>
  </TABLE>
  <BR><?echo $FORUM[write_comment];?><BR>
  <BR><TEXTAREA NAME="kommentar" COLS=50 ROWS=10 wrap=virtual></TEXTAREA><BR>
  <input type="hidden" name=thema value="<?echo $thema?>">
  <INPUT TYPE=submit VALUE="<? echo $FORUM[write_submit];?>">
<?
if($ENABLE_SESSION){
  echo '<INPUT TYPE="hidden" NAME="'.session_name().'" VALUE="'.session_id().'">';
}else{
  echo '<INPUT TYPE="hidden" NAME="nick" VALUE="'.$nick.'">
        <INPUT TYPE="hidden" NAME="pruef" VALUE="'.$pruef.'">';
}
?>
</FORM>
</center>
</BODY>
</HTML>
