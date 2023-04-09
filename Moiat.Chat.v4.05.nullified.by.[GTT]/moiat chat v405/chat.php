<?
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

//get userdata
include "rid.php";

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html");
?>
<html><head>
<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache">
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
<script language="JavaScript">
<!--
function move() { self.scrollBy(0,999999); }
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#808080" vlink="#C0C0C0" alink="#808080">
<font face="Arial" size="2">
<? 
set_time_limit(0);
ignore_user_abort(1);

// flush sled vseki tekst
ob_implicit_flush(1);

if (!isset($room) || !ereg("^[1-4]{1}$",$room)) $room = 1;
$roomfile = "chat" . $room . ".dat";

$crlist = file("myrooms.txt");
$croomc = count($crlist)-1;
for ($i=0; $i<=$croomc; $i++) {

$rmdata = explode("|", $crlist[$i]);
if ($rmdata[0]==$room) { $roomname = $rmdata[1]; }
}
if ($roomname=='') { $roomname = "unknown"; }

function smiles ($smstring, $usr) {
global $sex;

$smstring = eregi_replace(":[-]*[\)]{1,}", "<img src=./img/smile_$sex.gif width=12 height=12 align=middle>", $smstring);
$smstring = eregi_replace("8[-]*[\)]{1,}", "<img src=./img/cool_$sex.gif width=12 height=12 align=middle>", $smstring);
$smstring = eregi_replace(":[-]*[\(]{1,}", "<img src=./img/sad_$sex.gif width=12 height=12 align=middle>", $smstring);
$smstring = eregi_replace(":[-]*[p|ð|Ð]{1,}", "<img src=./img/tongue_$sex.gif width=12 height=12 align=middle>", $smstring);
$smstring = eregi_replace(";[-]*[\)]{1,}", "<img src=./img/wink_$sex.gif width=12 height=12 align=middle>", $smstring);

return $smstring;
}


function glmsg() {
global $roomfile;
$charr = file($roomfile);
$last_msgc = count($charr)-1;
$last_msg = $charr[$last_msgc];
return trim($last_msg);
}


function cmpmsg($inp) {
global $roomfile;

$charr = file($roomfile);
$last_msgc = count($charr)-1;

for ($i=0; $i<=$last_msgc; $i++) {
$charr[$i] = trim($charr[$i]);
if ($inp==$charr[$i]) {
$toreturn = $i+1;
for ($ri=$toreturn; $ri<=$last_msgc; $ri++)
{ $retmsg .= $charr[$ri]."\n"; }
}

}

return $retmsg;
}

if ($sex=="f") { echo $nickname .", ". $femalewelcome .".<br>\n"; }
else { echo $nickname .", ". $malewelcome .".<br>\n"; } 
echo $youarein ." ". $roomname ." ". $croom ."<br>\n";

$count=0;

while(connection_status()===0) {

$mm = glmsg();
sleep(1);
//usleep(500000);
$mm2 = cmpmsg($mm);

$count++;
$check=($count % 30);
if ($check==0) { echo " "; }

if ($mm2!="") {

$ds = explode("\n", $mm2);
$dc = count($ds)-1;

for ($i=0; $i<$dc; $i++) {

if (ereg("<!--(.+)-->([a-zA-Z0-9à-ÿÀ-ß_\-]+)::([a-zA-Z0-9à-ÿÀ-ß_\-]+)::([^<]*)<br>", $ds[$i], $nk)) { 

$nk[4] = smiles($nk[4], $nk[2]);

if ($nickname==$nk[2]) { echo "<b>$personalfor $nk[3]:</b> ". stripslashes($nk[4]). "<script>move();</script><br>"; } 
if ($nickname==$nk[3]) { echo "<b>$personalfrom $nk[2]:</b> ". stripslashes($nk[4]). "<script>move();</script><br>"; } 

} else { 

$fk = ereg("<!--(.+)--><font color=[^>]+>([a-zA-Z0-9à-ÿÀ-ß_\-]+)</font>", $ds[$i], $nk);

$ds[$i] = smiles($ds[$i], $nk[2]);

echo stripslashes($ds[$i])."<script>move();</script>"; }

//for $i
}

//if $mm2
}

//while
}

//remove the session file
unlink("./s/". $rid .".txt");

exit;
//echo "</font></body></html>";
?>