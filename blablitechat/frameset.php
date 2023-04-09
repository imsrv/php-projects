<?php 
include "config.php";
$enter_as=false;

if(isset($name)){$name=trim($name);
$name=str_replace('"','',$name);
$name=str_replace("'",'',$name);
$name=str_replace('\\','',$name);
$name=remove_bad_words($name);
$fs=refresh_online(0,1);
for($i=0;$i<count($fs);$i++){
if(stristr($fs[$i],$name)){$name=0;}}
$enter_as=$name;}else{$name=0;}

if(strlen($name)<2){die("</head><body onload=\"parent.location='index.php?name=0'\"></body></html>");}

$xpas=md5($enter_as.$secret_word);

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
<frame src="top.php?chat=1" name="a" marginwidth="0" scrolling="no" marginheight="0" frameborder="0" noresize="noresize" />
<frame src="chat.php<?php print "?name=$enter_as&amp;xpas=$xpas&amp;time_offset=$time_offset&amp;r=$random";?>" name="b" marginwidth="0" scrolling="auto" marginheight="0" frameborder="0" noresize="noresize" />
<frame src="bottom.php<?php print "?chat=1&amp;name=$enter_as&amp;xpas=$xpas&amp;time_offset=$time_offset";?>" name="c" marginwidth="0" scrolling="no" marginheight="0" frameborder="0" noresize="noresize" />
</frameset></html>