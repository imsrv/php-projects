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
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser don't refresh his content
  exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">
<HTML>
<HEAD>
 <TITLE>Chat-Forum</TITLE>
</HEAD>
<frameset cols="30%,*" border="0" frameborder="0" framespacing="0">
<?
if($ENABLE_SESSION){
  echo'<frame src="links.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'" name="links">
       <frame src="rechts.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'" name="rechts">';
}else{
  echo"<frame src=\"links.$FILE_EXTENSION?nick=$nick&amp;pruef=$pruef\" name=\"links\">
       <frame src=\"rechts.$FILE_EXTENSION?nick=$nick&amp;pruef=$pruef\" name=\"rechts\">";
}
?>
</frameset>
<BODY BGCOLOR="#FFDEAD">
<H1>Blackboard</H1>
Leider unterstuetzt Dein Browser keine Frames. Dadurch kannst Du keine Foren sehen.<BR> 
zurueck zum <A HREF="<?echo $CHATSERVERNAME,$INSTALL_DIR?>">Chat</A>.
</BODY>
</HTML>
