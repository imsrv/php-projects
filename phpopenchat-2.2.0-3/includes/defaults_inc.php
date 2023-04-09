<?
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
 * Show debugging informations
 *
 * $debug = FALSE; Set to 'no debugging informations'
 * $debug = TRUE; to 'Show debugging informations'
 */
$debug = FALSE;
Error_Reporting(7);

/*
 * Choose language file
 * language you want the chat to talk with
 */
//include "german_inc.php";
//include "french_inc.php";
//include "spanish_inc.php";
include "english_inc.php";

/*
 * Some default variables
 * Note: Values for server or path names without trailing slash
 */
$CHATNAME	  = "PHPOpenChat";
$MAX_NICK_LENGTH  = 15;
$FILE_EXTENSION	  = "php";
$INSTALL_DIR	  = "/phpopenchat";//no trailing slash. leave it blank, if you use the root directory of your webserver
//change it to the server name where your chat is installed
$CHATSERVERNAME   = "http://<your hostname>";//no trailing slash
$BACKGROUNDIMAGE  = "images/hauskopf.gif";
$DATABASENAME     = "phpopenchat";
$DATABASEHOST     = "localhost";
$DATABASEUSER     = "phpopenchat";
$DATABASEPASSWD   = "<your mysql password>";
$CONNECT_TRIES	  = 10;//tries to connect to database before an error occured

/*
 * if you modify the variable ENTRYCHANNELNAME, 
 * you have to create a new channel also
 * which has this new name.
 */
$ENTRYCHANNELNAME = "Channel_1";
$MAX_LINE_LENGTH  = "500";
$ROW_BUFFER_SIZE  = 40;
$MODERATOR_RATE   = 500;
$LAST_TIME_ONLINE = 28;//days of inactivity before a user is kicked automaticly
$ADDITIONAL_LETTERS= "Ü Ö Ä ü ö ä ß é";//additional letters allowed for nickname
$ENABLE_SESSION   = TRUE;//set to FALSE if you use PHP3!
$USERIMG_MAX_BYTES= 15000;
$USERIMG_IMGSIZE_X= 16;
$USERIMG_IMGSIZE_Y= 16;
$SESSION_NAME	  = "PHPOPENCHAT_ID";
$VERSION_NUMBER	  = "2.2.0";

// Path to the admin-module
$ADMIN_DIR = "$INSTALL_DIR/admin";

// the forbidden words are separated by a pipe symbol ('|').
// Note: The more you add the slower the chat!
$NO_NO_WORDS 	  = " pisser| [a|ä|Ä]rsch| arse|asshole|shit|votze|fick|bums| vögeln | rammeln | blasen | wiks | wichs | wix | abspritz| fuck| suck| porn|hure|pussy | nutte|flitchen| bitch|fotze|muschi|cunt|pimmel|drecksack|sackgesicht|titte|tits|sieg heil| hitler";
$NICK_NOT_ALLOWED = "|^join$|^msg$|^me$|^locate$|^announce$";

//salt variable definition for the function crypt()
//for safety reasons, it is very IMPORTANT to modify the value of this variable!
$pass_phrase     = "Please enter here some text!";

/*
** streaming text time (the value 10 stands for 3 minutes)
** after this time it appears a link like 'update text' in
** the text frame. (for onlookers only)
*/
$COUNT_BEFORE_RELOAD=20;
$FORUMDATE        = 30;//selects all forum-entries from the last [$FORUMDATE] days
$KICK_COUNT	  = 15;//anzahl der ignorierenden chatter, bevor gekickt wird
$SPERRPASSWORT    = substr($pass_phrase.$nick,5,8);
$MAIL_TEXT_COLOR  = "#7fff00";
$MODERATOR_COLOR  = "#88ffff";
$COMODERATOR_COLOR= "#ffff88";
$VIP_COLOR	  = "#88ff88";
$PATEN_COLOR      = "#ff3333";
$CHAT_TEXT_SIZE	  = "12px";//don't forget 'px', it's css!
$PRIVAT_ICON_PATH = "images/chatter/";
$ICON_PATH        = "images/smileys/";
$BG_IMAGE	  = "images/chat_bg.gif";
$LOGO		  = "images/exit_logo.gif";
$TEAM_MAIL_ADDR   = "team@ortelius.de";
$DYNAMIC_SLEEP	  = 50;
$LOOK_IN_COLOR	  = '#dedede';
$DEFAULT_TEXT_COLOR = '#e1e1e1';
$DEFAULT_BG_COLOR='#284628';

/*
** Interface controls
*/
$SHOW_TIME	  = TRUE;
$IRC_COMMANDS	  = TRUE;
$SELECT_CHANNEL   = TRUE;
$SELECT_USER	  = TRUE;
$CHANGE_SCROLLING = TRUE;
$SET_STATUSFILTER = TRUE;
$SET_TWADDLEFILTER= TRUE;
$BUTTON_HELP	  = TRUE;
$BUTTON_FORUM	  = TRUE;
$BUTTON_MESSAGES  = TRUE;
$BUTTON_IGNORE    = TRUE;
$CHANGE_COLOR_LINK= TRUE;
$WISPERING	  = TRUE;
$BUTTON_NOTIFY	  = TRUE;
$BUTTON_WHOISONLINE=TRUE;
/////////////////////////////////////////////////////////////////////////////

//register session
if($ENABLE_SESSION){
  include("session_inc.php");
}

/* 
 * For compatibility of includes from output.php and input.php
 */
if(!$nick){
  $nick = $Nick;
}

if($nick && !$salt_nick){
  if($$SESSION_NAME){
    $salt_nick     = substr(md5($$SESSION_NAME.$pass_phrase),strlen($pass_phrase)%30,2);
  }else{
    $salt_nick     = substr(md5($nick.$pass_phrase),strlen($pass_phrase)%30,2);
  }
  $salt_channels = $salt_nick;
}

/*
** Browser check
*/
//Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0)
//Mozilla/4.73 [de]C-CCK-MCD DT (WinNT; U)
if(!$BROWSER_NAME){
  if(ereg("MSIE ",$HTTP_USER_AGENT)){
    $BROWSER_NAME    = "ie";//Internet Explorer
  }else{
    if(substr($HTTP_USER_AGENT,0,10)=='Mozilla/4.'){
      $BROWSER_NAME    = "nn";//Netscape Navigator
    }else{
      $BROWSER_NAME    = "mz";//Netscape 6
    }
  }
}
if($entry){
  $ENTRYCHANNELNAME = $entry;
}

//function to check access permissions of a page
include ("check_permissions_inc.php");
// define new line as a constant
define ('nl', "\n");
define ('tab',"\t");
?>
