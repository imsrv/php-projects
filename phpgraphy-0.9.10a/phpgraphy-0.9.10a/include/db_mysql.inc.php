<?php
/*
*  Copyright (C) 2004-2005 JiM / aEGIS (jim@aegis-corp.org)
*  Copyright (C) 2000-2001 Christophe Thibault
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
*  $Id: db_mysql.inc.php 196 2005-10-18 16:10:10Z jim $
*
*/

// MySQL access layer functions

function quote_smart($value)
{
    // Stripslashes (Commented out because we've handled this at the user input validation level)
    /*
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    */

    $value = "'" . mysql_real_escape_string($value) . "'";

    return $value;
}

// To ensure compatibility with PHP < 4.3.0, we'll create a mysql_real_escape_string() equiv
// TODO


function get_comment($nom)
{
  global $sDB,$nConnection,$sTable;

  $query="SELECT * FROM $sTable WHERE name=".quote_smart($nom);

  $res=mysql_db_query($sDB,$query,$nConnection);
  if (!$res) return; 
  $row=mysql_fetch_array($res);
  return $row["descr"];

}

function get_rating($nom)
{
  global $sDB,$nConnection,$sTableRatings;

  $query="SELECT AVG(rating), COUNT(*) FROM $sTableRatings WHERE pic_name=".quote_smart($nom);

  $res=mysql_db_query($sDB,$query,$nConnection);
  if (!$res) return; 
  $row=mysql_fetch_array($res);
  return ($row[1]?$row[0]:false);
}

function already_rated($nom)
{
  global $sDB,$nConnection,$sTableRatings;

  $query="SELECT * FROM $sTableRatings WHERE pic_name=".quote_smart($nom)." and ip='".getenv("REMOTE_ADDR")."'";

  $res=mysql_db_query($sDB,$query,$nConnection);
  if (!$res) return; 
  $row=mysql_fetch_array($res);
  return($row);
}

function get_level_db($name)
{
  global $sDB,$nConnection,$sTable;

  $query="SELECT * FROM $sTable WHERE name=".quote_smart($name);

  $res=mysql_db_query($sDB,$query,$nConnection);
  if (!$res) return;
  $row=mysql_fetch_array($res);
  return (int)$row["seclevel"];
}

function get_nb_comments($name)
{
  global $sDB,$nConnection,$sTableComments;

  $query="SELECT * FROM ".$sTableComments." WHERE pic_name=".quote_smart($name);

  $res=mysql_db_query($sDB,$query,$nConnection);
  return mysql_num_rows($res);
}

function get_user_comments($id) 
{
    global $sDB,$nConnection,$sTableComments;

    $query="SELECT * FROM ".$sTableComments." WHERE pic_name=".quote_smart($id);

    $res=mysql_db_query($sDB,$query,$nConnection);
    if (!$res) return;
    $i=0;
    while($row=mysql_fetch_array($res)) {
        $ret[$i][0]=$row["user"];
        $ret[$i][1]=$row["datetime"];
        $ret[$i][2]=$row["comment"];
        $ret[$i][3]=$row["ip"];
        $ret[$i][4]=$row["id"];
        $i++;
    }
    return $ret;
}

function get_last_commented($dir = null, $nb_last_commented = 15, $seclevel = 0)
{
    global $sDB,$nConnection,$sTableComments;

    $dir=stripcslashes($dir);
    if ($dir == "/") unset($dir);
    if (!isset($seclevel)) $seclevel=0;

    /*
    As we have to stay compatible with MySQL below 4.1, we have to treat returned data
    To avoid bad performance on database with lot of entries, enabling the use of limit
    and deal with the fact that the same picture commented several times must only
   appear once. A factor of 10 seem to be a good compromise.
    */
    $limit=(int)$nb_last_commented * 10;

    $query="SELECT pic_name, datetime, user FROM ".$sTableComments;
    if ($dir) $query.=" WHERE pic_name LIKE ".quote_smart($dir . '%');
    $query.=" ORDER BY datetime desc";
    $query.=" LIMIT ".$limit;

    $res=mysql_db_query($sDB,$query,$nConnection);

    // DEBUG
    if ($debug) {
        echo "<div>";
        echo $query."<br>";
        echo mysql_error()."<br>";
        echo "Size:".mysql_num_rows($res)."</div>";
    }

    if (!$res) return;
    $i=0;

    // Code below is to remove duplicate pictures and check inherited level
    while(($row=mysql_fetch_array($res)) && ($i < $nb_last_commented))
    {
        // Checking that 'pic_name' is not already in the array and inherited seclevel
        unset($dup);

        for ($j=0;$j<sizeof($ret);$j++) if ($ret[$j][0] == $row["pic_name"]) $dup=1;

        if (!isset($dup) && (get_level(dirname($row["pic_name"])) <= $seclevel)) {
            $ret[$i][0]=$row["pic_name"];
            $ret[$i][1]=$row["datetime"];
            $ret[$i][2]=$row["user"];
            $i++;
        }
    }

    return $ret;
}

function get_last_user_comments($dir = null)
{

  // Deprecated function, please now use get_last_commented()

  global $sDB,$nConnection,$sTableComments;

  $dir=stripcslashes($dir);
  if ($dir == "/") unset($dir);

  $query="select * from ".$sTableComments;
	if ($dir) $query.=" where pic_name like \"".$dir."%\"";
  $query.=" order by datetime desc";
  $res=mysql_db_query($sDB,$query,$nConnection);
  if (!$res) return;
  $i=0;
  while(($row=mysql_fetch_array($res)) && $i<15)
  {
    $ret[$i][0]=$row["pic_name"];
    $ret[$i][1]=$row["datetime"];
    $ret[$i][2]=$row["user"];
    $i++;
  }
  return $ret;
}

function get_top_ratings($dir = null, $nb_top_rating = 10, $seclevel = 0)
{

    global $sDB,$nConnection,$sTable, $sTableRatings;

    $dir=stripcslashes($dir);
    if ($dir == "/") unset($dir);
    if (!isset($seclevel)) $seclevel=0;

    // Get more picture that we really want because we'll have to check the inherited 
    // security level after the SQL query
    $limit=(int)$nb_top_rating * 10;

    $query="SELECT pic_name, avg(rating) AS rat FROM ".$sTableRatings;
    if ($dir) $query.=" WHERE pic_name LIKE ".quote_smart($dir . '%');
    $query.=" GROUP BY pic_name ORDER BY rat DESC"; 
    $query.=" LIMIT ".$limit;

    $res=mysql_db_query($sDB,$query,$nConnection);

    // DEBUG
    if ($debug) {
        echo "<div>";
        echo $query."<br>";
        echo mysql_error()."<br>";
        echo "Size:".mysql_num_rows($res)."</div>";
    }

    if (!$res) return; 

    $i=0;
    while (($row = mysql_fetch_array($res)) && ($i < $nb_top_rating)) {

        // Check level of the file directory
        // (This will make more SQL requests but security has a cost)

        if (get_level(dirname($row["pic_name"])) <= $seclevel) {
            $result[$i][0]=$row["pic_name"];
            $result[$i][1]=$row["rat"];
            $i++;
        }

    }

    return $result;

}

function db_add_rating($display,$rating)
{

  global $sDB,$nConnection,$sTableRatings;

  $query="INSERT INTO $sTableRatings (datetime, pic_name, ip, rating) VALUES (now(), ".quote_smart($display).", '".$_SERVER['REMOTE_ADDR']."', ".quote_smart($rating).")";

  mysql_db_query($sDB,$query,$nConnection);

}

function db_add_user_comment($picname,$comment,$user)
{

    global $sDB,$nConnection,$sTableComments;

    $query="INSERT INTO ".$sTableComments." VALUES (0, ".quote_smart($picname).", ".quote_smart($comment).",'".date("Y-m-d H:i:s")."', ".quote_smart($user).", '".$_SERVER['REMOTE_ADDR']."')";

    $res = mysql_db_query($sDB,$query,$nConnection);

    if (mysql_error()) {

        trigger_error("DEBUG: MySQL Error: ".mysql_error(). " while processing '".$query."'", E_USER_NOTICE);
        return false;

    } else return true;

}

function db_is_login_ok($user,$pass)
{

    global $sDB,$nConnection,$sTableUsers;

    $query="SELECT * FROM ".$sTableUsers." WHERE login=".quote_smart($user)." and pass=".quote_smart($pass);

    $res = mysql_db_query($sDB,$query,$nConnection);

    if(!$res || mysql_num_rows($res)==0 ) return $emptyarray;

    return mysql_fetch_array($res);

}

function db_get_login($LoginValue)
{

    global $sDB,$nConnection,$sTableUsers;

    $query="SELECT * FROM ".$sTableUsers." WHERE cookieval=".quote_smart($LoginValue);

    $res = mysql_db_query($sDB,$query,$nConnection);

    if($res && mysql_num_rows($res)>0 ) return mysql_fetch_array($res);
    return $emptyarray;

}

function db_update_pic($display,$dsc,$lev) {

  global $sDB,$nConnection,$sTable;

  // FIXME: use UPDATE instead of REPLACE ?
  $query="REPLACE INTO $sTable VALUES(".quote_smart($display).", ".quote_smart($dsc).", ".quote_smart($lev).")";

  mysql_db_query($sDB,$query,$nConnection);

}

function db_delete_pic($display)
{

    global $sDB,$nConnection,$sTable;

    $query="DELETE FROM $sTable WHERE name=".quote_smart($display);

    $db=mysql_db_query($sDB,$query,$nConnection);

    if (mysql_error()) return(false);

    $query="DELETE FROM $sTableComments WHERE pic_name=".quote_smart($display);

    $db=mysql_db_query($sDB,$query,$nConnection);

    if (mysql_error()) return(false);

}

function db_del_user_comment($pic,$delcom)
{

    global $sDB,$nConnection,$sTableComments;

    // FIXME: Is the $pic var not needed
    $query="DELETE FROM ".$sTableComments." where id=".quote_smart($delcom);

    $res = mysql_db_query($sDB,$query,$nConnection);

    if(mysql_error()) {
        trigger_error("DEBUG: ".mysql_error()." while executing ''".$query."'", E_USER_NOTICE);
        return false;
    }

}

// User Management

function get_all_user_information()
{
    global $sDB, $nConnection;

    $query = "SELECT * FROM users";
    $res = mysql_db_query($sDB, $query, $nConnection);

    if(mysql_error()) {
        trigger_error("DEBUG: ".mysql_error()." while executing ''".$query."'", E_USER_NOTICE);
        return false;
    }

    while($user=mysql_fetch_object($res)) {

        $allLoginPassword[] = array('login'=>trim($user->login), 'password'=>trim($user->pass), 'security_level'=>trim($user->seclevel), 'cookie_value'=>trim($user->cookieval));

    }

    return $allLoginPassword;
}


function delete_user($uid)
{

    global $sDB, $nConnection;

    $users = get_all_user_information();

    if(isSet($users[$uid])) {

        $query = 'DELETE FROM users WHERE login="'.$users[$uid]['login'].'" AND pass="'.$users[$uid]['password'].'" AND seclevel='.$users[$uid]['security_level'].' AND cookieval='.$users[$uid]['cookie_value'];

        $res = mysql_db_query($sDB, $query, $nConnection);

        if (mysql_error()) {
            trigger_error("DEBUG: ".mysql_error()." while executing ''".$query."'", E_USER_NOTICE);
            return false;

        }
    }
}

function save_user_information($all_user_info)
{

    global $sDB, $nConnection;

    foreach($all_user_info as $line) {

        $res = mysql_db_query($sDB,'SELECT COUNT(*) AS NBR FROM users WHERE cookieval="'.$line['cookie_value'].'"');
        $row = mysql_fetch_array($res);

        if($row['NBR']) {

            $query = 'UPDATE users SET login="'.$line['login'].'", pass="'.$line['password'].'", cookieval="'.$line['cookie_value'].'", seclevel='.$line['security_level'].' WHERE cookieval="'.$line['cookie_value'].'"';
            $res = mysql_db_query($sDB, $query, $nConnection);

        } else {

            $query = 'INSERT INTO users VALUES ("'.$line['login'].'","'.$line['password'].'","'.$line['cookie_value'].'",'.$line['security_level'].')' ;
            $res = mysql_db_query($sDB, $query, $nConnection);

        }

        if (mysql_error()) {
            trigger_error("Error while saving user information", E_USER_ERROR);
            trigger_error("DEBUG: ".mysql_error()." while executing ''".$query."'", E_USER_NOTICE);
        }

    }

}

// Database check (connection and structure)

function db_check_struct() 
{
    // Return false if check failed and true if successful
    // This test that you've created the tables by testing the access to one of those

    global $sDB,$nConnection,$sTable, $sTableUsers, $sTableComments, $sTableRatings;

    $tables_list=array("sTable", "sTableUsers", "sTableComments", "sTableRatings");

    // $query="SELECT * FROM ".$sTable." LIMIT 0,1";
    foreach ($tables_list as $table) {

        $query="SELECT * FROM ".$$table." LIMIT 0,1";
        $res = mysql_db_query($sDB,$query,$nConnection);
        if (mysql_error()) {
            trigger_error("DEBUG: Could not find table ".$$table, E_USER_NOTICE);
            return false;
        }

    }

    return true;

}

function db_check_admin()
{
    // This function check if there's at least one administrator account
    // Return true if yes, false if not

    global $sDB,$nConnection, $sTableUsers;

    $query="SELECT * FROM ".$sTableUsers." WHERE seclevel = 999";

    $res = mysql_db_query($sDB,$query,$nConnection);
    if (mysql_error()) {
        trigger_error("DEBUG: ".mysql_error()." while executing ''".$query."'", E_USER_NOTICE);
        return false;
    }

    if (mysql_num_rows($res) >= 1) {

        return true;

    } else {

        return false;

    }

}

function db_create_struct_from_file()
{

    global $sDB, $nConnection;

    define("DB_STRUCT_FILE", "misc/phpgraphy_struc.sql");

    $phpgraphy_struct = file_get_contents(DB_STRUCT_FILE);

    $queries = explode(";", $phpgraphy_struct);

    foreach ($queries as $query) {

        // This is to avoid trying executing the empty string (previously EOF)
        if (ord($query[0]) == 32) continue; 

        $res = mysql_db_query($sDB, $query, $nConnection); 

        if (mysql_error()) {

            trigger_error("DEBUG: MySQL Error: ".mysql_error(). " while processing '".$query."'", E_USER_NOTICE);
            return false;
        }
    }
    return true;

}

$nConnection = mysql_pconnect($sServer, $sUser, $sPass);

if($nConnection<1) {
  die("<b>ERROR:</b>MySQL Database unavailable !");
}

?>
