<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();

	include("../_include/connection.php");
	$added = false;
	if(isset($add))
	{
		if($rights == 1)
			mysql_query("UPDATE calendar_user SET fullname = '$fullnamex', password = '$password', email = '$email', user_right = '$user_right' WHERE user_id = $eid");
		else
			mysql_query("UPDATE calendar_user SET fullname = '$fullnamex', password = '$password', email = '$email' WHERE user_id = $eid");
		$added = true;
	}
	else
	{
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
	<td class="header" align="center">Edit User</td>
</tr>
<tr>
	<td><hr></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label" align="center">
	<form action="editUser.php" method="post">
	<?php if($added){?>
		User saved!
		<br>
		<input type="button" value="Close" onClick="javascript: window.opener.location.href = window.opener.location.href; self.close();">
	<?php }else{?>
		<?php if($error == "") { ?>
		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
		<tr>
			<td class="label" width="38%">Full Name </td>
			<td class="label">:<input type="text" name="fullnamex" value="<?=$row["fullname"]?>"></td>
		</tr>
		<tr>
			<td class="label" width="38%">Email </td>
			<td class="label">:<input type="text" name="email" value="<?=$row["email"]?>"></td>
		</tr>
		<tr>
			<td class="label">Login ID</td>
			<td class="label">:<?=$row["username"]?></td>
		</tr>
		<tr>
			<td class="label">Password</td>
			<td class="label">:<input type="password" name="password" value="<?=$row["password"]?>"></td>
		</tr>
		<?php if($rights == 1) {?>
		<tr>
			<td class="label">User Type</td>
			<td class="label">:
				<select name="user_right">
					<option value="1"<?php if($row["user_right"] == "1") echo " selected";?>>Admin
					<option value="0"<?php if($row["user_right"] == "0") echo " selected";?>>Moderator
				</select>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2" align="center"><input type="hidden" name="eid" value="<?=$item?>"><input type="submit" value="Save" name="add"></td>
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
