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
 * online_text.php 
 *
 *  This Script allows users to show their online-status on a HP in a more  
 *  flexible way than online.php does
 *  
 *  Usage:
 *  Somewehere in your Page put
 * 
 * '<script src="http://<<CHAT_SERVER&PATH>>/online_text.php?nick=<<NICK_TO_CHECK>>"></script>'
 * 
 *  then you can check the variable 'chatter_online' if the nick is on the chat
 *
 *  E.G.:
 *  if (chatter_online==1) document.writeln("USERON") else document.writeln("USEROFF");
 */

include "defaults_inc.php";

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

$nick=str_replace("_"," ",$nick);
$result=mysql_query("SELECT Nick FROM chat WHERE Nick='$nick'",$db_handle);
/*
 * If the user is online return 'var chatter_online=1' else 
 * return 'var chatter_online=0'
 */
if(mysql_num_rows($result)==1){
printf("var chatter_online=1;");  
}else{
printf("var chatter_online=0;");
}
mysql_close($db_handle);
exit;
?>
