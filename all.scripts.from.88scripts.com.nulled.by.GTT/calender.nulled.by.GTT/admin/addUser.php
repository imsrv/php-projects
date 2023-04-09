<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	
	$error = "";
	if($rights == 1)
	{
		include("../_include/connection.php");

		$added = false;
		if(isset($add))
		{
			$result = mysql_query("SELECT * FROM calendar_user WHERE username = '$username'");
			if(mysql_num_rows($result) == 0)
			{
				mysql_query("INSERT INTO calendar_user(fullname, username, password, user_right, email) VALUES ( '$fullnamex', '$username', '$password', '$user_right', '$email')");
				$added = true;
			}
			else
			{
				$error = "Username already exists. Please try again.";
			}
		}
	}
	else
	{
		$error = "You have no rights to add user.";
	}
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title> Admin </title>
<style type="text/css">
	.header {font: bold 11pt arial}
	.label {font: 8pt arial}
	.footer {font: 9pt arial}
	.error {font: italic 8pt arial; color: red}
	.data {font: 8pt arial}
	input {font: 8pt arial}
	select {font: 8pt arial}
</style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td class="header" align="center">Add User</td>
</tr>
<tr>
	<td><hr></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label" align="center">
	<form action="addUser.php" method="post">
	<?php if($added){?>
		<?php if($error == "") { ?>
		User added!
		<br>
		<input type="button" value="Close" onClick="javascript: window.opener.location.href = window.opener.location.href; self.close();">
		<?php }else{ ?>
			<?=$error?>
			<br>
			<input type="button" value="Back" onClick="javascript: history.back();">
		<?php }?>
	<?php }else{?>
		<?php if($error == "") { ?>
		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
		<tr>
			<td class="label" width="38%">Full Name </td>
			<td class="label">:<input type="text" name="fullnamex"></td>
		</tr>
		<tr>
			<td class="label" width="38%">Email </td>
			<td class="label">:<input type="text" name="email"></td>
		</tr>
		<tr>
			<td class="label">Login ID</td>
			<td class="label">:<input type="text" name="username"></td>
		</tr>
		<tr>
			<td class="label">Password</td>
			<td class="label">:<input type="password" name="password"></td>
		</tr>
		<tr>
			<td class="label">User Type</td>
			<td class="label">:
				<select name="user_right">
					<option value="1">Admin
					<option value="0">Moderator
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Add" name="add"></td>
		</tr>
		</table>
		<?php }else{ 
			echo $error;
		} ?>
	<?php }?>
	</form>
	</td>
</tr>

</table>
</body>
</html>
