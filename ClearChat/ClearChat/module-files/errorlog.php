<?php
require "../common/config.php";
$current = date("d M y - H:i");
if ($pw != $adminpw) {
die("Incorrect or missing password...");
} else {
if (isset($deletenum)) {
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("DELETE FROM nuke_ccerror WHERE id = '$deletenum'",$db);
unset ($deletenum);
}
?>
<html>
<head>
<title>ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">
&nbsp;&nbsp;&nbsp;<span class="nick"><?php echo $current; ?></span><br>



<?php
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT * FROM nuke_ccerror order by id desc limit 0, $lognumber",$db);

while ($output = mysql_fetch_array($result))
{
// Headers
echo"<br><table bgcolor=\"FFFFEE\" cellspacing=\"1\" cellpadding=\"4\" border=\"0\" onMouseOver=\"this.style.backgroundColor='#99CCFF';\" onMouseOut=\"this.style.backgroundColor='#FFFFEE';\">";
echo"<tr>";
echo"<td bgcolor=\"#000033\" valign=\"middle\"><a href=\"errorlog.php?pw=$pw&amp;lognumber=$lognumber&amp;deletenum=";
echo $output["id"];
echo"\">[Delete]</a></td>";
echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"nick\">Username:</span></td>";
echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"nick\">IP:</span></td>";
echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"nick\">Date:</span></td>";
echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"nick\">Error #:</span></td>";
echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"nick\">Userinfo:</span></td></tr>";


// Output
echo"<tr><td bgcolor=\"#000033\" align=\"center\" valign=\"top\"><span class=\"nick\">#";
echo $output["id"];
echo"</span></td>";

echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"say\"><a href=\"idcheck.php?pw=$pw&submit=NickCheck&checkdata=";
echo $output["username"];
echo "\">";
echo $output["username"];  
echo"</a></span></td>";

echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"say\"><a href=\"idcheck.php?pw=$pw&submit=IPCheck&checkdata=";
echo $output["useraddress"];
echo "\">";
echo $output["useraddress"];
echo"</a></span></td>";

echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"say\">";
echo $output["date"];
echo"</span></td>";

echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"say\">";
echo $output["errornumber"];
echo"</span></td>";

echo"<td bgcolor=\"#000033\" valign=\"top\"><span class=\"say\">";
echo $output["userinfo"];
echo"</span></td></tr>";


// Password/comment row
echo"<tr><td bgcolor=\"#000033\" valign=\"bottom\" align=\"right\"><span class=\"nick\">Pw:&nbsp;</span></td><td bgcolor=\"#000033\" colspan=\"3\" valign=\"bottom\"><span class=\"say\">\"";
echo $output["userpw"];
echo"\"</span></td>";

echo"<td bgcolor=\"#000033\" rowspan=\"2\" colspan=\"2\" valign=\"top\"><span class=\"nick\">Comment:&nbsp;</span><span class=\"say\">";
echo $output["comment"];
echo $closealltags;
echo"</span></td></tr>";

echo"<tr><td bgcolor=\"#000033\" valign=\"top\" align=\"right\"><span class=\"nick\"><nobr>Real pw:</nobr></span></td><td bgcolor=\"#000033\" colspan=\"3\" valign=\"top\"><span class=\"say\">\"";
echo $output["realuserpw"];
echo"\"</span></td></tr>";








echo"</table>";



}

}
?>


</body>
</html>