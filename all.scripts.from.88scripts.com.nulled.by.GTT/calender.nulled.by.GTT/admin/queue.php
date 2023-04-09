<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	include("../_include/connection.php");
	if(isset($item))
	{
		@mysql_query("UPDATE calendar_event SET queue_flag = 0 WHERE event_id = $item");
	}
	if(isset($delete))
	{
		@mysql_query("DELETE FROM calendar_event WHERE event_id = $delete");
	}

?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
	<title>::  ::</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
<style type="text/css">
	td {font: 9pt arial}
	input {font: 9pt arial}
	select {font: 9pt arial}
	.title {font: bold 9pt arial}
	.day {font: bold 9pt arial}
	.add {font: 9pt arial}
	.copyrightsite {font: bold 8pt verdana}
</style>

</HEAD>

<body bgcolor="white">
<center>
<?=getMenu('queue')?>
<br><hr width="600"><br>
<table width="600" cellpadding="2" cellspacing="2" border="0">
<tr valign="top">
	<td align="center">
<?php
	
	print listQueue($rights,$id);
?>

	</td>
</tr>
</table>
<br><br>
<?php include("../_include/footer.php"); ?>
</center>
</body>
</html>
