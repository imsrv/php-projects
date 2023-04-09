<?php 
include "config.php";
include "incl/header.inc";

$fs=open_file($log_file,1);
if(count($fs)>$keep_lines){
$store_lines='';
for($j=0;$j<$keep_lines;$j++){
$store_lines=$store_lines.$fs[$j]."\n";}
save_file($log_file,$store_lines,0);}

$online=0;
$fs=refresh_online(0,1);
$online=count($fs);
?>
</head><body class="y" onload="document.fms.name.focus()">
<form name="fms" action="frameset.php" method="post" target="_parent" onsubmit="<?php if($online>=$users_per_room){print 'document.fms.name.value=\'    \';';}?>if(document.fms.name.value.length<2){document.fms.name.value='';return false}">
<table align="center" width="260" class="t" cellpadding="0" cellspacing="0"><tr><td align="right" class="k">
<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1"><tr>
<td align="left" class="c"><?php print $lang[3];?></td></tr><tr><td align="center" class="a" nowrap="nowrap">
<?php print $lang[4];?>:
<input type="text" name="name" style="width:130px" maxlength="<?php print $username_length;?>" class="g" value="" />
<input type="submit" value=" <?php print $lang[6];?> " class="h" />
</td></tr></table></td></tr></table>
<?php print $lang[27].':'.$online;?>
</td></tr></table></form></body></html>