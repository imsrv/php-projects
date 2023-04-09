<div id="textbox">
<center>
<b>Search Results</b>
<br /><br />
<?php

if ($_POST['id'] !== "") {
$id = trim($_POST['id']);
$sql = mysql_query("SELECT first_name, last_name FROM users WHERE id='$id'");
if (mysql_num_rows($sql) == 0) {
echo 'User #'.$id.' not found!';
}
else {
$fetch = mysql_fetch_row($sql);
$fullname = $fetch[0] . " " . $fetch[1];
echo 'User #'.$id.': <a href="admin.php?action=6&user='.$id.'">'.$fullname.'</a>';
}
}
else {
//First name search
if (isset($_POST['first'])) {
$first_name = trim($_POST['first']);
$param = "first_name LIKE '%" . $first_name ."%'";
}

//Last name search
if (isset($_POST['last'])) {
if (isset($first_name)) { $param .= " AND "; }
$last_name = trim($_POST['last']);
$param .= "last_name LIKE '%" . $last_name ."%'";
}

if ($param !== "") {
echo '</center>';
$query = mysql_query("SELECT * FROM users WHERE $param ORDER BY last_name");
while($r = mysql_fetch_array($query)) {
$fullname = $r['first_name'] . " " . $r['last_name'];
echo '<li> <a href="admin.php?action=6&user='.$r['id'].'">'.$fullname.'</a>';
}
}
echo '<center>';
}
?>
<br /><br />
<a href="admin.php?action=4">Search for a User</a> | <a href="admin.php">Home</a>
</center>
</div>