<?php

require "config.class.php";
$c = new config();
$c->open();

if ($go == "Support") {
	$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE support > 0 ORDER BY supports");
	if (mysql_num_rows($get)) {
		$row = mysql_fetch_array($get);
		mysql_query("UPDATE $c->mysql_tb_le SET supports = supports+'$row[support]' WHERE id = '$row[id]'");
		$id = false;
		header("Location: $row[url]");
	} else
		$id = false;
}

if ($id) {
	$get = mysql_query("SELECT * FROM $c->mysql_tb_le WHERE id = '$id'");
	if (mysql_num_rows($get)) {
		$row = mysql_fetch_array($get);
		mysql_query("UPDATE $c->mysql_tb_le SET ut=ut+1 WHERE id = '$id'");
		header("Location: $row[url]");
	} else
		$id = false;
}

if (!$id) {
	$get = mysql_query("SELECT * FROM $c->mysql_tb_le ORDER BY ut");
	$row = mysql_fetch_array($get);
	mysql_query("UPDATE $c->mysql_tb_le SET ut=ut+1 WHERE id = '$row[id]'");
	header("Location: $row[url]");
}

$c->close();
?>