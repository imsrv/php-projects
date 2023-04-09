<?
//----------------------------------------//
// Decoded and fixed by WAXZY [MST]
// 07/30/2007
//----------------------------------------//
//$comp_link = 'http://www.uzmanjandarma.net/youload';
//Include page auto path detector ...
//Allows our script to be directly included into another page!
if(isset($_SERVER['SCRIPT_FILENAME']) && realpath('youloader.php') != realpath($_SERVER['SCRIPT_FILENAME'])){
	$p1 = explode(DIRECTORY_SEPARATOR,dirname(realpath($_SERVER['SCRIPT_FILENAME'])));
	$p2 = explode(DIRECTORY_SEPARATOR,dirname(realpath('youloader.php')));$i=0;
	while($i<count($p1) && $i<count($p2) && $p1[$i] == $p2[$i]) $i++;
	for($j=$i;$j<count($p1);$j++) $rpath .= '../';
	for($j=$i;$j<count($p2);$j++) $rpath .= $p2[$j].'/';
}else{
	die('Error!');
}
@include ("$rpath".'you_config.php');
$url_file = "$rpath$url_file";
$linefeed = chr(13).chr(10);# needed as delimiter in flat files
# Load clip list into array from flat file
//Get our video clip ID from our admin preview click ...
$vc = trim(strip_tags($_GET['vc']));
$file = @file($url_file);
if(file_exists($url_file)){
	foreach($file as $line) {
		$my_clip = explode('|', $line);
		$clip = $line;
		//DC Mod Remove our clip from view 
		//if it has a disable flag ...
		if (!$my_clip[4] == '1'){
			$clips[] = trim($clip);
		}
		//Auto preview from our links in admin ...
		$clip = substr(strrchr($my_clip[2], '/'), +1);
		if ($vc == $clip){
			$vid_clip = $my_clip[2];
		}
		#print "clip = $clip<br>";
	}
}
# Get the selected clip
if ($_POST['view_cl']){
	$vid_clip = $_POST['view_cl'];
}
$page = $_SERVER['PHP_SELF'];

echo '
<form name="YT" action="';

echo $page;

echo '" method="post">                      
<table align="center" width="425" border="0" cellspacing="0" cellpadding="4" class="t1">
<tr align="center">
<td colspan="2">';

//License Validation!
$maxl = '18';

//QUICK FIX FOR SUB DOMAIN
//$web = strtolower(str_replace("www.", "", $_SERVER['SERVER_NAME']));
$web = strtolower($_SERVER['SERVER_NAME']);
preg_match("/[^\.\/]+\.[^\.\/]+$/", $web, $matches);
$web = $matches[0];
$server = md5($web);
$id = strrev(substr($server,0,$maxl-0));
$license = str_replace('YL-', '', $license);
//Validation for deluxe license block
$hashit = 14432785;
$hash = "$hashit$web";
$idh  = md5($hash);
$id2  = strrev(substr($idh,0,$maxl-0));

//if(!strcmp($license, strtoupper($id2))){
	$img_link = "<img src=\"$rpath"."images/$img_default\" width=\"425\" height=\"350\" oncontextmenu=\"return false;\">";
//}else{
//	$img_link = "<a href=\"http://$comp_link\" target=\"_blank\"><img src=\"$rpath"."images/youloaderp.gif\" width=\"425\" height=\"350\" border=\"0\" oncontextmenu=\"return false;\"></a>";
//	$unr_vers = '1';
//}

//Disable YouTube relative vids option!
if ($rel_videos != 'no'){
	$rel = '&rel=0';
}
if (!$_POST && $default != '' or $vid_clip == '1' && $default != ''){
	$vid_clip = $default;
}else{
	$auto = '&autoplay=1';
}
if ($vid_clip != '' && $vid_clip != '1'){
	# Find the current clip so the 'times Viewed' can be incremented
	# Load clip list into array from flat file
	$file = @file($url_file);
	foreach($file as $line) {
		$my_clip = explode('|', $line);
		$clip = $line;
		$clipsa[] = trim($clip);
		#print "clip = $clip<br>";
	}
	$i=0;
	while ($clipsa[$i]){
		$ii = $i + 1;
		$my_clipa = explode('|', $clipsa[$i]);
		//DC Mod had to check for $vc so we dont increment 
		//our count from admin clicks ...
		if ($my_clipa[2] == $vid_clip && !$vc && $unr_vers != '1'){
			# Increment the 'times viewed' variable.
			$my_clipa[3] = $my_clipa[3] +1;
			$clipsa[$i] = implode('|', $my_clipa);
		}		
	$i++;
	}
	# Write the flat file out with the new data.
	// Lets lock our file for writing, windows based servers will
	// Surely require this to prevent data corruption on multi writes 	
	$fh = @fopen($url_file, 'w') or die("<span class=\"M1\">Can't open $url_file file please check permissions!</span>");
	$i=0;
	while ($clipsa[$i]){
		flock($fh, LOCK_EX);
		$data =  "$clipsa[$i]$linefeed";
		fwrite($fh, $data);
		#print "data is $data<br>";
		$i++;
	}
	flock($fh, LOCK_UN);
	fclose($fh);
	echo "<div align=\"center\"><object width=\"425\" height=\"350\"><param name=\"movie\" value=\"$vid_clip\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"$vid_clip$rel$auto\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"350\"></embed></object></div>";
}else{
	echo "<div align=\"center\">$img_link</div>";
}

if (!$_POST or $vid_clip == '1'){
	$sel = ' SELECTED';
}
$countit = count($clips);
if ($countit == '1'){
	$clp = 'Clip';
}else{
	$clp = 'Clips';
}

//Get our YouTube video id code ...
$clip = substr(strrchr($vid_clip, '/'), +1);
for($i=0;$i<count($clips);$i++){ $ii = $i+1;
	$n = sprintf('%02s',$ii);
	$my_clip = explode('|', $clips[$i]);
	if (preg_match("/\b$clip\b/",$my_clip[2]) && $sel != ' SELECTED'){
		$views = $my_clip[3] +1;
	}
	if (preg_match("/\b$clip\b/",$my_clip[2])){
		$num = "$n - ";
	}
	if ($views >= '1000'){
		$vc = 'Popular';
	}else{
		$vc = 'Views';
	}
}
//Auto format our views YouTube style ...
$views = number_format($views);
$views = sprintf('%04s',$views);
/////////////////////
$max  = '3';
/////////////////////
//Begin lic code block ...
if ($countit > $max){
	$max = $max;
}else{
	$max = $countit;
}
//if(!strcmp($license, strtoupper($id2))){
	$count_ck = $countit;
	if ($countit == ''){
		$my_count = 'No Clips Available ...';
	}else{
		if ($vid_clip == '1' or !$_POST){
			$my_count = (count($clips))." $clp Available ...";
		}else{
			$my_count = "Clip$num"."$vc $views";
		}
	}
//}
//else{
//	$my_count = "<a href=\"http://$comp_link\" class=\"M1\" title=\"Buy YouLoader Now!\" target=\"_blank\">Unregistered $max Clips</a> ...";
//	$count_ck = $max;//Default to our reg check count if lic code mismatch ...
//}

echo '</td></tr><tr bgcolor="#535353"><td class="M1" nowrap>';
echo $my_count;
echo '</td><td align="right">';
echo "<SELECT NAME=\"view_cl\" class=\"drop\" onChange=\"this.form.submit()\"><OPTION VALUE=\"1\"$sel>::Please Select Video::</OPTION>\n";

@sort($clips, SORT_NUMERIC);//Back Compatable method
//@usort($clips, "numeric");
for($i=0;$i<$count_ck;++$i){ 
	$ii = $i+1;
	$c = sprintf('%02s',$ii);
	$my_clip = explode('|', $clips[$i]);
	//Auto trim long names to fit our selector.            
	$max_length = '33';
	$desc_len = $my_clip[1];
	if (strlen($desc_len) > $max_length){
		$desc_len = substr($desc_len, 0, $max_length);
		$pos = strrpos($desc_len, ' ');
		if ($pos === false) {
			$clip_title = substr($desc_len, 0, $max_length).' ...';
		}
		$clip_title = substr($desc_len, 0, $pos).' ...';
	}else{
		$clip_title = $desc_len;
	}
	if (preg_match("/\b$clip\b/",$my_clip[2]) && $sel != ' SELECTED'){
		$name = "$c - $clip_title".'*';
		echo "<OPTION VALUE=\"".$my_clip[2]."\" class=\"drophl\" SELECTED>";
	}else{
		$name = "$c - $clip_title";
		echo "<OPTION VALUE=\"".$my_clip[2]."\">";
	}
	$name = str_replace('-', ' - ', $name);
	$name = str_replace('_', ' ', $name);
	$name = ucwords($name);
	echo ''.$name."</OPTION>\n";
} 
echo "</SELECT>\n\n";
echo '<noscript><input type="submit" value="GO" class="M1"></noscript></td></tr></table></form>';
?>