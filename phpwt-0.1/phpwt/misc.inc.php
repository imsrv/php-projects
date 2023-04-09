<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

function getPhpVersion() {
	$v2 = preg_replace("/[^0-9\.]+/","",phpversion()); 
	$v=$v2-0; 
	return $v;
}

function existTable($tbname) {
	$mfd = OpenMDB();
	$sql = "SHOW TABLES FROM phpspellbook";
	if(($res = mysql_query($sql, $mfd))) {
		for($i = 0; $row = mysql_fetch_row($res); $i++) {
			if($row[0] == $tbname) {
				return TRUE;
			}
		}
	}
	return FALSE;
}

function strposi($string, $needle) {
	$istr = strtolower($string);
	$ineedle = strtolower($needle);
	return strpos($istr, $ineedle);
}

function printDate() {
	$today = getdate();
	$month = $today['month'];
	$mday = $today['mday'];
	$year = $today['year'];
	$hours = $today['hours'];
	$mins = $today['minutes'];
	$secs = $today['seconds'];
	$nowdate = "$hours:$mins:$secs $mday/$month/$year";
	return $nowdate;
}

?>
