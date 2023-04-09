<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	include("../_include/connection.php");
	if(isset($delete) && ($rights == 1))
	{
		@mysql_query("DELETE FROM calendar_user WHERE user_id = $delete");
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
<?=getMenu('user')?>
<br><hr width="600"><br>
<table width="600" cellpadding="2" cellspacing="2" border="0">
<tr valign="top">
	<td align="center">
<?php
	
	print listUsers($rights,$id);
?>

	</td>
</tr>
<tr>
	<td>*Only admin will be able to add/delete/modify users.</td>
</tr>
</table>
<br><br>
<?php include("../_include/footer.php"); ?>
</center>
</body>
</html>
