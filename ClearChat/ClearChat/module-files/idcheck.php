<?php
require "../common/config.php";

if ($pw != $adminpw) {
die("Incorrect or missing password...");
} else {
?>

<html>
<head><title>ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">


<?php
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");


if ($submit == "NickCheck") {
mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT DISTINCT useraddress FROM nuke_clearchat WHERE username = '$checkdata' order by date desc",$db);

echo "<span class=\"say\">Listing all IP-addresses (and nicknames) used by user ";
echo "<span class=\"nick\">$checkdata:</span><br><br>";
while ($output = mysql_fetch_array($result))
{
echo "<a href=\"idcheck.php?pw=$pw&submit=IPCheck&checkdata=";
echo $output["useraddress"];
echo "\"><b>";
echo $output["useraddress"];
echo "</b></a><br>";

$tempuseraddress = $output["useraddress"];
$subresult = mysql_query("SELECT DISTINCT username FROM nuke_clearchat WHERE useraddress = '$tempuseraddress' order by username",$db);
while ($suboutput = mysql_fetch_array($subresult))
{
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href=\"idcheck.php?pw=$pw&submit=NickCheck&checkdata=";
echo $suboutput["username"];
echo "\">";
echo $suboutput["username"];
echo "</a>";
echo "<br>";
}

echo "<br>";
}
}


if ($submit == "IPCheck") {

mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT DISTINCT username FROM nuke_clearchat WHERE useraddress = '$checkdata' order by date desc",$db);

echo "<span class=\"say\">Listing all nicknames (and IP-addresses) used by IP ";
echo "<span class=\"nick\">$checkdata:</span><br><br>";
while ($output = mysql_fetch_array($result))
{
echo "<a href=\"idcheck.php?pw=$pw&submit=NickCheck&checkdata=";
echo $output["username"];
echo "\"><b>";
echo $output["username"];
echo "</b></a><br>";

$tempusername = $output["username"];
$subresult = mysql_query("SELECT DISTINCT useraddress FROM nuke_clearchat WHERE username = '$tempusername' order by useraddress",$db);
while ($suboutput = mysql_fetch_array($subresult))
{
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href=\"idcheck.php?pw=$pw&submit=IPCheck&checkdata=";
echo $suboutput["useraddress"];
echo "\">";
echo $suboutput["useraddress"];
echo "</a>";
echo "<br>";
}

echo "<br>";
}

}



}
?>

</body>
</html>