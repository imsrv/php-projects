<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

// Header
$cur = 'Inbox';
include("header.php");

$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$id' AND msg_to='$user_id'");
$check = mysql_num_rows($sql);
if ($check == 0) {
$sql = mysql_query("SELECT * FROM inbox WHERE msg_id='$id' AND msg_cc='$user_id'");
$check = mysql_num_rows($sql);
}
if ($check == 0) {
echo '<div id="textbox" align="center"><b>This message is not available!</b></center></div>';
include("footer.php");
exit();
}

if ($_GET['del'] == "true") {
mysql_query("DELETE FROM inbox WHERE msg_id='$id'");
echo '<script language="javascript">
setTimeout("window.parent.location=\'inbox.php\'", 2000);
</script>
<div id="textbox" align="center"><b>Message deleted!</b><br /><br />Transferring you to <a href="inbox.php">inbox</a>...</div>';
include("footer.php");
exit();
}
?>

<div id="textbox" align="center">
Are you sure you want to delete this message?
<br /><br />
<center>
<input type="button" value=" No " onClick="jump('read.php?id=<?=$id?>');"><br /><br />
<input type="button" value=" Yes " onClick="jump('delete.php?id=<?=$id?>&del=true');">
</center>
</div>

<?php

// Footer
include("footer.php");

?>