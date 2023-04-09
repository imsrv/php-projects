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
function randomint($max) { 
    static $startseed = 0; 
    if (!$startseed) {
        $startseed = (double)microtime()*getrandmax(); 
        srand($startseed);
    } 
    return (rand()%$max);
} 

/* 
 * Include some default values
 */
include("defaults_inc.php");
Error_Reporting(7);

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if($db_handle<1){
  exit;
}
include ("channels_inc.php");
if($HTTP_POST_VARS["nick"]){
  if($ENABLE_SESSION){@session_destroy();}
	include("write_line_inc.php");
	include ("login_inc.php");
	$return = user_login($HTTP_POST_VARS["nick"],$HTTP_POST_VARS["password"],"",$HTTP_POST_VARS["entry"],$db_handle);
	if($return== TRUE){
		if($ENABLE_SESSION){
			$nick = $HTTP_POST_VARS["nick"];
			$pruef=Crypt($nick,$salt_nick);
			$entry=$HTTP_POST_VARS["entry"];
      $ii=0;
      session_register('pruef','nick','entry','vip','moderator','is_vip','is_como','is_moderator_for','ii','lastRow','BROWSER_NAME','salt_nick');
      header('Status: 301');
      header("Location: frame_set.".$FILE_EXTENSION."?".session_name()."=".session_id());
			exit;
		}else{
			$nick = $HTTP_POST_VARS["nick"];
			$pruef=Crypt($nick,$salt_nick);
			$entry=$HTTP_POST_VARS["entry"];
      header('Status: 301');
			header("Location: frame_set.".$FILE_EXTENSION."?nick=".urlencode($nick)."&pruef=".urlencode($pruef)."&entry=".urlencode($entry));
			exit;
		}
	}
}


$REMOTE_USER=strip_tags($PHPOPENCHAT_USER);//cookie        
if($PHPOPENCHAT_USER){
	$date = date("H");
	if ($date >= 5) {  $gruss = $GREETINGS[1]; }
	if ($date >= 12) { $gruss = $GREETINGS[2]; }
	if ($date >= 14) { $gruss = $GREETINGS[3]; }
	if ($date >= 18) { $gruss = $GREETINGS[4]; }
	if ($date >= 22) { $gruss = $GREETINGS[5]; }
	switch (randomint(3)) {
	  case 0:
	    $hello_message = $COME_IN;
	    break;
	  case 1:
	    $hello_message =  $TELL_US;
	    break;
	  case 2:
	    $hello_message =  $WHATS_UP;
	    break;
	  default:
	    $hello_message =  $CHAT_WITH_US;
	  }
	}else{
	  $entrylink = "<H1><A HREF=\"frame_set.$FILE_EXTENSION\" TARGET=_top>$I_WANT_TO_CHAT!</A></H1>";
        }
        $num_reg_chatters = mysql_result(mysql_query("SELECT count(Nick) AS count FROM chat_data",$db_handle),0,"count");

/** Loesche alle Teilnehmer aus der Tabelle der Telnehmer, die 10 Minuten nix gesagt haben  **/
    	$result=mysql_query("DELETE FROM chat WHERE Zeit<(UNIX_TIMESTAMP()-(10*60))",$db_handle);
        $num=mysql_result(mysql_query("SELECT count(*) AS count FROM chat",$db_handle),0,"count");
  	if ($num>0) {
		$online_users  = '<STRONG>'.$num.'</STRONG>';
		$online_table  = '<P ALIGN=CENTER>';
		$online_table .= '<TABLE BORDER=0 WIDTH=100%>';
		$online_table .= '<TR><TH BGCOLOR="#AAAAAA">'.$NICK_NAME.'</TH><TH BGCOLOR="#AAAAAA">'.$CHANNEL.'</TH>';
		$online_table .= '<TH BGCOLOR="#AAAAAA">'.$NICK_NAME.'</TH><TH BGCOLOR="#AAAAAA">'.$CHANNEL.'</TH>';
		$online_table .= '<TH BGCOLOR="#AAAAAA">'.$NICK_NAME.'</TH><TH BGCOLOR="#AAAAAA">'.$CHANNEL.'</TH>';
		$online_table .= '<TH BGCOLOR="#AAAAAA">'.$NICK_NAME.'</TH><TH BGCOLOR="#AAAAAA">'.$CHANNEL.'</TH>';
		$raumresult=mysql_query("SELECT DISTINCT Raum FROM chat ORDER BY Raum",$db_handle);
		$i=0;
		$smileydir="images/chatter/";
		while($row=mysql_fetch_object($raumresult)){
	  		$raum=$row->Raum;
	  		$result=mysql_query("SELECT Nick FROM chat WHERE Raum='$raum' ORDER BY Nick");
	  		while($nickrow=mysql_fetch_object($result)){
				if($i % 4 ==0){$online_table .= "</TR>\n<TR>";}
				$online_table .= '<TD BGCOLOR="#a0FFa0">';
				$nick=$nickrow->Nick;
				if(file_exists($smileydir.strtolower(str_replace(" ","_",$nick)).".gif")){
					$online_table .= "<IMG WIDTH=16 HIGHT=16 SRC=\"".$smileydir.strtolower(str_replace("%20","_",str_replace("+","_",urlencode($nick)))).".gif\">";
				}else{
					$online_table .= "<IMG WIDTH=16 HIGHT=1 SRC=\"images/dot_clear.gif\">";
				}
				if(mysql_result(mysql_query("SELECT count(*) AS count FROM paten WHERE Nick='$nick'",$db_handle),0,"count")){$color="#ff0000";}else{$color="#000000";}
        if($PHPOPENCHAT_USER && mysql_result(mysql_query("SELECT count(*) AS count FROM chat_notify WHERE Nick='$PHPOPENCHAT_USER' AND Friend='$nick'",$db_handle),0,"count")){
          $color="#0000ff";
        }
				$online_table .= '&nbsp;<FONT COLOR="'.$color.'">'.str_replace(" ","&nbsp;",$nick).'</FONT></td><TD BGCOLOR="#FFFFa0">'.$raum.'</td>';
	        		$i++;
	  		}
		}
        	if($i % 4 != 0){
			echo '</tr>';
		}
		$online_table .= '</TABLE>';
  	}else{
      $online_users = '<STRONG>0</STRONG>';
      $online_table = '';
  	}
mysql_close($db_handle);
include "index_tpl.php";
?>
