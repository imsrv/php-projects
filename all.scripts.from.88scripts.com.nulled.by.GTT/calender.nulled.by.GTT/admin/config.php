<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	include("../_include/connection.php");
	if(isset($save) && ($rights == 1))
	{
		@mysql_query("UPDATE calendar_config SET private_flag = $private, html_flag = $html, queue_flag = $queue, link_flag = 0");
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
<?=getMenu('config')?>
<br><hr width="600"><br>
<table width="600" cellpadding="2" cellspacing="2" border="0">
<tr valign="top">
	<td align="center">
<?php
	
	print listConfigs($rights,$id);
?>

	</td>
</tr>
<tr>
	<td><br><br>
	*When <b>Public Use</b> is enabled, visitors are allowed to add event.<br>
	*When <b>Event Queue</b> is enabled, all events added by visitors will not be displayed until approved.<br>
	*Only admin will be able to change configuration.</td>
</tr>
</table>
<br><br>
<?php include("../_include/footer.php"); ?>
</center>
</body>
</html>
