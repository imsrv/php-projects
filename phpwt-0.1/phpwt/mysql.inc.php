<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

function OpenMDB() {
	global $mfd, $mysqlhost, $mysqluser, $mysqlpass, $mysqldb; 
	$mfd = mysql_connect($mysqlhost, $mysqluser, $mysqlpass) or die("Error: <b>unable to connect to the database</b>: ".mysql_error()."<br>");
	mysql_select_db($mysqldb, $mfd) or die("Error: <b>unable to select the database</b>: ".mysql_error()."<br>");
}

function CloseMDB() {
	global $mfd;
	mysql_close($mfd);
}

function addTranslation($lang, $url, $source) {
	global $mfd;
	$langt = $lang;
	if($lang == "") $langt = "en";
	OpenMDB();
	$sql = "INSERT INTO `$langt` (`id`, `url`, `source`) VALUES ('' ,'$url', '".addslashes($source)."')";
	mysql_query($sql, $mfd) or die("Error: addTranslation: ".mysql_error($mfd)."<br />");
	CloseMDB();
}

function isDupTrans($lang, $url) {
	global $mfd;
	$langt = $lang;
	if($langt == "") $langt = "en";
	$res = FALSE;
	OpenMDB();
	$sql = "SELECT `url` FROM `$langt` WHERE `lang` = '$lang' AND `url` = '$url' LIMIT 1";
	$res = mysql_query($sql, $mfd) or die("Error: isDupTrans: ".mysql_error($mfd)."<br />");
	if(mysql_num_rows($res) > 0)
		$res = TRUE;
	CloseMDB();
	return $res;
}


function getPageTranslated($lang, $id) {
	global $mfd;
	$langt = $lang;
	if($langt == "") $langt = "en";
	OpenMDB();
	$sql = "SELECT * FROM `$langt` WHERE `id` = '$id'";
	$res = mysql_query($sql, $mfd) or die("Error: getPageTranslated: ".mysql_error($mfd)."<br />");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
	} else
		$row = "";
	CloseMDB();
	return $row;
}

function getPageTranslatedId($lang, $url) {
	global $mfd;
	$langt = $lang;
	if($langt == "") $langt = "en";
	OpenMDB();
	$sql = "SELECT `id` FROM `$langt` WHERE `url` LIKE '".urldecode($url)."'";
	$res = mysql_query($sql, $mfd) or die("Error: getPageTranslatedId: ".mysql_error($mfd)."<br />");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		$id = $row["id"];
	} else $id = 0;
	CloseMDB();
	return $id;
	
}

function updatePageTranslated($lang, $id, $source) {
	global $mfd;
	$langt = $lang;
	if($langt == "") $langt = "en";
	OpenMDB();
	$sql = "UPDATE `$langt` SET `source` = '".addslashes($source)."' WHERE `id` = '$id' LIMIT 1";
	mysql_query($sql, $mfd) or die("Error: updatePageTranslated: ".mysql_error($mfd)."<br />");
	CloseMDB();
}

function rebuildLinks($lang) {
	global $mfd;
	$langt = $lang;
	if($langt == "") $langt = "en";
	OpenMDB();
	$sql = "SELECT * FROM `$langt`";
	$res = mysql_query($sql, $mfd) or die("Error: rebuildLinks:".mysql_error($mfd)."<br />");
	while(($row = mysql_fetch_array($res))) {
		$id = $row["id"];
		$url = $row["url"];
		$html = $row["source"];
		echo "<b>Rebuilding links in <font color='#0000ff'><b>".$url."</b></font>... </b>";
		$html = replaceTag($lang, $url, $html);
		updatePageTranslated($lang, $id, $html);
		echo "<font color='#00aa00'><b>Done.</b></font><br />";
	}
	CloseMDB();
	
}

function replaceTag($lang, $url, $html) {
	global $baseurl, $scripturl;
	$oldtags = getTags($html, "<a ", "</a");
	for($i = 0; $i < sizeof($oldtags); $i++) {
		$oldtfieldst[$i] = trim(getTagField($oldtags[$i], "href="));
		if($oldtfieldst[$i] != "") {
			$pos0 = strpos($oldtfieldst[$i], "&u=") + 3;
			$pos1 = strpos($oldtfieldst[$i], "&prev=");
			if($pos0 && $pos1 && $pos0 < $pos1) {
				$oldtfields[$i] = urldecode(substr($oldtfieldst[$i], $pos0, $pos1 - $pos0));
			} else
				$oldtfields[$i] = $baseurl;
		} else
			$oldtfields[$i] = $baseurl;
	}
	for($i = 0; $i < sizeof($oldtfields); $i++) {
		if($oldtfields[$i] == $baseurl)
			$newtfields[$i] = $baseurl;
		else {
			if(($pos2 = strpos($oldtfields[$i], "lang=en&idlink=")) != false) {
				$idlink = substr($oldtfields[$i], $pos2 + 15);
			} else 
				$idlink = getPageTranslatedId($lang, $oldtfields[$i]);
			$newtfields[$i] = $scripturl."/lang.php?lang=".$lang."&idlink=".$idlink;
		}
	}
	for($i = 0; $i < sizeof($oldtags); $i++) {
		$newtags[$i] = str_replace($oldtfieldst[$i], $newtfields[$i], $oldtags[$i]);
	}
	for($i = 0; $i < sizeof($oldtags); $i++) {
		$html = str_replace($oldtags[$i], $newtags[$i], $html);
	}
	return $html;
}


?>
