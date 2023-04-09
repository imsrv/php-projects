<html>
<head>
<title>{sitename} Newsletter Templates</title>
<link rel="stylesheet" type="text/css" href="../slim.css">
</head>
<body>

<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td valign="middle" align="center" height="40">
		<h3>Newsletter Templates</h3>
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

<form name="form_newsletter_templates" action="do_on_message.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>All your newsletter templates: </b><br><br>
		(select one to edit)
	</td>
	<td bgColor="white" valign="top">
		&nbsp;<a href="do_change_sort_order.php">{SORT_ORDER}</a><br><br>
		{MESSAGE_LIST}
		{MESSAGE_MENU}
	</td>
</tr>
</form>

{MESSAGE_ADD_EDIT}

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>

</body>
</html>
