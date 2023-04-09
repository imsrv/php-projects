<?
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

if ($HTTP_COOKIE_VARS["rid"]=='') { $rid = $HTTP_GET_VARS["rid"]; } else { $rid = $HTTP_COOKIE_VARS["rid"]; }

$sdata = file("./s/". $rid .".txt");
$nickname = trim($sdata[0]);
$sex = trim($sdata[1]);
$color = trim($sdata[2]);
$room = trim($sdata[3]);

?>