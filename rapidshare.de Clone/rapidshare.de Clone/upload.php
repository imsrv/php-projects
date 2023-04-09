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

$filename = $_FILES['upfile']['name'];
$filesize = $_FILES['upfile']['size'];
$rand2=rand('1','999999');

$m=$shourturl;
if ($m=="true")
  $short= "";
else
  $short= "download.php?file=";

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$rand2."\n"){
?> <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> 
<?
    echo "That file is not allowed to be uploaded.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
  if ($line==$_SERVER['REMOTE_ADDR']."\n"){
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
   <? echo "You are not allowed to upload files.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

$checkfiles=file("./files.txt");
foreach($checkfiles as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0]==$filecrc){
    $filecrc=rand('10000','1000000000');
  }
}

if(isset($allowedtypes)){
$allowed = 0;
foreach($allowedtypes as $ext) {
  if(substr($filename, (0 - (strlen($ext)+1) )) == ".".$ext)
    $allowed = 1;
}
if($allowed==0) {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><?
   echo "That file type is not allowed to be uploaded.";
   ?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
   die();
}
}

if(isset($categorylist)){
$validcat = 0;
foreach($categories as $cat) {
  if($_POST['category']==$cat || $_POST['category'] = ""){ $validcat = 1; }
}
if($validcat==0) {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><?
   echo "Invalid category was chosen..";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
   include("./footer.php");
   die();
}
$cat = $_POST['category'];
} else { $cat = ""; }

if($filesize==0) {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><?
echo "You didn't pick a file to upload.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$filesize = $filesize / 1048576;

if($filesize > $maxfilesize) {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><?
echo "The file you uploaded is too large.";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

if($filesize > $nolimitsize) {

$uploaders = fopen("./uploaders.txt","r+");
flock($uploaders,2);
while (!feof($uploaders)) { 
$user[] = chop(fgets($uploaders,65536));
}
fseek($uploaders,0,SEEK_SET);
ftruncate($uploaders,0);
foreach ($user as $line) {
@list($savedip,$savedtime) = explode("|",$line);
if ($savedip == $userip) {
if ($time < $savedtime + ($uploadtimelimit*60)) {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><?
echo "You're trying to upload again too soon!";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}
}
if ($time < $savedtime + ($uploadtimelimit*60)) {
  fputs($uploaders,"$savedip|$savedtime\n");
}
}
fputs($uploaders,"$userip|$time\n");

}

$passkey = rand(100000, 999999);

if($emailoption && isset($_POST['myemail']) && $_POST['myemail']!="") {
$uploadmsg = "Your file (".$filename.") was uploaded.\n Your download link is: ". $scripturl . "$short" . $rand2 . "\n Your delete link is: ". $scripturl . "$short" . $rand2 . "&del=" . $passkey . "\n Thank you for using our service!";
mail($_POST['myemail'],"Your Uploaded File",$uploadmsg,"From: admin@yoursite.com\n");
}

if($passwordoption && isset($_POST['pprotect'])) {
  $passwerd = md5($_POST['pprotect']);
} else { $passwerd = md5(""); }

if($descriptionoption && isset($_POST['descr'])) {
  $description = strip_tags($_POST['descr']);
} else { $description = ""; }

$filelist = fopen("./files/".$rand2.".txt","w");
fwrite($filelist, $rand2 ."|". basename($_FILES['upfile']['name']) ."|". $passkey ."|". $userip ."|". $time."|0|".$description."|".$passwerd."|".$cat."|\n");

$movefile = "./storage/" . $rand2;
move_uploaded_file($_FILES['upfile']['tmp_name'], $movefile);
?>
<center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>

<?
include("./ads.php");
echo "<center><b>Your file was uploaded!</b></center><br />";
echo "<center>Your download link </center> <p><center> <a href=\"" . $scripturl . "$short" . $rand2 . "\">". $scripturl . "$short" . $rand2 . "</a><br />";
echo "<p><center>Your delete link </center> <p><center> <a href=\"" . $scripturl . "$short" . $rand2 . "&del=" . $passkey . "\">". $scripturl . "$short" . $rand2 . "&del=" . $passkey . "</a><br />";
echo "<p><center>Please remember the above links."; ?><p><?
include("./bottomads.php");
?>
  </td></tr></table></center>
<?

include("./footer.php");
?>