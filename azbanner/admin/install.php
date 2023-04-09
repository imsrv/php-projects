<?php 
include("../config.php");
$connection=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Die Verbindung zum MySQL-Datenbankserver ist fehlgeschlagen");
mysql_select_db($db) or die ("Die benötigte Datenbank konnte nicht gefunden werden");
$install=mysql_query("CREATE TABLE `$ad_table` (
  `ID` int(8) NOT NULL auto_increment,
  `ART` char(1) NOT NULL default '0',
  `URL` varchar(180) NOT NULL default '',
  `PARTNER` varchar(30) NOT NULL default '',
  `CODE` text NOT NULL,
  `BILD` varchar(180) NOT NULL default '',
  `IMPRESSIONS` varchar(8) NOT NULL default '',
  `KLICKS` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ");
$std_inhalt=mysql_query("INSERT INTO `$ad_table` VALUES (18, '1', '', 'Amazon', '<iframe width=\"468\" height=\"60\" scrolling=\"no\" frameborder=0 src=\"http://rcm-de.amazon.de/e/cm?t=chemiewelt&l=st1&search=php&mode=books&p=13&o=3&f=ifr\">\r\n\r\n <table border=''0'' cellpadding=''0'' cellspacing=''0'' width=''468'' height=''60''><tr><td><MAP NAME=''boxmap13''><AREA SHAPE=''RECT'' COORDS=''95, 46, 160, 59'' HREF=''http://rcm-de.amazon.de/e/cm/privacy-policy.html?o=3'' target=_top  alt=''Information''><AREA COORDS=''0,0,10000,10000'' HREF=''http://www.amazon.de/exec/obidos/redirect/302-0773920-2697634?path=tg/browse/-/301128&tag=chemiewelt&creative=@CCMID@&camp=@CAMPID@&link_code=@LINKCODE@'' target=_top ></MAP><img src=\"http://images-eu.amazon.com/images/G/03/associates/recommends/468x60.gif\" width=468 height=60 usemap=\"#boxmap13\" border=\"0\" access=regular></td></tr></table></iframe>\r\n\r\n', '', '1', '')");
$std_inhalt2=mysql_query("INSERT INTO `$ad_table` VALUES (21, '0', 'http://www.gastro24.info', '', '', 'http://server.zoerb.net/gastro24/pr/banner.gif', '0', '0')");
       
if($install==1 && $std_inhalt==1 && $std_inhalt2==1)
{
echo "<font color=\"#009933\"><b>Die Datenbankstruktur für AZBANNER wurde erfolgreich angelegt !</b></font>";
echo "<br><br>";
echo "Es ist ratsam diese Datei vor Betrieb des Scripts wieder von Ihrem Server zu entfernen !";
echo "<br><br>";
echo "Viel Spaß mit AZBANNER";
}
else 
{
echo "<font color=\"#FF0000\"><b>Beim Anlegen der Datenbankstruktur traten Fehler auf !</b></font>";
echo "<br><br>";
echo "Bitte überprüfen Sie die Einstellungen in config.php oder setzten Sie sich mit Ihrem Webhoster in Verbindung !";
}
?>        