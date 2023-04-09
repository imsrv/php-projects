<html>
<head>
<title>Administrative Area :: Statistics</title>
<link rel="stylesheet" type="text/css" href="../slim.css">
</head>
<body>

<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td valign="middle" align="center" height="40">
		<h3>Statistics</h3>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa">

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="main.php">Menu</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>

<tr>
	<td align="left" valign="top" width="25%" bgColor="#FFFFFF">
		<b>Number of messages sent by members:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="4" cellSpacing="1" border="0">
		<tr height="20">
			<td width="40%" align="center" bgColor="#FFFFFF" rowSpan="2"><b>Username</b></td>
			<td align="center" bgColor="#FFFFFF" colSpan="3"><b>Messages Sent</b></td>
		</tr>
		<tr height="20">
			<td width="20%" align="center" bgColor="#FFFFFF"><b>Today</b></td>
			<td width="20%" align="center" bgColor="#FFFFFF"><b>Average/day</b></td>
			<td width="20%" align="center" bgColor="#FFFFFF"><b>Total</b></td>
		</tr>
		{MEMBERS_LIST}
		</table>
	</td>
</tr>

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>

</body>
</html>
