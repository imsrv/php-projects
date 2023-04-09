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
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>istek listesi</title>
<center>
<br><br><br>
<?php
if ($row_isteklistesi['ip'] == $ip) { ?>
<?php echo $row_isteklistesi['sanatci']; ?> - <?php echo $row_isteklistesi['sarki']; ?><br>
Bu isteğinizi silmek istediğinizden emin misiniz?<br>
<a href="isteklistesisil.php?id=<?php echo $row_isteklistesi['id']; ?>">Evet</a>&nbsp;&nbsp;<a href="javascript:history.go(-1);">Hayır</a>
<?php } else { ?>
Bu istek size ait olmadığından veya istekte bulunduktan sonra<br>IP adresinizi değiştirdiğinizden bu isteği silemezsiniz.<br><input type="button" value="Kapat" onclick="javascript:window.close();">
<?php } ?>
</center>
<?php
mysql_free_result($isteklistesi);
?>