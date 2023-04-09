<?php

$timedate = date("d M y - H:i");
$useraddress = $_SERVER['REMOTE_ADDR'];
require "../common/config.php";

if (isset($submit))
{
$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");

mysql_select_db("$dbname",$db);
$checker = mysql_query("SELECT user_password FROM nuke_users WHERE username = '$username'");
while ($disp = mysql_fetch_array($checker))
{
$realuserpw = $disp["user_password"];
}


if (($userpw == $realuserpw) && ($userpw != "")) {

include "../common/checks.php";
mysql_select_db("$dbname",$db);
$sql = "INSERT INTO nuke_clearchat (username, comment, useraddress, date) VALUES ('$username','$comment','$useraddress','$timedate')";
$result = mysql_query($sql);

} else {

//Inserts error data
$userinfo = $_SERVER['HTTP_USER_AGENT'];
$errornumber = "2: Undocked";
mysql_select_db("$dbname",$db);
$sql = "INSERT INTO nuke_ccerror (username, userpw, realuserpw, errornumber, useraddress, userinfo, date, comment) VALUES ('$username', '$userpw', '$realuserpw', '$errornumber', '$useraddress', '$userinfo', '$timedate', '$comment')";
$result = mysql_query($sql);

$error = "true";
}
}

$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");

mysql_select_db("$dbname",$db);
$checker = mysql_query("SELECT user_password FROM nuke_users WHERE username = '$username'");
while ($disp = mysql_fetch_array($checker))
{
$userpw = $disp["user_password"];
}
?>

<html><head>
<title>Undocked ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<script language="JavaScript" src="../common/clearchat.js" type="text/javascript"></script>
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
<meta http-equiv="Pragma" content="no-cache">
<?php
if ($error == "true") {
echo "<script language=\"javascript\" type=\"text/javascript\">\nalert('Your username/password combination did not match.\\nPlease contact the site administrator if this problem persists.\\nThe error has been logged.')</script>";
}
?>
</head><body bgcolor="#000044" class="input" onLoad="parent.outputframe.location.href='view.php', document.inputform.comment.focus()">
<form name="inputform" action="input.php" autocomplete="off" method="get" onSubmit="return checkComment()">
<input type="text" name="comment" size="28" maxlength="255"><br>
<nobr>
<input type="submit" name="submit" class="saybtn" value="Say">&nbsp;
<a href="javascript:smiley(':)')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>smile.gif" alt="Smile" border="0" height="15" width="15" /></a>
<a href="javascript:smiley(':(')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>sad.gif" alt="Sad" border="0" height="15" width="15" /></a>
<a href="javascript:smiley('8)')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>cool.gif" alt="Cool" border="0" height="15" width="15" /></a>
<a href="javascript:smiley(';D')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>smilewinkgrin.gif" alt="Smilegrin" border="0" height="15" width="15" /></a>
<a href="javascript:smiley('-laugh-')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>laugh.gif" alt="Laughing" border="0" height="15" width="15" /></a>
</nobr><br>

<nobr>&nbsp;
<a href="Javascript: top.close()">Close</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../common/smilies.php", "smilies", "width=300, height=350, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=0, scrollbars=0, status=0, titlebar=0, toolbar=0")'>Smilies</a>
<span class="say"> : </span>
<a href="<?php echo $siteurl; ?>" target="_blank">Site</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../common/help.php", "help", "width=750, height=550, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=1, scrollbars=1, status=0, titlebar=0, toolbar=0")'>?</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../copyright.php", "Copyright", "toolbar=no, location=no, directories=no, status=no, scrollbars=yes,  resizable=no, copyhistory=no, width=500, height=270")'>©</a>
</nobr><br>

<input type="text" name="username" class="usrn" value="<?php echo $username; ?>">
<input type="text" name="userpw" class="usrn" value="<?php echo $userpw; ?>">
</form>
</body>
</html>