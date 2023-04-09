<?//-*- C -*-
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

$Zeit=time();
$update=mysql_query("UPDATE chat SET Zeit=$Zeit,Raum='$channel' WHERE Nick='$nick'",$db_handle);

if($reload){
  $update=mysql_query("SELECT count(*) AS count FROM chat_data WHERE Nick = '$nick' AND Passwort = '$SPERRPASSWORT'");
  if(mysql_result($update,0,"count")){
    //User is gekicked
    echo "Sorry, you are kicked!</BODY</HTML>";
    exit;
  }else{
    //User are to long inactive. Reconnect by clicking the 'update text' button in the refresh frame
    
    $update=mysql_query("INSERT INTO chat (Nick,Zeit,Raum,Quassel,Zugang) VALUES ('$nick',$Zeit,'$channel',0,'$channel')",$db_handle);
  }
}
@mysql_Free_Result($update);
?>
