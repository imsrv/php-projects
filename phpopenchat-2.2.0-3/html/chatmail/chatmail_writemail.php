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

$chatmail_heading = $WRITE_MAIL;

if($send && $chat){
	if($mail_to){
		$chat   = str_replace('>','&gt;',$chat);
		$chat   = str_replace('<','&lt;',$chat);
		$chat   = strip_tags($chat);
		$chat   = str_replace("'","&#39",$chat);
		if($subject==''){
			$subject = $NOSUBJECT;
		}else{
			$subject = strip_tags($subject);
			$subject = str_replace("'","&#39",$subject);
		}
		$update = mysql_query("INSERT INTO chat_mail (NICK,SENDER,BODY,TIME,SUBJECT,UNREAD)VALUES('$mail_to','$nick','$chat',CURRENT_TIMESTAMP(),'$subject',0)",$db_handle);
		$select_msg_to = '<div align="center"><font color="#007B39"><strong>'.$SEND_SUCCESS.'</strong></font><br><br></div>';
	}else{
		$select_msg_to = '<div align="center"><font color="#FF0000"><strong>'.$NO_SELECTION.'</strong></font><br></div>';
	}
}
if($search){
	$search=addslashes($search);
	$query = "select Nick from chat_data where Nick like '$search%' AND Nick !='$nick' AND Zeit>(UNIX_TIMESTAMP()-($LAST_TIME_ONLINE*24*60*60)) order by Nick";
	$result=mysql_query($query,$db_handle);
	if(mysql_num_rows($result)>0){
		$select_msg_to  = '<table><tr><td width="80"></td><td><font face="arial,helvetica,sans-serif" size="2">'.$CHOOSE_NICK.':</font></td></tr>';
		$select_msg_to .= '<tr><td></td><td><SELECT NAME="mail_to" SIZE="5">';
		$show_content = TRUE;
	}else{
		$select_msg_to  = '<div align="center"><font color="#FF0000"><strong>'.$NO_HIT.'</strong></font><br>';
		$select_msg_to .= '<br><font face="arial, helvetica, sans-serif" size="2">'.$MSG_SEND_TO.'</font><br><br>';
    		$select_msg_to .= '<input name=search value="'.$search.'"> <input type=submit value="'.$GO.'"><br><br>';
	}
	if(mysql_num_rows($result)==1){
		while($a=mysql_fetch_array($result)){
			$select_msg_to .= "<OPTION VALUE=\"$a[Nick]\" selected>$a[Nick]";
		}
	}else{
		while($a=mysql_fetch_array($result)){
 			$select_msg_to .= "<OPTION VALUE=\"$a[Nick]\">$a[Nick]";
		}
	}
	$select_msg_to .= '</select></td></tr></table><br>';
	$select_msg_to .= '<input type=hidden name=send value="1">';
}
elseif(!$ID){
    $show_subjects  = '<div align="center"><font face="arial, helvetica, sans-serif" size="2">'.$MSG_SEND_TO.'</font><br><br>';
    $show_subjects .= '<input name=search value="'.$search.'"> <input type=submit value="'.$GO.'"><br><br>';
}
if($what=='answer'){
	$query= " select TIME, SENDER, SUBJECT, BODY from chat_mail where NICK='$nick' && ID=$ID";
	$result= mysql_query($query,$db_handle);
	$row=mysql_fetch_array($result);
	$showtime = substr($row[TIME],8,2).".";
	$showtime .= substr($row[TIME],5,2).".";
	$showtime .= substr($row[TIME],0,4)." - ";
	$showtime .= substr($row[TIME],11,5);
	$select_msg_to  = '<table><tr><td width="80" align="right"><font face="arial,helvetica,sans-serif" size="2">'.$RECEIPIENT.':</font></td><td><input name="mail_to" maxlength="50" size="20" value="'.$row[SENDER].'"></td></tr></table>';
	//now insert > on every line
	if(substr($row[SUBJECT],0,3) != "RE:"){
		$subject = 'RE: '.$row[SUBJECT];
	}else{
		$subject = $row[SUBJECT];
	}
	$row[BODY]="&gt; ".$row[BODY];
	$row[BODY] = str_replace(nl,nl.'&gt; ',$row[BODY]);
	// now put $text_content together
	$text_content = '('.$showtime.') '.$row[SENDER].' '.$WROTE.':'.nl.$row[BODY].nl;
	$content  = '<table><tr><td width="80" align="right"><font face="arial,helvetica,sans-serif" size="2">'.$SUBJECT.':</font></td><td><input name="subject" maxlength="50" size="50" value="'.$subject.'"></td></tr>';
	$content .= '<tr><td align="right" valign="top"><font face="arial,helvetica,sans-serif" size="2">'.$MESSAGE.':</font></td><td><TEXTAREA NAME="chat" rows="15" cols="50" WRAP="VIRTUAL">'.$text_content.'</TEXTAREA></td></tr>';
	$content .= '<tr><td></td><td><INPUT TYPE="submit" VALUE="'.$SENDMAIL.'"> <INPUT TYPE="reset" Value=" '.$CLEAR.' "></td></tr></table>';
	$show_subjects = '<input type=hidden name=send value="1"><br>';
	@mysql_free_result($result);
}
if($show_content){
  $content  = '<table><tr><td width="80" align="right"><font face="arial,helvetica,sans-serif" size="2">'.$SUBJECT.':</font></td><td><input name="subject" maxlength="50" size="50" value="'.$subject.'"></td></tr>';
  $content .= '<tr><td align="right" valign="top"><font face="arial,helvetica,sans-serif" size="2">'.$MESSAGE.':</font></td><td><TEXTAREA NAME="chat" rows="15" cols="50" WRAP="VIRTUAL">'.$text_content.'</TEXTAREA></td></tr>';
  $content .= '<tr><td></td><td><INPUT TYPE="submit" VALUE="'.$SENDMAIL.'"> <INPUT TYPE="reset" Value=" '.$CLEAR.' "></td></tr></table>';
}

mysql_close($db_handle);

if($ENABLE_SESSION){
  $inbox_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}
else{
  $inbox_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_inbox.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
if($ENABLE_SESSION){
  $write_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_writemail.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}
else{
  $write_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_writemail.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
if($ENABLE_SESSION){
  $sent_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_sentmail.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'">';
}
else{
  $sent_mail_link = '<A HREF="'.$INSTALL_DIR.'/chatmail/chatmail_sentmail.'.$FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'">';
}
include("messages_tpl.php");
?>