<?php
include('../cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');

mysql_query("ALTER TABLE `tm_cj_iplog` ADD `_proxy` TINYINT(1)  UNSIGNED DEFAULT \"0\" NOT NULL");

mysql_close();
?>
OK.
