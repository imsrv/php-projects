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
echo "<form action=\"stats.php\" method=\"get\">";
echo "<input name=\"action\" type=\"hidden\" value=\"bannernew\">";
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
</table><br>";
echo "<center><table width=\"800\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"left\"><font face=\"sans-serif\" size=\"2\"><b>Banner hinzufügen:</b></font></td></tr></table><table width=\"800\" border=\"1\" cellpadding=\"0\">";
echo "<tr>";
echo "<td valign=\"top\" width=\"20\">Bilddatei (Banner):</td><td><input name=\"BANNER\" type=\"text\" size=\"70\"></td><td>Hier fügen Sie bitte die URL der Bilddatei/Bannerfile ein. (Bsp.: <i>http://bilder.zoerb.net/banner/kampagne45.gif</i>)</td></tr>";
echo "<tr><td width=\"20\" valign=\"top\">Verknüpfung (URL):</td><td><input name=\"URL\" type=\"text\" size=\"70\"></td><td valign=\"top\">Hier fügen Sie bitte die zum Banner gehörende Verknüpfung (URL) ein. (Bsp.: <i>http://www.zoerb.net</i>)</td></tr>";
echo "<tr><td></td><td align=\"center\"><input name=\"\" type=\"reset\"><input name=\"\" type=\"submit\"></td><td></td></tr>";
echo "</table><table width=\"800\"><tr><td><font face=\"sans-serif\" size=\"2\"><b><a href=\"stats.php\"><< zurück</a></b></font></td></tr></table></form>";


echo "<img src=\"images/banner_copy.gif\"></center>";
?>
