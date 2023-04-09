<?//-*- C -*-
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

/** description of UNREAD variable in table chat_mail
 * if UNREAD is set to:
 * 0 = mail is unread, will be shown in output and is deleted by nobody
 * 1 = mail is unread, will be shown in output and is deleted by sender
 * 2 = mail is unread and deleted by nobody
 * 3 = mail is unread and deleted by sender
 * 4 = mail is read and deleted by nobody
 * 5 = mail is read and deleted by sender
 * 6 = mail is read and deleted by receipient
 */


/**
 * Include default values
 */
include "defaults_inc.php";

//start session
if($ENABLE_SESSION){
  @session_start();
}
$nick=urldecode($nick);

/**
 * Check for access permissions of this page
 *
 * compare the given and the calculated checksum,
 * if they don't match the user has no permissions
 * and the script ends by printing a status header of 204
 * (no content change by client browser)
 */
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK");//browser don't refresh his content
  exit;
}

/**
 * Open a database connection
 *
 * This include returns a database identifier '$db_handle'
 * used by some database querys.
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}

$chatmail_heading = $INBOX;
if(!$ID){
	$query="select ID,SENDER, SUBJECT, UNREAD, TIME from chat_mail where NICK='$nick' AND UNREAD < '6' order by TIME desc ";
	$result=mysql_query($query,$db_handle);
	$show_subjects = '<br><table><tr><td width="35"></td><td width="110"><font face="arial,helvetica,sans-serif" size="2">'.$SENDER.'</font></td><td width="250"><font face="arial,helvetica,sans-serif" size="2">'.$SUBJECT.'</font></td><td width="120"><font face="arial,helvetica,sans-serif" size="2">'.$RECEIVED.'</font></td></tr><tr></tr>';
	while($row=mysql_fetch_array($result)){
		//changes date and time to DD.MM.YYYY - HH:MM
		$showtime = substr($row[TIME],8,2).".";
		$showtime .= substr($row[TIME],5,2).".";
		$showtime .= substr($row[TIME],0,4)." - ";
		$showtime .= substr($row[TIME],11,5);	
		$show_subjects .= '<tr><td valign="middle" align="left">';
		if($row[UNREAD] < "4"){
			$show_subjects .= '<img src="'.$CHATSERVERNAME.''.$INSTALL_DIR.'/images/new.gif">';
		}
		$show_subjects .= '</td><td valign="top"><b><font face="arial,helvetica,sans-serif" size="2">'.$row[SENDER].'</b></font></td><td valign="top"><font face="arial,helvetica,sans-serif" size="2">';
		if($row[UNREAD] < "4"){
			$show_subjects .= '<b>';
 		}
    if($ENABLE_SESSION){
      $show_subjects .= '<a href="'.$CHATSERVERNAME.''.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?what=showdetail&ID='.$row[ID].'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'&'.session_name().'='.session_id().'">'.wordwrap($row[SUBJECT],30,"\n",1).'</a>';
    }else{
      $show_subjects .= '<a href="'.$CHATSERVERNAME.''.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?what=showdetail&ID='.$row[ID].'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'">'.wordwrap($row[SUBJECT],30,"\n",1).'</a>';
    }
		if($row[UNREAD] < "4"){
			$show_subjects .= '</b>';
		}
		$show_subjects .= '</font></td><td valign="top"><font face="arial,helvetica,sans-serif" size="2">';
		if($row[UNREAD] < "4"){
			$show_subjects .= '<b>';
		}
		$show_subjects .= $showtime;
		if($row[UNREAD] < "4"){
			$show_subjects .= '</b>';
		}
		$show_subjects .= '</font></td></tr>';
	}
	$show_subjects .= '</table><br>';
	@mysql_free_result($result);
}
if($what=='showdetail'){
	$query= " select TIME, SENDER, SUBJECT, BODY, UNREAD from chat_mail where NICK='$nick' AND ID=$ID";
	$result= mysql_query($query,$db_handle);
	$row=mysql_fetch_array($result);
	$showtime = substr($row[TIME],8,2).".";
	$showtime .= substr($row[TIME],5,2).".";
	$showtime .= substr($row[TIME],0,4)." - ";
	$showtime .= substr($row[TIME],11,5);
	if($row[UNREAD]=="2"){
		$query = "update chat_mail set unread=4 where ID=$ID";
		$result=mysql_query($query,$db_handle);
	}
	elseif($row[UNREAD]=="3"){
		$query = "update chat_mail set unread=5 where ID=$ID";
		$result=mysql_query($query,$db_handle);
	}
	$show_subjects = '<br><table>';
	$show_subjects .= '<tr><td align=right width="80">'.$SENDER.': </td><td width="370" align=left><b>'.$row[SENDER].'</b></td></tr>';
	$show_subjects .= '<tr><td align=right>'.$RECEIVED.': </td><td align=left><b>'.$showtime.'</b></td></tr>';
	$show_subjects .= '<tr><td align=right>'.$SUBJECT.': </td><td align=left><b>'.$row[SUBJECT].'</b></td></tr>';
	$show_subjects .= '<tr><td align=right valign=top>'.$MESSAGE.': </td><td bgcolor="#ddffdd" align=left>'.nl2br(wordwrap($row[BODY],50,"\n",1)).'</td></tr><tr><td></td><td>[ ';
	if($row[SENDER]!=$MODERATOR_NAME && $row[SENDER]!=$TEAM_NAME){
    if($ENABLE_SESSION){
      $show_subjects .= '<a href="chatmail_writemail.'.$FILE_EXTENSION.'?what=answer&ID='.$ID.'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'&'.session_name().'='.session_id().'">'.$ANSWER.'</a> | ';
    }else{
      $show_subjects .= '<a href="chatmail_writemail.'.$FILE_EXTENSION.'?what=answer&ID='.$ID.'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'">'.$ANSWER.'</a> | ';
    }
	}
  if($ENABLE_SESSION){
    $show_subjects .= '<a href="chatmail_inbox.'.$FILE_EXTENSION.'?what=delete&ID='.$ID.'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'&'.session_name().'='.session_id().'">'.$DELETE.'</a> ';
  }else{
    $show_subjects .= '<a href="chatmail_inbox.'.$FILE_EXTENSION.'?what=delete&ID='.$ID.'&nick='.urlencode($nick).'&pruef='.urlencode($pruef).'">'.$DELETE.'</a> ';
  }
	$show_subjects .= ']</td></tr></table><br>';
	@mysql_free_result($result);
}
elseif($what=='delete'){
	settype($ID,'integer');
	$query="select UNREAD from chat_mail where ID=$ID && NICK='$nick'";
	$result=mysql_query($query,$db_handle);
	$row=mysql_fetch_array($result);
	if($row[UNREAD]=="4"){
		$query="update chat_mail set UNREAD=6 where ID=$ID && NICK='$nick'";
		$result=mysql_query($query,$db_handle);
	}
	elseif($row[UNREAD]=="5"){
		$query="delete from chat_mail where ID=$ID && NICK='$nick'";
		$result=mysql_query($query,$db_handle);
	}
	@mysql_free_result($result);
  if($ENABLE_SESSION){
    header("location: chatmail_inbox.$FILE_EXTENSION?nick=".urlencode($nick)."&pruef=$pruef&".session_name()."=".session_id());
  }else{
    header("location: chatmail_inbox.$FILE_EXTENSION?nick=".urlencode($nick)."&pruef=$pruef");
  }
}
mysql_close($db_handle);

if($ENABLE_SESSION){
  $inbox_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}else{
  $inbox_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
if($ENABLE_SESSION){
  $write_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_writemail.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}else{
  $write_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_writemail.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
if($ENABLE_SESSION){
  $sent_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_sentmail.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}else{
  $sent_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_sentmail.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
include("messages_tpl.php");
?>
