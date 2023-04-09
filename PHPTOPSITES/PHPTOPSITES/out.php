<?
include "config.php";

mysql_db_query ($dbname,"update top_user set hitout=hitout+1 Where sid=$site",$db) or die (mysql_error());

$get_rows = mysql_db_query ($dbname,"Select url from top_user Where sid=$site",$db) or die (mysql_error());
$rows = mysql_fetch_array($get_rows); 

header("location: $rows[url]");
?>