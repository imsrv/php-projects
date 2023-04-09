<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");
include("func.inc.php");

// Header
$cur = 'Inbox';
include("header.php");
?>

<div id="textbox">
<div id="msglist">
<span>
<form name="delete" action="massdelete.php" method="post" onSubmit="return confirmDelete();">
<?php
$pp_array = array();
$sql = mysql_query("SELECT * FROM inbox WHERE msg_to='$user_id' OR msg_cc='$user_id'");
$pages = mysql_num_rows($sql);
if ($pages == 0) {
echo 'You have no messages in your inbox...';
}
else {
$page = $_GET['page'];
if ($page <= 0) { $page = 1; }
$perpage = 20;
$pos = $page * $perpage - $perpage;
if ($pos < 0) { $pos = 0; }
$pages = $pages / $perpage;
if (strrpos($pages,'.') > 0) {
$pages = substr($pages, 0, strrpos($pages,'.'));
$pages = $pages + 1;
}
$query = mysql_query("SELECT * FROM inbox WHERE msg_to='$user_id' OR msg_cc='$user_id' ORDER BY msg_id DESC LIMIT $pos, $perpage");
while($r = mysql_fetch_array($query)) {
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='{$r['msg_from']}'");
$fetch = mysql_fetch_row($get);
$from_user = $fetch[0] . " " . $fetch[1];

if ($from_user == " ") {
$from_user = "N/A";
}

if ($r['msg_read'] == 0) {
$read = '<input type="checkbox" name="msg[]" value="'.$r['msg_id'].'"> <a href="read.php?id='.$r['msg_id'].'"><b>'.stripslashes($r['msg_subject']).'</b></a> - [<b>'.$from_user.'</b>] - [<b>'.gmdate('M jS @ H:i A', $r['msg_time']).'</b>]<br />';
}
else {
$read = '<input type="checkbox" name="msg[]" value="'.$r['msg_id'].'"> <a href="read.php?id='.$r['msg_id'].'">'.stripslashes($r['msg_subject']).'</a> - ['.$from_user.'] - ['.gmdate('M jS @ H:i A', $r['msg_time']).']<br />';
}
echo $read;
}
echo "\n<br />";
echo '&nbsp;<input type="button" class="btn" value="Select All" onClick="checkAll(this.form);"> <input type="submit" class="btn" value="Delete Selected">';
echo "\n<br /><br />";
for ($i = 1; $i <= $pages; $i++) {
if ($page == $i) {
$pp_array[] = '<i>Page ' . $i . '</i>';
}
else {
$pp_array[] = '<a href="inbox.php?page='.$i.'">Page '.$i.'</a>';
}
}
echo '&laquo; ' . implode(' | ', $pp_array) . ' &raquo;';
}
?>

<input type="hidden" name="ref" value="inbox">
</form>
</span>
</div>
</div>

<?php

// Footer
include("footer.php");

?>