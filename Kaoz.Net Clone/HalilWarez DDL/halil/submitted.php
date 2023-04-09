<?php
if ($HTTP_POST_VARS && (!$HTTP_POST_VARS[sname] || !$HTTP_POST_VARS[surl] || !$HTTP_POST_VARS[title][0] || !$HTTP_POST_VARS[url][0] || !$HTTP_POST_VARS[type][0])) {
	include "wrong.html";
	die();
} elseif ($HTTP_POST_VARS) {
	$c->open();
	if ($c->blacklist($surl))
		$dont = true;
	else
		$dont = false;
	if (!$dont) {
		for ($i=0; $i<count($HTTP_POST_VARS[title]); $i++) {
			if (!$title[$i] || !$url[$i] || !$type[$i] || $c->blacklist($url[$i]))
				break;
			else {
				$dato = $c->dato();
				@mysql_query("INSERT INTO $c->mysql_tb_que (type, title, url, sname, surl, date, email) "
				."VALUES ('$type[$i]','$title[$i]','$url[$i]','$sname','$surl','$dato','$email')");
			}
		}
	}
	include "thanks.php";
	die();
	$inc = true;
} else
	$inc = false;
?>