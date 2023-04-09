<?php
require "../common/config.php";

if ($pw != $adminpw) {
die("Incorrect or missing password...");
} else {

$timedate = date("d M y - H:i");
$useraddress = $_SERVER['REMOTE_ADDR'];

$db = mysql_connect("$dbaddress", "$dbuser", "$dbpass");

if (isset($delete))
{
mysql_select_db("$dbname",$db);
$result = mysql_query("DELETE FROM nuke_$delete",$db);

unset ($delete);

header("Location: input.php?pw=$pw&username=$username&userpw=$userpw");

exit;
}

if (isset($submit))
{

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
$errornumber = "3: Admin";
mysql_select_db("$dbname",$db);
$sql = "INSERT INTO nuke_ccerror (username, userpw, realuserpw, errornumber, useraddress, userinfo, date, comment) VALUES ('$username', '$userpw', '$realuserpw', '$errornumber', '$useraddress', '$userinfo', '$timedate', '$comment')";
$result = mysql_query($sql);

$error = "true";
}
}

mysql_select_db("$dbname",$db);
$checker = mysql_query("SELECT user_password FROM nuke_users WHERE username = '$username'");
while ($disp = mysql_fetch_array($checker))
{
$userpw = $disp["user_password"];
}
?>

<html>
<head>
<title>ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<script language="JavaScript" src="../common/clearchat.js" type="text/javascript"></script>
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
<meta http-equiv="Pragma" content="no-cache">
<?php
if ($error == "true") {
echo "<script language=\"javascript\" type=\"text/javascript\">\nalert('Your username/password combination did not match.\\nPlease contact the site administrator if this problem persists.\\nThe error has been logged.\\n\\n(If you are the admin, make sure you are logged in as a user!)')</script>";
}
?>
</head>
<body bgcolor="#000044" class="input" onLoad="parent.outputframe.location.href='view.php?pw=<?php echo $pw; ?>', document.inputform.comment.focus()">
<table border="0">
<tr>
<td width="360">
<form name="inputform" action="input.php?pw=<?php echo $pw; ?>" autocomplete="off" method="get" onSubmit="return checkComment()">
<input type="text" name="comment" size="55" maxlength="255"><br>

<nobr>
<input type="submit" name="submit" class="saybtn" value=" Say ">&nbsp;
<input type="button" name="refresh" class="saybtn" value="View Chat" onClick="parent.outputframe.location.href='view.php?pw=<?php echo $pw; ?>';">&nbsp;
<a href="javascript:smiley(':)')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>smile.gif" alt="Smile" border="0" height="15" width="15" /></a>
<a href="javascript:smiley(':(')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>sad.gif" alt="Sad" border="0" height="15" width="15" /></a>
<a href="javascript:smiley('8)')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>cool.gif" alt="Cool" border="0" height="15" width="15" /></a>
<a href="javascript:smiley(';D')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>smilewinkgrin.gif" alt="Smilegrin" border="0" height="15" width="15" /></a>
<a href="javascript:smiley('-laugh-')"><img src="../common/smilies/<?php echo $smileycolor; ?>/<?php echo $smileycolor; ?>laugh.gif" alt="Laughing" border="0" height="15" width="15" /></a>
</nobr>
<br>

<nobr>
&nbsp;<a href="Javascript:void(0);" onClick='window.open("../undocked-files/undockedchat.php?username=<?php echo $username; ?>", "undockedchat", "width=200, height=500, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=1, scrollbars=0, status=0, titlebar=0, toolbar=0")'>Undock</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../common/help.php", "help", "width=750, height=550, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=1, scrollbars=1, status=0, titlebar=0, toolbar=0")'>?</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../common/smilies.php", "smilies", "width=300, height=350, screenX=20, screenY=20, top=20, left=20, menubar=0, resizable=0, scrollbars=0, status=0, titlebar=0, toolbar=0")'>Smilies</a>
<span class="say"> : </span>
<a href="input.php?pw=<?php echo $pw; ?>&amp;username=<?php echo $username; ?>&amp;userpw=<?php echo $userpw; ?>&amp;delete=clearchat" onclick="return confirm('Delete all data in \nthe clearchat table?')">Empty chat log</a>
<span class="say"> : </span>
<a href="input.php?pw=<?php echo $pw; ?>&amp;username=<?php echo $username; ?>&amp;userpw=<?php echo $userpw; ?>&amp;delete=ccerror" onclick="return confirm('Delete all data in \nthe error log table?')">Empty error log</a>
</nobr><br>

<input type="text" name="pw" class="usrn" value="<?php echo $pw; ?>"><br>
<input type="text" name="username" class="usrn" value="<?php echo $username; ?>"><br>
<input type="text" name="userpw" class="usrn" value="<?php echo $userpw; ?>">
</form>
</td>

<td valign="top" align="left">
<form name="chatlogform" action="chatlog.php?pw=<?php echo $pw; ?>" method="post" target="outputframe">
<input type="text" name="lognumber" size="10" value="1000"><br>
<input type="submit" name="submitlognumber" class="saybtn" value="Chat log">&nbsp;
</form>
</td>

<td valign="top" align="left">
<form name="errorlogform" action="errorlog.php?pw=<?php echo $pw; ?>" method="post" target="outputframe">
<input type="text" name="lognumber" size="10" value="20"><br>
<input type="submit" name="submitlognumber" class="saybtn" value="Error log">&nbsp;
</form>
</td>

<td valign="top" align="left">
<form name="idcheckform" action="idcheck.php?pw=<?php echo $pw; ?>" method="post" target="outputframe">
<input type="text" name="checkdata" size="25" value="<?php echo $username; echo" / "; echo $useraddress; ?>"><br>
<input type="submit" name="submit" class="saybtn" value="NickCheck">
<input type="submit" name="submit" class="saybtn" value="IPCheck">&nbsp;
</form>
</td>

</table>
</body>
</html>

<?php
}
?>