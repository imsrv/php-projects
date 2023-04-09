<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.0
////////////////////////////////////////////////////////

include("./config.php");
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
include("./header.php");

if($topten==false){
echo "This page is disabled.";
include("./footer.php");
die();
}
?>
<center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top>
<h1><center>Top Ten Files</h1>
<p><table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td>#</td><td width="50%"><b>Filename</b></td><td><b>Downloads</b></td><td><b>Size</b></td><td><b>Last Download</b></td></tr>
<tr><td colspan=5 height=10></td></tr>
<?php

if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
 
// Rename PATHTO with the mapname where you keep the config.php
include("./config.php");
 
 
if($enable_filelist == false){
echo "File List Is Disabled.";
die();
}
 
$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".txt","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}
 
if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}

$i = 1;
 
foreach($order as $line)
{
  $line = explode(',', $line);

$shourturl==$me;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

  if (isset($_GET['sortby'])) {
  	echo "<tr><td>".$i."</td><td><a href=\"" . $scripturl . "$me" . $line[1] . "\">".$line[0]."</a></td><td>".$line[2]."</td>";
  } else {
  	echo "<tr><td>".$i."</td><td><a href=\"" . $scripturl . "$me" . $line[1] . "\">".$line[2]."</a></td><td>".$line[0]."</td>";
  }

// Rename PATHTO with the mapname where you keep the "storage" map
 $filesize = filesize("./storage/".$line[1]);
  $filesize = ($filesize / 1048576);
 
  if ($filesize < 1)
  {
     $filesize = round($filesize*1024,0);
     echo "<td>" . $filesize . " KB</td>";
 
  }
  else
    {
     $filesize = round($filesize,0);
     echo "<td>" . $filesize . " MB</td>";
     
  }
echo "<td>".date('Y-m-d G:i', $line[3])."</td></tr>";
if($i == 10) break;
$i++;
 
}
?>

</table></p></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
?>