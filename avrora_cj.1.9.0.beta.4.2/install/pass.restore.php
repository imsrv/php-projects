<?php
include('../cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');

mysql_query("update tm_cj_traders set _pass='21232f297a57a5a743894a0e4a801fc3' where tid=1");

mysql_close();
?>
OK.
