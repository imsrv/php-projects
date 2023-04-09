<?php
$userid = $_POST['userid'];
mysql_query("DELETE FROM users WHERE id='$userid'") or die (mysql_error());
?>
<div id="textbox" align="center">
The user has been deleted!
<br /><br />
<a href="admin.php?action=3">Delete a User</a> | <a href="admin.php">Home</a>
</div>