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

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']){
?> <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> <?
    echo "You are not allowed to download files.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

if(!isset($_GET['a']) || !isset($_GET['b']))
{
  echo "<script>window.location = '".$scripturl."';</script>";
}

$validdownload = 0;


$filecrc = $_GET['a'];
$filecrctxt = $filecrc.".txt";
if (file_exists("./files/".$filecrctxt)) {
	$fh = fopen ("./files/".$filecrctxt,r);
	$thisline= explode('|', fgets($fh));
	if ($thisline[0]==$_GET['a'] && md5($thisline[2].$_SERVER['REMOTE_ADDR'])==$_GET['b'])
		$validdownload=$thisline;
	fclose($fh);
}
if($validdownload==0) {
?> <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> 
<?
    echo "<center>Invalid download link.</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
}

$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

$filesize = filesize("./storage/".$validdownload[0]);
$filesize = $filesize / 1048576;

if($filesize > $nolimitsize) {
$downloaders = fopen("./downloaders.txt","a+");
fputs($downloaders,"$userip|$time\n");
fclose($downloaders);
}


$validdownload[4] = time();

// begin separate file mod
$newfile = "./files/$filecrc" . ".txt";
$f=fopen($newfile, "w");
fwrite ($f,$validdownload[0]."|". $validdownload[1]."|". $validdownload[2]."|". $validdownload[3]."|". $validdownload[4]."|".($validdownload[5]+1)."|".$validdownload[6]."|".$validdownload[7]."|".$validdownload[8]."|\n");
fclose($f);
// end separate file mod

header('Content-type: application/octetstream');
header('Content-Length: ' . filesize("./storage/".$validdownload[0]));
header('Content-Disposition: attachment; filename="'.$validdownload[1].'"');
readfile("./storage/".$validdownload[0]);

?>