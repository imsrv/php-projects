<?php
/************************************************************************************

	Script Name	: Youtube Downloader 0.1
	Function	: To show path into FLV files located at Youtube.com
	Creator	: Yeni Setiawan (yeni.setiawan@yahoo.com, http://sandalian.com)
	Created date	: April 5, 2007
	Requirement	: PHP with CURL

	Note:
	This is a basic functions used to show real URI of FLV files at youtube.com so we can
	download the file and play it offline. 

	Disclaimer:
	You use it at your own risk. You can ask me question about this script but you shouldn't  
	ask me about any damaged computer caused by this script.

	To do:
	- Build AJAX interface.
	- Put it in my homepage as public service

************************************************************************************/


// ------------------------------------ START SCRIPT --------------------------//
function get_content_of_url($url){
	$ohyeah = curl_init();
	curl_setopt($ohyeah, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ohyeah, CURLOPT_URL, $url);
	$data = curl_exec($ohyeah);
	curl_close($ohyeah);
	return $data;
}

function get_flv_link($string) {
        if (preg_match('/\/player2\.swf\?(.*)", "movie_player"/', $string, $match)) {
            $url = $match[1];
            return 'http://youtube.com/get_video.php?'.$url;
        }
}

function get_http_header($url){
	$uh = curl_init();
	curl_setopt($uh, CURLOPT_URL, $url);
	curl_setopt($uh, CURLOPT_HEADER, 1);
	curl_setopt($uh, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($uh);
	curl_close($uh);
	return $res;
}

function show_url($http_header){
	$arai = explode("\n",$http_header);
	foreach($arai as $ini){
		if(eregi("location",$ini)) $url = $ini;
	}
	list($sampah,$hasil) = explode("Location:",$url);
	return str_replace("\n","",trim($hasil));
}

function download_youtube($url){
	$data = get_content_of_url($url);
	$next_url = get_flv_link($data);
	$data = get_http_header($next_url);
	return show_url($data);
}
// ------------------------------------ END SCRIPT --------------------------//

?> 