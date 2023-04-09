<?php 
require_once('Connections/lyrics.php');
?>
<?php
$colname_giden = "1";
if (isset($_GET['id'])) {
  $colname_giden = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_giden = sprintf("SELECT * FROM cikis WHERE id = %s", $colname_giden);
$giden = mysql_query($query_giden, $lyrics) or die(mysql_error());
$row_giden = mysql_fetch_assoc($giden);
$totalRows_giden = mysql_num_rows($giden);
?>
<?php
mysql_query("UPDATE cikis SET sayi=(sayi + 1) WHERE id='$_GET[id]'");
mysql_query("UPDATE cikis SET toplam=(toplam + 1) WHERE id='$_GET[id]'");
?>
<?php
$colname_giden = "1";
if (isset($_GET['id'])) {
  $colname_giden = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_lyrics, $lyrics);
$query_giden = sprintf("SELECT * FROM cikis WHERE id = %s", $colname_giden);
$giden = mysql_query($query_giden, $lyrics) or die(mysql_error());
$row_giden = mysql_fetch_assoc($giden);
$totalRows_giden = mysql_num_rows($giden);
?>
<?php
  header(sprintf("Location: %s", $row_giden['url']));
?>
<?php
mysql_free_result($giden);
?>