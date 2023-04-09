<?php

//SQL
/*

CREATE TABLE `dokumanlar` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sayfa_adi` VARCHAR( 150 ) NOT NULL ,
`baslik` VARCHAR( 150 ) NOT NULL ,
`icerik` TEXT NOT NULL ,
`sayac` INT NOT NULL default '0'
) TYPE = MYISAM ;

*/

//SQL Baðlantýsý
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());

if ( isset($_GET['id']) && is_numeric($_GET['id']) ) $id = $_GET['id'];
else $id = false;

if ( isset($_GET['s']) ) $sayfa = mysql_real_escape_string(htmlspecialchars($_GET['s']));
else $sayfa = false;

if ( !$id && !$sayfa ) echo 'Sayfa idsi veya adý girilmemiþ';
else {

	$sql = 'SELECT * FROM `dokumanlar` WHERE ';
	if ( $id ) $sql .= '`id` = ' . $id;
	else if ( $sayfa ) $sql .= '`sayfa_adi` = \'' . $sayfa . '\'';
	$sql .= ' LIMIT 1;';
	
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ( !$row['id'] ) echo 'Aradýðýnýz sayfa veritabanýnda bulunamamýþtýr';
	else {
		echo $row['baslik'] . '<br><br>' . $row['icerik'];
		//Sayac 1 arttýrýlýyor
		$row['sayac']++;
		echo '<br><br>Toplam okuma: ' . $row['sayac'];
		mysql_query('UPDATE `dokumanlar` SET `sayac` = ' . $row['sayac'] . ' WHERE `id` = ' . $row['id'] . ' LIMIT 1');
	}

}

?>