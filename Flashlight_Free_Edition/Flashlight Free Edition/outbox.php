<?php

// Before page load 
session_start();
include("config.php");
include("auth.php");
include("info.php");

// Header
$cur = 'Outbox';
include("header.php");
?>

<div id="textbox">
<div id="msglist">
<span>
<form name="delete" action="massdelete.php" method="post" onSubmit="return confirmDelete();">
<?php
$pp_array = array();
$sql = mysql_query("SELECT * FROM outbox WHERE msg_from='$user_id'");
$pages = mysql_num_rows($sql);
if ($pages == 0) {
echo 'You have no messages in your outbox...';
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
$query = mysql_query("SELECT * FROM outbox WHERE msg_from='$user_id' ORDER BY msg_id DESC LIMIT $pos, $perpage");
while($r = mysql_fetch_array($query)) {
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='{$r['msg_to']}'");
$fetch = mysql_fetch_row($get);
$to_user = $fetch[0] . " " . $fetch[1];

if ($to_user == " ") {
$get = mysql_query("SELECT first_name, last_name FROM users WHERE id='{$r['msg_cc']}'");
$fetch = mysql_fetch_row($get);
$to_user = $fetch[0] . " " . $fetch[1];
}

if ($to_user == " ") {
$to_user = "N/A";
}

echo '<input type="checkbox" name="msg[]" value="'.$r['msg_id'].'"> <a href="view.php?id='.$r['msg_id'].'">'.stripslashes($r['msg_subject']).'</a> - ['.$to_user.'] - ['.gmdate('M jS @ H:i A', $r['msg_time']).']<br />';
}
echo "\n<br />";
echo '&nbsp;<input type="button" class="btn" value="Select All" onClick="checkAll(this.form);"> <input type="submit" class="btn" value="Delete Selected">';
echo "\n<br /><br />";
for ($i = 1; $i <= $pages; $i++) {
if ($page == $i) {
$pp_array[] = '<i>Page ' . $i . '</i>';
}
else {
$pp_array[] = '<a href="outbox.php?page='.$i.'">Page '.$i.'</a>';
}
}
echo '&laquo; ' . implode(' | ', $pp_array) . ' &raquo;';
}
?>

<input type="hidden" name="ref" value="outbox">
</form>
</span>
</div>
</div>

<?php

// Footer
include("footer.php");

?>