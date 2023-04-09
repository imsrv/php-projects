<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >
include("config.php");

if((!$_GET["idlink"]) || ($_GET["idlink"] < 0) || (!$_GET["lang"])) {
		header("location: ".$baseurl);
} else {
	$idlink = $_GET["idlink"];
	if($idlink == 0) $idlink = 1;
	if($_GET["lang"]) {
		$lang = $_GET["lang"];
		if(agentSpider($_SERVER["HTTP_USER_AGENT"])) {
			$row = getPageTranslated($lang, $idlink);
			$html = $row["source"];
			echo $html;
		} else {
			$row = getPageTranslated($lang, $idlink);
			$trueurl = $row["url"]; 
			header("location: ".$trueurl);
		}
	}
}

?>
