<?php 
include "config.php";
include "incl/header.inc";
check_user();
?>
</head><body class="y">
<table align="center" width="96%" class="t" cellpadding="0" cellspacing="0"><tr><td>
<table width="99%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1">
<tr><td colspan="3" align="center" class="c"><?php print $room_name;?></td></tr>
<tr><td class="d" width="10%">&nbsp;<?php print $lang[31];?>&nbsp;</td><td class="d" width="10%">&nbsp;<?php print $lang[32];?>&nbsp;</td><td class="d" width="80%">&nbsp;<?php print $lang[33];?>&nbsp;</td></tr>
<?php
$fs=open_file($log_file,1);

$print_lines=array();$j=0;

$no_messages="<tr class=\"$row_bg\"><td colspan=\"3\" class=\"l\">$lang[36]</td>";

for($i=0;$i<count($fs);$i++){
if($j==$keep_lines){break;}

if(isset($fs[$i])&&strlen($fs[$i])>9){
$row=explode(":|:",$fs[$i]);

$pop_user=$row[2];

$user_time=show_time($row[0]);
$print_lines[$j]="<tr class=\"$row_bg\"><td class=\"l\">$user_time</td><td class=\"l\"><b>$pop_user</b></td><td>$row[3]</td>";
$j++;change_row_color();}
}

for($i=count($print_lines);$i>=0;$i--){
if(isset($print_lines[$i])&&strlen($print_lines[$i])>9){
print $print_lines[$i];
print "</tr>\n";}
elseif(count($print_lines)==0){print $no_messages."</tr>\n";}
}
?></table></td></tr></table>
<span class="k"><a href="info.php?why=link" onclick="self.scrollTo(0,0);return false"><?php print $lang[25];?></a></span>
<br /><br /></td></tr></table></body></html>