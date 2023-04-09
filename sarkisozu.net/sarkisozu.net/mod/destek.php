<?php
mysql_select_db($database_lyrics, $lyrics);
$query_gidenler = "SELECT * FROM cikis ORDER BY id ASC";
$gidenler = mysql_query($query_gidenler, $lyrics) or die(mysql_error());
$row_gidenler = mysql_fetch_assoc($gidenler);
$totalRows_gidenler = mysql_num_rows($gidenler);
?>
<?php do { ?>
<a href="http://www.sarkisozu.net/cikis.php?id=<?php echo $row_gidenler['id']; ?>" target="_blank"><?php echo $row_gidenler['isim']; ?></a><br>
<?php } while ($row_gidenler = mysql_fetch_assoc($gidenler)); ?>
<?php
mysql_free_result($gidenler);
?>
