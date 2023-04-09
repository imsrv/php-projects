<?php
include("config.php");
$connection=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Die Verbindung zum MySQL-Datenbankserver ist fehlgeschlagen");
mysql_select_db($db) or die ("Die benötigte Datenbank konnte nicht gefunden werden");
//Anzahl der Klicks anhand der ID einlesen, um eins erhöhen und updaten
$get_klicks=mysql_query("SELECT * FROM $ad_table WHERE ID=$ID");
while ($row=mysql_fetch_object($get_klicks))
{
$KLICKS=$row->KLICKS;
}
$KLICKS++;
$update_klicks=mysql_query("UPDATE $ad_table SET KLICKS=$KLICKS WHERE ID=$ID");
//Weiterleitung zu gewünschten URL
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<meta http-equiv=\"refresh\" content=\"0; URL=",$URL,"\">
</head>";
?>
