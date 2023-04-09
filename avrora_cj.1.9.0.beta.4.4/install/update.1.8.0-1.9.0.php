<?php
include('../cj_config.php');
mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or die('Cannot connect to DB');
mysql_select_db(DB_DEVICE) or die('Cannot select DB DEVICE');

mysql_query("ALTER TABLE `tm_cj_iplog` DROP INDEX NewIndex, ADD INDEX NewIndex (_ip,tid,_act)");
mysql_query("create table if not exists tm_cj_settings
(
   id                             varchar(32)                    not null,
   value                          varchar(255)                   not null,
   primary key (id)
);");
mysql_query("INSERT INTO tm_cj_settings (id, value) VALUES ('last_trader', '4');");
mysql_query("INSERT INTO tm_cj_settings (id, value) VALUES ('last_trader_view', '4');");

mysql_close();
?>
OK.
