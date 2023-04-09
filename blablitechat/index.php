<?php 
include "config.php";

if(!isset($name)){$name=0;}

$online=0;
$fs=refresh_online($name,1);
$online=count($fs);

if($online==0&&$clear_chat==1){
save_file($log_file,'',0);}

$frameset=1;
include "incl/header.inc";
?>
<script type="text/javascript">
<?php 
print "if(document.images){\n";

for($i=0;$i<count($pics);$i++){
$entry=explode("|",$pics[$i]);
if(isset($entry[4])&&strlen($entry[4])>3){
print "pca$i=new Image();pca$i.src='$skin_dir/$entry[0]'\n";
print "pcb$i=new Image();pcb$i.src='$skin_dir/$entry[4]'\n";
}}
for($i=0;$i<count($smilies);$i++){
$entry=explode("|",$smilies[$i]);
if(isset($entry[1])&&strlen($entry[1])>3){
print "smi$i=new Image();smi$i.src='$skin_dir/$entry[1]'\n";
}}
print "snd=new Image();snd.src='$skin_dir/sound.swf'\n";
print "}";?></script></head>
<frameset rows="<?php print $fset;?>" border="0">
<frame src="top.php" name="a" marginwidth="0" scrolling="no" marginheight="0" frameborder="0" noresize="noresize" />
<frame src="<?php if(isset($admin)){print "admin.php?r=$random";}else{print "login.php?r=$random";}?>" name="b" marginwidth="0" scrolling="auto" marginheight="0" frameborder="0" noresize="noresize" />
<frame src="bottom.php" name="c" marginwidth="0" scrolling="no" marginheight="0" frameborder="0" noresize="noresize" />
</frameset></html>