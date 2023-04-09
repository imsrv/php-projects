<?php
require "../common/config.php";
?>
<html>
<head>
<title>Undocked ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="refresh" content="<?php echo $undockedrefreshrate; ?>">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">

<?php
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT * FROM nuke_clearchat order by id desc limit 0, $undockedoutputnumber",$db);

while ($output = mysql_fetch_array($result))
{
echo"<span class=\"nick\" ";
echo"title=\"Posted ";
echo $output["date"];
echo"\"";
echo">";
echo $output["username"];
echo":</span>";

echo" ";

echo"<span class=\"say\"";
echo"title=\"Posted ";
echo $output["date"];
echo"\"";
echo">";
echo $output["comment"];
echo $closealltags;
echo"</span>";

echo"<br>";

}

?>
</body>
</html>