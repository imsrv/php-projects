<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// determine which text has to be shown

require("includes.php3");

$eerste = "nee";

if ($state=="")
{
	$state="started";
	$eerste="ja";
	
	$query = "SELECT MAX(id) AS latestid FROM chat_session_ids;"
	$ids = mysql_fetch_array(mysql_query($query, $mysql_link));
	$latestid = $ids["latestid"];
	
	?>
	<script>
	<!--
	alert("<? print($latestid); ?>");
	//-->
	</script>
	<?
}


// Fetch new text from database

$query = "SELECT * FROM Chat_Text WHERE date_time > '$nu';";

$result = mysql_query($query, $mysql_link);

$query = "SELECT now() AS nu;";
$now_time = mysql_fetch_array(mysql_query($query, $mysql_link));
$nu = $now_time["nu"];


$data = "";

if (mysql_num_rows($result) > 0)
{
	$teller++;
}

while ($record = mysql_fetch_array($result))
{
	$data .= strip_tags($record["said_by"]).":".strip_tags($record["text"])."<br>";
}

$data = addslashes($data);

$encodedurl = urlencode($nu);	

?>
<html>
<meta http-equiv=refresh content="5; URL=update.php3?state=started&nu=<? print($encodedurl); ?>&garb=<? print(date("U")); ?>">
<head>
<script>

<?
if ($eerste=="ja") print("parent.text.document.writeln(\"<body bgcolor=black text=white><font size=3 face=tahoma>\"+\"\\n\");");
?>


<?
if (mysql_num_rows($result) > 0)
{
?>

	parent.text.document.writeln("<? print($data); ?>");
	parent.text.scrollBy(0, 50);

<?
}
?>
</script>
</head>
<body>
</body>
</html>
