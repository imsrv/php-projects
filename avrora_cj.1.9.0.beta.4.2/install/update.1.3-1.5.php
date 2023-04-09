<?php
include('../cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');

mysql_query("ALTER TABLE `tm_cj_iplog` DROP `_domain`");
mysql_query("ALTER TABLE `tm_cj_iplog` ADD `tid` MEDIUMINT UNSIGNED DEFAULT \"1\" NOT NULL AFTER _ip");
mysql_query("ALTER TABLE `tm_cj_iplog` DROP INDEX NewIndex, ADD INDEX NewIndex (_ip,tid)");
mysql_close();
?>
OK.
