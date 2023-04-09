<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

// Header
$cur = 'Outbox';
include("header.php");

$id = $_GET['id'];
$sql = mysql_query("SELECT * FROM outbox WHERE msg_id='$id' AND msg_from='$user_id'");
$check = mysql_num_rows($sql);
if ($check == 0) {
echo '<div id="textbox" align="center"><b>This message is not available!</b></center></div>';
include("footer.php");
exit();
}

if ($_GET['del'] == "true") {
mysql_query("DELETE FROM outbox WHERE msg_id='$id'");
echo '<script language="javascript">
setTimeout("window.parent.location=\'outbox.php\'", 2000);
</script>
<div id="textbox" align="center"><b>Message deleted!</b><br /><br />Transferring you to <a href="outbox.php">outbox</a>...</div>';
include("footer.php");
exit();
}
?>

<div id="textbox" align="center">
Are you sure you want to delete this message?
<br /><br />
<center>
<input type="button" value=" No " onClick="jump('view.php?id=<?=$id?>');"><br /><br />
<input type="button" value=" Yes " onClick="jump('delete_outbox.php?id=<?=$id?>&del=true');">
</center>
</div>

<?php

// Footer
include("footer.php");

?>