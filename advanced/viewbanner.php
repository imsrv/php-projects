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

include("connect.php");

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

//Select ALL Banners
$get_banner = @mysql_query("SELECT * FROM banners ORDER BY RAND()");

?>
<script type="text/javascript" language="JavaScript1.2" src="<?=DIRTOMANAGER;?>status.js"></script>
<?php
$isgood = false;

while($each_banner = @mysql_fetch_array($get_banner)){
	$isgood = true;
	$doquery = @mysql_query("SELECT * FROM banners WHERE `id`='$each_banner[0]'");
	$thero = @mysql_fetch_row($seeresult);
	
	if($thero[5] == 'OFF'){
		break;
	}
		
	$newrow = @mysql_fetch_row(@mysql_query("SELECT * FROM stats WHERE `id`='$each_banner[0]'"));
	$hits1 = $newrow[6];
	$views1 = $newrow[8];
	$todayis = date('m') . '/' . date('d') . '/' . date('Y');
	
	if($isgood == true){
		$breakit = explode(',',$thero[5]);
		$part1 = $breakit[0];
		$part2 = $breakit[1];
	
	if($part1 == 'V'){
		if($part2 > $views1){
			$isgood = false;
			
		}	
	} else {
		if($part1 == 'H'){
			if($part2 > $hits1){
				$isgood = false;
				
			}
		} else {
			if($part1 == 'D'){
				$off = false;
				$rowd = explode('/',$part2);
				$month = $rowd[0];
				$day = $rowd[1];
				$year = $rowd[2];
				$myday = date('d');
				$mymonth = date('m');
				$myyear = date('Y');
				
				if($myyear == $year){
					if($mymonth == $month){
						if($myday == $day){
							$off = true;
							
						}
					}
				}
				
				if($off == false && $myyear > $year){
					$off = true;
					
				}
				
				
				if($off == false && $mymonth > $month && $myyear >= $year){
					$off = true;
					
				}
				
				if($off == false && $myday > $day && $mymonth >= $month && $myyear >= $year){
					$off = true;
					
				}
				
								
				if($off == false){
					$isgood = true;
				}
				
			}
		}	
	}
}
if($isgood == true){ break;}
		
}	

if($isgood == false){
	echo "No banners to display";
	exit();
}

//Check if user is unique or not
$user_ip = get_user_ip();
$get_ip = @mysql_query("SELECT * FROM ips WHERE `viewip`='$user_ip'");

if(@mysql_num_rows($get_ip) <= 0){
	$unique = true;
	$add_ip = @mysql_query("INSERT INTO ips (`viewip`) VALUES ('$user_ip')");
} else {
	$unique = false;
}


//Edit The Banner Stats
$banner_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE id='$each_banner[0]'"));

//Get width & Heigth
$width = $banner_stat[3];
$length = $banner_stat[4];


$views = $banner_stat[7];
$uni_views = $banner_stat[8];
$views++;

if($unique == true){
	$uni_views++;
}
//Insert Back In
$update_stat = @mysql_query("UPDATE stats SET `views`='$views' , `uni_views`='$uni_views' WHERE id='$each_banner[0]'");


$id = $each_banner[0];
$openmode = $each_banner[7];

if($myrow[2] == 'NONE'){
	$mouseover = '';
} else {
	$mouseover = $each_banner[2];
}

$location = $each_banner[3];
$urlto = $each_banner[4];

// Check Size
if($banner_stat[width] == 'NA' || $banner_stat[length] == 'NA'){
	$dosize = NULL;
} else {
	$dosize = 'width="' . $width . '" height="' . $length . '"';
}

$link = 'href="'.DIRTOMANAGER.'catchadd.php?id=' . $id . '" target="' . $openmode . '"' . $javait;


?>
<a <? echo $link;?> ><img src="<? echo $location;?>" alt="<? echo $mouseover;?>" <? echo $dosize;?> border="0"></a>
<!--
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
-->
