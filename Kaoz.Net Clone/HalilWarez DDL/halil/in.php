<?php
# in.php

require "config.class.php";
$c = new config();
$c->open();

$ip = $REMOTE_ADDR;

function location() {
	header("Location:http://www.cyberddl.info");
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

echo "<html><head><title>Continue to $c->site_name</title>

</head><body topmargin=\"0\" marginheight=\"0\" marginwidth=\"0\" leftmargin=\"0\">
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"100%\"><tr>
<td valign=\"middle\" align=center><a href=\"in.php?id=$id&sid=$sid\">Continue to $c->site_name</a><br><br><br>
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