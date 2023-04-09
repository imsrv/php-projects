<?// -*- C++ -*-
/*   ********************************************************************   **
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
* format of the error message, which appears throughout logon
*
* @param mixed $code
* @author Michael Oertel <Michael@ortelius.de>
* @global $nick,$message
* @return string contains the error message
*/

/* 
 * Include some default values
 */
include ('defaults_inc.php');

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ('connect_db_inc.php');
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;//the error message is printed in connect_db_inc.php
}
include ("login_inc.php");
if($password && $password2){ //new registration
	check_register($nick,$password,$password2,$user_email,$db_handle);
  if(!$fehler){
  	//set a cookie
    $Zeit = time();
    SetCookie("PHPOPENCHAT_USER",$nick,time()+10035200);
    $result=mysql_query("DELETE FROM chat WHERE Nick='$nick'",$db_handle);
    $result=mysql_query("DELETE FROM channels WHERE Name='$nick'",$db_handle);
    $result=mysql_query("INSERT INTO chat_data (Nick,Zeit,Raum,Passwort,PictureURL,Email,Online,Host) VALUES ('$nick',$Zeit,'$channel','$password','$pictureURL','$user_email',0,'$REMOTE_ADDR')",$db_handle);
    $result=mysql_query("INSERT INTO chat_mail (TIME,UNREAD,NICK,SENDER,SUBJECT,BODY) VALUES (CURRENT_TIMESTAMP(),1,'$nick','$TEAM_NAME','$WELCOME_SUBJ','<!-- $nick|$TEAM_NAME|2|0|0|-->$WELCOME_MSG')",$db_handle);
    $pruef=Crypt($nick,$salt_nick);
    $successlink = "<a href=\"index.$FILE_EXTENSION\">";
    $success = $REGISTER_SUCCESS_1.$successlink.$REGISTER_SUCCESS_2;
  }
}else{
  
}
include("register_tpl.php");
?>
