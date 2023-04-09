<div id="textbox" align="center">
<form name="add" action="admin.php?action=u1" method="post">
<b>Add a User</b><br /><br />
First Name:<br /><input type="text" name="first" size="20" maxlength="50"><br /><br />
Last Name:<br /><input type="text" name="last" size="20" maxlength="50"><br /><br />
Username:<br /><input type="text" name="username" size="20" maxlength="50" onFocus="extractUsername()"><br /><br />
Password:<br /><input type="password" name="password" size="20" maxlength="25"><br /><br />
Confirm Password:<br /><input type="password" name="cpassword" size="20" maxlength="25"><br /><br />
User Notes:<br />
<textarea name="notes" cols="20" rows="5"></textarea><br /><br />
<input type="submit" value="Add User"> <input type="reset" value="Reset">
</form>
</div>