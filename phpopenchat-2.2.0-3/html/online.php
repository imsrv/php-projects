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
if(mysql_num_rows($result)==1){
  Header("HTTP/1.1 200 OK");
  Header("Content-Type: image/gif");
  $fp = fopen( "images/online.gif","r");
  fpassthru($fp);
}else{
  Header("HTTP/1.1 200 OK");
  Header("Content-Type: image/gif");
  $fp = fopen( "images/offline.gif","r");
  fpassthru($fp);
}
fclose($fp);
mysql_close($db_handle);
exit;
?>
