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

// Function to input a text line in the database
include "write_line_inc.php";

// Check if chatter is kicked
$result=mysql_query("SELECT Nick FROM chat_data WHERE Nick = '$nick' AND Passwort= '$SPERRPASSWORT'",$db_handle);
if(mysql_num_rows($result)==1)
{

    echo "<html><title>$MSG_INVITE</title>";
    echo "<body bgcolor=\"white\"><br><font color=\"red\" size=\"+1\">";
    echo "<center>$MSG_KICKED</center>";
    echo "</font></body></html>";

}
else
{

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

    //delete a chatter from the group of invited chatter
    if($group=="invited_chatter"){
        //get all of the already invited chatter of nickname
        $result=mysql_query("SELECT Allow FROM channels WHERE Name = '$nick'",$db_handle);
        if(mysql_num_rows($result)==1){

        /**
        * Invited chatter
        *
        * contains a list of invited chatter seperated by "|"
        *
        * @var string $invited_chatter
        */
        $invited_chatter = mysql_result($result,0,"Allow");
        }
        mysql_free_result($result);

        $invited_chatter = str_replace("|$chatter_to_del|","|",$invited_chatter);
        if($invited_chatter=="|"){
        $result=mysql_query("UPDATE channels SET Allow='' WHERE name='$nick'",$db_handle);
        }else{
        $result=mysql_query("UPDATE channels SET Allow='$invited_chatter' WHERE name='$nick'",$db_handle);
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

    //add a chatter from the group of invited chatter
    if($group=="invited_chatter"){
        //get all of the already invited chatter of nickname
        $result=mysql_query("SELECT Allow FROM channels WHERE Name = '$nick'",$db_handle);
        if(mysql_num_rows($result)==1){

        /**
        * Invited chatter
        *
        * contains a list of invited chatter seperated by "|"
        *
        * @var string $invited_chatter
        */
        $invited_chatter = mysql_result($result,0,"Allow");
        }
        mysql_free_result($result);

        if($invited_chatter==""){
        $invited_chatter="|";
        }
        $invited_chatter = "|$chatter_to_add$invited_chatter";
        $result=mysql_query("UPDATE channels SET Allow='$invited_chatter' WHERE name='$nick'",$db_handle);

        return TRUE;
    }

    return FALSE;
    }
    //get invited chatter
    $result=mysql_query("SELECT Allow FROM channels WHERE Name = '$nick'",$db_handle);
    if(mysql_num_rows($result)==1){

        /**
        * Invited chatter
        *
        * contains a list of invited chatter seperated by "|"
        *
        * @var string $invited_chatter
        */
        $invited_chatter = mysql_result($result,0,"Allow");
    }
    mysql_free_result($result);
    //all of not invited chatter
    $nick_result=mysql_query("SELECT Nick FROM chat WHERE Nick <> '$nick' ORDER BY Nick",$db_handle);
    $select_of_all_chatters = "\n\t\t\t\t\t<SELECT SIZE=\"5\" NAME=\"chatter\">";
    $select_of_not_invited = "\n\t\t\t\t\t<SELECT SIZE=\"5\" NAME=\"austritt\">";
    while($i=mysql_fetch_array($nick_result)){
    // check, if already invited
    $temp=$i["Nick"];
    if((!ereg($temp,$invited_chatter) && $temp!=$austritt) || $temp==$eintritt){
        $select_of_all_chatters .= "\n\t\t\t\t\t\t<OPTION VALUE=\"";
        $select_of_all_chatters .= $i["Nick"];
        $select_of_all_chatters .= "\">";
        $select_of_all_chatters .= $i["Nick"];
        $select_of_all_chatters .= "</OPTION>";

        $select_of_not_invited .= "\n\t\t\t\t\t\t<OPTION VALUE=\"";
        $select_of_not_invited .= $i["Nick"];
        $select_of_not_invited .= "\">";
        $select_of_not_invited .= $i["Nick"];
        $select_of_not_invited .= "</OPTION>";
    }

    }
    $select_of_all_chatters .= "\n\t\t\t\t\t</SELECT>";
    $select_of_not_invited .= "\n\t\t\t\t\t</SELECT>";

    $result=mysql_query("SELECT Allow FROM channels WHERE Name = '$nick'",$db_handle);
    if(mysql_num_rows($result)>0){$kick = mysql_result($result,0,"Allow");}

    if(($raus)&&($eintritt)){

    //del a chatter from the list of already invited chatters
    if(!del_chatter($nick,$eintritt,"invited_chatter")){
        echo "Error while deleting a chatter from the group of invited users.";
        exit;
    }

    $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$eintritt'",$db_handle),0,"Raum");
    schreib_zeile("<!-- ||0|0|0|--><b><font color=#88EFEF>$nick:</font></b> <STRONG>$eintritt</STRONG> $IS_DISCHARGED.",$channel);
    }

    if(($rein)&&($austritt)){

      //add a chatter to the list of already invited chatters
    if(!add_chatter($nick,$austritt,"invited_chatter")){
        echo "Error while adding a chatter from the group of invited users.";
        exit;
    }

    $channel=mysql_result(mysql_query("SELECT Raum FROM chat WHERE Nick='$austritt'",$db_handle),0,"Raum");
    schreib_zeile("<!-- ||0|0|0|--><b><font color=#88EFEF>$nick:</font></b> <STRONG>$austritt</STRONG> $IS_INVITED",$channel);
    }

    $result=mysql_query("SELECT Allow FROM channels WHERE Name='$nick'",$db_handle);
    if(mysql_num_rows($result)>0){
    $tmp=mysql_result($result,0,"Allow");
    }
    mysql_free_result($result);
    mysql_close($db_handle);


    //selection of all invited chatter
    $option_value = explode("|",$tmp);
    $i=1;
    $select_of_invited_chatter = "\n\t\t\t\t\t<SELECT SIZE=\"5\" NAME=\"eintritt\">";
    while($option_value[$i]){
    if($option_value[$i]!=$nick){
        $select_of_invited_chatter .= "\n\t\t\t\t\t\t<OPTION VALUE=\"".$option_value[$i]."\">";
        $select_of_invited_chatter .= $option_value[$i]."</OPTION>";
    }
    $i++;
    }
    $select_of_invited_chatter .= "\n\t\t\t\t\t</SELECT>";
    include("invite_tpl.php");
}
?>