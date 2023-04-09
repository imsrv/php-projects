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

/**
* Create a database connection
*
* Tries to connect to database and print out an error if that fails. 
* In case of success a data base handle is returned.
*
* @author Michael Oertel <Michael@ortelius.de>
* @global $FEHLER,$BACKGROUNDIMAGE,$CHAT_OVERLOAD,$FILE_EXTENSION,$REPEAT_LOGIN,$INSTALL_DIR
* @return string contains the database handle
*/
function connect_db ($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD){
  global $FEHLER,$BACKGROUNDIMAGE;
  $noconnectmsg  = "<HTML><HEAD><TITLE>$FEHLER</TITLE></HEAD><BODY BGCOLOR=\"#FFFFFF\" BACKGROUND=\"$BACKGROUNDIMAGE\"><BR>";
  $noconnectmsg .= "<DIV STYLE=\"color:#f00\">$FEHLER:</DIV>&nbsp;";
  $noconnect     = 0;
  $dbh           = @mysql_connect($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
  
  // tries to connect to database five times
  while (!$dbh && $noconnect<5){
    $noconnect++;
    Sleep(2);
    $dbh = @mysql_connect($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
    if($debug){
      echo "$noconnect. connection try.<BR>";
    }
    if($noconnect>4){
      global $CHAT_OVERLOAD,$FILE_EXTENSION,$REPEAT_LOGIN,$INSTALL_DIR;
      echo $noconnectmsg,"$CHAT_OVERLOAD <A HREF=\"/frame_set.$FILE_EXTENSION\" TARGET=\"_top\">$REPEAT_LOGIN</A>.";
      echo "<P><A HREF=\"/$INSTALL_DIR\">Chat-HomePage</A></BODY></HTML>";
	  @mail($TEAM_MAIL_ADDR,$ERRORMAIL_SUBJECT,$ERRORMAIL_BODY,'FROM: phpOpenChat');
      return -1;
    }
  }
  
  global $DATABASENAME;
  if(!mysql_select_db($DATABASENAME,$dbh)){
    echo $noconnectmsg,"Can't find database '$DATABASENAME'";
    global $INSTALL_DIR;
    echo "<P><A HREF=\"/$INSTALL_DIR\">Chat-HomePage</A></BODY></HTML>";
    @mysql_close($db_handle);
    return -1;
  }

  return $dbh;
}
?>
