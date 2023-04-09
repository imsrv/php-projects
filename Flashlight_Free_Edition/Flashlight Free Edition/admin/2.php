<div id="textbox" align="center">

<?php
if ((!isset($_GET['user'])) || ($_GET['user'] == "")) {
?>
<form name="edit">
<b>Edit a User</b><br /><br />
<select name="user" size="7">
<?php
$query = mysql_query("SELECT * FROM users ORDER BY last_name");
while($r = mysql_fetch_array($query)) {
$id = $r['id'];
$first = $r['first_name'];
$last = $r['last_name'];
echo '<option value="'.$id.'">'.$first.' '.$last.'</option>';
}
?>
</select>
<br /><input type="button" value="Edit User" onClick="jump('admin.php?action=2&user=' + document.edit.user.value);">
</form>
<?php
}
else {
$user = $_GET['user'];

$get = mysql_query("SELECT first_name, last_name, username, notes FROM users WHERE id='$user'");
$fetch = mysql_fetch_row($get);
$first = $fetch[0];
$last = $fetch[1];
$uname = $fetch[2];
$notes = stripslashes($fetch[3]);
?>

<form name="edit" action="admin.php?action=u2" method="post">
First Name:<br /><input type="text" name="first" size="20" maxlength="50" value="<?=$first?>"><br /><br />
Last Name:<br /><input type="text" name="last" size="20" maxlength="50" value="<?=$last?>"><br /><br />
Username:<br /><input type="text" name="username" size="20" maxlength="50" value="<?=$uname?>"><br /><br />
<font color="#FF0000"><b>Change</b></font> Password:<br /><input type="password" name="password" size="20" maxlength="25"><br /><br />
Confirm <font color="#FF0000"><b>Change</b></font> Password:<br /><input type="password" name="cpassword" size="20" maxlength="25"><br /><br />
User Notes:<br />
<textarea name="notes" cols="20" rows="5"><?=$notes?></textarea><br /><br />
<input type="submit" value="Edit User"> <input type="reset" value="Reset">
<input type="hidden" name="userid" value="<?=$user?>">
</form>

<?php
}
?>
</div>