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

//This is the function to get the images for the numbers
function getpicture($number){
	$arrayit = preg_split('//', $number, -1, PREG_SPLIT_NO_EMPTY); 
    $total = count($arrayit); 
    $i = 0;
	echo '<img src="images/numbers/aleft.png">';
   	while($i  < $total){
		echo '<img src="images/numbers/a' . $arrayit[$i] . '.png">';
		$i = $i +1;
	}
	echo '<img src="images/numbers/aright.png">';
	
}

//Function to check Ip
function get_ip(){
	$op = getenv('REMOTE_ADDR');
	$ipparts = explode(".", $op);
	
	if ($ipparts[0] == "165" && $ipparts[1] == "21") {    
    	if (getenv("HTTP_CLIENT_IP")) {
        	$ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        }
    } else {
        return $op;
    }
    return $ip;
}

//Function to check for browser type
function check_browser($var,$var2){
    if (preg_match("/Opera/i",$var)) $temp = 'Opera';
    elseif (preg_match("/MSIE 6/i",$var)) $temp = 'Internet Explorer 6';
    elseif (preg_match("/MSIE 5.5/i",$var)) $temp = 'Internet Explorer 5.5';
    elseif (preg_match("/MSIE 5.0/i",$var)) $temp = 'Internet Explorer 5';
    elseif (preg_match("/MSIE 4/i",$var)) $temp = 'Internet Explorer 4';
    elseif (preg_match("/Netscape\/7.0/i",$var)) $temp = 'Netscape 7';
    elseif (preg_match("/Mozilla\/5.0/i",$var)) $temp = 'Netscape 6';
    elseif (preg_match("/Mozilla\/4.7/i",$var)) $temp = 'Netscape 4.7';
    elseif (preg_match("/Mozilla\/4.6/i",$var)) $temp = 'Netscape 4.6';
    elseif (preg_match("/Mozilla\/4.5/i",$var)) $temp = 'Netscape 4.5';
    elseif (preg_match("/rv:1.4/i",$var)) $temp = 'Mozilla 1.4';
    elseif (preg_match("/rv:1.5a/i",$var)) $temp = 'Mozilla 1.5a';
    elseif (preg_match("/rv:1.5/i",$var)) $temp = 'Mozilla 1.5';
    elseif (preg_match("/Galeon/i",$var)) $temp = 'Galeon';
    elseif (preg_match("/Konqueror/i",$var)) $temp = 'Konqueror';
    else $temp = $var2;

    return $temp;
}

//function to check for system type
function check_system($var,$var2){

    if (preg_match("/windows nt 5.1/i",$var)) $temp = 'Windows XP';
    elseif (preg_match("/windows xp/i",$var)) $temp = 'Windows XP';
    elseif (preg_match("/linux/i",$var)) $temp = 'Linux';
    elseif (preg_match("/macintosh/i",$var)) $temp = 'Macintosh';
    elseif (preg_match("/win 9x 4.90/i",$var)) $temp = 'Windows Me';
    elseif (preg_match("/windows me/i",$var)) $temp = 'Windows Me';
    elseif (preg_match("/windows nt 5.0/i",$var)) $temp = 'Windows 2000';
    elseif (preg_match("/windows 2000/i",$var)) $temp = 'Windows 2000';
    elseif (preg_match("/windows nt 3.1/i",$var)) $temp = 'Windows 3.1';
    elseif (preg_match("/windows nt 3.5.0/i",$var)) $temp = 'Windows NT 3.5';
    elseif (preg_match("/windows nt 3.5.1/i",$var)) $temp = 'Windows NT 3.5.1';
    elseif (preg_match("/windows nt 4.0/i",$var)) $temp = 'Windows NT 4.0';
    elseif (preg_match("/windows 98/i",$var)) $temp = 'Windows 98';
    elseif (preg_match("/windows 95/i",$var)) $temp = 'Windows 95';
    elseif (preg_match("/sunos/i",$var)) $temp = 'SunOS';
    else $temp = $var2;

    return $temp;
}

//Function to check for countery name
function check_country($ip){
	$ip = sprintf("%u", ip2long($ip));
	$country = 'other';
	
	$check_country = @mysql_query("SELECT `country`,`a2`,`a3`,`number` FROM `country_ip_list` WHERE `ipfrom` <= '$ip' and `ipto` >= '$ip' LIMIT 0, 1");

	if($get_country = @mysql_fetch_row($check_country)){
		$country = $get_country[0];
	}
	return $country;
}


include_once("inc/configure.php");
	
//Check if a groupname is selected and the group is not empty
$id = $_GET['id'];

$check_counter = @mysql_query("SELECT * FROM `counter_list` WHERE `id`='$id'");

//If no Image Exist, Show No Image Picture
if(@mysql_num_rows($check_counter) <= 0){
	echo 'COUNTER DOES NOT EXIST';
	exit();
}

$ip = get_ip();

$check_user = @mysql_query("SELECT * FROM `counter_ip` WHERE `ip`='$ip' AND `id`='$id'");

//See if visiotr is unique
if(mysql_num_rows($check_user) <= 0){
	$insert_ip = @mysql_query("INSERT INTO `counter_ip` (`id`,`ip`) VALUES ('$id','$ip')");
	$uniqueis = true;
} else {
	$uniqueis = false;
}

//Get stats
$get_info = @mysql_fetch_array($check_counter);

$u_hits = $get_info[5];
$all_hits = $get_info[6];
$type = $get_info[2];
$isviewable = $get_info[3];
$unique = $get_info[4];

if($uniqueis == true){
	$u_hits++;
	$all_hits++;
	
	$user_info = getenv("HTTP_USER_AGENT");
	
	//get country and update it
	$user_country = check_country($ip);
	
	$get_last_cuntry_count = @mysql_fetch_array(@mysql_query("SELECT `$user_country` FROM `counters_countries` WHERE `id`='$id'"));
	$get_last_cuntry_count[0]++;
	$update_cuntry_count = @mysql_query("UPDATE `counters_countries` SET `$user_country`='$get_last_cuntry_count[0]' WHERE `id`='$id'");
	
	//get system and update it
	$user_system = check_system($user_info,'other');
	
	$get_last_sys_count = @mysql_fetch_array(@mysql_query("SELECT `$user_system` FROM `counter_system` WHERE `id`='$id'"));
	$get_last_sys_count[0]++;
	$update_system_count = @mysql_query("UPDATE `counter_system` SET `$user_system`='$get_last_sys_count[0]' WHERE `id`='$id'");
	
	//get browser and update it
	$user_browser = check_browser($user_info,'other');
	
	$get_last_bro_count = @mysql_fetch_array(@mysql_query("SELECT `$user_browser` FROM `counter_browser` WHERE `id`='$id'"));
	$get_last_bro_count[0]++;
	$update_browser_count = @mysql_query("UPDATE `counter_browser` SET `$user_browser`='$get_last_bro_count[0]' WHERE `id`='$id'");
		
} else {
	$all_hits++;
}
//update stats
$update_stat = @mysql_query("UPDATE `counter_list` SET `u_hits`='$u_hits',`all_hits`='$all_hits' WHERE `id`='$id'");

if($isviewable == 'NO'){
	exit();
}

if($unique == 'YES'){
	$number = $u_hits;
} else {
	$number = $all_hits;
}

if($type == 'Text'){
	echo '<strong><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif">'. $number.'</font></strong>';
	exit();
}

getpicture($number);

?>