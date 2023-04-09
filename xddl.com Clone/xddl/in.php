<?php
# in.php

require "config.class.php";
$c = new config();
$c->open();

$ip = $REMOTE_ADDR;

function location() {
	header("Location: $c->site_url");
}

function banned($ip) {
	$fil = @file("banned.txt");
	for ($i=0; $i<count($fil); $i++) {
		if (eregi($ip, $fil[$i]))
			return true;
	}
	return false;
}

if ($kaoz[hit])
	location();
elseif (banned($ip)) {
	setCookie("kaoz[hit]", $id, time()+86400);
	location();
} elseif ($id && !$sid) {

	$get = mysql_query("SELECT * FROM $c->mysql_tb_ip WHERE ip = '$ip'");
	if (!mysql_num_rows($get)) {
		$sid = md5(uniqid(rand()));
		@mysql_query("INSERT INTO iplogg (ip, sid, id, hit, ref) VALUES('$ip','$sid','$id','1','$HTTP_REFERER')");

echo "<html><style type=\"text/css\">
.form {
	border-collapse: collapse;
	border-style: solid; 
	border-width: 1; 
	border-color: #000000; 
	background-color: #F1F1F1; 
	font-family: Verdana; 
	font-size: 9px;
}
td {
	font-family: Verdana, Arial, Sans-Serif;
	font-size: 9px;
}
.td2 {
</style><style type=\"text/css\">
.form {
	border-collapse: collapse;
	border-style: solid; 
	border-width: 1; 
	border-color: #000000; 
	background-color: #F1F1F1; 
	font-family: Verdana; 
	font-size: 9px;
}
td {
	font-family: Verdana, Arial, Sans-Serif;
	font-size: 9px;
}
.td2 {
</style>
<head><title>Continue to $c->site_name</title>
<link rel=stylesheet href=\"ddlcenter.css\" type=\"text/css\">
</head><body bgcolor=#F1F1F1><body topmargin=\"0\" marginheight=\"0\" marginwidth=\"0\" leftmargin=\"0\">
<center><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"100%\"><tr>
<td align=\"center\"><font color=\"000000\" style=\"font-size: 13pt\"><a href=\"in.php?id=$id&sid=$sid\">Continue to $c->site_name</a><br><br><br>
</td></tr></table></body></html>";
	} else
		location();

} elseif ($sid && $id) {
	setCookie("kaoz[hit]", $id, time()+86400);
	$get = @mysql_query("SELECT * FROM $c->mysql_tb_ip WHERE sid = '$sid' && id = '$id' && hit = '1' && ip = '$ip'");
	if (mysql_num_rows($get)) {
		@mysql_query("UPDATE $c->mysql_tb_ip SET hit=2 WHERE sid = '$sid' && hit = '1' && ip = '$ip'");
		@mysql_query("UPDATE $c->mysql_tb_le SET inn=inn+1 WHERE id = '$id'");
	}
		location();
} else
	location();

$c->close();
?>