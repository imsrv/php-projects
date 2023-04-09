<?
include "config.php";

$query = mysql_db_query ($dbname,"select count(sid) as stotal from top_user WHERE STATUS='Y'",$db) or die (mysql_error());
$rows = mysql_fetch_array ($query);

srand ((double) microtime() * 100000000);

if ($rows[stotal] > 1) $random_site = rand (0, $rows[stotal] - 1);
else $random_site = 0;

$query = mysql_db_query ($dbname,"select sid from top_user WHERE STATUS='Y' limit $random_site,1",$db) or die (mysql_error());

$rows = mysql_fetch_array ($query);

header("location: out.php?site=$rows[sid]");
?>