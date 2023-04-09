<?php
/*
#
#	$Id: GETBANNER.PHP
#	Version 2.1.0
#
*/

srand((double)microtime()*1000000);
$result = mysql_query("SELECT * FROM banners WHERE level=$level AND Active='1' ORDER BY RAND() LIMIT 1");
$list = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$banid = $row["id"];
$image = $row["img"];
$height = $row["height"];
$width = $row["width"];
$alt = $row["details"];
$url = $row["url"];
$bps = $row["bps"];
if ($bps == '') {
echo "<a href=clickbanner.php?banid=$banid&link=bps target=_blank>";
echo "<img src=$image height=$height width=$width alt=$alt border=0>";
echo "</a>";
}
else {
if ($url == '') {
echo"<img src=$imgloc$image height=$height width=$width alt=$alt border=0>";
}
else {
echo"<a href=clickbanner.php?banid=$banid&link=$url target=_blank>";
echo"<img src=$imgloc$image height=$height width=$width alt=$alt border=0>";
echo"</a>";
}
}
$result = mysql_query("UPDATE banimp SET hits = hits+1 WHERE bannerid = '$banid'");
?>