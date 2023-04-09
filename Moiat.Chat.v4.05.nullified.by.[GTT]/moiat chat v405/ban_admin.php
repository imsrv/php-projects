<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/
$username = "admin";
$password = "admin";

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html");

if ( (!isset($PHP_AUTH_USER)) || !(($PHP_AUTH_USER == $username) && ( $PHP_AUTH_PW == $password )) ) {
header("WWW-Authenticate: Basic Realm=\"BAN admin\"");
header("HTTP/1.0 401 Unauthorized");
echo "Unauthorized access..."; exit;
}


// include the language file
include "language.php";

?>
<html>
<head>
<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache">
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
</head>
<body bgcolor="#6699CC" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
<?


if (isset($ban) && eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", $ban) && (isset($name))) {

$banned = file ("banned.txt");
$bcnt = count($banned);

for ($i=0; $i<$bcnt; $i++){

$busr = explode("|", $banned[$i]);
$bip = $busr[0];
$bname = trim($busr[1]);

if (($bip==$ban) && ($bname==$name)) { $fnd = 1;}
}
if ($fnd!=1) {
echo "$youbanneduserip: $ban $andnick: $name<br><br>";
$fw = fopen("banned.txt","a");
set_file_buffer($fw, 0);
flock($fw, LOCK_EX);
fwrite($fw, "$ban|$name\n");
flock($fw, LOCK_UN);
fclose($fw); } else { echo "$alreadybannedip: $ban $andnick: $name<br><br>"; }
}
elseif (isset($unban) && eregi("[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", $unban) && (isset($name))) {

$banned = file ("banned.txt");
$bcnt = count($banned);

for ($i=0; $i<$bcnt; $i++){

$ubusr = explode("|", $banned[$i]);
$ubip = $ubusr[0];
$ubname = trim($ubusr[1]);

if (($ubip==$unban) && ($ubname==$name)) { echo "$ipunbanned: $unban<br><br>"; }
else { $fullb = $fullb . $ubip ."|". $ubname ."\n"; }
}
$fw = fopen("banned.txt","w");
set_file_buffer($fw, 0);
flock($fw, LOCK_EX);
fwrite($fw, $fullb);
flock($fw, LOCK_UN);
fclose($fw); 
}

$usr = file ("users.txt");
$ucnt = count($usr);

echo "<b>$currentlythesearin:</b><br><table width=100% border=0>
<tr>
<td width=30%><b>$bnickname</b></td>
<td width=10%><b>$bsex</b></td>
<td width=10%><b>$broom</b></td>
<td width=20%><b>IP</b></td>
<td width=30%><b>BAN</b></td>
</tr>";

for ($i=0; $i<$ucnt; $i++){

$ud = explode("|", $usr[$i]);
$unick = $ud[0];
$usex = $ud[1];
$uroom = $ud[2];
$uip = $ud[3];

echo "<tr>
<td>$unick</td>
<td>$usex</td>
<td>$uroom</td>
<td>$uip</td>
<td><a href=ban_admin.php?ban=$uip&name=$unick>$justban</a></td>
</tr>";

}

echo "</table><br><br><br>";


$banned = file ("banned.txt");
$bcnt = count($banned);

echo "<b>$thebannedips:</b><br><table width=60% border=0>
<tr>
<td width=20%><b>IP</b></td>
<td width=20%><b>»ÏÂ</b></td>
<td width=20%><b>UNBAN</b></td>
</tr>";

for ($i=0; $i<$bcnt; $i++){

$busr = explode("|", $banned[$i]);
$bip = $busr[0];
$bname = trim($busr[1]);

echo "<tr>
<td>$bip</td>
<td>$bname</td>
<td><a href=ban_admin.php?unban=$bip&name=$bname>$justunban</a></td>
</tr>";

}

echo "</table><br><br>
<a href=ban_admin.php>$refreshdata</a>
<br>
</body>
</html>";