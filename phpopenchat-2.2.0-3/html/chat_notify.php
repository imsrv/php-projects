<? // -*- C++ -*-
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
 * Include default values
 */
include "defaults_inc.php";

//start session
if($ENABLE_SESSION){
  @session_start();
}

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
  header("Status: 204 OK\r\n");//browser don't refresh his content
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

if($ENABLE_SESSION){
  $permissions = '<INPUT TYPE="hidden" NAME="'.session_name().'" VALUE="'.session_id().'">';
}else{
  $permissions = '<INPUT TYPE="hidden" NAME="nick" VALUE="'.$nick.'">
                  <INPUT TYPE="hidden" NAME="pruef" VALUE="'.$pruef.'">';
}

if($action=='list'){
  $result = mysql_query("SELECT * FROM chat_notify where Nick='$nick' order by Friend",$db_handle);
  $select_of_friends  = '<br><table align="center"><tr><td colspan="4"><font face="arial,helvetica,sans-serif" size="2">'.$MSG_FRIENDS_TIME.': '.date("H:i").'</font></td></tr><tr><td>&nbsp;</td></tr>';
  $select_of_friends .= '<tr><td width="120"><font face="arial,helvetica,sans-serif" size="2"><b>'.$MSG_FRIENDS_FRIEND.':</b></font></td><td width="70"></td><td width="150"><font face="arial,helvetica,sans-serif" size="2"><b>'.$MSG_FRIENDS_LAST_SEEN.':</b></font></td><td width="120"><font face="arial,helvetica,sans-serif" size="2"><b>'.$CHANNEL.':</b></font></td><td width="50"></td></tr><tr></tr>';
  while($row=mysql_fetch_object($result)){
    $friend = $row->Friend;
    $lastlogin = mysql_query("SELECT Zeit, Raum FROM chat_data where Nick='$friend'",$db_handle);
    $row_login = mysql_fetch_object($lastlogin);
    $showtime  = date("d.m.Y - H:i ",$row_login->Zeit);
    $select_of_friends .= '<tr><td><font face="arial,helvetica,sans-serif" size="2">'.$friend.'</font></td>';
    $online_status = mysql_query("SELECT Nick FROM chat where Nick='$friend'",$db_handle);
    if(mysql_num_rows($online_status)>0){
      $select_of_friends .= '<td><font face="arial,helvetica,sans-serif" size="2" color="#009900"><b>Online</b></font></td>';
    }else{
      $select_of_friends .= '<td><font face="arial,helvetica,sans-serif" size="2" color="#FF0000">Offline</font></td>';
    }
    $select_of_friends .= '<td><font face="arial,helvetica,sans-serif" size="2">'.$showtime.'</font></td>';
    $select_of_friends .= '<td><font face="arial,helvetica,sans-serif" size="2">'.$row_login->Raum.'</font></td>';
    if($ENABLE_SESSION){
      $select_of_friends .= '<td><a href="chat_notify.php?action=delete&amp;friend='.$friend.'&amp;nick='.urlencode($nick).'&amp;pruef='.$pruef.'&amp;'.session_name().'='.session_id().'"><font face="arial,helvetica,sans-serif" size="2">'.$DELETE.'</font></a></td></tr>';
    }else{
      $select_of_friends .= '<td><a href="chat_notify.php?action=delete&amp;friend='.$friend.'&amp;nick='.urlencode($nick).'&amp;pruef='.$pruef.'"><font face="arial,helvetica,sans-serif" size="2">'.$DELETE.'</font></a></td></tr>';
    }
  }
  $select_of_friends .= '</table><br>';
  mysql_free_result($result);
  include ("notify_list_tpl.php");
}
if($action=='delete'){
  $result = mysql_query("delete from chat_notify where Friend='$friend' && Nick='$nick'",$db_handle);
  header("location: chat_notify.$FILE_EXTENSION?action=list&nick=".urlencode($nick)."&pruef=$pruef&".session_name()."=".session_id());
}
if($action!='list'){
  if(!$friendsearch){
    $search_for_chatter  = '<font face="arial,helvetica,sans-serif" size="2">'.$MSG_FRIENDS_ADD_TITLE.':</font><br><br>';
    $search_for_chatter .= '<input name="friendsearch" value="'.$friendsearch.'" type="text" size="20" maxlength="20"> <input type="submit" value="'.$MSG_FRIENDS_SEARCH.'"><br>';
    $search_for_chatter .= nl.'<input name="nick" value="'.$nick.'" type="hidden">'.nl.'<input name="pruef" value="'.$pruef.'" type="hidden">'.nl.'<input name="'.session_name().'" value="'.session_id().'" type="hidden">';
  }
  if($friendsearch){
    $friendsearch=addslashes($friendsearch);
    $result = mysql_query("select Nick from chat_data where Nick like '$friendsearch%' AND Nick !='$nick' order by Nick",$db_handle);
    if(mysql_num_rows($result)>0){
      $show_search_result  = '<font face="arial,helvetica,sans-serif" size="2">'.$CHOOSE_NICK.':</font><br><br>';
      $show_search_result .= '<SELECT NAME="add_friend" SIZE="5">';
      $show_add_button = "TRUE";
    }else{
      $show_search_result  = '<font face="arial,helvetica,sans-serif" size="2" color="#FF0000"><strong>'.$NO_HIT.'</strong></font><br><br>';
      $show_search_result .= '<font face="arial, helvetica, sans-serif" size="2">'.$MSG_FRIENDS_ADD_TITLE.':</font><br><br>';
      $show_search_result .= '<input name="friendsearch" type="text" size="20" maxlength="20"> <input type="submit" value="'.$MSG_FRIENDS_SEARCH.'">';
      $search_for_chatter .= nl.'<input name="nick" value="'.$nick.'" type="hidden">'.nl.'<input name="pruef" value="'.$pruef.'" type="hidden">'.nl.'<input name="'.session_name().'" value="'.session_id().'" type="hidden">';
    }
    if(mysql_num_rows($result)==1){
      while($a=mysql_fetch_array($result)){
        $show_search_result .= "<OPTION VALUE=\"$a[Nick]\" selected>$a[Nick]";
      }
    }else{
      while($a=mysql_fetch_array($result)){
        $show_search_result .= "<OPTION VALUE=\"$a[Nick]\">$a[Nick]";
      }
    }
    $show_search_result .= '</select><br><br>';
    mysql_free_result($result);
  }
  if($show_add_button){
    $add_button = '<INPUT TYPE="submit" VALUE="'.$MSG_FRIENDS_ADD_BUTTON.'"><br>';
  }
  if($add_friend){  
    $result = mysql_query("INSERT INTO chat_notify (Nick,Friend) VALUES ('$nick','$add_friend')",$db_handle);
    header("location: chat_notify.$FILE_EXTENSION?action=list&nick=".urlencode($nick)."&pruef=$pruef&".session_name()."=".session_id());
  }
include("notify_add_tpl.php");
}
mysql_close($db_handle);
?>
