<html>
<head>
<META http-equiv="content-type" content="text/html; charset=windows-1254">
<META http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>myAgenda</title>
<script LANGUAGE="javascript" src="js/jslib.js"></script>
<link rel="StyleSheet" href="css/style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<CENTER>
<!-- HEADER STARTS -->
<table width="600" border="0" cellspacing="0" cellpadding="0">
 <tr>
	<td></td>
 </tr>
</table>
<!-- HEADER ENDS -->
<table width="600" border="0" cellspacing="0" cellpadding="0">
 <tr>
	<td width="150" valign="top">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
 <tr>
	<td width="15"><font color="#FF0000" class="small">&raquo;</font></td>
	<td><a href="index.php">Home</a></td>
 </tr><tr>
	<td><font color="#FF0000" class="small">&raquo;</font></td>
	<td><a href="reminders.php">Reminders</a></td>
 </tr><tr>
	<td><font color="#FF0000" class="small">&raquo;</font></td>
	<td><a href="modifyinfo.php">Modify Info</a></td>
 </tr><tr>
	<td><font color="#FF0000" class="small">&raquo;</font></td>
	<td><a href="logout.php">Log Out</a></td>
 </tr>
</table>
	
	</td>
	<td valign="top">
	
<!-- CENTER COLUMN STARTS -->

<table border=0 cellspacing=0 cellpadding=1 width="100%" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td>
		 <table border=0 cellpadding=2 cellspacing=2 width="100%">
		 <tr>
			<td bgcolor="#f3f3f3" align="center"><font class="text">{strDate}</font></td>
	 </tr>
	</table>

	</td>
 </tr>
</table>

	</td>
 </tr>
</table>
<img src="images/spacer.gif" width="1" height="2" border="0" alt=""><br>

<table border=0 cellspacing=0 cellpadding=1 width="100%" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr><form action="add.php" method="post" name="myAgenda">
		<td>{calendarTable}</td>
 </tr>
 <input type="hidden" name="day">
 <input type="hidden" name="month">
 <input type="hidden" name="year">
 </form>
</table>

	</td>
 </tr>
</table>
<Script language="JavaScript">
function addReminder(day,month,year) {
	var f = document.myAgenda;
		f.day.value = day
		f.month.value = month
		f.year.value = year
		f.submit();
}
</SCRIPT>
<img src="images/spacer.gif" width="1" height="2" border="0" alt=""><br>
<table border=0 cellspacing=0 cellpadding=1 width="100%" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td>
		 <table border=0 cellpadding=2 cellspacing=2 width="100%">
		 <tr>
			<td bgcolor="#f3f3f3"><font class="small">{strHaveNotes}</font></td>
	 </tr>
	</table>

	</td>
 </tr>
</table>

	</td>
 </tr>
</table>

<img src="images/spacer.gif" width="1" height="2" border="0" alt=""><br>
<table border=0 cellspacing=0 cellpadding=1 width="100%" bgcolor="#333333" align="center">
 <tr><form method="post" action="{SELF}">
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td>
		 <table border=0 cellpadding=2 cellspacing=2 width="100%">
		 <tr>
			<td bgcolor="#f3f3f3" align="center">{strMonthSelect} / {strYearSelect}&nbsp;
			<input type="submit" name="go" value="  {strGo}  "></td>
	 </tr></form>
	</table>

	</td>
 </tr>
</table>

	</td>
 </tr>
</table>

<!-- CENTER COLUMN ENDS -->
	
	</td>
	<td valign="top" align="center">
	
<img src="images/install.jpg" border="0" alt="" width="164" height="300">	
	
	</td>
 </tr>
</table>
</CENTER>
</BODY>
</HTML>
