<?php require_once('Connections/lyrics.php'); ?>
<?php
$sarkiid = $_GET['id'];
$ip = $_SERVER["REMOTE_ADDR"];
mysql_select_db($database_lyrics, $lyrics);
$query_isteklistesi = "SELECT * FROM istekler WHERE id = '$sarkiid'";
$isteklistesi = mysql_query($query_isteklistesi, $lyrics) or die(mysql_error());
$row_isteklistesi = mysql_fetch_assoc($isteklistesi);
$totalRows_isteklistesi = mysql_num_rows($isteklistesi);
include "css.php";
?>
<?php
if ($row_isteklistesi['ip'] == $ip) { ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM istekler WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_lyrics, $lyrics);
  $Result1 = mysql_query($deleteSQL, $lyrics) or die(mysql_error());

  $deleteGoTo = "isteklistesisilindi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  } ?>
<script>
window.location = "isteklistesisilindi.php";
</script>
<?php
}
?>
<?php
} else { ?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>istek listesi</title>
<center>
<br><br><br>
Bu istek size ait olmadýðýndan veya istekte bulunduktan sonra<br>IP adresinizi deðiþtirdiðinizden bu isteði silemezsiniz.<br><input type="button" value="Kapat" onclick="javascript:window.close();">
</center>
<?php } ?>
<?php
mysql_free_result($isteklistesi);
?>