<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

if (($HTTP_REFERER=="") && isset($chat)) {

echo '<script language="JavaScript">
<!--
top.location.href = "banneduser.php";
// -->
</script>';

exit;
}

// include the language file
include "language.php";

//get userdata
include "rid.php";

// start
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

if (!empty($HTTP_POST_VARS["chat"])) { $chat = $HTTP_POST_VARS["chat"]; }

?>
<html>
<head>
<title>empty blue</title>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
</head>
<?

if (!isset($room) || !ereg("^[1-4]{1}$",$room)) $room = 1;
$roomfile = "chat" . $room . ".dat";

echo '<body bgcolor="#6699CC" text="#FFFFFF" link="#808080" vlink="#C0C0C0" alink="#808080">
<font face="Arial" size="2">';


function rollLog($filename, $nrlines) {
$lines = file($filename);
$currlines = count($lines);

if($currlines > $nrlines) {
$fp = fopen($filename, "w");
set_file_buffer($fp, 0);
flock($fp, LOCK_EX);
$fw = fopen("history.txt", "a");
set_file_buffer($fw, 0);
flock($fw, LOCK_EX);

for($i=0; $i<$currlines; $i++) {
if ($i<($currlines-$nrlines+1)) { $lines[$i] = trim($lines[$i]); fwrite($fw, $lines[$i]."\n"); }
else { $lines[$i] = trim($lines[$i]); fwrite($fp, $lines[$i]."\n"); }
}

flock($fw, LOCK_UN);
fclose($fw);
flock($fp, LOCK_UN);
fclose($fp);
    }
}


rollLog($roomfile, 20);

$anum = microtime();
$date=(date("d-m-Y"));
$time=(date("H:i:d"));

// when a new user enters the chat
if ($user == "new") {
	$flp = fopen($roomfile, "a");
        set_file_buffer($flp, 0);
	flock($flp, LOCK_EX);
	fwrite($flp,"<!--$anum--><font color=black>$nickname $enterson $date $at $time.</font><br>\n");
	flock($flp, LOCK_UN);
	fclose($flp);
}

	if ($chat=="" || $chat==" ") { }
	elseif ($chat == "/help") {
		echo "<script language=\"JavaScript\">alert('$thecommands:\\n\\n  /help - $thishelpmenu\\n  /logout - $logout\\n');</script>\n";
	}
	elseif ($chat == "/logout"){
		echo "<script language=\"JavaScript\">parent.window.close();</script>\n";
	}
        else {

$chat = htmlspecialchars($chat); 
$file = fopen($roomfile, "a");
set_file_buffer($file, 0);
flock($file, LOCK_EX);

if (ereg("([a-zA-Z0-9à-ÿÀ-ß_\-]{1,})::(.*)", $chat, $rs)) { 
fwrite($file,"<!--$anum-->$nickname::$chat<br>\n");
}
else 
fwrite($file,"<!--$anum--><font color=$color>$nickname</font><font color=black> - $chat</font><br>\n");
flock($file, LOCK_UN);
fclose($file);

	}

//end
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "<!-- Debug: ".$totaltime." -->";

?></font>

</body>
</html>