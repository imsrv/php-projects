<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

// start
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html");

function show_main_page($msg="") {
global $charset, $language, $enternickname, $yoursex, $male, $female, $choosecolor, $black, $orange, $red, $purple, $green, $blue, $gray, $enter;
?>
<html>
<head>
<title>My Chat</title>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
</head>
<body bgcolor="#6699CC" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">

<!--
======================================
||  Moiat Chat ver 4.05             ||
||  Copyright 2002-2003 by Bloody   ||
======================================
-->

<form action="index.php" method="post">
<center>
<table border=0 cellPadding=0 cellSpacing=0 width=460>
<tr><td><IMG align="left" border="0" src="./img/bg.gif" width="115" height="200"></td>
<td>

<table border="0" width="300" cellspacing="0" cellpadding="0">
<tr>
<td align="center"><img src="./img/logo.gif" border="0" width="260" height="69" align="center"><br>
<? echo $msg; ?></td>
</tr>
<tr>
<td><img src="./img/uptbl.gif" border="0" width="300" height="5"></td>
</tr>
<tr>
<td bgcolor="#ffffff" align="left">
<table width="298" border="0" cellspacing="5" cellpadding="0">
<tr>
<td width="50%">
<font face="Arial" size="2" color="#000000">&nbsp;<? echo $enternickname; ?>:</font>
</td>
<td align="left" valign=middle width="50%">
<input type="text" name="nickname" size="10" maxlength="15">
</td>
</tr>
<tr>
<td width="50%">
<font face="Arial" size="2" color="#000000">&nbsp;<? echo $yoursex; ?>:</font>
</td>
<td align="left" valign="middle" width="50%">
<select name="sex">
<option value="m" selected><? echo $male; ?></option>
<option value="f"><? echo $female; ?></option>
</select>
</td>
</tr>
<tr>
<td width="50%">
<font face="Arial" size="2" color="#000000">&nbsp;<? echo $choosecolor; ?>:</font>
</td>
<td align="left" valign=middle width=50%>
<select name="color">
<option value="black" selected><? echo $black; ?></option>
<option value="red"><? echo $red; ?></option>
<option value="orange"><? echo $orange; ?></option>
<option value="purple"><? echo $purple; ?></option>
<option value="green"><? echo $green; ?></option>
<option value="blue"><? echo $blue; ?></option>
<option value="gray"><? echo $gray; ?></option>
</select>
</td>
</tr>
<tr>
<td align="center" colspan="2">
<input type="submit" name="login" value="<? echo $enter; ?>">
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td><img src="./img/dntbl.gif" border="0" width="300" height="5"></td>
</tr>
</table>

</td>
</tr>
<tr>
<td align="left"><br><font face="Arial" size="2">&nbsp;<? include "online.php"; ?></font></td>
<td align="right"><br><font face="Arial" size="2">&copy; 2002 by Bloody&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
</tr>
</table>

</center>
</form>
<? include "showonline.php"; ?>
</body>
</html>
<?
}


if (!empty($HTTP_POST_VARS["sex"])) { $sex = $HTTP_POST_VARS["sex"]; }
if (!empty($HTTP_POST_VARS["color"])) { $color = $HTTP_POST_VARS["color"]; }
if (!empty($HTTP_POST_VARS["nickname"])) { $nickname = $HTTP_POST_VARS["nickname"]; }

if (!empty($HTTP_POST_VARS["ch"])) { $ch = $HTTP_POST_VARS["ch"];
include "rid.php";
if (!empty($HTTP_POST_VARS["room"])) { $room = $HTTP_POST_VARS["room"]; } 
$fprid = fopen("./s/$rid.txt","w+");
fwrite($fprid, "$nickname\n$sex\n$color\n$room");
fclose($fprid); }

$visitorip = getenv("REMOTE_ADDR"); 


$currtm = time();

if (!isset($nickname) || $nickname=="") {
show_main_page();

//end
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "<!-- Debug: ".$totaltime." -->";

exit;

} 
elseif (!ereg("^[a-zA-Z0-9à-ÿÀ-ß_\-]+$", $nickname)) {  
show_main_page("<font face=\"Arial\" size=\"2\">$wrongnickname</font><br><br>");
exit; }

elseif (ereg("^Bloody$", $nickname) && (!eregi("(194.12.255.166|127.0.0.1)", $visitorip))) {  
show_main_page("<font face=\"Arial\" size=\"2\">$bloodyreserved</font><br><br>");
exit; }

elseif (isset($banned) && ($banned==1)) {
show_main_page("<font face=\"Arial\" size=\"2\">$youarebanned</font><br><br>");
exit; }

else {
$userdata = file("users.txt");
$unum = count($userdata);
for ($i=0; $i<$unum; $i++) {
$ud = explode("|", $userdata[$i]);
if (($nickname==$ud[0] && trim($ud[4])>=$currtm) && ($ch!=1)) {
show_main_page("<font face=\"Arial\" size=\"2\">$alreadyloggedin</font><br><br>");
exit; }
}

if ($ch==1) {
$currtime = time();
$logouttime = ($currtime+45);
//$userdata = file("users.txt");
//$unum = count($userdata);

$reconstructed ="";
for ($i=0; $i<$unum; $i++) {

$ud = explode("|", $userdata[$i]);
$ud[4] = trim($ud[4]);

if ($ud[4] >= $currtime) {

if ($nickname == $ud[0]) {
$reconstructed .= $ud[0] ."|". $ud[1] ."|". $room ."|". $ud[3] ."|". $logouttime ."\n";;
} else { $reconstructed .= $ud[0] ."|". $ud[1] ."|". $ud[2] ."|". $ud[3] ."|". $ud[4] ."\n"; }
}

}

$fw = fopen("users.txt", "w");
set_file_buffer($fw, 0);
flock($fw, LOCK_EX);
fwrite($fw, $reconstructed);
flock($fw, LOCK_UN);
fclose($fw);

}

else {
$user = fopen("users.txt", "a");
set_file_buffer($user, 0);
flock($user, LOCK_EX);
fwrite($user, $nickname."|".$sex."|1|".$visitorip."|".($currtm+45)."\n");
flock($user, LOCK_UN);
fclose($user);
}

if (!isset($room)) $room=1;


//gen id
srand((double) microtime() * 1000000);
$rnum = rand(0, 1024);
$rnum2 = rand(1024, 2048);
$rid = $nickname . $rnum . $rnum2;
$fprid = fopen("./s/$rid.txt","w+");
fwrite($fprid, "$nickname\n$sex\n$color\n$room");
fclose($fprid);

setcookie("rid", $rid, time()+7200);


?>
<html>
<head>
<title>My Chat</title>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
<script language="JavaScript">
<!--
function op(to) {
setTimeout('cbottom.justfocus()',100);
cbottom.form1.chat.value = to+'::';
}
// -->
</script>
</head>

<frameset framespacing="0" border="0" frameborder="0" rows="70,*,51,0">
<frame name="up" src="up.php" scrolling="no" noresize>

<frameset cols="130,*,20">
<frame name="online" noresize src="about:blank">
<frame name="middle" target="bottom" src="chat.php<? echo "?rid=$rid"; ?>" scrolling="auto">
<? echo "<frame name=\"right\" target=\"bottom\" scrolling=\"no noresize\" src=\"right.php?rid=$rid&user=new\">"; ?>
</frameset>

<frameset cols="*">
<? echo "<frame name=\"cbottom\" scrolling=no src=\"chatbox.php?rid=$rid\">" ?>
<frame name="refr" src="refreshfr.php<? echo "?rid=$rid"; ?>" scrolling="no" noresize>
</frameset>
</frameset>
<? //exit;
}

//end
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "<!-- Debug: ".$totaltime." -->";
?>
</font> 
</html>