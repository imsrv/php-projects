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
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
include("./header.php");
if($act=="login"){
  if($_POST['passwordx']==$adminpass){
    $_SESSION['logged_in'] = md5(md5($adminpass));
  }
}
if($act=="logout"){
  session_unset();
  echo "";
}

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==md5(md5($adminpass))) {

if(isset($_GET['download'])){
$filecrc = $_GET['download'];
$filecrctxt = $filecrc . ".txt";
if (file_exists("./files/" . $filecrctxt)) {
	$fh = fopen("./files/" . $filecrctxt, r);
	$filedata= explode('|', fgets($fh));
}
echo "<script>window.location='".$scripturl."download2.php?a=".$filecrc."&b=".md5($filedata[1].$_SERVER['REMOTE_ADDR'])."';</script>";
fclose ($fh);
}

if(isset($_GET['delete'])) {

unlink("./files/".$_GET['delete'].".txt");
unlink("./storage/".$_GET['delete']);



if(isset($_GET['banreport'])) {

$bannedfile = $_GET['banreport'];
if (file_exists("./files/$bannedfile".".txt")) {
	unlink("./files/".$bannedfile.".txt");
	unlink("./storage/".$bannedfile);
	$deleted=$bannedfile;
}
$fc=file("./reports.txt");
$f=fopen("./reports.txt","w+");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] != $_GET['banreport'])
    fputs($f,$line);
}
fclose($f);
$f=fopen("./bans.txt","a+");
fputs($f,$deleted[3]."\n".$deleted[0]."\n");
unlink("./storage/".$_GET['banreport']);
}
}
if(isset($_GET['ignore'])) {

$fc=file("./reports.txt");
$f=fopen("./reports.txt","w+");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] != $_GET['ignore'])
    fputs($f,$line);
}
fclose($f);
}

if(isset($_GET['act']) && $_GET['act']=="bans") {

if(isset($_GET['unban'])) {
$fc=file("./bans.txt");
$f=fopen("./bans.txt","w+");
foreach($fc as $line)
{
  if (md5($line) != $_GET['unban'])
    fputs($f,$line);
}
fclose($f);
}

if(isset($_POST['banthis'])) {
$f=fopen("./bans.txt","a+");
fputs($f,$_POST['banthis']."\n");
}


?>
<center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
<h1>Bans</h1><p> <center><form action="admin.php?act=bans" method="post">enter an ip or file hash to ban:  
<input type="text" name="banthis"> 
<input type="submit" value="BAN!">
<br />
</form></center>
<?php

$fc=file("./bans.txt");
foreach($fc as $line)
{
  echo $line . " - <a href=\"admin.php?act=bans&unban=".md5($line)."\">unban</a><br />";
}
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}


?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
<center><a href="admin.php?act=logout">click here to log out</a> | <a href="admin.php?act=bans">click here to manage bans</a></center><br />
<? 
//delete old files
echo "Deleting old files...<BR>";
$deleteseconds = time() - ($deleteafter * 24 * 60 * 60);
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != ".htaccess") {
  $fh=fopen("./files/" . $file ,r);
  $filedata= explode('|', fgets($fh));
  if ($filedata[4] < $deleteseconds) {
    $deletedfiles="yes";
	echo "Deleting - " . $filedata[1] . ":<BR>"; 
fclose($filedata);
    unlink("./files/".$file);
	echo "Deleted /files/" . $file . "<BR>"; 
    unlink("./storage/".str_replace(".txt","",$file));
	echo "Deleted /storage/" . str_replace(".txt","",$file) . "<BR><BR>"; 
  }
  fclose($fh);
}
}
closedir( $dh );
if (!$deletedfiles) echo "No old files to delete!<br /><br />";
//done deleting old files
?>
  <h1>Reports</h1>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><b>Filename</b></td><td><b>Uploader</b></td><td><b>Delete</b></td><td><b>Ignore report</b></td></tr>
<?php

$checkreports=file("./reports.txt");
foreach($checkreports as $line)
{
  $thisreport = explode('|', $line);
$filecrc = $thisreport[0];
if (file_exists("./files/$filecrc".".txt")) {
	$fr=fopen("./files/".$filecrc.".txt",r);
	$foundfile= explode('|', fgets($fr));
	fclose($fr);
}
$shourturl==$me;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";
echo "<tr><td><a href=\"admin.php?download=".$foundfile[0]."\">".$foundfile[1]."</td>";
echo "<td>".$foundfile[3]."</td>";
echo "<td><a href=\"admin.php?delete=".$foundfile[0]."\">Delete</a></td>";
echo "<td><a href=\"admin.php?ignore=".$foundfile[0]."\">Ignore report</a></td></tr>";

}

?>
</table>
<br />
<center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
  <h1>Files</h1>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><b>Filename</b></td><td><b>Size (MB)</b></td><td><b>Uploader</b></td><td><b>Bandwidth(MB)</b></td><td><b>Delete</b></td></tr>
<?php

$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
  $filecrc = str_replace(".txt","",$file);
  $filesize = filesize("./storage/". $filecrc);
  $filesize = ($filesize / 1048576);
  $fh = fopen ("./files/".$file, r);
  $filedata= explode('|', fgets($fh));
  echo "<tr><td><a href=\"$me".$filedata[0]."\">".$filedata[1]."</a></td><td>".round($filesize,2)."</td>";
  echo "<td>".$filedata[3]."</td><td style=padding-left:5px>".round($filesize*$filedata[5],2)."</td><td style=padding-left:5px><a href=\"admin.php?delete=".$filecrc."\">[x]</a></td></tr>";
  fclose ($fh);
}
}
closedir( $dh );
echo "</table>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
} else {
?><center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><center>
<h1><center>Admin Login</center></h1><br />
<? 
$d=$act;
if ($d=="logout")
  echo "<b>You Have Logged Out Succesfully!</b> <p>"; 
else
  echo ""; ?>
<form action="admin.php?act=login" method="post">Password:  
<input type="text" name="passwordx"> 
<input type="submit" value="Login">
<br /><br />
</form></center>
<?php }
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
?>