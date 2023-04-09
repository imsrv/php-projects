<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

$langs = array("English" => "en|all", "Italian" => "it|en", "French" => "fr|en", "German" => "de|en", "Spanish" => "sp|en", "Japanese" => "ja|en");
$langpair = array("English to German" => "en|de", "English to Spanish" => "en|es", "English to French" => "en|fr", "English to Italian" => "en|it", "English to Portuguese" => "en|pt", "English to Japanese" => "en|ja", "German to English" => "de|en", "German to French" => "de|fr", "Spanish to English" => "es|en", "French to English" => "fr|en", "Italian to English" => "it|en", "Portuguese to English" => "pt|en", "Japanese to English" => "ja|en");

function getTranslation($url, $sl, $el, $trueurl) {
	$translate = "http://216.239.37.104/translate_c?hl=en&ie=UTF-8&oe=UTF-8&langpair=".urlencode($sl."|".$el)."&u=".urlencode($url)."&prev=/language_tools";
	$html = curlGetPage($translate, "");
	if($html != "") {
		addTranslation($el, $trueurl, $html);
	}
}


function translateEn2All($sitemap) {
	global $langpair, $mfd, $langen, $scripturl;
	
	foreach($langpair as $l0 => $l1) {
		$fromto = explode("|", $l1);
		if($fromto[0] == "en") {
			echo "<b>Translating pages from $l0. Please wait...</b><br />";
			if($sitemap) {
				for($i = 0; $i < sizeof($sitemap); $i++) {
					echo "<b>Translating <font color='#0000ff'>".$sitemap[$i]."</font>...</b> ";
					getTranslation(trim($sitemap[$i]), trim($fromto[0]), trim($fromto[1]), trim($sitemap[$i]));
					echo "<font color='#00aa00'><b>Done.</b></font><br />";
				}
			} else {
				OpenMDB();
				$sql = "SELECT * FROM `en`";
				$res = mysql_query($sql, $mfd) or die("Error: translateEn2All:".mysql_error($mfd)."<br />");
				while(($row = mysql_fetch_array($res))) {
					$id = $row["id"];
					$trueurl = $row["url"];
					$url = $scripturl."/tcap.php?lang=en&idlink=".$id;
					echo "<b>Translating <font color='#0000ff'>".$url."</font>...</b> ";
					getTranslation(trim($url), trim($fromto[0]), trim($fromto[1]), trim($trueurl));
					echo "<font color='#00aa00'><b>Done.</b></font><br />";
					
				}
				CloseMDB();
			}
			echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
		}
	}
	
}

?>
