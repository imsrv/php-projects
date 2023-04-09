<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>AZBANNER - Administration & Statistik</title>
<link rel="stylesheet" href="azbanner.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<?php

include("../config.php");
$connection=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Die Verbindung zum MySQL-Datenbankserver ist fehlgeschlagen");
mysql_select_db($db) or die ("Die benötigte Datenbank konnte nicht gefunden werden");
// Routinen zum löschen bearbeiten und ändern der Daten
if($action==loeschen){$loesche=mysql_query("DELETE FROM $ad_table WHERE ID=$ID");}
if($action==stats)
{
$stats=mysql_query("UPDATE $ad_table SET IMPRESSIONS=0 WHERE ID=$ID");
$stats=mysql_query("UPDATE $ad_table SET KLICKS=0 WHERE ID=$ID");
}
if($action==partnernew){$new=mysql_query("INSERT INTO $ad_table (ID, ART, PARTNER, CODE, IMPRESSIONS) VALUES ('',1,'$BEZEICHNUNG','$CODE',0)");}
if($action==bannernew){$new=mysql_query("INSERT INTO $ad_table (ID, ART, BILD, URL, IMPRESSIONS, KLICKS) VALUES ('',0,'$BANNER','$URL',0,0)");}
if($bannermodify==true){$aendern=mysql_query("UPDATE $ad_table Set URL = '$URL' WHERE ID = '$ID'");
						$aendern=mysql_query("UPDATE $ad_table Set BILD = '$BILD' WHERE ID = '$ID'");
						$modified=true;}
if($partnermodify==true){$aendern=mysql_query("UPDATE $ad_table Set PARTNER = '$PARTNER' WHERE ID = '$ID'");
						$aendern=mysql_query("UPDATE $ad_table Set CODE = '$CODE' WHERE ID = '$ID'");
						$partnermodified=true;}
# Titel
echo "<center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"800\">
  <tr>
   <td><img src=\"images/spacer.gif\" width=\"23\" height=\"1\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"341\" height=\"1\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"436\" height=\"1\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" border=\"0\" alt=\"\"></td>
  </tr>

  <tr>
   <td colspan=\"3\"><img name=\"Untitled1_r1_c1\" src=\"images/Untitled-1_r1_c1.jpg\" width=\"800\" height=\"11\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"1\" height=\"11\" border=\"0\" alt=\"\"></td>
  </tr>
  <tr>
   <td rowspan=\"2\"><img name=\"Untitled1_r2_c1\" src=\"images/Untitled-1_r2_c1.jpg\" width=\"23\" height=\"109\" border=\"0\" alt=\"\"></td>
   <td><img name=\"Untitled1_r2_c2\" src=\"images/banner.gif\" width=\"341\" height=\"90\" border=\"0\" alt=\"\"></td>
   <td rowspan=\"2\"><img name=\"Untitled1_r2_c3\" src=\"images/Untitled-1_r2_c3.jpg\" width=\"436\" height=\"109\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"1\" height=\"90\" border=\"0\" alt=\"\"></td>
  </tr>
  <tr>
   <td><img name=\"Untitled1_r3_c2\" src=\"images/Untitled-1_r3_c2.jpg\" width=\"341\" height=\"19\" border=\"0\" alt=\"\"></td>
   <td><img src=\"images/spacer.gif\" width=\"1\" height=\"19\" border=\"0\" alt=\"\"></td>
  </tr>
</table>";
echo "<form action=\"stats.php\" method=\"get\"><input name=\"bannermodify\" type=\"hidden\" value=\"true\"><table width=\"800\" border=\"0\"><tr><td align=\"left\"><font face=\"sans-serif\" size=\"2\"><b>Banner</b></font><table width=\"800\" border=\"1\">";
echo "<tr>";
echo "<td>ID</td><td>Bild-Url</td><td>Verknüpfung</td><td align=\"center\">Einblendungen</td><td align=\"center\">Klicks</td><td align=\"center\">Klickrate</td><td align=\"center\" width=\"90\">Statistik<br>löschen</td><td width=\"70\" align=\"center\">Änderungen<br>speichern</td><td width=\"50\" align=\"center\">Eintrag<br>löschen</td>";
echo "</tr>";
$abfrage=mysql_query("SELECT * FROM $ad_table WHERE ART=0 ORDER BY ID");
while($row=mysql_fetch_object($abfrage))
{
@$KLICKRATE=$row->KLICKS*100/$row->IMPRESSIONS;
@$KLICKRATE=round($KLICKRATE,2);
echo "<tr>";
echo "<td width=\"15\">",$row->ID,"<input name=\"ID\" type=\"hidden\" value=\"",$row->ID,"\"></td><td><input name=\"BILD\" type=\"text\" value=\"",$row->BILD,"\"></td><td><input name=\"URL\" type=\"text\" value=\"",$row->URL,"\"></td><td align=\"center\">",$row->IMPRESSIONS,"</td><td align=\"center\">",$row->KLICKS,"</td><td align=\"center\">$KLICKRATE %</td><td align=\"center\"><a href=\"stats.php?action=stats&ID=",$row->ID,"\"><img src=\"images/stats.gif\" border=\"0\"></a></td><td align=\"center\"><input type=image src=\"images/save.gif\" border=0></td><td align=\"center\"><a href=\"stats.php?action=loeschen&ID=",$row->ID,"\"><img src=\"images/delete.gif\" border=\"0\"></a></td>";
echo "</tr>";
}
echo "</table></td></tr><tr><td><table border=\"0\" width=\"800\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"top\">"; if($modified==true){echo "<font face=\"sans-serif\" color=\"red\" size=\"2\"><b>Bannerdaten wurden geändert !</b></font>";}echo "</td><td align=\"right\"><a href=\"bannerneu.php\">neuer Eintrag</a></form></td></tr></table>";

echo "</td></tr><tr><td>";
//PARTNERPROGRAMME anzeigen
echo "<form action=\"stats.php\" method=\"get\"><input name=\"partnermodify\" type=\"hidden\" value=\"true\"><font face=\"sans-serif\" size=\"2\"><b>Partnerprogramme</b></font>";
echo "<center><table width=\"800\" border=\"1\">";
echo "<tr>";
echo "<td>ID</td><td>Partner</td><td>Programm-Code</td><td width=\"90\" align=\"center\">Einblendungen</td><td width=\"90\" align=\"center\">Statistik<br>löschen</td><td width=\"70\" align=\"center\">Änderungen<br>speichern</td><td width=\"50\" align=\"center\">Eintrag<br>löschen</td>";
echo "</tr>";
$abfrage=mysql_query("SELECT * FROM $ad_table WHERE ART=1 ORDER BY ID");
while($row=mysql_fetch_object($abfrage))
{
echo "<tr>";
echo "<td width=\"15\" valign=\"top\">",$row->ID,"<input name=\"ID\" type=\"hidden\" value=\"",$row->ID,"\"></td><td valign=\"top\"><input name=\"PARTNER\" type=\"text\" value=\"",$row->PARTNER,"\"></td><td><textarea name=\"CODE\" cols=\"30\" rows=\"10\">$row->CODE</textarea></td><td valign=\"top\" align=\"center\">",$row->IMPRESSIONS,"</td><td valign=\"top\" align=\"center\"><a href=\"stats.php?action=stats&ID=",$row->ID,"\"><img src=\"images/stats.gif\" border=\"0\"></a></td><td valign=\"top\" align=\"center\"><input type=image src=\"images/save.gif\" border=0></td><td valign=\"top\" align=\"center\"><a href=\"stats.php?action=loeschen&ID=",$row->ID,"\"><img src=\"images/delete.gif\" border=\"0\"></a></td>";
echo "</tr>";
}
echo "</table>";
echo "</td></tr><tr><table width=\"800\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"top\">"; if($partnermodified==true){echo "<font face=\"sans-serif\" color=\"red\" size=\"2\"><b>Partnerdaten wurden geändert !</b></font>";}echo "</td><td align=\"right\"><a href=\"partnerneu.php\">neuer Eintrag</a></td></tr></table></table></form><div>Aus technischen Gründen ist eine Angabe der Klicks bzw. Klickrate bei den Partnerprogrammen nicht möglich,<br>diese finden Sie auf den Statistikseiten des jeweiligen Partnerprogrammes !</div>";
echo "<br><img src=\"images/banner_copy.gif\"></center>";
?>
