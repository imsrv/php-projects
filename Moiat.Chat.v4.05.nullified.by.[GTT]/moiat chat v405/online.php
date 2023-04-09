<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

$currtm = time();

$online = file("users.txt");
$unum = count($online);
$sum = $unum;

for ($i=0; $i<$unum; $i++) {
$ud = explode("|", $online[$i]);
$utime = trim($ud[4]);
if ($utime<$currtm) { $sum = $sum-1; }
}

if ($sum==0) { $fw = fopen("users.txt", "w"); fclose($fw); }

if ($sum==1) { echo $oneuserinchat; } else { echo $sum ." ". $usersinchat; }

?>