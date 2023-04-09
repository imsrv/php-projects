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


//Fetch database information
@include_once("inc/configure.php");

//Check if a groupname is selected and the group is not empty
$group = $_GET['group'];

$check_group = @mysql_query("SELECT * FROM `stats` WHERE `group`='$group' ORDER BY RAND()");

//If no Image Exist, Show No Image Picture
if(@mysql_num_rows($check_group) <= 0){
	echo "Banner group: $_GET[group], does not exist or has no banners in it.";
	exit();
}


$isgood = false;

while($each_banner = @mysql_fetch_array($check_group)){
	$isgood = true;

	$banner_info = @mysql_fetch_row(@mysql_query("SELECT * FROM `banners` WHERE `id`='$each_banner[0]'"));

	if($banner_info[5] == 'OFF'){
		break;
	}
		
	$banner_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM `stats` WHERE `id`='$each_banner[0]'"));
	$hits1 = $banner_stat[6];
	$views1 = $banner_stat[8];
	$todayis = date('m') . '/' . date('d') . '/' . date('Y');
	
	if($isgood == true){
		$breakit = explode(',',$banner_info[5]);
		$part1 = $breakit[0];
		$part2 = $breakit[1];
	
	if($part1 == 'V'){
		if($part2 > $views1){
			$isgood = false;
			echo "<!-- 2 -->";
		}	
	} else {
		if($part1 == 'H'){
			if($part2 > $hits1){
				$isgood = false;
				echo "<!-- 3 -->";
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
							echo "<!-- 4 -->";
							
						}
					}
				}
				
				if($off == false && $myyear > $year){
					$off = true;
					echo "<!-- 5 -->";
				}
				
				
				if($off == false && $mymonth > $month && $myyear >= $year){
					$off = true;
					echo "<!-- 6 -->";
				}
				
				if($off == false && $myday > $day && $mymonth >= $month && $myyear >= $year){
					$off = true;
					echo "<!-- 7 -->";
				}
				
								
				if($off == false){
					$isgood = false;
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
$ip = get_user_ip();
$check_ip = @mysql_query("SELECT * FROM banner_view_ip WHERE `ip`='$ip' AND `id`='$each_banner[0]'");

if(@mysql_num_rows($check_ip) <= 0){
	$unique = true;
	$insert_ip = @mysql_query("INSERT INTO banner_view_ip (`id`,`ip`) VALUES ('$each_banner[0]','$ip')");
} else {
	$unique = false;
}


//Edit The Banner Stats
$get_stat = @mysql_query("SELECT * FROM `stats` WHERE `id`='$each_banner[0]'");
$stat = @mysql_fetch_array($get_stat);

//Get width & Heigth
$width = $stat[3];
$length = $stat[4];

$isflash = $stat[9];
$views = $stat[7];
$uni_views = $stat[8];
$views++;

if($unique == true){
	$uni_views++;
}
//Insert Back In
$update_stat = @mysql_query("UPDATE stats SET `views`='$views' , `uni_views`='$uni_views' WHERE id='$each_banner[0]'");

$id = $each_banner[0];
$thename = $banner_info[1];
$openmode = $banner_info[7];

if($banner_info[2] == 'NONE'){
	$mouseover = '';
} else {
	$mouseover = $banner_info[2];
}

$location = $banner_info[3];
$urlto = $banner_info[4];


// Check Size
if($width == 'NA' || $length == 'NA'){
	$dosize = NULL;
} else {
	$dosize = 'width="' . $width . '" height="' . $length . '"';
}

$link = 'catchbanner.php?id=' . $id;


?> <title><?php echo $thename;?></title><?php
	if($isflash == 'NO'){
		?>
		<a href="<?=$link;?>" target="<?=$openmode;?>" <?=$javait;?> ><img src="<?php echo $location;?>" alt="<?php echo $mouseover;?>" <?php echo $dosize;?> border="0"></a>
		<?php
	} else {
		?>
		<a href="<?=$link;?>" target="<?=$openmode;?>" <?=$javait;?> ><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <?php echo $dosize;?>>
		<param name="movie" value="<?php echo $location;?>">
		<param name="quality" value="high">
		<embed src="<?php echo $location;?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <?php echo $dosize;?>></embed></object></a>
		<?php
	}
?>
<script type="text/javascript" language="JavaScript1.2" src="javafile.js"></script>