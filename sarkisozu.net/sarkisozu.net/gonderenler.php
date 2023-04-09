<?php
mysql_query("UPDATE gonderenler SET ziyaretci=(ziyaretci + 1) WHERE ref='$gond'");
mysql_query("UPDATE gonderenler SET toplam=(toplam + 1) WHERE ref='$gond'");
?>