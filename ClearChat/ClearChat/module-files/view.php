<?php
require "../common/config.php";
$current = date("d M y - H:i");

if ($pw != $adminpw) {
die("Incorrect or missing password...");
} else {

if (isset($deletenum)) {
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("DELETE FROM nuke_clearchat WHERE id = '$deletenum'",$db);
unset ($deletenum);
}
?>

<html>
<head>
<title>ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="refresh" content="<?php echo $adminrefreshrate; ?>; url=view.php?pw=<?php echo $pw; ?>">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">
&nbsp;&nbsp;&nbsp;<span class="nick"><?php echo $current; ?></span><br>

<?php
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT * FROM nuke_clearchat order by id desc limit 0, $adminoutputnumber",$db);


while ($output = mysql_fetch_array($result))
{

echo"<a href=\"view.php?pw=$pw&amp;deletenum=";
echo $output["id"];
echo"\" title=\"#";
echo $output["id"];
echo" --- Posted ";
echo $output["date"];
echo" --- IP: ";
echo $output["useraddress"];
echo"\">[Delete]</a>";

echo"<span class=\"nick\"";
echo"title=\"#";
echo $output["id"];
echo" --- Posted ";
echo $output["date"];
echo" --- IP: ";
echo $output["useraddress"];
echo"\"";
echo">&nbsp;&nbsp;";
echo "<a href=\"idcheck.php?pw=$pw&submit=NickCheck&checkdata=";
echo $output["username"];
echo "\">";
echo $output["username"];
echo "</a>";
echo": </span>";

echo"<span class=\"say\"";
echo"title=\"#";
echo $output["id"];
echo" --- Posted ";
echo $output["date"];
echo" --- IP: ";
echo $output["useraddress"];
echo"\"";
echo">";
echo $output["comment"];
echo $closealltags;
echo"</span><br>";
}
?>
</body>
</html>
<?php
}
?>