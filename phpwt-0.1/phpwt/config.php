<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

global $mfd, $mysqlhost, $mysqluser, $mysqlpass, $mysqldb; 

ob_implicit_flush();

$agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:0.9.9) Gecko/20020513";

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

//MYSQL
$mysqlhost = "localhost"; // myqsl host
$mysqluser = "mysql"; // mysql user
$mysqlpass = ""; // mysql pass
$mysqldb = "translator"; // database

$langen = "en";
$langit = "it";
$langde = "de";
$langfr = "fr";
$langes = "es";
$langja = "ja";
$langpt = "pt";

$baseurl = "http://www.yourwebsitehome.org"; // home of your website ( without ending '/' character )
$scripturl = "http://www.yourwebsitehome.org/translator"; // php website translator url ( without ending '/' character )

$visible = TRUE;

include("mysql.inc.php");

function agentSpider($agent) {
	global $visible;
	if($visible)
		return TRUE;
	$spiders = array("googlebot", "wget", "scooter", "yahoo", "zyborg");
	$res = FALSE;
	$agentlow = strtolower($agent);
	for($i = 0; $i < sizeof($spiders); $i++) {
		if(strpos($agentlow, $spiders[$i]) != FALSE) {
			$res = TRUE;
			break;
		}
	}
	return $res;
}

?>
