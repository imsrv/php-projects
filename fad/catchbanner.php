<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

@include_once("inc/configure.php");

//Function to get user ip (stolen from phpskills.com :)
function get_user_ip(){       
	$ipParts = explode(".", $_SERVER['REMOTE_ADDR']);
	if ($ipParts[0] == "165" && $ipParts[1] == "21") {    
    	if (getenv("HTTP_CLIENT_IP")) {
        	$ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        }
    } else {
       return $_SERVER['REMOTE_ADDR'];
   	}
   	return $ip;
}


//Check banner correctness
$id = $_GET['id'];

$get_banner = @mysql_query("SELECT * FROM `banners` WHERE `id`='$id'");

if(@mysql_num_rows($get_banner) <= 0 ){
	header("Location: $SITE_DIR");
	exit();
}

$banner_info = @mysql_fetch_array($get_banner);
$addressto = "Location: " . $banner_info[4];

$ip = get_user_ip();
$get_ip = @mysql_query("SELECT * FROM banner_hit_ip WHERE `ip`='$ip' AND `id`='$id'");

if(@mysql_num_rows($get_ip) <= 0){
	$unique = true;
	$insert_ip = @mysql_query("INSERT INTO banner_hit_ip (`id`,`ip`) VALUES ('$id','$ip')");
} else {
	$unique = false;
}

$get_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE `id`='$id'"));

$hits = $get_stat[5];
$uni_hits = $get_stat[6];
$hits++;


if($unique == true){
	$uni_hits++;
}

//Insert Back In
$update_stat = @mysql_query("UPDATE stats SET `hits`='$hits' , `uni_hits`='$uni_hits' WHERE id='$id'");

header($addressto);
exit();
?>