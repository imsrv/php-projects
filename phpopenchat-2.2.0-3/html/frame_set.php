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
* Define of frameset
*
* Generates a message like 'someone is looking in the chat' and a frameset is defined
*
* @author Michael Oertel <Michael@ortelius.de>
*/

//Include default values
include("defaults_inc.php");

//Open a database connection
include("connect_db_inc.php");
//returns a database handle
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  //the error message was printed in connect_db()
  exit;
}

//check all values
if($ENABLE_SESSION){
  if(!session_is_registered("nick")){
    header("Status: 301");
    header("Location:index.$FILE_EXTENSION");
    exit;
  }
}else{
  if($pruef!=Crypt($nick,$salt_nick)){
    header("Status: 301");
    header("Location:index.$FILE_EXTENSION");
    exit;
  }
}
$chancrypt=Crypt($entry,$salt_channels);
?>
<HTML>
<HEAD>

<TITLE><?echo$CHATNAME?></TITLE>    
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
var scrollTO;
var timeout_on = false;
function scroll_it() {
 to=20;
 if(window.input && window.input.document && window.input.document.input && window.input.document.input.scroll){
  scrollspeed = window.input.document.input.scroll;
  index = scrollspeed.selectedIndex;
   if(scrollspeed.options[index].value!=0){
    speed = scrollspeed.options[index].value;      
    if(speed==3){
     to = 5;
     down=3;
    }else if(speed == 2){
     to = 10;
     down=2;
    }else{
     to = 20;
     down=1;
    }
    window.output.scrollBy(-1,down); 
    if (timeout_on == true) {
     clearTimeout(scrollTO);
    }
    timeout_on = true;
    scrollTO = setTimeout('scroll_it()',to);
  }
 }
}
//vars to store user status in his current channel
//used if not $ENABLE_SESSION
<?if(!$ENABLE_SESSION){?>
var vip='';
var moderator='';
var is_vip='';
var is_como='';
var is_moderator_for='';
var lastRow = 0;
var ii = 0;
<?}?>
var refresh = 8000;
var channel = '<?=urlencode($entry)?>';
var chanpruef = '<?=$chancrypt?>';
var chanchange= 0;
var flag = 1;
var BufferInt = window.setInterval("metaLoc()",refresh);
function metaLoc(){
 if(flag == 1){
   <?if($ENABLE_SESSION){?>
       getlines.location.href = 'getlines.<?echo "$FILE_EXTENSION?Nick=".urlencode($nick)."&pruef=$pruef&".session_name()."=".session_id()?>&channel='+channel+'&chanpruef='+chanpruef+'&chanchange='+chanchange;
   <?}else{?>
       getlines.location.href = 'getlines.<?echo "$FILE_EXTENSION?Nick=".urlencode($nick)."&pruef=$pruef"?>&channel='+channel+'&chanpruef='+chanpruef+'&lastRow='+lastRow+'&chanchange='+chanchange+'&ii='+ii+'&vip='+vip+'&moderator='+moderator+'&is_vip='+is_vip+'&is_como='+is_como+'&is_moderator_for='+is_moderator_for;
   <?}?> 
 }
}
</SCRIPT>
</HEAD>
<?
//in case of a moderator joins the chat, 
//the frame for moderating the chat becomes bigger.
$result=mysql_query("SELECT count(*) as count FROM vip WHERE Moderator='$nick' AND Channel='$entry'",$db_handle);
$a=@mysql_fetch_array($result);
if($a[count]>0){
  $mod_frame_size=50;
  if(!$msie){$mod_frame_size+=10;}  
}else{
  $mod_frame_size=0;
}
mysql_free_result($result);
mysql_close($db_handle);
unset($a);

if($ENABLE_SESSION){
	echo "<frameset frameborder=0 border=0 framespacing=0 cols=* rows=0,$mod_frame_size,*,160,0>
  \n\t<frame name=\"dummy\" src=\"dummy.html\">
	\n\t<frame name=\"moderate\" src=\"edit.$FILE_EXTENSION?".SID."\" scrolling=\"no\">
	\n\t<frame name=\"output\" src=\"output.$FILE_EXTENSION\" scrolling=\"auto\">
	\n\t<frame name=\"input\" src=\"input.$FILE_EXTENSION?enters=1&".session_name()."=".session_id()."\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\">
  \n\t<frame name=\"getlines\" src=\"getlines.$FILE_EXTENSION?Nick=".urlencode($nick)."&amp;pruef=$pruef&amp;channel=".urlencode($entry)."&amp;chanpruef=$chancrypt&amp;".session_name()."=".session_id()."&amp;init=1\" scrolling=\"no\">
	\n</frameset>\n</HTML>";
}else{
	echo "<frameset frameborder=1 border=1 framespacing=1 cols=* rows=0,$mod_frame_size,*,140,0>
  \n\t<frame name=\"dummy\" src=\"dummy.html\">
	\n\t<frame name=\"moderate\" src=\"edit.$FILE_EXTENSION\" scrolling=\"no\">
	\n\t<frame name=\"output\" src=\"output.$FILE_EXTENSION?Nick=".urlencode($nick)."&pruef=$pruef&channel=".urlencode($entry)."&chanpruef=$chancrypt\" scrolling=\"auto\">
	\n\t<frame name=\"input\" src=\"input.$FILE_EXTENSION?enters=1&Nick=".urlencode($nick)."&pruef=$pruef&channel=".urlencode($entry)."&chanpruef=$chancrypt&\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\">
  \n\t<frame name=\"getlines\" src=\"getlines.$FILE_EXTENSION?Nick=".urlencode($nick)."&amp;pruef=$pruef&amp;channel=".urlencode($entry)."&amp;chanpruef=$chancrypt&amp;init=1\" scrolling=\"no\">
	\n</frameset>\n</HTML>";
}
?>    


