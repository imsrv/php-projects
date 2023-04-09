<?php
$mysql = mysql_connect($eggblog_mysql_host,$eggblog_mysql_user,$eggblog_mysql_password);
mysql_select_db($eggblog_mysql_db,$mysql);

if ($mysql == 0) {
  header("Location: ../home/error_mysql.php");
}
?>