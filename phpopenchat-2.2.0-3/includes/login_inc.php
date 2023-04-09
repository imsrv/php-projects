<?// -*- C++ -*-
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
* format of the error message, which appears throughout logon
*
* @param mixed $code
* @author Michael Oertel <Michael@ortelius.de>
* @global $nick,$message
* @return string contains the error message
*/
function print_error($code){
  global $message,$nick;
  //if is not $nick set, the user logs itself out. 
  //It is not really necessary because the variable $fehler is set, but how knows?
  $nick="";

  //$message[] are defined in <language>_inc.php (e.g. english_inc.php)
  return "<FONT SIZE=\"3\" COLOR=\"#FF0000\">".$message["error_".$code]."</FONT>";
} // end func print_error


/**
* Check of user are logging in the chat
*
* A user can participate by an input of a E-Mail 
* address without registration. The registration is 
* executed with a specification of both passwords 
* ($password and $password2). With an only unique 
* specification of a password it is verified and 
* it is checked whether the user are registered.
*
* @param string $nick
* @param string $password
* @param string $password2
* @param string $user_email
* @param string $channel
* @param integer $db_handle
* @author Michael Oertel <Michael@ortelius.de>
* @global $fehler,$email,$onlinetime,$ENTRYCHANNELNAME,$CHANNEL_HINT,$WELCOME_MSG,$TEAM_NAME,$salt_nick,$enters,$leaves,$NO_NO_WORDS,$ADDITINAL_LETTERS,$is_moderator,$is_vip,$channickcolor,$day,$time,$LEAVES_US,$LAST_LOGON,$MODERATOR_NAME
* @return string contains the checksum ($pruef)
*/
function check_register($nick,$password,$password2,$user_email,$db_handle){
  global $fehler,$ADDITIONAL_LETTERS,$NO_NO_WORDS,$NICK_NOT_ALLOWED;
  $nick=trim($nick);
  $check=0;
  //if we find other characters than 'a-zA-Z0-9. _äÄöÖüÜßé' or 
  //more than one blanks between letters in var $nick, 
  //an error message will be returned.
  if(!$nick){
    $fehler = print_error("default");
  }
  if(ereg("  ",$nick) || ereg("[^a-zA-Z0-9. $ADDITIONAL_LETTERS]",$nick)){
    $fehler = print_error(6);
  }
  if(eregi($NO_NO_WORDS.$NICK_NOT_ALLOWED,$nick)){
    $fehler = print_error(5);
  }
  if(!$user_email){
    $fehler = print_error(4);
  }
  if($password!=$password2){
  	$fehler = print_error(3);
  }  
  //check if nick occupied
  $result=mysql_query("SELECT count(*) as count FROM chat_data WHERE Nick='$nick'",$db_handle);
  $check+=mysql_result($result,'0'.'count');
  @mysql_free_result($result);

  //check if nick already online
  $result=mysql_query("SELECT Nick FROM chat WHERE Nick='$nick'",$db_handle);
  $check+=mysql_num_rows($result);
  @mysql_free_result($result);
  
  //check if we have a channel name like the given nick name
  $result=mysql_query("SELECT Name FROM channels WHERE Name='$nick' AND User_Channel <> 1",$db_handle);
  $check+=mysql_num_rows($result);
  @mysql_free_result($result);
  if($check>0){
    $fehler = print_error(1);
  }
}
function user_login ($nick,$password,$password2,$channel,$db_handle){

  global $fehler;

  /**
   * contains the error message
   *
   * var $fehler is an error handler, if an error occurred 
   * var $fehler (global var) will be set and an empty string will be returned
   *
   * @var string $fehler
   */ 
  $fehler = "";

  /**
   * user's nickname
   *
   * depends on var $pruef after a successfully login
   *
   * @var string $nick
   */ 
  $nick=trim($nick);
  
  //if we find other characters than 'a-zA-Z0-9. _äÄöÖüÜßé' or 
  //more than one blanks between letters in var $nick, 
  //an error message will be returned.
  global $ADDITIONAL_LETTERS;
  if(ereg("  ",$nick) || ereg("[^a-zA-Z0-9. $ADDITIONAL_LETTERS]",$nick)){
    $fehler = print_error(6);
    return FALSE;
  }

  if(!$nick){
    $fehler = print_error("default");
    return FALSE;
  }
  
  /**
   * Flag determining wheter an error accured 
   * status messages or not (default: 0)
   *
   * @var integer $check
   */
  $check = 0;

  //if we find xxx-words (defined in defaults_inc.php) 
  //an error will be returned
  global $NO_NO_WORDS,$NICK_NOT_ALLOWED;
  if(eregi($NO_NO_WORDS.$NICK_NOT_ALLOWED,$nick)){
    $fehler = print_error(5);
    return FALSE;
  }   
  
  //delete all not active users
  $result=mysql_query("SELECT Nick,Raum FROM chat WHERE Zeit<(UNIX_TIMESTAMP()-(10*60))",$db_handle);
  if(mysql_num_rows($result)>0){
    global $channickcolor,$day,$time,$LEAVES_US;
    while($row=mysql_fetch_object($result)){
      //send message logoff for this user
	  $string =  "<!-- ||0|0|0|--><EM><FONT COLOR=$channickcolor><STRONG>".$row->Nick."</STRONG></FONT><font> $day$time * $LEAVES_US *</font></EM>";
	   schreib_zeile($string,$row->Raum);
	  //give the user a input-refresh to logon again if he wants
	  $string = "<!-- $row->Nick|$MODERATOR_NAME|2|0|0|--><script language=\"JavaScript\">parent.input.document.input.submit();</script>";
	  schreib_zeile($string,$row->Raum);
    }
  }
  @mysql_free_result($result);
  $result=mysql_query("DELETE FROM chat WHERE Zeit<(UNIX_TIMESTAMP()-(10*60))",$db_handle);
  
  //check if nick occupied
  $result=mysql_query("SELECT Online,Email FROM chat_data WHERE Nick='$nick'",$db_handle);
  $check+=mysql_num_rows($result);

  global $email,$onlinetime;
  $a = @mysql_fetch_array($result);
  $email      = $a[Email];
  $onlinetime = $a[Online];
  @mysql_free_result($result);
  
  //check if nick already online
  $result=mysql_query("SELECT Nick FROM chat WHERE Nick='$nick'",$db_handle);
  $check+=mysql_num_rows($result);
  @mysql_free_result($result);
  

  //check if we have a channel name like the given nick name
  $result=mysql_query("SELECT Name FROM channels WHERE Name='$nick' AND User_Channel <> 1",$db_handle);
  $check+=mysql_num_rows($result);
  @mysql_free_result($result);

  global $ENTRYCHANNELNAME;
  $result=mysql_query("SELECT Teilnehmerzahl FROM channels WHERE Name='$ENTRYCHANNELNAME'",$db_handle);
  $max_user     = mysql_result($result,0,"Teilnehmerzahl");
  @mysql_free_result($result);
  
  $result=mysql_query("SELECT count(*) AS count FROM chat WHERE Raum='$ENTRYCHANNELNAME'",$db_handle);
  $current_user = mysql_result($result,0,"count");
  @mysql_free_result($result);
  
  if($check>0 && !$password ){
    $fehler = print_error(1);
    return FALSE;
  //}elseif(!$user_email && !$password){
  //  $fehler = print_error(4);
  //  return "";
  }elseif($check==666){
    $fehler = print_error(5);
    return FALSE;
  }elseif($max_user && $max_user<=$current_user){
    $fehler = print_error(7);
    return FALSE;
  }else{
    
    global $CHANNEL_HINT,$REMOTE_ADDR;
    
    /*
     * Posted variables: $nick, $password, 
	 * if is no password given           -> login without registration
     * if is set $nick, $password                -> login from a registred user
     * if is set $nick, $password and $password2 -> login with registration
     */ 
    if(!$password){

      //set a cookie
      SetCookie("PHPOPENCHAT_USER",$nick,time()+10035200);
      //Login without registration
      $Zeit = time();
      if($channel==$ENTRYCHANNELNAME){
	$result=mysql_query("INSERT INTO chat (Nick,Zeit,Raum,Quassel,GRANT_ACCESS_FOR) VALUES ('$nick',$Zeit,'$channel',0,'$channel')",$db_handle);
      }else{
	$result=mysql_query("INSERT INTO chat (Nick,Zeit,Raum,Quassel,GRANT_ACCESS_FOR) VALUES ('$nick',$Zeit,'$channel',0,'')",$db_handle);
      }

      $result=mysql_query("INSERT INTO channels (Id,Name,PASSWORD,User_Channel,These,Allow,zeile_0) VALUES(0,'$nick','','1','$CHANNEL_HINT <STRONG>$nick</STRONG>.','|$nick|','')",$db_handle);
	  return TRUE;
    }elseif($password && !$password2){

      // Check password
      $result=mysql_query("SELECT Nick FROM chat_data WHERE Nick='$nick' AND Passwort='$password'",$db_handle);
      $rows=@mysql_num_rows($result);
      mysql_free_result($result);
      
      if($rows<=0){
	$fehler = print_error(2);
	return FALSE;
      }else{
	// Login of a registered user

	//set a cookie
	SetCookie("PHPOPENCHAT_USER",$nick,time()+10035200);

	$Zeit=time();
	
	// delete old data of user (may his browser was crashed)
	$logo_result=mysql_query("SELECT PictureURL FROM chat_data WHERE Nick='$nick'",$db_handle);
	if(mysql_num_rows($logo_result)==1){$logo=mysql_result($logo_result,0,"PictureURL");}else{$logo="";}
	mysql_free_result($logo_result);
	$result=mysql_query("DELETE FROM chat WHERE Nick='$nick'",$db_handle);
	@mysql_free_result($result);
	$result=mysql_query("DELETE FROM channels WHERE Name='$nick'",$db_handle);
	@mysql_free_result($result);
	if($channel==$ENTRYCHANNELNAME){
	  $result=mysql_query("INSERT INTO chat (Nick,Zeit,Raum,Quassel,GRANT_ACCESS_FOR) VALUES ('$nick',$Zeit,'$channel',0,'$channel')",$db_handle);
	  @mysql_free_result($result);
	}else{
	  $result=mysql_query("INSERT INTO chat (Nick,Zeit,Raum,Quassel,GRANT_ACCESS_FOR) VALUES ('$nick',$Zeit,'$channel',0,'')",$db_handle);
	  @mysql_free_result($result);
	}
	$result=mysql_query("UPDATE chat_data SET Zeit=$Zeit,Raum='$channel',Host='$REMOTE_ADDR' WHERE Nick='$nick'",$db_handle);
	@mysql_free_result($result);
	if($logo){
	  $result=mysql_query("INSERT INTO channels (Name,PASSWORD,User_Channel,These,Logo,Allow,zeile_0) VALUES('$nick','','1','$CHANNEL_HINT <STRONG>$nick</STRONG>.','$logo','|$nick|','')",$db_handle);
	  @mysql_free_result($result);
	}else{
	  $result=mysql_query("INSERT INTO channels (Name,PASSWORD,User_Channel,These,Allow,zeile_0) VALUES('$nick','','1','$CHANNEL_HINT <STRONG>$nick</STRONG>.','|$nick|','')",$db_handle);
	  @mysql_free_result($result);
	 }
	 return TRUE;
      }
    }
  }

  global $enters,$leaves;
  $enters = 1;
  $leaves = 0;
  
  global $salt_nick;
  return Crypt($nick,$salt_nick);
} // end func user_login

/**
* Check of a login in a protected channel
*
* Every channel can be protected by setting up a password.
* It is checked whether a correct password was indicated, 
* if the given password are correct the user gets access 
* rights for his whole chat-session
*
* @param string $Nick
* @param string $channel
* @param integer $db_handle
* @author Michael Oertel <Michael@ortelius.de>
* @global $channel_login,$pruef,$chanpruef,$UNLOCK_CHANNEL,$PASSWORD,$FILE_EXTENSION,$INSTALL_DIR
* @return string contains the error message
*/
function channel_login ($Nick,$channel,$db_handle){

  //check whether channel are password protected
  $result=mysql_query("SELECT PASSWORD FROM channels WHERE Allow='' AND Name='$channel'",$db_handle);
  if(mysql_num_rows($result)>0){
    $chanpasswort = mysql_result($result,0,"PASSWORD");}
  else{
    $chanpasswort = "";
  }
  mysql_free_result($result);
  global $channel_login;//is posted by the channel login form
  if($chanpasswort&&($channel_login!=$chanpasswort)){
    // channel is password protected and no password or a wrong 
    // password are given 

    // check whether the user already received rights of access
    $result=mysql_query("SELECT GRANT_ACCESS_FOR FROM chat WHERE Nick='$Nick' AND GRANT_ACCESS_FOR LIKE '%|$channel|%'",$db_handle);
    if(mysql_num_rows($result)==0){

      // the user has still no rights of access, he must input 
      // here the correct password -> show password input form
      global $pruef,$chanpruef,$UNLOCK_CHANNEL,$PASSWORD,$FILE_EXTENSION,$INSTALL_DIR;

      return '<p align="center"><form action="getlines.'.$FILE_EXTENSION.'" target="getlines" method="post"><input type="hidden" name="channel" value="'.$channel.'"><font color="#FFFFFF">'.$PASSWORD.':<\/font><input name="channel_login" type="password"><input name="Nick" type="hidden" value="'.$Nick.'"><input name="pruef" type="hidden" value="'.$pruef.'"><input name="channel" type="hidden" value="'.$channel.'"><input name="chanpruef" type="hidden" value="'.$chanpruef.'"><input name="form" type="hidden" value="1"><input name="chanchange" type="hidden" value="1"><input name="init" type="hidden" value="1"><input name="'.session_name().'" type="hidden" value="'.session_id().'"><font color="#000000"><input type="submit" value="'.$UNLOCK_CHANNEL.'!"><\/font><\/form><\/p>';
    }
    mysql_free_result($result);
  }
  
  // if the posted password ($channel_login) are 
  // correct -> the user gets access rights for this channel
  if($chanpasswort&&($channel_login==$chanpasswort)){
    $result=mysql_query("UPDATE chat SET GRANT_ACCESS_FOR=CONCAT(GRANT_ACCESS_FOR,'|$channel|') WHERE Nick='$Nick'",$db_handle);
  }

  return "";
}// end func channel_login
?>
