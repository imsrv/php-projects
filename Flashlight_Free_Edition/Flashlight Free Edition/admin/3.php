<div id="textbox" align="center">

<?php
if ((!isset($_GET['user'])) || ($_GET['user'] == "")) {
?>
<form name="del">
<b>Delete a User</b><br /><br />
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
<br /><input type="button" value="Delete User" onClick="jump('admin.php?action=3&user=' + document.del.user.value);">
</form>
<?php
}
else {
$user = $_GET['user'];
?>

<form name="delete" action="admin.php?action=u3" method="post">
Are you sure you want to delete this user?
<br /><br />
<input type="button" value=" No " onClick="jump('admin.php?action=3');"><br /><br />
<input type="submit" value=" Yes ">
<input type="hidden" name="userid" value="<?=$user?>">
</form>

<?php
}
?>
</div>