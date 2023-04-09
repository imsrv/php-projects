<?php
mysql_select_db($database_lyrics, $lyrics);
$query_css = "SELECT * FROM css";
$css = mysql_query($query_css, $lyrics) or die(mysql_error());
$row_css = mysql_fetch_assoc($css);
$totalRows_css = mysql_num_rows($css);
?>
<?php
mysql_select_db($database_lyrics, $lyrics);
$query_cache = "SELECT * FROM cache";
$cache = mysql_query($query_cache, $lyrics) or die(mysql_error());
$row_cache = mysql_fetch_assoc($cache);
$totalRows_cache = mysql_num_rows($cache);
?>
<?php
echo $row_css['css']; ?>
<?php include "gonderenler.php"; ?>
<?php include "online/onlinecounter.php"; ?>
<?php
mysql_free_result($css);
mysql_free_result($cache);
?>