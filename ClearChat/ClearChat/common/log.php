<?php
require "../common/config.php";
$current = date("d M y - H:i");
?>
<html>
<head>
<title>ClearChat Log</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">

&nbsp;
<nobr>
<span class="nick"><?php echo $current; ?></span>
&nbsp;&nbsp;
<a href="Javascript: top.close()">Close</a>
<span class="say"> : </span>
<a href="<?php echo $siteurl; ?>" target="_blank">Site</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../common/help.php", "help", "width=750, height=550, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=1, scrollbars=1, status=0, titlebar=0, toolbar=0")'>?</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../copyright.php", "Copyright", "toolbar=no, location=no, directories=no, status=no, scrollbars=yes,  resizable=no, copyhistory=no, width=500, height=270")'>©</a>
</nobr>
<br><br>

<?php
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");
mysql_select_db("$dbname",$db);
$result = mysql_query("SELECT * FROM nuke_clearchat order by id desc limit 0, $logoutputnumber",$db);

while ($output = mysql_fetch_array($result))
{

echo"<span class=\"say\" ";
echo"title=\"Posted ";
echo $output["date"];
echo"\"";
echo">";
echo $output["date"];
echo"&nbsp;&gt;&nbsp;</span>";

echo"";


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