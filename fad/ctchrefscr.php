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


//Include the necassary includes
include_once("inc/configure.php");

//Check if the banner is their
$id = $_GET['sessionid'];

$get_ref = @mysql_query("SELECT * FROM `referrals` WHERE `id`='$id'");

//If no banner id exist, or was removed redirect to add banner page
if(@mysql_num_rows($get_ref) <= 0 ){
	echo "This Link does not exist, Please contact system administrator.<br />
	You Can Access Our Main Site By <a href='" . $SITE_DIR . "'>Clicking Here</a>";
	exit();
}
$ref_info = @mysql_fetch_array($get_ref);

if($ref_info[2] == 'Main'){
	$urlto = $SITE_DIR;
} else {
	$urlto = $ref_info[2];
}

$hits = $ref_info[3];

$hits++;
$update_ref = @mysql_query("UPDATE `referrals` SET `hits`='$hits' WHERE `id`='$id'");

$thecookie = $_COOKIE['ref_id'];

if($thecookie != NULL){
	$ip = $_SERVER['REMOTE_ADDR'];
	$update_cookie = @mysql_query("UPDATE `ref_cookie`_list SET `ip`='$ip' WHERE `id`=$id'");
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
	$insert_cookie = @mysql_query("INSERT INTO `ref_cookie_list` (`id`,`ip`) VALUES ('$id','$ip')");
	session_start();
	$_SESSION['ref_id'] = $id;
	setcookie ('ref_id', $id,time()+1339200);
}

$addressto = 'Location: ' . $urlto;
header($addressto);
exit();
?>