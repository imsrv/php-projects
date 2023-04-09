<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

//get userdata
include "rid.php";

// start
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

$currtime = time();

$bandata = file("banned.txt");
$bannedlines = count($bandata);
if ($bannedlines!=0) {

 for ($i=0; $i<$bannedlines; $i++) {

 $busr = explode("|", $bandata[$i]);
 $bip = $busr[0];
 $bname = trim($busr[1]);

 if ($REMOTE_ADDR==$bip && ($nickname==$bname)) {
 $youarebanned = 1; setcookie ("banned", 1, $currtime+3600); }
 }

}

$logouttime = ($currtime+45);
$reconstructed = "";

$userdata = file("users.txt");
$unum = count($userdata);

for ($i=0; $i<$unum; $i++) {

$ud = explode("|", $userdata[$i]);
$ud[4] = trim($ud[4]);

if ($ud[4] >= $currtime) {

 if ($nickname == $ud[0]) {
 $reconstructed .= $ud[0] ."|". $ud[1] ."|". $room ."|". $ud[3] ."|". $logouttime ."\n"; $recon = "done";
 } else { $reconstructed .= $ud[0] ."|". $ud[1] ."|". $ud[2] ."|". $ud[3] ."|". $ud[4] ."\n"; }

// if
}

// for
}

if ($recon != "done") { $reconstructed .= $nickname ."|". $sex ."|". $room ."|". $REMOTE_ADDR ."|". $logouttime ."\n"; }

$fw = fopen("users.txt", "w");
set_file_buffer($fw, 0);
flock($fw, LOCK_EX);
fwrite($fw, $reconstructed);
flock($fw, LOCK_UN);
fclose($fw);

header("Refresh: 15; refreshfr.php?nickname=" .rawurlencode($nickname). "&sex=$sex&room=$room");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
<script language="JavaScript">
<!--
top.online.document.charset="<? echo $charset; ?>";
top.online.document.open();

top.online.document.write('<html>'+
'<head>'+
'<title>Online Users</title>'+
'<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">'+
'<meta http-equiv="Content-Language" content="<? echo $language; ?>">'+
'<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache">'+
'</head>'+
'<body bgcolor="#6699CC" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">'+
'<font size="2" face="Arial">');


top.online.document.write('&nbsp;<? echo $whosonline; ?>:<br><br>');

<?

if ($youarebanned==1) {
echo "top.location.href = \"banneduser.php\";"; }


$udata = explode("\n", $reconstructed);
$unumb = count($udata);

for ($i=0; $i<$unumb; $i++) {
$ud = explode("|", $udata[$i]);

if (($ud[0]=="Bloody" || $ud[0]=="PCto") && ($ud[2]==$room)) { 
?>
top.online.document.write('<img src="./img/boy.gif"><a href="#" onclick="top.op(\'<? echo $ud[0]; ?>\');"><font color=#fcfc00><? echo $ud[0]; ?></font></a><br>');
<? }
elseif (($ud[1]=="m") && ($ud[2]==$room)) { 
?>
top.online.document.write('<img src="./img/boy.gif"><a href="#" onclick="top.op(\'<? echo $ud[0]; ?>\');"><? echo $ud[0]; ?></a><br>');
<? }
elseif (($ud[1]=="f") && ($ud[2]==$room)) {
?>
top.online.document.write('<img src="./img/girl.gif"><a href="#" onclick="top.op(\'<? echo $ud[0]; ?>\');"><? echo $ud[0]; ?></a><br>');
<? }

}

//end
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);

?>

top.online.document.write('<!-- <? echo "Debug: ".$totaltime; ?> -->');

top.online.document.write('</font>'+
'</body>'+
'</html>');

top.online.document.close();
// -->
</script>
</head>
</html>