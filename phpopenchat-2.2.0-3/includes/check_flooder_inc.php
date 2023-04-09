<?//-*-C++-*-
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
* Check for flooder
*
* @param string $sag
* @param string $nick
* @author Mirko Giese  <giese@foreach.de>
* @global string last_sag; sag_count
* @return sleep_time
* this function checks, if a flooding-programm is in use or if the user tries 
* to repaet his message over and over again. if, lets deactivate
*/


if($last_sag==$chat && $chat!=""){
  $sag_count++;
  if($sag_count>3){
	$sag_count=4;
  }
  switch($sag_count){
    case 1: //first repeat of text, only let him wait 2 seconds
	  $sleep_time = "2";
	  break;
	case 2: //he still try it. give him a message and wait 4 seconds
	  $sleep_time= "4";
	  $zeile = '<!-- '.$nick.'|'.$MODERATOR_NAME.':|2|0|0|--> <i>'.$day.$time.
	   '</i> '.$FLOODING_MSG1;
	   $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$nick'",$db_handle),0,"Raum");
	   schreib_zeile($zeile,$channel);
	  break;
	case 3: //stupid. but i give him a last chance
	  $sleep_time = "10";
	  $zeile = '<!-- '.$nick.'|'.$MODERATOR_NAME.':|2|0|0|--> <i>'.$day.$time.
	   '</i> '.$FLOODING_MSG2;
	   $chat ="";
	   $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$nick'",$db_handle),0,"Raum");
	   schreib_zeile($zeile,$channel);
	   break;
	case 4 :// kick him. he is stupid or a bot
		$chat = "";
		header("Status: 204 OK\r\n");
		$result=mysql_query("SELECT count(*) AS count FROM paten WHERE Nick = '$nick'",$db_handle);
	    $patencheck=mysql_result($result,0,"count");
    	if($patencheck==0){
			$result=mysql_query("UPDATE chat SET User_busy=2 WHERE Nick='$nick'",$db_handle);
	        $result=mysql_query("UPDATE chat_data SET Passwort='$SPERRPASSWORT' WHERE Nick='$nick'",$db_handle);
	        $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$nick'",$db_handle),0,"Raum");
	        schreib_zeile("<!-- ||0|0|0|--><b><font color=#88EFEF>$MODERATOR_NAME:</font></b> <STRONG>$nick</STRONG> <EM>$KICKED</EM>!",$channel);

		}
	default:
		break;
		
		
  }

}else{
	$sag_count="0";
	$sleep_time = "";
} 
if($sag_count<3){
	$last_sag=$chat;
}
session_register("last_sag");
session_register("sag_count");
if($sleep_time){
	sleep($sleep_time);
}

?>
