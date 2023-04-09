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
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr valign="top">
	<td align="center">
<?php
	
	include("./_include/connection.php");
	include("./_include/functions.php");
	$public = isCalendarPublic();
	include("calendarClass.php");
	$calendar = new Calendar('index.php',$d,$m,$y);
	$calendar->buildCalendar(80,80);
	if($d == "") 
		$d = date("d");
?>
	<br>
	<form action="index.php" method="post">
	<input type="hidden" name="d" value="<?=$d?>">
	<select name="m">
	<?php
		$month_name = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		for($i=1;$i<13;$i++)
		{
			if($i == $m)
				echo "<option value='$i' selected>".$month_name[$i];
			else
				echo "<option value='$i'>".$month_name[$i];
		}
	?>
	</select>
	<select name="y">
	<?php
		for($i=2002;$i<2010;$i++)
		{
			if($i == $y)
				echo "<option value='$i' selected>$i";
			else
				echo "<option value='$i'>$i";
		}
	?>
	</select>
	<input type="submit" value="Go">
	</form>
	<br><br>
	<form action="index.php" method="post">
	<table width="80" height="80" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
	<tr>
		<td class="title" align="center" height="10">Event Search</td>
	</tr>
	<tr>
		<td bgcolor="white"><input type="text" name="searchText" size="16"><input type="submit" value="GO" name="search"></td>
	</tr>
	</table>
	</form>
	<br><br>
		
	</td>
	<td>
<?php
	if(isset($search) || isset($searchText))
	{
		include("calendarSearchClass.php");
		$calendarSearch = new CalendarSearch($searchText);
		$calendarSearch->buildCalendarSearch(500, $public);
	}
	else
	{
		include("calendarDetailClass.php");
		$calendarDetail = new CalendarDetail($d,$m,$y);
		$calendarDetail->buildCalendarDetail(500, $public);
	}
?>

	</td>
</tr>
</table>
<br><br>
<?php include("./_include/footer.php"); ?>
</center>
</body>
</html>
