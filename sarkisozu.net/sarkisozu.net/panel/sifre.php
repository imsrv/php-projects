<?php require_once('../Connections/lyrics.php'); ?>
<?php
session_start();
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "sifre")) {
  $updateSQL = sprintf("UPDATE admin SET pass=%s WHERE user=%s",
                       GetSQLValueString(md5($_POST['pass']), "text"),
                       GetSQLValueString($MM_Username, "text"));

  mysql_select_db($database_lyrics, $lyrics);
  $Result1 = mysql_query($updateSQL, $lyrics) or die(mysql_error());

  $updateGoTo = "sifre_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
include "../css.php";
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>Þifre Deðiþtir</title>
</head>
<body>
<?php
if ($MM_UserGroup == '10') {
?>
<br><br><br><br>
<center><form name="sifre" method="post" action="<?php echo $editFormAction; ?>">
Yeni Þifre: <input type="text" name="pass">&nbsp;<input type="submit" value="Deðiþtir! (Geri alýnamaz)">
<input type="hidden" name="MM_update" value="sifre">
</form><input type="button" value="Geri" onClick="history.go(-1);"></center>
<?php
} else if ($MM_UserGroup == '5') {
?>
<br><br><br><br>
<center><form name="sifre" method="post" action="<?php echo $editFormAction; ?>">
Yeni Þifre: <input type="text" name="pass">&nbsp;<input type="submit" value="Deðiþtir! (Geri alýnamaz)">
<input type="hidden" name="MM_update" value="sifre">
</form><input type="button" value="Geri" onClick="history.go(-1);"></center>
<?php
} else {
?>
<script>
window.location = "../giris.php?hata=girisyap";
</script>
<?php
}
?>
</body>
</html>