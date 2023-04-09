<?php
include("config.php");
$connection=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Die Verbindung zum MySQL-Datenbankserver ist fehlgeschlagen");
mysql_select_db($db) or die ("Die benötigte Datenbank konnte nicht gefunden werden");
//Alle Einträge der Datenbank in Array einlesen / Add all Banners in DB to array
$abfrage=mysql_query("SELECT * FROM $ad_table ORDER BY ID");

while($row=mysql_fetch_object($abfrage))
{
$banner[]=$row->ID;
}
$banner_anzahl=count($banner);
//Zufällig einen Banner anzeigen
$zufall=rand(0,$banner_anzahl-1);
$ID=$banner[$zufall];
//Anzuzeigenden Banner einlesen
$get_showed=mysql_query("SELECT * FROM $ad_table WHERE ID=$ID");
while($row=mysql_fetch_object($get_showed))
{
$ART=$row->ART;
$ID=$row->ID;
$IMG=$row->BILD;
$URL=$row->URL;
$CODE=$row->CODE;
$IMPRESSIONS=$row->IMPRESSIONS;
}
//ART=0 bei "normalen Bannern" ART=1 bei Partnerprogrammen
//Wenn Eintrag ein normaler Banner ist
if($ART==0) 
{
echo "<a href=\"goto.php?URL=",$URL,"&ID=$ID\" target=\"_blank\"><img src=\"",$IMG,"\" border=\"0\"></a>";
$IMPRESSIONS++;
$update_impressions=mysql_query("UPDATE $ad_table SET IMPRESSIONS=$IMPRESSIONS WHERE ID=$ID");
}
//Wenn Eintrag zu Partnerprogrammen gehört->Partnerprogramm Coder einbinden
elseif($ART==1)
{
echo $CODE;
$IMPRESSIONS++;
$update_impressions=mysql_query("UPDATE $ad_table SET IMPRESSIONS=$IMPRESSIONS WHERE ID=$ID");
}



?>