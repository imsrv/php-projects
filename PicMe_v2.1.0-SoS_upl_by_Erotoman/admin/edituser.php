<?PHP
/*
#
#	$Id: EDITUSER.PHP
#	Version 2.0.0
#
*/
?>
	<a href="<? echo $PHP_SELF; ?>?action=deleteuser&userid=<? echo $userid ?>">Delete User</a>
	</td>
	<form name="updateuser" action="<? echo $PHP_SELF; ?>" method="put">
	<b>Last updated:</b> <? echo $updated ?>
	<table border="0" cellpadding="0" cellspacing="0" width="75%">
		<tr>
	<td Align="right"><b>Userid:</b></td>
	<td><input type="hidden" name="userid" value="<? echo $userid; ?>"><b>&nbsp;<? echo $userid; ?></b></td>
	<td Align="right"><b>Password:&nbsp;</b></td>
	<td><input type="text" name="password" size="24" value="<? echo $password; ?>"></td>
	</tr>
	<tr>
	<td Align="right"><b>Email:&nbsp;</b></td>
	<td><input type="text" name="email" size="24" value="<? echo $email; ?>"></td>
	<td Align="right"><b>Sex:&nbsp;</b></td>
	<td><select name="sex" size="1">
	<option value="Male"<? if($sex == Male) { echo selected; } ?>>Male</option>
	<option value="Female"<? if($sex == Female) { echo selected; } ?>>Female</option>
	</select></td>
	</tr>
	<tr>
	<td Align="right"><b>Hobbies:&nbsp;</b></td>
	<td><input type="text" name="hobbies" size="24" value="<? echo $hobbies; ?>"></td>
	<td Align="right"><b>Music:&nbsp;</b></td>
	<td><input type="text" name="music" size="24" value="<? echo $music; ?>"></td>
	</tr>
	<tr>
	<td Align="right"><b>Chat:&nbsp;</b></td>
	<td><input type="text" name="chat" size="24" value="<? echo $chat; ?>"></td>
	<td Align="right"><b>Email Visible:&nbsp;</b></td>
	<td><input type="checkbox" value="1" name="emailvisible"
	<? if($emailvisible == "1") { echo "checked"; }?>>
	</td>
	</tr>
	<tr>
	<td>
	<input type="hidden" name"submituser" value="on">
	<br><input type="submit" name="submituser" value="Update User"></td>
	<td>
	</td>
	<td></td>
	<td></td>
	</tr>
	</table>
	</form>