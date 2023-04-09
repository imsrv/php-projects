<?php
mysql_select_db($database_lyrics, $lyrics);
$query_iletisim = "SELECT * FROM iletisim";
$iletisim = mysql_query($query_iletisim, $lyrics) or die(mysql_error());
$row_iletisim = mysql_fetch_assoc($iletisim);
$totalRows_iletisim = mysql_num_rows($iletisim);
?>
<?php
mysql_free_result($iletisim);
?>