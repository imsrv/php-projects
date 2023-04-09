<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.1              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

/* 
 * Include some default values
 */

include ('defaults_inc.php');
//start session
if($ENABLE_SESSION){
  @session_start();
}

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ('connect_db_inc.php');
include ('write_line_inc.php');
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;//the error message is printed in connect_db_inc.php
}

/* 
 * Check for login if there no nick and no checksum, else
 * kick ClickedeeClickers. Only one text row in two seconds. 
 * See also at the end of the document for 'User_busy' release code. 
 */
if(check_permissions($nick,$pruef)){
  $result=mysql_query("SELECT User_busy FROM chat WHERE Nick='$nick'",$db_handle);
  if(mysql_num_rows($result)>0){
    $busy=mysql_result($result,0,'User_busy');
    mysql_free_result($result);
  }else{
    $busy=2;
  }
  if($busy){
    if($busy==2){
      //Chatter is kicked -> logout
      if($ENABLE_SESSION){session_destroy();}
      $chanexit="$CHATSERVERNAME/$INSTALL_DIR/index.php";
      $fehler='<FONT COLOR=blue>'.$INACTIVE.'</FONT>';
      $chanexit .= '?fehler='.urlencode($fehler);
      //$expruef=Crypt($Nick,',|');
      //include ('exit_inc.php');
      header('Status: 301');
      header('Location: '.$chanexit);
      exit;
    }else{
      header("HTTP/1.0 204 OK\r\n");
      if(!mysql_close($db_handle)){echo 'Close of MySQL connection failed!'.nl;}
      exit;
    }
  }else{
    $result=mysql_query("UPDATE chat SET User_busy=1 WHERE Nick='$nick'",$db_handle);
  }
}else{
  include 'channels_inc.php';
  if(!$nick){

    /*
     * Exit chat
     */
    if($Exit){
      include ('exit_inc.php');
    }
    
    //A new chatter want to come in, so he get the login form
    include ('login_tpl.php');
    exit;
  }else{

    // The new chatter has posted his login data, so we check this
    include('login_inc.php');
    $pruef = user_login($HTTP_POST_VARS['nick'],$HTTP_POST_VARS['password'],$HTTP_POST_VARS['password2'],$HTTP_POST_VARS['entry'],$db_handle);
    
    //$pruef contains the checksum of nickname
    //$pruef is empty,
    //if the given password doesn't match with the password in the database
    if($pruef){
      $nick=$HTTP_POST_VARS['nick'];
      if($ENABLE_SESSION){
        session_register('pruef','nick','vip','moderator','is_vip','is_como','is_moderator_for');
        //session_register('vip','moderator','is_vip','is_como','is_moderator_for');
      }
    }
    if(!check_permissions($nick,$pruef)){

      //the user has no access permissions,
      //so he has to try to logon again
      include ('login_tpl.php');
      exit;
    }
  }
}
if($ENABLE_SESSION){
	include('check_flooder_inc.php');
}
//the user has access permission for this page
//calculate the check sum of the current channel
$chancrypt=Crypt($channel,$salt_channels);

$chancode = urlencode($channel);
$nickcode = urlencode($nick);
//check the posted color value
if($change_color){
  if(strlen($change_color)!=7||!ereg('^#',$change_color)||ereg('[^#0-9a-fA-F]',$change_color)){
    unset($change_color);
    $choose_color_error = $message[error_8];
  }else{
    $change_color=substr($change_color,0,7);
    $color=$change_color;
  }
  
  //user changes his color, maybe he opened the color-window in other channel, so check which channel he is
  $channel=mysql_result(mysql_query("select Raum from chat where Nick='$nick'",$db_handle),'0','Raum');
}

//Check posted variables
if($say_to_nick){
  $say_to_nick=strip_tags($say_to_nick);
}
$color     = substr($color,0,7);

//$speaking contains: "says_to_nick" or "wispers_to_nick"
//$say_to_nick contains a nickname
$$speaking = $say_to_nick;


/*
 * Import some data of active channel and
 * initialyze default values
 */
include 'channels_inc.php';

if($SHOW_TIME){
  $day = '['.$WEEKDAY[date ('D')];
  $time= date (' H:i').']';
}

/* 
 * Function to input a text line in database
 */
$chat=substr($chat,0,$MAX_LINE_LENGTH);


/*
 * Exit chat
 */
if($Exit){
  include ('exit_inc.php');
}

//Update online time of user 
//(the time since his first login)
include ('timeupdate_inc.php');

/*
 * Check to see if they're changing the channel 
 */
if ($oldchannel!=$channel){
  $enters=1;
  $leaves=1;
  $chanjs='parent.flag=1;
';
  
  if(!$ENABLE_SESSION){
    $chanjs.='parent.vip=\'\';
parent.moderator=\'\';
parent.is_vip=\'\';
parent.is_como=\'\';
parent.is_moderator_for=\'\';
parent.lastRow=0;
';
  }else{
    $vip='';
    $moderator='';
    $is_vip='';
    $is_como='';
    $is_moderator_for='';
  }
}

/*
 * Check for mails
 */
if($BUTTON_MESSAGES){
  //mailings are activated in defaults_inc.php
  //check for new mails
  $result=mysql_query("SELECT ID,SENDER,SUBJECT,UNREAD FROM chat_mail WHERE Nick='$nick' AND (UNREAD=0 OR UNREAD=1)",$db_handle);
  //UNREAD=0 or 1 means not yet seen in output-window
  while($row=mysql_fetch_object($result)){
    $nachricht_popup=0;
    if($row->UNREAD=="0"){
      $temp=mysql_query("update chat_mail set UNREAD=2 where ID=$row->ID",$db_handle);
    }
    elseif($row->UNREAD=="1"){
      $temp=mysql_query("update chat_mail set UNREAD=3 where ID=$row->ID",$db_handle);
    }
    //format chat line
    if($ENABLE_SESSION){
      $content = '<a href="chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'" target="ressource_window">'.$row->SUBJECT.'</a>';
    }else{
      $content = '<a href="chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?nick='.$nick.'&pruef='.$pruef.'"  target="ressource_window">'.$row->SUBJECT.'</a>';
    }
    $line = '<!-- '.$nick.'|'.$MODERATOR_NAME.'|2|0|0|--> <i>'.$day.$time.'</i> '.$row->SENDER.' '.$LEFT_THIS_MESSAGE.': <FONT COLOR="'.$MAIL_TEXT_COLOR.'">'.$content.'</FONT>';
    schreib_zeile($line,$channel);
    unset($content);
  }
  @mysql_free_result($result);
}

include ('mysql_update_inc.php');
if ($chat){
  //if we use htmlentities() no line containing ' " is possible
  $chat = str_replace('\'','&#39;',$chat);
  $chat = str_replace('<','&lt;',$chat);

  if(eregi('www\.|https?://|ftp://|.+@.+\..+',$chat)){
    $chat_pieces=explode(' ',$chat);
    reset($chat_pieces);
    do{
      if(eregi('www\.|https?://|ftp://',current($chat_pieces))){
        $chat_pieces[key($chat_pieces)] = eregi_replace("((((https?://([^ :@]*(:[^ :@]*)?@)?)|(ftp://([^ :@]*(:[^ :@]*)?@)?))?[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(:[0-9]{1,5})?(/[^][ <>@()]*)?)|(((https?://([^ :@]*(:[^ :@]*)?@)?)|(ftp://([^ :@]*(:[^ :@]*)?@)?)|(www\.))[^] <>/@()]+\.[a-z]{2,}(:[0-9]{1,5})?(/[^][ <>@()]*)?))",
          "<A HREF=\"".$INSTALL_DIR."/jump.".$FILE_EXTENSION."?url=\\0\" TARGET=\"_blank\">\\0</a>",current($chat_pieces));
      }elseif(eregi('.*@.*\..*',current($chat_pieces))){
        $chat_pieces[key($chat_pieces)] = eregi_replace("[^][ <>@():]+@[^][ <>@():]+\.[a-z]{2,}","<A HREF=\"mailto:\\0\">\\0</A>",current($chat_pieces));
      }
    }while(next($chat_pieces));
    $chat = implode($chat_pieces,' ');
  }

  $string = $string.' <font>'.$day.$time.'</font><font COLOR="'.$color.'">';
  
  if ($wispers_to_nick){
     $to_nick = $wispers_to_nick;
  }elseif ($says_to_nick){
    $to_nick = $says_to_nick;
  }else{
    unset($to_nick);
  }

  /*
   * Insert smilies and replace some words in $chat like 'fuck', 'suck', .. with '...oops...'
   * to interpret given text as IRC-Commands if enabled in defaults_inc.php
   */
  include 'filter_inc.php';
  $me_comment = false;

  // Workaround for /locate-whisper-problem
  $old_wispers_to_nick = $wispers_to_nick;

  $chat = filter($chat,$nick,$to_nick);
  if($chat){
     if ($me_comment){
       $string = "$string <EM>*";
     }elseif ($wispers_to_nick){
       $string = "$string <EM>$WISPERS_TO $wispers_to_nick: </EM>";
     }elseif ($says_to_nick){
       $string = "$string <EM>$SAYS_TO $says_to_nick: </EM>";
     }else{
       $string = "$string <EM>$SAYS: </EM>";
     }

     if ($me_comment){
       $string = $string.$chat.' *</EM></font>';
     }else{
       $string = $string.$chat.'</font>';
     }
     $result = mysql_query("SELECT count(*) AS count FROM paten WHERE Nick='$nick'",$db_handle);
     $pate   = mysql_result($result,0,'count');
     mysql_free_result($result);
     if(($is_vip       && Crypt($nick.$pass_phrase,$salt_nick) == $is_vip)||
        ($is_moderator && Crypt($nick.$pass_phrase,$salt_nick) == $is_moderator)){
       $enabled = 1;
     }else{
       $enabled = 0;
     }

     if($sys_msg){
       $string = "<!-- $nick|$MODERATOR_NAME|1|$pate|$enabled|-->$string";
     }elseif($wispers_to_nick){
       $string = "<!-- $wispers_to_nick|$nick|1|$pate|$enabled|-->$string";
     }else{
       $string = "<!-- $says_to_nick|$nick|0|$pate|$enabled|-->$string";
     }

     // Workaround for /locate-whisper-problem
     $wispers_to_nick = $old_wispers_to_nick;

     /*
      * Write the given string in the database
      */
     $ownLine=&$string;
     schreib_zeile($string,$channel);
   }
}

if (($enters==1)&&(!$fehler)){
  
  //check if the current user a moderator or vip
  $result=mysql_query("SELECT count(*) as count FROM vip WHERE Nick='$nick' AND Channel='$channel'",$db_handle);
  $a=@mysql_fetch_array($result);
  if($a[count]>0){
    $is_vip=Crypt($nick.$pass_phrase,$salt_nick);
  }else{
    $is_vip='';
  }
  mysql_free_result($result);
  
  $result=mysql_query("SELECT count(*) as count FROM vip WHERE Moderator='$nick' AND Channel='$channel'",$db_handle);
  $a=@mysql_fetch_array($result);
  if($a[count]>0){
    $is_moderator=Crypt($nick.$pass_phrase,$salt_nick);
  }else{
    $is_moderator='';
  }
  mysql_free_result($result);
  unset($a);

  if(!$is_moderated){

    $hellothere = '<!-- |'.$nick.'|0|0|0|--><i><font> ';
    $come_from="$COME_FROM $oldchannel";
    $come_from_privat="$COME_FROM_PRIVAT $oldchannel";
    
    /*Stammtischinfo*/
    /*
    $result=mysql_query("SELECT count(*) AS count FROM chat_data WHERE Online>=$onlinetime",$db_handle);
    $a=@mysql_fetch_array($result);
    if($a[count]>0){    
      //$join = "* ".$JOINING_IN." und sitzt auf dem ".mysql_result($result,0,"count").". Platz des Stammtisches *";
      $join = "* $JOINING_IN *";
    }else{
      $join = "* $JOINING_IN *";
    }
    unset($a);
    @mysql_free_result($result);
    */
    if($oldchannel!=$channel){
      if($old_user_channel){
        $hellothere = "$hellothere$day$time * $come_from_privat *</font></i>";
      }else{
        $hellothere = "$hellothere$day$time * $come_from *</font></i>";
      }
      schreib_zeile($hellothere,$channel);
    }else{
      $hellothere = '';
    }
  }
  include 'mysql_update_inc.php';
}

if ($leaves==1 && !$oldchan_is_moderated){

  $hellothere = "<!-- |$nick|0|0|0|--><i><font> $day$time * $GOES_TO $channel *</font></i>";
  schreib_zeile($hellothere,$oldchannel);
  $result=mysql_query("SELECT Name FROM channels WHERE Teilnehmerzahl=1",$db_handle);
  while ($a=mysql_fetch_array($result)){
    $name=$a[Name];
    $check=mysql_query("SELECT count(*) as count FROM chat WHERE Raum='$name'",$db_handle);
    if(mysql_num_rows($check)==0){
      $delete=mysql_query("DELETE FROM channels WHERE Name='$name'",$db_handle);
    }
  
    mysql_free_result($check);
  }
  mysql_free_result($result);
}

/*
 * The body loads up the refresh window with values passed
 */
?>

<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="<?echo$INSTALL_DIR?>/style.css">
<TITLE>Eingabe</TITLE>
<script language="JavaScript" type="text/javascript">
<!--
<?
echo $chanjs;
//echo "alert('debug: \'$hellothere\'');";
if($ownLine || $hellothere){
  if(!$ownLine){
    $noLine=TRUE;
    $ownLine=$hellothere;
    if($enters){
      $ownLine.='<p align="center">--- <b>'.$channel.'</b> ---</p>';
    }
  }
  if($is_moderated){
    $vip_=strtolower($vip);
    $nick_=strtolower($nick);
    $moderator_=strtolower($moderator);
    
    if($vip_ != $nick_ && $moderator_!=$nick_ && !$noLine){
      echo "parent.output.document.write('<font>$MODERATOR_MESSAGE <b>$nick<\/b><\/font> $ownLine<br>');\n";
    }elseif($vip_ == $nick_){
      echo "parent.output.document.write('<font><a href=\"dummy.html#\" target=\"dummy\"><u><b>$nick<\/b><\/u><\/a><\/font> $ownLine<br>');\n";
    }else{
      echo "parent.output.document.write('<font><a href=\"dummy.html#\" target=\"dummy\"><u><b>$nick<\/b><\/u><\/a><\/font> <b>$ownLine</b><br>');\n";
    }
    unset($vip_);
    unset($moderator_);
    unset($nick_);
  }else{
    echo "parent.output.document.write('<font><a href=\"dummy.html#\" target=\"dummy\"><u><b>$nick<\/b><\/u><\/a><\/font> $ownLine<br>');\n";
  }
}
?>

//no clickadeclick!
var submitcount=0;
function checkSubmit() {
  if (submitcount == 0){
    submitcount++;
    return true;
  }else{
    return false;
  }
}

//funktion for text scrolling
function scroll_me() {
  if (parent.scroll_it) {
    parent.scroll_it();
    return;
  }
}

function openWindow(){
  var newWindow;
  newWindow = window.open('','Color','scrollbars=no,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,width=300,height=450,screenX=50,screenY=250');

}



function OpenDialog(file) {
        // open window
         var newWindow;
        newWindow=window.open(file,"","scrollbars=yes,directories=no,width=640,height=480")

        if (newWindow != null && newWindow.opener == null)
                newWindow.opener=window
        }


<?if(!$fehler){?>
function setfocus() {
 parent.channel   = '<?=urlencode($channel)?>';
 parent.chanpruef = '<?=$chancrypt?>';
 parent.chanchange= 1;
 parent.metaLoc();
 document.input.chat.focus();
 return true;
}
<?}
if($nachricht_popup){?>
function MessageShowPopup() 
{
        // Name the top-level window so that we can target it.
        window.top.name = "MessageMain";

        // open the popup window
        var popupURL = "<?
                          if($ENABLE_SESSION){
                            echo "$CHATSERVERNAME/$INSTALL_DIR/message_popup.$FILE_EXTENSION?".session_name()."=".session_id();
                          }else{
                            echo "$CHATSERVERNAME/$INSTALL_DIR/message_popup.$FILE_EXTENSION?pruef=$pruef&nick=$nickcode";
                          }
                        ?>";
        var popup = window.open(popupURL,"MessagePopup",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=350,height=400');
        // set the opener if it's not already set. it's set automatically
        // in netscape 3.0+ and ie 3.0+.
        if( navigator.appName.substring(0,8) == "Netscape" )
        {
                popup.location = popupURL;
                popup.opener = self;
        }
}

MessageShowPopup();
<?}?>
// -->
</script>
</HEAD>
<?  

//Update only once per session
if($action){
  $result=mysql_query("UPDATE chat_data SET Host='$REMOTE_ADDR' WHERE Nick='$nick'",$db_handle);
}

// Ok, they're in.  Show chat interface.
if($chanbg_gif){
  $bgimage=$chanbg_gif;
}else{
  $bgimage=$BACKGROUNDIMAGE;
}

if(($oldchannel != $channel)||($action)){
  $js_onload = 'setfocus();document.input.chat.focus();';
}else{
  $js_onload = 'document.input.chat.focus();';
}

/*
 * First form:  Change Channel
 */
if($ENABLE_SESSION){
  $exit_link = "$CHATSERVERNAME/$INSTALL_DIR/input.$FILE_EXTENSION?Exit=1&amp;".session_name()."=".session_id()."&amp;chanexit=index.".$FILE_EXTENSION;
}else{
  $exit_link = "$CHATSERVERNAME/$INSTALL_DIR/input.$FILE_EXTENSION?Exit=1&amp;Nick=$nickcode&amp;pruef=$pruef&amp;chanexit=index.$FILE_EXTENSION";
}

/*
 * This shows the channel selections 
 * and selects the correct channel 
 */
if($SELECT_CHANNEL){
  $select_channel = '<select name="channel" onChange="submit();" STYLE="font-size: 10px;">';
  $i=0;
  $chan_teilnehmer=nl;
  while ($i<$numchannels){
    
    /* 
     * How many users are in the channels?
     */
    $chatresult=mysql_query("SELECT count(Nick) FROM chat WHERE Raum ='$chan[$i]'",$db_handle);        
    $chan_teilnehmer = $chan_teilnehmer.' <input name="chan['.$i.']" type="hidden" value="'.$chan[$i].'">';
    $chan_teilnehmer = $chan_teilnehmer.nl.'<input name="teilnehmerzahl['.$i.']" type="hidden" value="'.$teilnehmerzahl[$i].'">';
    $online=mysql_result($chatresult,0,'count(Nick)');
    if($online==''){$online=0;}
    unset($zuviel);
    
    if (($online>=$teilnehmerzahl[$i])&&($teilnehmerzahl[$i]>0)){
      $zuviel=1;
    }
    
    if($teilnehmerzahl[$i]!=-1){
      if(($zuviel!='')||($teilnehmerzahl[$i]==-2)){
        $select_channel .= nl.tab.tab.tab.tab.'<option VALUE="'.$channel.'"';
      }else{
        $select_channel .= nl.tab.tab.tab.tab.'<option VALUE="'.$chan[$i].'"';
      }
      if ($channel==$chan[$i]){
        $select_channel .= ' selected';
      }
      $select_channel .= '>';
      if(($teilnehmerzahl[$i]!=0)&&($teilnehmerzahl[$i]!=-1)){
        if($online>=$teilnehmerzahl[$i]){
          $select_channel .= $chan[$i].' (voll)';
        }else{
          $select_channel .= "$chan[$i] ($online/$teilnehmerzahl[$i])";
        }
      }else{
        $select_channel .= "$chan[$i] ($online)";
      }
    }
    if(($teilnehmerzahl[$i]==-1)&&($online!=0)){
      if($zuviel){
        $select_channel .= nl.tab.tab.tab.tab.'<option VALUE="'.$channel.'"';
      }else{
        $select_channel .= nl.tab.tab.tab.tab.'<option VALUE="'.$chan[$i].'"';
      }
      if ($channel==$chan[$i]){
        $select_channel .= ' selected';
      }
      $select_channel .= '>';
      if(($teilnehmerzahl[$i]!=0)&&($teilnehmerzahl[$i]!=-1)){
        if($online>=$teilnehmerzahl[$i]){
          $select_channel .= $chan[$i].' (voll)';
        }else{
          $select_channel .= "$chan[$i] ($online/$teilnehmerzahl[$i])";
        }
      }else{
        $select_channel .= "$chan[$i] ($online)";
      }
    }
    $i++;
  }
  mysql_free_result($chatresult);
  $select_channel .= '</select>'.nl.nl;
  //$select_channel .= "<input type=\"submit\" value=\"« wechseln\">";
}else{
  $select_channel = '<input name="channel" type="hidden" value="'.$ENTRYCHANNELNAME.'">';
}


if($checkchannel==1){
  $get_privat_channel = '<input type="hidden" name="GetPrivChan" value="1">';
}else{
  $get_privat_channel='';
}
if($BUTTON_HELP){
  $help_button = nl.tab.tab.tab.'<INPUT TYPE="button" NAME="OpenWin" VALUE="'.$HELP.'" onClick="OpenDialog(\''.$INSTALL_DIR.'/help.'.$FILE_EXTENSION.'\')" STYLE="font-size: 10px;">';
}else{
  $help_button = '';
}
if($pruef && $BUTTON_FORUM){
  if($ENABLE_SESSION){
    $forum_button = nl.tab.tab.tab.'<INPUT TYPE="button" NAME="OpenWin" VALUE="'.$FORUM[title].'" onClick="OpenDialog(\''.$INSTALL_DIR.'/forum/forum.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'\')" STYLE="font-size: 10px;">';
  }else{
    $forum_button = nl.tab.tab.tab.tab.'<INPUT TYPE="button" NAME="OpenWin" VALUE="'.$FORUM[title].'" onClick="OpenDialog(\''.$INSTALL_DIR.'/forum/forum.'.$FILE_EXTENSION.'?nick='.$nickcode.'&pruef='.$pruef.'\')" STYLE="font-size: 10px;">';
  }
}else{
  $forum_button = '';
}   

if(!$wispers_to_nick){
  $says_to_status = ' CHECKED';
}else{
  $wispers_to_status = ' CHECKED';
}

if($SELECT_USER){
  if($WISPERING){
    $radio_say_to    = '<INPUT NAME="speaking" TYPE="radio" VALUE="says_to_nick" '.$says_to_status.' /> '.$SAY_TO;
    $radio_wisper_to = '<INPUT NAME="speaking" TYPE="radio" VALUE="wispers_to_nick" '.$wispers_to_status.' > '.$WISPER_TO;
  }else{
    $radio_say_to    = '<INPUT NAME="speaking" TYPE="hidden" VALUE="says_to_nick">';
  }
  
  $select_user = '<SELECT NAME="say_to_nick" STYLE="font-size: 10px;">'.nl.tab.tab.tab.tab.'<OPTION VALUE="">'.$ALL;
  $nick_result=mysql_query("SELECT Nick,Quassel FROM chat WHERE Raum='$channel' ORDER BY Nick",$db_handle);
  while($a=mysql_fetch_array($nick_result)){
    $teilnehmer=$a['Nick'];
    $checkquassel=$a['Quassel'];
    if($teilnehmer!=$nick){
      $select_user .= nl.tab.tab.tab.tab.'<OPTION VALUE="'.$teilnehmer.'"';
      if(strtolower($teilnehmer)==strtolower($say_to_nick)){
	if($checkquassel==1){$teilnehmer="($teilnehmer)";}
	$select_user .= ' SELECTED>'.$teilnehmer.nl;
      }else{
	if($checkquassel==1){$teilnehmer="($teilnehmer)";}
	$select_user .= '>'.$teilnehmer.nl;
      }
    }
    
  }
  $select_user .= nl.tab.tab.tab.'</SELECT>';
}else{
  $select_user  = '<input name="say_to_nick" type="hidden" value="'.$say_to_nick.'">';
  $select_user .= nl.tab.tab.tab.tab.'<INPUT NAME="speaking" TYPE="hidden" VALUE="'.$says_to_nick.'" >';
}

if($BUTTON_MESSAGES){
  if($ENABLE_SESSION){
    $messages_button = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$CHATMAIL.' " onClick="OpenDialog(\'chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'\')" STYLE="font-size: 10px;">';
  }else{
    $messages_button = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$CHATMAIL.' " onClick="OpenDialog(\'chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?nick='.$nickcode.'&pruef='.$pruef.'\')" STYLE="font-size: 10px;">';
  }
}
if($BUTTON_IGNORE){
  if($ENABLE_SESSION){
    $ignore_invite_button = '<INPUT TYPE="button" NAME="OpenWin" VALUE="'.$IGNORE_INVITE.'" onClick="OpenDialog(\'invite.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'\')" STYLE="font-size: 10px;">';
  }else{
    $ignore_invite_button = '<INPUT TYPE="button" NAME="OpenWin" VALUE="'.$IGNORE_INVITE.'" onClick="OpenDialog(\'invite.'.$FILE_EXTENSION.'?nick='.$nickcode.'&pruef='.$pruef.'\')" STYLE="font-size: 10px;">';
  }
}
if($enters && !$is_moderator && $is_moderated){
  //$privat=1;$privat_chk=0;
  $no_gruentxt=1;
  $no_gruentxt_chk=0;
}

if($BUTTON_NOTIFY){
  if($ENABLE_SESSION){
    $button_notify      = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$NOTIFY.' " onClick="OpenDialog(\'chat_notify.'.$FILE_EXTENSION.'?action=list&'.session_name().'='.session_id().'\')" STYLE="font-size: 10px;">';
  }else{
    $button_notify      = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$NOTIFY.' " onClick="OpenDialog(\'chat_notify.'.$FILE_EXTENSION.'?action=list&nick='.$nickcode.'&pruef='.$pruef.'\')" STYLE="font-size: 10px;">';
  }
}

if($BUTTON_WHOISONLINE){
  if($ENABLE_SESSION){
    $button_whoisonline      = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$WHOISONLINE.' " onClick="OpenDialog(\'whoisonline.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'\')" STYLE="font-size: 10px;">';
  }else{
    $button_whoisonline      = '<INPUT TYPE="button" NAME="OpenWin" VALUE=" '.$WHOISONLINE.' " onClick="OpenDialog(\'whoisonline.'.$FILE_EXTENSION.'?nick='.$nickcode.'&pruef='.$pruef.'\')" STYLE="font-size: 10px;">';
  }
}

/*beginn quassel-filter*/
if (($privat==1)&&($privat_chk!=1)){
  $quassel=mysql_query("UPDATE chat SET Quassel=1 WHERE Nick='$nick'",$db_handle);
  $privat_status = 'CHECKED';
  $twaddle_color = '#FF0000';
  $privat_checked=1;
  
}elseif((!$privat)&&($privat_chk==1)){
  $quassel=mysql_query("UPDATE chat SET Quassel=0 WHERE Nick='$nick'",$db_handle);
  $privat_status = '';
  $twaddle_color = '#000000';
  $privat_checked=0;
  
}elseif($privat_chk==1){
  $privat_status = 'CHECKED';
  $twaddle_color = '#FF0000';
  $privat_checked=1;
  
}elseif($privat_chk=="0"){
  $privat_status = '';
  $twaddle_color = '#000000';
  $privat_checked=0;
  
}else{
  //privat-state is not given...select it from database
  $result = mysql_query("select Quassel from chat where Nick='$nick'",$db_handle);
  $db_privat = mysql_result($result,'0','Quassel');
  mysql_free_result($result);
  if($db_privat==0){
	  $privat_status = '';
	  $twaddle_color = '#000000';
	  $privat_checked=0;
  }else{
	  $privat_status = 'CHECKED';
	  $twaddle_color = '#FF0000';
	  $privat_checked=1;	
  }
}

if($SET_TWADDLEFILTER){
  $button_twaddle_filter  = nl.tab.tab.tab.tab.'<input name="privat" onclick="submit();" type="checkbox" value="1" '.$privat_status.' >';
  $button_twaddle_filter .= nl.tab.tab.tab.tab.'<FONT STYLE="font-size: 12px;" COLOR="'.$twaddle_color.'"> '.$TWADDLEFILTERNAME;
  $button_twaddle_filter .= nl.tab.tab.tab.tab.'</FONT>';
  $button_twaddle_filter .= nl.tab.tab.tab.tab.'<INPUT NAME="privat_chk" TYPE="hidden" VALUE="'.$privat_checked.'" >';
}else{
  $button_twaddle_filter  = nl.tab.tab.tab.tab.'<input name="privat" type="hidden" value="0" >';
}
/*ende quassel-filter*/

/*beginn gruentext filter*/

if (($no_gruentxt==1)&&($no_gruentxt_chk!=1)){
  $quassel=mysql_query("UPDATE chat SET Gruentext=1 WHERE Nick='$nick'",$db_handle);
  $status_filter_status = 'CHECKED';
  $status_filter_color  = '#FF0000';
  $status_filter_checked=1;
  
}elseif((!$no_gruentxt)&&($no_gruentxt_chk==1)){
  $quassel=mysql_query("UPDATE chat SET Gruentext=0 WHERE Nick='$nick'",$db_handle);
  $status_filter_status = '';
  $status_filter_color  = '#000000';
  $status_filter_checked=0;
  
}elseif($no_gruentxt_chk==1){
  $status_filter_status = 'CHECKED';
  $status_filter_color  = '#FF0000';
  $status_filter_checked=1;
  
}elseif($no_gruentxt_chk=="0"){
  $status_filter_status = '';
  $status_filter_color  = '#000000';
  $status_filter_checked=0;
  
}else{
  //status-state is not given...select it from database 
  $result = mysql_query("select Gruentext from chat where Nick='$nick'",$db_handle);
  $db_privat = mysql_result($result,'0','Gruentext');
  mysql_free_result($result);
  if($db_privat==0){
	  $status_filter_status = '';
	  $status_filter_color  = '#000000';
	  $status_filter_checked=0;
  }else{
	$status_filter_status = 'CHECKED';
    $status_filter_color  = '#FF0000';
    $status_filter_checked=1; 
  }
}

if($SET_STATUSFILTER){
  $button_status_filter  = nl.tab.tab.tab.tab.'<input name="no_gruentxt" onclick="submit();" type="checkbox" value="1" '.$status_filter_status.' >';
  $button_status_filter .= nl.tab.tab.tab.tab.'<FONT STYLE="font-size: 12px;" COLOR="'.$status_filter_color.'"> '.$STATUSFILTERNAME;
  $button_status_filter .= nl.tab.tab.tab.tab.'</FONT>';
  $button_status_filter .= nl.tab.tab.tab.tab.'<INPUT TYPE="hidden" NAME="no_gruentxt_chk" VALUE="'.$status_filter_checked.'" >';
}else{
  $button_status_filter  = nl.tab.tab.tab.tab.'<input name="no_gruentxt" type="hidden" value="0">';
}

/*ende gruentext filter*/
if(!$color){$color=$DEFAULT_TEXT_COLOR;}
if($ENABLE_SESSION){
  $color_link = "choose_color.$FILE_EXTENSION?".session_name()."=".session_id()."&channel=$channel&privat=$privat&no_gruentxt=$no_gruentxt&scroll=$scroll&scroll_old=$scroll&say_to_nick=".urlencode($say_to_nick)."&sprechen=$$sprechen&color=".urlencode($color)."&old_color=".urlencode($old_color)."&is_vip=$is_vip&is_moderator=$is_moderator"; 
}else{
  $color_link = "choose_color.$FILE_EXTENSION?channel=$channel&privat=$privat&no_gruentxt=$no_gruentxt&nick=".urlencode($nick)."&pruef=$pruef&scroll=$scroll&scroll_old=$scroll&say_to_nick=".urlencode($say_to_nick)."&sprechen=$$sprechen&color=".urlencode($color)."&old_color=".urlencode($old_color)."&is_vip=$is_vip&is_moderator=$is_moderator";
}


if($change_color){
  //close sattelit
  //$js_onload .= 'closeWindow();';
  $result=mysql_query("UPDATE chat SET color='$change_color' WHERE Nick='$nick'",$db_handle);
  $result=mysql_query("UPDATE chat_data SET color='$change_color' WHERE Nick='$nick'",$db_handle);
  $color_msg="<!--  | |0|0|0|--><b><font color=$channickcolor>$MODERATOR_NAME:</font></b><i> <FONT COLOR=\"$change_color\"><STRONG>$nick</STRONG> $HAS_CHANGED_COLOR.</FONT></i>"; 
  schreib_zeile($color_msg,$channel);
}
if($CHANGE_COLOR_LINK){
  $change_color_link  = nl.tab.tab.tab.'<FONT STYLE="font-size: 12px;">&nbsp;</FONT><A '; 
  $change_color_link .= 'onClick="openWindow()" HREF="'.$color_link.'" ';
  $change_color_link .= 'TARGET="Color">';
  $change_color_link .= '<FONT COLOR="'.$color.'" STYLE="font-size: 12px;">'.$CHANGE_COLOR;
  $change_color_link .= '</FONT></A><FONT STYLE="font-size: 12px;">&nbsp;'.nl.tab.tab.'</FONT>';
}

if($CHANGE_SCROLLING){
  if($scroll=="0"){$scroll_off_status = 'SELECTED';}
  if($scroll=="1"){$scroll_on_status1  = 'SELECTED';}
  if($scroll=="2"){$scroll_on_status2  = 'SELECTED';}
  if($scroll=="3"){$scroll_on_status3  = 'SELECTED';}
  $switch_auto_scrolling   = $AUTOSCROLLING.'<BR>';
  $switch_auto_scrolling  .= '<SELECT Id="scroll" NAME="scroll" STYLE="font-size: 10px;"';
  if($BROWSER_NAME=='ie' || ($scroll && !$is_moderator)){
    $switch_auto_scrolling  .= ' onChange="scroll_me();"';
  }
  $switch_auto_scrolling  .= '>';
  $switch_auto_scrolling  .= '<OPTION VALUE=1 '.$scroll_on_status1.'>'.$ON.'</OPTION>';
  $switch_auto_scrolling  .= '<OPTION VALUE=2 '.$scroll_on_status2.'>'.$ON1.'</OPTION>';
  $switch_auto_scrolling  .= '<OPTION VALUE=3 '.$scroll_on_status3.'>'.$ON2.'</OPTION>';
  $switch_auto_scrolling  .= '<OPTION VALUE=0 '.$scroll_off_status.'>'.$OFF.'</OPTION>';
  $switch_auto_scrolling  .= '</SELECT>';
  if($BROWSER_NAME=='ie' || ($scroll && !$is_moderator)){
    $switch_auto_scrolling  .= '<SCRIPT LANGUAGE="javascript" TYPE="text/javascript">scroll_me();</SCRIPT>';
  }
}else{
  $switch_auto_scrolling   = '<input name="scroll" type="hidden" value="1">';
  $switch_auto_scrolling  .= '<SCRIPT LANGUAGE="javascript">scroll_me();</SCRIPT>';
}

//set the required hidden fields
if($ENABLE_SESSION){
  $hidden_fields = nl.tab.tab.tab.'<input name="'.session_name().'" type="hidden" value="'.session_id().'">';
}else{
  $hidden_fields = nl.tab.tab.tab.'<input name="pruef" type="hidden" value="'.$pruef.'">';
  $hidden_fields .= nl.tab.tab.tab.'<input name="nick" type="hidden" value="'.$nick.'" >';
}
$hidden_fields .= nl.tab.tab.tab.'<input name="scroll_old" type="hidden" value="'.$scroll_old_value.'" >';
$hidden_fields .= nl.tab.tab.tab.'<input name="delete_read_mail" type="hidden" value="'.$nachricht_popup.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="is_vip" type="hidden" value="'.$is_vip.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="is_moderator" type="hidden" value="'.$is_moderator.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="is_moderated" type="hidden" value="'.$is_moderated.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="email" type="hidden" value="'.$email.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="numchannels" type="hidden" value="'.$numchannels.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="user_channel" type="hidden" value="'.$user_channel.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="chanbgcolor" type="hidden" value="'.$chanbgcolor.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="channickcolor" type="hidden" value="'.$channickcolor.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="changrafik" type="hidden" value="'.$changrafik.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="changroesse" type="hidden" value="'.$changroesse.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="chanthese" type="hidden" value="'.$chanthese.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="chanexit" type="hidden" value="'.$chanexit.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="oldchannel" type="hidden" value="'.$channel.'" />';
$hidden_fields .= nl.tab.tab.tab.'<input name="color" type="hidden" value="'.$color.'" />';

//extra hidden field for the form 'chat'
$hidden_fields_chat = nl.tab.tab.tab.'<input name="channel" type="hidden" value="'.$channel.'" >';

include ('input_tpl.php');
echo '</HTML>';
flush();
sleep(2);
$result=mysql_query("UPDATE chat SET User_busy=0 WHERE Nick='$nick' AND User_busy<2",$db_handle);
if(!@mysql_close($db_handle)){echo 'Close of MySQL connection failed!'.nl;}
exit;
?>
