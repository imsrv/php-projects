<?php 
include "config.php";
include "incl/header.inc";
check_user();

$online_users='';
$added=0;$sound=0;
if(!isset($last)){$last=0;}

$fs=refresh_online($name,0);
$array_length=count($fs);
$fs[$array_length]="$name:|:$timestamp:|:$REMOTE_ADDR";
sort($fs);

for($i=0;$i<($array_length+1);$i++){
if(isset($fs[$i])&&strlen($fs[$i])>9){
$row=explode(":|:",$fs[$i]);
$show_ip=explode('.',$row[2]);
$title="*.*.$show_ip[2].$show_ip[3]";
$online_users=$online_users."usr('$row[0]','$title');";
}}

$fs=implode("\n",$fs);
save_file($usr_file,$fs,0);

if(isset($entry)&&strlen($entry)>0&&strlen($entry)<$entry_length+1){
include "incl/format_entry.inc";
$line="$timestamp:|:-:|:$name:|:$entry:|:$REMOTE_ADDR\n";
$fs=open_file($log_file,0);$fs=$line.$fs;
save_file($log_file,$fs,0);$added=1;
}
?>
</head><body class="y" onload="set_rtime()" onunload="clear_rtime()">
<table align="center" width="95%" class="t" cellpadding="0" cellspacing="0"><tr><td>
<table width="99%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1">
<tr><td colspan="4" align="center" class="c"><?php print $room_name;?></td></tr>
<tr><td class="d" width="10%">&nbsp;<?php print $lang[31];?>&nbsp;</td><td class="d" width="10%">&nbsp;<?php print $lang[32];?>&nbsp;</td><td class="d" width="65%">&nbsp;<?php print $lang[33];?>&nbsp;</td><td class="d" width="15%">&nbsp;<?php print $lang[27];?>&nbsp;</td></tr>
<?php
if($added==0){
$fs=open_file($log_file,1);}
else{$fs=explode("\n",$fs);}

$print_lines=array();$j=0;
$array_length=count($fs);

if($array_length<$chat_lines){
$chat_lines=$array_length;}

$no_messages="<tr class=\"$row_bg\"><td colspan=\"3\" class=\"l\">$lang[36]</td>";
$online_users="<td rowspan=\"$chat_lines\" class=\"e\"><script type=\"text/javascript\">$online_users</script></td>";

for($i=0;$i<$array_length;$i++){
if($j==$chat_lines){break;}

if(isset($fs[$i])&&strlen($fs[$i])>9){
$row=explode(":|:",$fs[$i]);

$pop_user=$row[2];

if($j==0&&$last!=0&&$last<$row[0]&&$added==0){$sound=1;}
if($j==0){$last=$row[0];}
$user_time=show_time($row[0]);
$print_lines[$j]="<tr class=\"$row_bg\"><td class=\"l\">$user_time</td><td class=\"l\"><b>$pop_user</b></td><td>$row[3]</td>";
$j++;change_row_color();}
}

for($i=count($print_lines);$i>=0;$i--){
if(isset($print_lines[$i])&&strlen($print_lines[$i])>9){
print $print_lines[$i];
if($i==count($print_lines)-1){print $online_users;}
print "</tr>\n";}
elseif(count($print_lines)==0){print $no_messages.$online_users."</tr>\n";}
}

?></table></td></tr></table><table width="99%" cellpadding="0" cellspacing="0"><tr>
<td class="k"><?php $end_time=time_to_run();$total_time=substr(($end_time-$start_time),0,5);print $total_time.' '.$lang[19];?>
<script type="text/javascript"><?php print "set_last($last);";if($sound==1){print 'snd();';}?></script></td>
<td align="right" class="k"><a href="info.php?why=link" style="text-decoration:none" onclick="return time_win(<?php print $time_offset;?>)" title="<?php print $lang[24]?>"><?php print $local_time;?></a></td></tr></table>
</td></tr></table></body></html>