<?php

function checkuser($u) {
$v = explode(' ', $u);
$u1 = trim($v[0]);
$u2 = trim($v[1]);
$q = mysql_query("SELECT * FROM users WHERE first_name LIKE '%$u1%' AND last_name LIKE '%$u2%'");
return mysql_num_rows($q);
}

function getuserid($u) {
$v = explode(' ', $u);
$u1 = trim($v[0]);
$u2 = trim($v[1]);
$q = mysql_query("SELECT id FROM users WHERE first_name LIKE '%$u1%' AND last_name LIKE '%$u2%'");
$ft = mysql_fetch_row($q);
return $ft[0];
}

function dateDiff($date1, $date2) {
$ret=array('days'=>0,'hours'=>0,'minutes'=>0,'seconds'=>0);
$totalsec = abs($date2 - $date1);
if ($totalsec >= 86400) {
$ret['days'] = floor($totalsec/86400); 
$totalsec = $totalsec % 86400; 
}
if ($totalsec >= 3600) { 
$ret['hours'] = floor($totalsec/3600); 
$totalsec = $totalsec % 3600; 
}
if ($totalsec >= 60) { 
$ret['minutes'] = floor($totalsec/60); 
} 
$ret['seconds'] = $totalsec % 60; 
return $ret; 
}

function format($text) {
$text = stripslashes($text);
$text = htmlspecialchars($text, ENT_QUOTES);
$Patterns[] = "/\[b\](.*?)\[\/b\]/is";
$Replacements[] = "<b>\\1</b>";
$Patterns[] = "/\[i\](.*?)\[\/i\]/is";
$Replacements[] = "<i>\\1</i>";
$Patterns[] = "/\[u\](.*?)\[\/u\]/is";
$Replacements[] = "<u>\\1</u>";
$Patterns[] = "/\[bp\](.*?)\[\/bp\]/is";
$Replacements[] = "<li> \\1</li>";
$Patterns[] = "/\[img\](.*?)\[\/img\]/is";
$Replacements[] = "<img border=\"0\" src=\"\\1\">";
$Patterns[] = "/\[url=(.*?)\](.*?)\[\/url\]/is";
$Replacements[] = "<a target=\"_blank\" href=\"\\1\">\\2</a>";
$Patterns[] = "/\[url\](.*?)\[\/url\]/is";
$Replacements[] = "<a target=\"_blank\" href=\"\\1\">\\1</a>";
ksort($Patterns);
ksort($Replacements);
$return_string = '';
while ($return_string != $text) {
$return_string = $text;
$text = preg_replace($Patterns,$Replacements,$text);
}
$text = nl2br($text);
return $text;
}
?>