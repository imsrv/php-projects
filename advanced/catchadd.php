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

include("connect.php");

//Get Id Number
$id = $_GET['id'];

$banner = @mysql_query("SELECT * FROM banners WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($banner) <= 0 ){
	header("Location: add.php");
	exit();
}
$banner_info = @mysql_fetch_array($banner);
$addressto = "Location: " . $banner_info[4];

$user_ip = get_user_ip();
$check_count = @mysql_query("SELECT * FROM ips WHERE `visitip`='$user_ip'");
$count = @mysql_num_rows($check_count);

if($count == 0){
	$unique = true;
	$insert_ip = @mysql_query("INSERT INTO ips (`visitip`) VALUES ('$user_ip')");
} else {
	$unique = false;
}
$banner_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE `id`='$id'"));

$hits = $banner_stat[5];
$uni_hits = $banner_stat[6];
$hits++;


if($unique == true){
	$uni_hits++;
}

//Insert Back In
$update_banner = @mysql_query("UPDATE stats SET `hits`='$hits' , `uni_hits`='$uni_hits' WHERE id='$id'");


header($addressto);
exit();
?>