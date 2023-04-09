<?php

include "config.php";
include "db_file.php";

DB_connect();
$query="UPDATE LFchat_banners SET hits = hits + 1 WHERE id = " . $_GET['id'];
$res = @mysql_query($query);

$query="SELECT url FROM LFchat_banners WHERE id = " . $_GET['id'];
$res = @mysql_query($query);
$row = mysql_fetch_row( $res );

header( "Location: " . $row[0] );

?>