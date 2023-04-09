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

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']){
?>
<center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
    echo "You are not allowed to download files.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

if(isset($_GET['file'])) {
  $filecrc = $_GET['file'];
} else {
?>

<?
?>
<center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
  echo "Invalid download link.<br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
  include("./footer.php");
  die();
}

$foundfile=0;
if (file_exists("./files/".$filecrc.".txt")) {
	$fh1=fopen("./files/".$filecrc.".txt",r);
	$foundfile= explode('|', fgets($fh1));
	fclose($fh1);
}
{
  $thisline = explode('|', $line);
  if ($thisline[0]==$filecrc){
    $foundfile=$thisline;
  }
}

if(isset($_GET['del'])) {

$deleted=0;
$filecrc = $_GET['file'];
$filecrctxt = $filecrc . ".txt";
$passcode = $_GET['del'];
if (file_exists("./files/".$filecrctxt)) {
	$fh2=fopen ("./files/".$filecrctxt,r);
	$thisline= explode('|', fgets($fh2));
	if($thisline[2] == $passcode){
$deleted=1;
fclose($fh2);
		unlink("./files/".$filecrctxt);
	}

}

if($deleted==1){
unlink("./storage/".$_GET['file']);
?>
<center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
echo "<center><b>Your file was deleted.</b></center><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>You Will Be Redirected To Homepage In 10 Seconds.</center></b><br />";
} else {
?><center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
echo "<center><b>Invalid delete link . </b></center><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>You Will Be Redirected To Homepage In 10 Seconds.</center></b><br />";
}
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();

}

if($foundfile==0) {
?> <center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top><?
  echo "<center><b>Invalid download link.</center></b><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>You Will Be Redirected To Homepage In 10 Seconds.</center></b><br />";
  ?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
  die();
}

if(isset($foundfile[7]) && $foundfile[7]!=md5("") && (!isset($_POST['pass']) || $foundfile[7] != md5($_POST['pass']))){
?>  <center><table style='margin-top:20px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top> 
<?
include("./ads.php"); ?> <p> <?
echo "<form action=\"download.php?file=".$foundfile[0]."\" method=\"post\"><center><b>Password Protected: </center></b><p><center><input type=\"password\" name=\"pass\"><p><center><input value=\"Enter\" type=\"submit\" /></form>";
?><p><center>Please Enter The Correct Password To Acess The Download</center><?
?><p><p><?
include("./bottomads.php");
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}
?>
<center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>

<?

$filesize = filesize("./storage/".$foundfile[0]);
$filesize = $filesize / 1048576;

if($filesize > $nolimitsize) {

$userip=$_SERVER['REMOTE_ADDR'];
$time=time();
$downloaders = fopen("./downloaders.txt","r+");
flock($downloaders,2);
while (!feof($downloaders)) { 
$user[] = chop(fgets($downloaders,65536));
}
fseek($downloaders,0,SEEK_SET);
ftruncate($downloaders,0);
foreach ($user as $line) {
list($savedip,$savedtime) = explode("|",$line);
if ($savedip == $userip) {
if ($time < $savedtime + ($downloadtimelimit*60)) {
echo "You're trying to download again too soon!";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}
}
if ($time < $savedtime + ($downloadtimelimit*60)) {
  fputs($downloaders,"$savedip|$savedtime\n");
}
}

}

$fsize = 0;
$fsizetxt = "";
  if ($filesize < 1)
  {
     $fsize = round($filesize*1024,0);
     $fsizetxt = "".$fsize." KB";
    $check1 = "KB";
  }
  else
    {
     $fsize = round($filesize,2);
     $fsizetxt = "".$fsize." MB";
$check1 = "MB";
  }
include 'ads.php';

?>
<p>
<?
$quantity= $foundfile[5] * $fsizetxt;
$d=$descriptionoption;
switch ($d)
{
case false:
 $test="";
  break;
case true:
  $test= "File Description: ";
  break;
default:
  echo ""; }
$f=$foundfile[6];
if ($f=="")
  $test2= "None";
else
  $test2= "$foundfile[6]"; 
$e=$descriptionoption;
switch ($e)
{
case false:
 $test4="";
  break;
case true:
  $test4= "$test2";
  break;
default:
  echo ""; }
echo "<center><b>File Name: </b>$foundfile[1] (<a href='report.php?file=$foundfile[0]'>Report This File</a>)<br></br><b>File Bandwith Used: </b>$quantity $check1<br></br><b>IP Adress: </b>$foundfile[3]<br></br><b>File Size:</b> $fsizetxt<br></br><b>File Downloaded:</b> $foundfile[5] times<br></br><b>Last Download: </b>".date('Y-m-d G:i', $foundfile[4])."</center>\n";

if(isset($foundfile[6])){ echo "<center><b>$test</b>$test4<br /><br />"; }
$randcounter = rand(100,999);
?><p><div id="dl" align="center">

<?php 

if($downloadtimer == 0) {
echo "<input type=submit value=\"Download File Now\" onClick=\"".$scripturl. "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR'])."\">"; 
} else { ?>
If you're seeing this message, you need to enable JavaScript

<?php } ?>
</div>

<script language="Javascript">
x<?php echo $randcounter; ?>=<?php echo $downloadtimer; ?>;
function countdown() 
{
 if ((0 <= 100) || (0 > 0))
 {
  x<?php echo $randcounter; ?>--;
  if(x<?php echo $randcounter; ?> == 0)
  {
document.getElementById("dl").innerHTML = '<input type="submit" value="Download File Now" onClick="window.location=\'<?php echo $scripturl . "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR']) ?>\'">';
  }
  if(x<?php echo $randcounter; ?> > 0)
  {
 document.getElementById("dl").innerHTML = '<input type=submit value=\"Please wait '+x<?php echo $randcounter; ?>+' seconds..\">';
   setTimeout('countdown()',1000);
  }
 }
}
countdown();
</script><p><p>
<?php
include("./bottomads.php");
?>
 </td></tr></table></center>
<?php
include("./footer.php");
?>
