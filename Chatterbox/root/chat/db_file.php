<?php
    $db_host="localhost";// localhost usually works. If you don't know this value you will need to ask your hosts
    $db_username="username";// The username used to connect to your database
    $db_password="password";// The pasword used to connect to your database
    $db_name="dbase name";// The name of your database
//DO NOT EDIT BELOW THIS LINE - UNLESS YOU WANT TO BREAK IT OR YOU UNDERSTAND WHAT IT IS ALL ABOUT!
  function DB_connect()
  {

    global $db_name,$db_con,$db_host,$db_username,$db_password;
    $db_con = mysql_pconnect($db_host,$db_username,$db_password); //Set up permanent connection
    @mysql_select_db("$db_name",$db_con) or die("<font face='Verdana' size='2' color='red'><b><br><br><br>Script cannot continue!<BR><BR><BR>I was unable to connect to the database!<BR><BR>Please check the db_file.php in your chat directory for the correct host, <BR>user name, database name and password. One of them is probably incorrect!!");
  }
?>