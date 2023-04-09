<?php require_once('Connections/lyrics.php'); ?>
<?php
mysql_select_db($database_lyrics, $lyrics);
$query_isteklistesi = "SELECT * FROM istekler ORDER BY id DESC";
$isteklistesi = mysql_query($query_isteklistesi, $lyrics) or die(mysql_error());
$row_isteklistesi = mysql_fetch_assoc($isteklistesi);
$totalRows_isteklistesi = mysql_num_rows($isteklistesi);
$ip = $_SERVER["REMOTE_ADDR"];
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1254">
<title>istek listesi</title>
<?php include "css.php"; ?>
</title>
</head>
<body><br>
<center><input type="button" value="Kapat" onclick="javascript:window.close();"></center><br>
<?php if ($totalRows_isteklistesi > 0 ) { ?>
<?php do { ?>
<?php echo $row_isteklistesi['sanatci']; ?> - <?php echo $row_isteklistesi['sarki']; ?><?php if ($row_isteklistesi['ip'] == $ip) { ?> | <a href="isteksil_onay.php?id=<?php echo $row_isteklistesi['id']; ?>">bu isteği sil</a><?php } ?><br>
<?php } while ($row_isteklistesi = mysql_fetch_assoc($isteklistesi)); ?>
<?php } else { ?>
Şu anda yapılmış herhangi bir istek bulunmuyor.
<?php } ?>
<br><br>
<center><input type="button" value="Kapat" onclick="javascript:window.close();"></center>
</body>
</html>
<?php
mysql_free_result($isteklistesi);
?>