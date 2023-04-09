<?
/////////////////////////////////////////////////////////
//	
//	include/ryosimap.inc
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Legacy library from the "Ryo's Webmail" days.  Contains misc. functions.
	COMMENTS:
		Most of the functions here should eventually be phased out and/or moved to other 
		include's.

********************************************************/

function ShowSeen($obj,$true,$false){
	if (($obj->Unseen=='U')||($obj->Recent=='N')){
		return $false;
	}else{
		return $true;
	}
}

function ShowBytes($numbytes){
	if ($numbytes > 1000){
		$kb=(int)($numbytes/1000);
		return $kb." KB";
	}else{
		return $numbytes." B";
	}
}

function TZDate($tz){
	$server_tz = (int)date("Z");	//server timezone offset in seconds
	$gmt = time() - $server_tz;
	$user_tz = $tz * 60 * 60; 		//user tz offset in seconds
	$ts = $gmt + $user_tz;
	
	if ($tz < 0){
		if ($tz > -10){
			$ttz=$tz * -1;
			$tz_string = "-0".$ttz."00";
		}else{
			$tz_string = $tz."00";
		}
	}else if ($tz >= 0){
		if ($tz < 10) $tz_string = "+0".$tz."00";
		else $tz_string = "+".$tz."00";
	}
	return date("D, d M Y H:i:s", $ts)." $tz_string";
}

function ShowDate($obj){
	return $obj->date;
}

function ShowDate2($str,$cd_a,$mode){
	$pos=strpos($str, ",");
	if ($pos > 0) $str = substr($str, $pos+1);
	$str=trim($str);
	
	$a=explode(" ",$str);
	$month_a=array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
	$month_str=$a[1];
	$month=$month_a[$month_str];
	$day=(int)$a[0];
	$year=(int)$a[2];
	$time=$a[3];
	
	if ($mode=="short"){
		$str = $month."/".$day."/".$year;
	}else if ($mode!="full"){
		if (($cd_a["day"]==$day) && ($cd_a["month"]==$month)){
			$str="";
			$is_today=true;
		}else{
			$str=$month."/".$day;
			$is_today=false;
		}
		if ($cd_a["year"]!=$year) $str.="/".$a[2];
		if ($is_today){
			$ta=explode(":",$time);
			$str.=" ".$ta[0].":".$ta[1]." ".$a[4];
		}
	}

	return $str;
}

function ShowShortDate($timestamp, $format){
	$now = time();
	$day_secs = 60*((int)date("H")*60 + (int)date("i"));
	$week_secs = 60 * 60 * 24 * 7;
	$diff = $now - $timestamp;
	if ($diff < $day_secs){
		$str = $format["today"];
		if (empty($str)) $str="%t";
		$str = str_replace("%t", date("H:i", $timestamp), $str);
	}else if ($diff < $week_secs){
		$dsow = $format["dsow"];
		$dow_code = date("w", $timestamp);
		$dow = $dsow[$dow_code];
		$time = date("H:i", $timestamp);
		$str = $format["lastweek"];
		$str = str_replace("%t", $time, $str);
		$str = str_replace("%w", $dow, $str);
	}else{
		$c_a = getdate();
		$d_a = getdate($timestamp);
		$message_year = $d_a["year"];
		$current_year = $c_a["year"];
		
		if ($message_year != $current_year) $str = $format["prevyears"];
		else $str = $format["thisyear"];
		
		$str = str_replace("%m", $d_a["mon"], $str);
		$str = str_replace("%d", $d_a["mday"], $str);
		$str = str_replace("%y", $d_a["year"], $str);
	}
	return $str;
}

function FolderOptions3($folders, $defaults){
	if ($folders == false) {
    	echo "Call failed<br>\n";
		return array();
	} else {
		sort($folders);
		$c=sizeof($folders);
		$fa=$defaults;
	   	for ($i=0;$i<$c;$i++){
			$folder=$folders[$i];
			if (($fa[$folder]=="") && ($folder[0]!='.') && (!empty($folder))){
				$folder_name=$folder;
				$folder=$folder;
				$fa[$folder]=$folder_name;
			}			
    	}
	}
	
	reset($fa);
	while (list ($key,$val) = each ($fa)) {
		if (!empty($key)) echo "<option value=\"".$key."\">$val\n";
	}
}

function FolderOptions2($folderlist, $default){
    if (is_array($folderlist)){
        while(list($key,$item)=each($folderlist)){
            if ($item[0]!=".")
                echo "<option value=\"$item\" ".(strcmp($item, $default)==0?"SELECTED":"").">$item\n";
        }
    }
}

function DefaultOptions($folderlist, $default){
    if (is_array($folderlist)){
        while(list($key,$item)=each($folderlist)){
            if ($item[0]!=".")
                echo "<option value=\"$key\" ".(strcmp($key, $default)==0?"SELECTED":"").">$item\n";
        }
    }
}

function DefaultOptions2($folders, $defaults, $default){
	if ($folders == false) {
    	echo "Call failed<br>\n";
		return array();
	} else {
		sort($folders);
		$c=sizeof($folders);
		$fa=$defaults;
	   	for ($i=0;$i<$c;$i++){
			$folder=$folders[$i];
			if (($fa[$folder]=="") && ($folder[0]!='.')){
				$folder_name=$folder;
				$folder=$folder;
				$fa[$folder]=$folder_name;
			}			
    	}
	}
	
	reset($fa);
	while (list ($key,$val) = each ($fa)) {
		echo "<option value=\"".$key."\" ".(strcmp($key, $default)==0?"SELECTED":"").">".urldecode($val)."\n";
	}
}


function myWordWrap($string,$num){
	$len=strlen($string);
	$curpos=0;
	$str="";
	
	while (($curpos+$num)<$len){
		$str.=substr($string,$curpos,$num);
		$str.="\n";
		$curpos=$curpos+$num;
	}
	$str.=substr($string,$curpos,$len);
	
	return $str;
}

?>