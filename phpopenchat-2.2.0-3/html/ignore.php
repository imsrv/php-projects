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

//Function to input a text line in the database
include "write_line_inc.php";

/**
 * Check for godfather of chat
 *
 * The godfathers of chat gets more rights in the chat.
 *
 * @var integer $pate
 */
$result=mysql_query("SELECT count(*) AS count FROM paten WHERE Nick = '$nick'",$db_handle);
$pate=mysql_result($result,0,"count");
if($pate){
  $paten_msg = "<FONT COLOR=\"#ff0000\">$MSG_IGNORE_PATEN</FONT>";
}
mysql_free_result($result);

/**
 * Deletes a chatter from group
 *
 * @param string $nick
 * @param string $chatter_to_del
 * @param string $group
 * @global $db_handle
 * @author Michael Oertel <michael@ortelius.de>
 */
function del_chatter($nick,$chatter_to_del,$group){
  global $db_handle;
  
  //delete a chatter from the group of ignored chatter
  if($group=="ignored_chatter"){
    //get all of the already ignored chatter of nickname
    $result=mysql_query("SELECT Ignor FROM chat WHERE Nick = '$nick'",$db_handle);
    if(mysql_num_rows($result)==1){
      
      /**
       * Ignored chatter
       * 
       * contains a list of ignored chatter seperated by "|"
       *
       * @var string $ignored_chatter
       */
      $ignored_chatter = mysql_result($result,0,"Ignor");
    }
    mysql_free_result($result);
    
    $ignored_chatter = str_replace("|$chatter_to_del|","|",$ignored_chatter);
    if($ignored_chatter=="|"){
      $result=mysql_query("UPDATE chat SET Ignor='' WHERE Nick='$nick'",$db_handle);
    }else{
      $result=mysql_query("UPDATE chat SET Ignor='$ignored_chatter' WHERE Nick='$nick'",$db_handle);
    }
    
    return TRUE;
  }
 
  return FALSE;
}

/**
 * Adds a chatter to group
 *
 * @param string $nick
 * @param string $chatter_to_add
 * @param string $group
 * @global $db_handle
 * @author Michael Oertel <michael@ortelius.de>
 */
function add_chatter($nick,$chatter_to_add,$group){
  global $db_handle;
  
  //add a chatter from the group of ignored chatter
  if($group=="ignored_chatter"){
    //get all of the already ignored chatter of nickname
    $result=mysql_query("SELECT Ignor FROM chat WHERE Nick = '$nick'",$db_handle);
    if(mysql_num_rows($result)==1){
      
      /**
       * Ignored chatter
       * 
       * contains a list of ignored chatter seperated by "|"
       *
       * @var string $ignored_chatter
       */
      $ignored_chatter = mysql_result($result,0,"Ignor");
    }
    mysql_free_result($result);
    
    if($ignored_chatter==""){
      $ignored_chatter="|";
    }
    $ignored_chatter = "|$chatter_to_add$ignored_chatter";
    $result=mysql_query("UPDATE chat SET Ignor='$ignored_chatter' WHERE Nick='$nick'",$db_handle);

    return TRUE;
  }
 
  return FALSE;
}

if(($del)&&($ignored_chatter)){
  // the form button "-- >>" is pressed and a chatter was selected
  // the chatter is no longer ignored

  if(!del_chatter($nick,$ignored_chatter,"ignored_chatter")){
    echo "Error while deleting a chatter from the group of ignored users.";
    exit;
  }
}

if(($add)&&($chatter)){
  // the form button "<< --" is pressed and a chatter to ignore was selected
  // the chatter will be ignored
  
  if(!add_chatter($nick,$chatter,"ignored_chatter")){
    echo "Error while adding a chatter to the group of ignored users.";
    exit;
  }

  /**
   * Examination, how often the chatter was ignored already by other users
   *
   * If the ignored chatter ignored by more than $KICK_COUNT chatters, 
   * the chatter will be kicked out of the chat.
   *
   * @var integer $ignore_count
   */
  $ignore_count=mysql_result(mysql_query("SELECT count(*) AS count FROM chat WHERE Ignor LIKE '%|$chatter|%'",$db_handle),0,"count");
  if($ignore_count>=$KICK_COUNT){
    $result=mysql_query("UPDATE chat SET User_busy=2 WHERE Nick='$chatter'",$db_handle);
    $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$chatter'",$db_handle),0,"Raum");
    schreib_zeile("<!-- ||0|0|0|--><b><font color=#88EFEF>$MODERATOR_NAME:</font></b> <STRONG>$chatter</STRONG> <EM>$KICKED</EM>.",$channel);
  }

  if($pate){
    /**
     * the current user is a godfather so he kick a chatter by ignoring them.
     */
    $result=mysql_query("SELECT count(*) AS count FROM paten WHERE Nick = '$chatter'",$db_handle);
    $patencheck=mysql_result($result,0,"count");
    if($patencheck==0){
      $result=mysql_query("UPDATE chat SET User_busy=2 WHERE Nick='$chatter'",$db_handle);
      $result=mysql_query("UPDATE chat_data SET Passwort='$SPERRPASSWORT' WHERE Nick='$chatter'",$db_handle);
      $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$chatter'",$db_handle),0,"Raum");
      schreib_zeile("<!-- ||0|0|0|--><b><font color=#88EFEF>$MODERATOR_NAME:</font></b> <STRONG>$chatter</STRONG> <EM>$KICKED</EM>!",$channel);
    }
  }
  $ignore_hint  = "<BR>$MSG_IGNORE_NUMBER: <STRONG>$ignore_count</STRONG>";
  $ignore_hint .= "<BR>$MSG_IGNORE_ALSO: <STRONG>".$KICK_COUNT."</STRONG>";
}

$result=mysql_query("SELECT Ignor FROM chat WHERE Nick = '$nick'",$db_handle);
if(mysql_num_rows($result)==1){
  $kick = mysql_result($result,0,"Ignor");
}

$option_value = explode("|",$kick);
$select_of_ignored_chatter = "\n\t\t\t\t\t<SELECT SIZE=\"5\" NAME=\"ignored_chatter\">";
$i=1;
while($option_value[$i]){
  $select_of_ignored_chatter .= "\n\t\t\t\t\t\t<OPTION VALUE=\"$option_value[$i]\">";
  $select_of_ignored_chatter .= "$option_value[$i]\n";
  $i++;
}
$select_of_ignored_chatter .= "\n\t\t\t\t\t</SELECT>";


//all of not kicked chatter	
$nick_result=mysql_query("SELECT Nick FROM chat WHERE Nick <> '$nick' ORDER BY Nick",$db_handle);
$select_of_all_chatters = "\n\t\t\t\t\t<SELECT SIZE=\"5\" NAME=\"chatter\">";
while($i=mysql_fetch_array($nick_result)){
  // check, if already kicked
  $temp=$i["Nick"];
  if(!ereg($temp,$kick)){
    $select_of_all_chatters .= "\n\t\t\t\t\t\t<OPTION VALUE=\"";
    $select_of_all_chatters .= $i["Nick"];
    $select_of_all_chatters .= "\">";
    $select_of_all_chatters .= $i["Nick"];
    $select_of_all_chatters .= "</OPTION>";
  }
}
$select_of_all_chatters .= "\n\t\t\t\t\t</SELECT>";

$result=mysql_query("SELECT Allow FROM channels WHERE Name = '$nick'",$db_handle);
if(mysql_num_rows($result)>0){$kick = mysql_result($result,0,"Allow");}

$result=mysql_query("SELECT Allow FROM channels WHERE Name='$nick'",$db_handle);
if(mysql_num_rows($result)>0){
  $tmp=mysql_result($result,0,"Allow");
}
mysql_free_result($result);
mysql_close($db_handle);

include("ignore_tpl.php");
?>
