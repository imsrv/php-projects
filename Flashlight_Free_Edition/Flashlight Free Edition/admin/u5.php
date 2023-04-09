<?php

function doerror($err) {
echo '<div id="textbox" align="center">
<b>Error:</b><br /><br />
'.$err.'<br /><br />
<a href="javascript:history.go(-1)">&lt;&lt; Go Back</a>
</div>';
include("footer.php");
exit();
}

$vars = array('cname', 'curl', 'attachments', 'maxsize', 'maxtotal');

for ($i = 0; $i < count($vars); $i++) {
$vars[$i] = addslashes($_POST[$vars[$i]]);
}

if (strlen(trim($cname)) == 0) {
doerror('You did not enter a company name!');
}

if (strlen(trim($attachments)) == 0) {
$attachments = 0;
}

if ($attachments == 1) {
if (strlen(trim($maxsize)) == 0) {
doerror('You did not enter a message attachments maxsize!');
}
if (!is_numeric($maxsize)) {
doerror('You entered an invalid character in message attachments maxsize (numbers only)!');
}
if (strlen(trim($maxtotal)) == 0) {
doerror('You did not enter a message attachments total!');
}
if (!is_numeric($maxtotal)) {
doerror('You entered an invalid character in message attachments total (numbers only)!');
}
}

mysql_query("UPDATE settings SET company_name='$cname', company_url='$curl', attachments='$attachments', attachments_maxsize='$maxsize', attachments_total='$maxtotal'") or die (mysql_error());
?>

<div id="textbox" align="center">
Settings have been updated!
<br /><br />
<a href="admin.php?action=5">Back to Settings</a> | <a href="admin.php">Home</a>
</div>