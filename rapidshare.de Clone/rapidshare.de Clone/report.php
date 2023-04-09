<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
////////////////////////////////////////////////////////

include("./config.php");
include("./header.php");

if(isset($_GET['file'])){
$thisfile=$_GET['file'];
}else{
?>
<center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
echo "<center>Try reporting a file.</center>"; 
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}



$foundfile=0;
if (file_exists("./files/".$thisfile.".txt")) {
	$fh1=fopen("./files/".$thisfile.".txt",r);
	$foundfile= explode('|', fgets($fh1));
	fclose($fh1);
}


if($foundfile==0){
?><center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
echo "<center>Try reporting a file.</center>"; 
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']."\n"){
?><center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
    echo "<center>You are not allowed to report files.</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

$reported = 0;
$fc=file("./reports.txt");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] == $thisfile)
    $reported = 1;
}

if($reported == 1) {
?> <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> 
<?
echo "<center><b>File reported. Thanks.<p></b></center>";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>You Will Be Redirected To Homepage In 10 Seconds.</center></b><br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$filelist = fopen("./reports.txt","a+");
fwrite($filelist, $thisfile ."|". $_SERVER['REMOTE_ADDR'] ."\n");
?> <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> 
<?
echo "<center><b>File reported. Thanks.</b><p>";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?
echo "<center><b>You Will Be Redirected To Homepage In 10 Seconds.</center></b><br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");

?>