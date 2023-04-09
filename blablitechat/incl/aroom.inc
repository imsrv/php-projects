<tr><td class="d" width="10%">&nbsp;<?php print $lang[4];?>&nbsp;</td><td class="d" width="80%">&nbsp;<?php print $lang[33];?>&nbsp;</td><td class="d" width="10%">&nbsp;<?php print $lang[68];?>&nbsp;</td></tr>
<?php

$j=0;$print_lines=array();
$fs=open_file($log_file,1);

if(isset($line)){
$line=(int)$line;
$fs[$line]='';
$fm=implode("\n",$fs);
save_file($log_file,$fm,0);}

$no_messages="<tr class=\"$row_bg\"><td colspan=\"3\" class=\"l\">$lang[36]</td>";

for($i=0;$i<count($fs);$i++){
if($j==$keep_lines){break;}

if(isset($fs[$i])&&strlen($fs[$i])>9){
$row=explode(":|:",$fs[$i]);

$message=strip_tags($row[3]);
$print_lines[$j]="<tr class=\"$row_bg\"><td class=\"l\"><b>$row[2]</b><br /><span class=\"k\">[$row[4]]</span></td><td class=\"k\">$message</td><td class=\"k\" nowrap=\"nowrap\"><a href=\"info.php?reason=link\" onclick=\"return go_url('admin.php?line=$i',5,0)\" title=\"$lang[71] $lang[33]\">$lang[71]</a></td>";
$j++;change_row_color();}
}

for($i=count($print_lines);$i>=0;$i--){
if(isset($print_lines[$i])&&strlen($print_lines[$i])>9){
print $print_lines[$i];
print "</tr>\n";}
elseif(count($print_lines)==0){print $no_messages."</tr>\n";}
}

?>