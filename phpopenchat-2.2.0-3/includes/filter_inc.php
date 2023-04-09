<?// -*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel, Frerk Meyer                    **
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
* Replace ASCII Emoticons with images
*
* A user has the possibility of calling its own icon if it exist.
* With ':me' if the user speaks to somebody, with :you if somebody
* speaks to the user.
* 
* @param string $chat
* @param string $nick
* @param string $to_nick
* @author Michael Oertel <Michael@ortelius.de>
* @global $PRIVAT_ICON_PATH,$ICON_PATH,$NO_NO_WORDS,$IRC_COMMANDS
* @return string contains the modified chat line
*/
function filter ($chat,$nick,$to_nick){

  /**
   * To interpret IRC like commands
   */
  global $IRC_COMMANDS;
  if($IRC_COMMANDS && substr($chat,0,1)=="/"){ //parse here only if IRC-commands are allowed and an irc-command is given
    if(substr($chat,0,5) == "/join"){ //the nick 'join' is not allowed by default
      global $db_handle;
      
      eregi("^/([^ ]*) (.*)$",$chat,$split);
      
      //check if the channel exists
      $result = mysql_query("SELECT Name FROM channels WHERE User_Channel=0 AND Name LIKE '$split[2]%'",$db_handle);
      if(mysql_num_rows($result) == 1){
        $tmp_channel = mysql_result($result,0,"Name");
        
        //check how many chatters are in the choosen channel
        $check = mysql_query("SELECT count(*) AS count FROM chat WHERE Raum = '$tmp_channel'",$db_handle);
        $num = mysql_result($check,0,"count");
        mysql_free_result($check);
        
        //check how many chatters are allowed in the channel
        $check = mysql_query("SELECT Teilnehmerzahl FROM channels WHERE Name = '$tmp_channel'",$db_handle);
        $num_allowed = mysql_result($check,0,"Teilnehmerzahl");
        mysql_free_result($check);
        
        if(($num_allowed==0)||($num<$num_allowed)){
          global $oldchannel,$channel,$enters,$leaves,$chancode,$salt_channels,$chancrypt;
          $oldchannel   = $channel;
          $channel      = $tmp_channel;
          $chancode     = urlencode($channel);
          
          //get the specific data of the new channel
          $checkchannel = 1;
          global $chanpasswd,$chanbgcolor,$channickcolor,$oldchan_is_moderated,$is_moderated,$chanthese,$chanexit,$old_user_channel,$user_channel,$changrafik;
          include("channels_inc.php");
          
          //the user has access permission for this page
          //calculate the check sum of the current channel
          $chancrypt=Crypt($channel,$salt_channels);
          
          $enters     = 1;
          $leaves     = 1;
        }
      }
      $chat = "";
      unset ($split);
      unset ($tmp_channel);
      @mysql_free_result($result);
    }elseif(substr($chat,0,3) == '/me'){ //the nick 'me' is not allowed by default
      global $me_comment;
      $me_comment=true;
      $chat=str_replace('/me','',$chat);
    }elseif(substr($chat,0,9) == '/announce'){
      global $db_handle,$channel,$SAYS;
      // check if the current chatter a godfather
      $result    = mysql_query("SELECT count(*) AS count FROM paten WHERE Nick = '$nick'");
      $godfather = mysql_result($result,0,"count");
      if($godfather){
        eregi("^/[^ ]* (.*)$",$chat,$split);
        $chat = str_replace('/announce','',$chat);
        $chat = '';
        $line = '<!-- |'.$nick.'|0|0|0|-->&nbsp;<font color="#ffffff">'.$SAYS.':</font><font color="#ee0000"><h3> '.$split[1].'</h3></font>';
        $result=mysql_query("SELECT Name FROM channels",$db_handle);
        while($row=mysql_fetch_object($result)){
          schreib_zeile($line,$row->Name);
        }
        global $ownLine;
        $ownLine=$line;
        unset($line);
      }else{
        $chat = '';
      }
      @mysql_free_result($result);
    }elseif(substr($chat,0,7) == "/locate"){ //the nick 'locate' is not allowed by default
      global $db_handle,$wispers_to_nick;
      $wispers_to_nick=$nick;
      eregi("^/[^ ]* (.*)$",$chat,$split);
      
      //check if the channel exists
      $result = mysql_query("SELECT Nick,Raum FROM chat WHERE Nick LIKE '$split[1]%'",$db_handle);
      if(mysql_num_rows($result) == 1){
        global $IS_CHATTING_IN,$sys_msg;
        $sys_msg = TRUE;
        
        $chat=mysql_result($result,0,"Nick") . " $IS_CHATTING_IN \"" . mysql_result($result,0,"Raum") . "\"";
      }else{
        global $NOT_ONLINE,$sys_msg;
        $sys_msg = TRUE;
        $chat="$split[1] $NOT_ONLINE";
      }
      mysql_free_result($result);
    }elseif(substr($chat,0,4) == "/msg"){ //the nick 'join' is not allowed by default
      global $says_to_nick,$say_to_nick,$wispers_to_nick,$db_handle;
      
      eregi("^/[^ ]* ([^ ]*).*$",$chat,$split);
      
      //check if the user exists
      $result = mysql_query("SELECT Nick FROM chat WHERE Nick LIKE '$split[1]%'",$db_handle);
      if(mysql_num_rows($result) == 1){
        $says_to_nick = "";
        $speaking = "wispers_to_nick";
        $$speaking = mysql_result($result,0,"Nick");
        $wistpers_to_nick = $$speaking;
        $say_to_nick = $$speaking;
      }
      $chat = str_replace("/msg $split[1]","",$chat);
      unset ($split);
      mysql_free_result($result);
    }elseif(substr($chat,0,1) == "/"){
      global $says_to_nick,$say_to_nick,$wispers_to_nick,$db_handle;
      
      eregi("^/([^ ]*).*$",$chat,$split);
      
      //check if the user exists
      $result = mysql_query("SELECT Nick FROM chat WHERE Nick LIKE '$split[1]%'",$db_handle);
      if(mysql_num_rows($result) == 1){
        $wispers_to_nick = "";
        $speaking = "says_to_nick";
        $$speaking = mysql_result($result,0,"Nick");
        $say_to_nick = $$speaking;
      }
      $chat = str_replace("/$split[1]","",$chat);
      unset ($split);
      mysql_free_result($result);
    }
  }

  /** 
   * Array containing the possible Emoticons
   *
   * @var array $smiley
   */
  if (empty($smiley)) {
    $smiley[]=":-))";
    $smiley[]="B-))";
    $smiley[]="=:-)";
    $smiley[]=":-)=";
    $smiley[]=":-)";
    $smiley[]=";-)";
    $smiley[]=":-x";
    $smiley[]=":-(";
    $smiley[]=":-P";
    $smiley[]=":-p";
    $smiley[]="&gt;-";
    $smiley[]=":h)";
    $smiley[]=":T::";
    $smiley[]="@}--";
    $smiley[]="@}X-";
    $smiley[]="~==";
    $smiley[]="~--";
    $smiley[]=":[=]";
    $smiley[]=":-G-";
    $smiley[]="(:(=";
    $smiley[]=":pkl)";
    $smiley[]=":mm)";
    $smiley[]=":ms)";
    $smiley[]=":ei:";
    $smiley[]=":ct";
    $smiley[]=":-|";
    $smiley[]=":-O";
    $smiley[]="|-)";
    $smiley[]="|-O";
    $smiley[]="[:-)";
    $smiley[]=".-)";
    $smiley[]=":,-)";
    $smiley[]=":,-(";
    $smiley[]=":.|";
    $smiley[]=":-]";
    $smiley[]=":-/";
    $smiley[]=":-Q";
    $smiley[]=":-D";
    $smiley[]=":*)";
    $smiley[]=":o";
    $smiley[]=":O";
    $smiley[]=":#D";
    $smiley[]="B-)";
    $smiley[]="%-)";
    $smiley[]=":,-)";
    $smiley[]=".-)";
    $smiley[]=":-";
    $smiley[]="~o";
    $smiley[]="8)";
    $smiley[]=":viv";
  }
  
  if(ereg("-|:|\~|\||)",$chat)){
    unset ($s);
    $pattern = "\:me";
    ereg("(.*)($pattern)(.*)",$chat,$s);
    if ($s[2]) {

      global $PRIVAT_ICON_PATH;
      $smileydir=$PRIVAT_ICON_PATH;
      $smileypath=$smileydir.strtolower(str_replace(" ","_",$nick)).".gif";
      if(@LinkInfo($smileypath)>=0){
	$smileypath=$smileydir.urlencode(strtolower(str_replace(" ","_",$nick))).".gif";
	$chat = $s[1]."<IMG SRC=\"".$smileypath."\" WIDTH=\"16\" HEIGHT=\"16\">".$s[3];
      }
    }
    unset($s);
    $pattern="\:you";
    ereg("(.*)($pattern)(.*)",$chat,$s);
    if ($s[2]) {

      global $PRIVAT_ICON_PATH;
      $smileydir=$PRIVAT_ICON_PATH;
      $smileypath=$smileydir.strtolower(str_replace(" ","_",$to_nick)).".gif";
      if(@LinkInfo($smileypath)>=0){
	$smileypath=$smileydir.urlencode(strtolower(str_replace(" ","_",$to_nick))).".gif";
	$chat = $s[1]."<IMG SRC=\"".$smileypath."\" WIDTH=\"16\" HEIGHT=\"16\">".$s[3];
      }
    }
    unset($s);

    global $ICON_PATH;
    $smileydir=$ICON_PATH;
    $smileyopen = "<IMG SRC=\"".$smileydir;
    $smileyclose = ".gif\" WIDTH=\"16\" HEIGHT=\"16\">";
    reset($smiley);
    $error=error_reporting(0);
    do {
      $pattern=preg_quote(current($smiley));
      ereg("(.*)($pattern)(.*)",$chat,$s);
      if ($s[2]) {
	$s[2] = rawurlencode(str_replace("/","\\",str_replace("&gt;",">",$s[2])));
	$chat = $s[1].$smileyopen.$s[2].$smileyclose.$s[3]; break;}
    } while (next($smiley));
    error_reporting($error);
  }
  global $NO_NO_WORDS;
  $chat = eregi_replace($NO_NO_WORDS,"...oops...",$chat);

  return $chat;
}//end func filter
?>
