<?php
$hostname_lyrics = "localhost";
$database_lyrics = "sarkisoz_lyrics";
$username_lyrics = "sarkisoz_lyrics";
$password_lyrics = "madcowxp750";
$lyrics = mysql_pconnect($hostname_lyrics, $username_lyrics, $password_lyrics) or trigger_error(mysql_error(),E_USER_ERROR); 
?>