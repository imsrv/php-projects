<html>
<head>
<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="bg">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#808080" vlink="#C0C0C0" alink="#808080">
<font face="Arial" size="2">

<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

if (!isset($fromline)) { $fromline = 0; } else { $fromline=($fromline-1)*50; }
$toline = $fromline + 50;

$log = file("history.txt");
$loglines = count($log);
if ($toline>=$loglines) $toline=$loglines;

echo "<center><b>My Chat History View</b></center><br>";
for ($i=$fromline; $i<=$toline; $i++) {
if (eregi("([a-z0-9�-�_\-]*)::([a-z0-9�-�_\-]*)::(.*)<", $log[$i], $nk)) { 
echo "<b>����� �� $nk[1] �� $nk[2]:</b> $nk[3]<br>"; } 
else { echo $log[$i]; }
}

echo "<br><br><br>";
echo "<br>Page: ";

for ($i=1; $i<($loglines/50); $i++) {
echo "<a href=history.php?fromline=$i>$i</a>  ";
}
?>

</font>
</body>
</html>