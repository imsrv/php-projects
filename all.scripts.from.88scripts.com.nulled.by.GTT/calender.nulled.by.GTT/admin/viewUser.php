<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();

	include("../_include/connection.php");
	$error = "";
	if($rights == 1 || ($id == $item))
	{
		$result = mysql_query("SELECT * FROM calendar_user WHERE user_id = $item");
		if(mysql_num_rows($result) > 0)
			$row = mysql_fetch_array($result);
		else
			$error = "User does not exists.";
	}
	else
		$error = "You have no rights to view this user.";

	
	
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title> Admin </title>
<style type="text/css">
	.header {font: bold 11pt arial}
	.label {font: 8pt arial}
	.label1 {font: bold 8pt arial}
	.footer {font: 9pt arial}
	.error {font: italic 8pt arial; color: red}
	.data {font: 8pt arial}
	input {font: 8pt arial}
</style>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
<tr>
	<td class="header" align="center">View User</td>
</tr>
<tr>
	<td><hr></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label" align="center">
	<?php if($error == "") { ?>
	<form>
		
		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
		<tr>
			<td class="label1" width="40%">Full Name </td>
			<td class="label">:<?=$row["fullname"]?></td>
		</tr>
		<tr>
			<td class="label1">Email</td>
			<td class="label">:<?=$row["email"]?></td>
		</tr>
		<tr>
			<td class="label1">Login ID</td>
			<td class="label">:<?=$row["username"]?></td>
		</tr>
		<tr>
			<td class="label1">Password</td>
			<td class="label">:-- Not shown --</td>
		</tr>
		<tr>
			<td class="label1">User Type</td>
			<td class="label">:<?php if($row["user_right"] == "1") echo "Admin"; else echo "Moderator";?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="button" value="Close" name="add" onClick="javascript: self.close();">&nbsp;&nbsp;</td>
		</tr>
		</table>
		

	</form>
	<?php }else{ 
		echo $error;
	} ?>
	</td>
</tr>

</table>
</body>
</html>
