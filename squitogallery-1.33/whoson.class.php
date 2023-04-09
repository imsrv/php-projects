<?php
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
class Whoson
{

function get_language()
{
$this->lang = $_SESSION['lang'];
}
function set_session($session,$uid)
{
if($session)
{
   $query = 'select * from session_track where session_id = "'.$session.'"';
   $result = $this->query($query);
   if(!mysql_num_rows($result))
   {
     $query = 'insert into session_track (session_id, time, user_id, ip) values ("'.$session.'","'.time().'","'.$uid.'","'.$_SERVER['REMOTE_ADDR'].'")';
     $this->query($query);
   }
   else
   {
     $query = 'update session_track set time="'.time().'", user_id = "'.$uid.'" where session_id = "'.$session.'"';
     $this->query($query);
   }
}
}
function clean_sessions($last_cleanup)
{
   if((time()-$last_cleanup>60))
   {
     $timeout = time()-600;
     $query = 'delete from session_track where time < "'.$timeout.'"';
     $this->query($query);
     return $timeout+600;
   }
}
function get_whos_on()
{
$query = 'select user_id from session_track where user_id !=0 ';
$res = $this->query($query);
$query ='select count(id) from session_track where user_id = 0';
$result = $this->query($query);
$guests = mysql_fetch_row($result);

echo $this->lang['There is currently'] .' '. mysql_num_rows($res) .' member(s) and '.$guests[0].' guest(s) '.$this->lang['logged in'].'<br>';
$query = 'select user_id from session_track where user_id != 0';
$result = $this->query($query);
while($users = mysql_fetch_array($res))
{
echo $this->get_username($users[0]).' ';
}

}
function get_username($id)
{
$query = 'select name from authorization where id = "'.$id.'"';
$result = $this->query($query);
$user = mysql_fetch_row($result);
return $user[0];

}
function set_db($host, $user, $pass, $db, $table)
{
  $this->host = $host;
  $this->user = $user;
  $this->pass = $pass;
  $this->db = $db;
  $this->table = $table;


}
function query($query)
{
     if(!isset($this->dbconnection))
	 $this->dbconnection = mysql_connect($this->host, $this->user, $this->pass)
         or die ("Cannot connect to database");
        // run query
      $ret = mysql_db_query($this->db, $query, $this->dbconnection)
         or die ("Error in query: $query");
        // return result identifier
      return $ret;

}



}