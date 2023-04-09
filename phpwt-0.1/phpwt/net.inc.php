<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

function curlGetNextLocation($url, $referer) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $GLOBALS["agent"]);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	if($referer != "") {
		curl_setopt($ch, CURLOPT_REFERER, $referer); 
	}
	$html = curl_exec($ch);
	curl_close ($ch);
	preg_match("/Location\:.*?\n/", $html, $matches);
	$nexturl = str_replace("\r", "", str_replace("\n", "", str_replace("Location: ", "", $matches[0])));
	$nexturl = correctUrl($nexturl, $referer);
	$nexturl = str_replace("%3b", "", $nexturl);
	$nexturl = str_replace("amp", "", $nexturl);
	return $nexturl;
}

function curlGetPage($url, $referer) {
	$html = "";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $GLOBALS["agent"]);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	if($referer != "") {
		curl_setopt($ch, CURLOPT_REFERER, $referer); 
	}
	$html = curl_exec($ch);
	if(curl_errno($ch)) {
//		$html = "";
	}
	curl_close ($ch);
	return $html;
}

function curlPostPage($url, $data) {
	$html = "";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $GLOBALS["agent"]);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	if($referer != "")
		curl_setopt($ch, CURLOPT_REFERER, $referer); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$html = curl_exec($ch);
	if(curl_errno($ch)) {
		$html = "";
	} 
	curl_close ($ch);
	return $html;
}

//returns domain without http:// and without ending slash
function formatDomain($domain) {
	$domain = str_replace(" ","",$domain);
	$domain = str_replace("http://","",$domain);
	$domain = str_replace("http:\\\\","",$domain);
	if (strpos($domain,"/") == strlen($domain)-1)
		$domain  = substr($domain,0,strlen($domain)-1);
	return $domain;
}

function rebuildQuery($query) {
	$newterms = array();
	$terms = explode("&", $query);
	while(($tt = array_pop($terms))) {
		if(!in_array($tt, $newterms)) {
			array_push($newterms, $tt);
		}
	}
	return implode("&",$newterms);
}

function correctURL($url, $domain) {
	if(strncmp($url, "//", 2) == 0) {
		$url = "http://".substr($url, 2);
	}
	$url = str_replace("'", "", $url);
	$url_info = parse_url($url);
	if($url_info["scheme"] == "http" || $url_info["scheme"] == "mailto" || $url_info["scheme"] == "javascript")
		return $url;
	if ($url_info["host"] == ""){
		$cur_link = parse_url($domain);
//		echo "$cur_link[path]|$domain<br>";
		$newurl = $cur_link["host"];
		if(strncmp($url_info["path"], "./", 2) == 0)
			$url_info["path"] = substr($url_info["path"], 2);
		if($url_info["path"] != "") {
			if($url_info["path"][0] == "/")
				$newurl .= $url_info["path"];
			else {
				if(($ps = strrpos($cur_link["path"], "/")) > 0)
					$curpath = substr($cur_link["path"], 0, $ps);
				$newurl .= "/".$curpath."/".$url_info["path"];
			}
		}
	//	echo "tempnewurl: $newurl<br>";
	} else {
		$newurl = $url_info["host"];
		if($url_info["path"][0] == "/") 
			$newurl .= $url_info["path"];
		else
			$newurl .= "/".$url_info["path"];
		
	}
	if($url_info["query"] != "")
		$newurl .= "?".rebuildQuery($url_info["query"]);
	while(strpos($newurl, "//") !== false)
		$newurl = str_replace("//", "/", $newurl);
	$newurl = "http://".$newurl;
	$newurl = str_replace("&amp;", "&", $newurl);
	return $newurl;
}

// $url is an external link ? [both $url and $versus need http://]
function isLinkExternal($url, $versus){
	$url_info = parse_url($url);
	$dom_info = parse_url($versus);

	if($url_info["scheme"] != "http" && $url_info["scheme"] != "")
		return true;
	if ($url_info["host"] != $dom_info["host"] && $url_info["host"] != ""
		&& $url_info["host"] != "www.".$dom_info["host"]
		&& "www.".$url_info["host"] != $dom_info["host"])
			return true;
	if($url_info["port"] != $dom_info["port"])
		return true;
	if($url_info["path"][1] == "~")
		return true;
	return false;
}

?>
