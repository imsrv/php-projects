<?php
/*
#
#	$Id: CLICKBANNER.PHP
#	Version 2.1.0
#
*/

include "settings.php";

$result = mysql_query("UPDATE banclk SET clicks = clicks+1 WHERE bannerid = '$banid'");
if ($link=='bps') {
$resulta = mysql_query("SELECT * FROM banners WHERE id=$banid");
         $list = mysql_num_rows($resulta);
         $rowa = mysql_fetch_array($resulta);
         $bpslink = $rowa["url"];
header("Location: $bpslink");
}
else {
header("Location: $link");
}
?>