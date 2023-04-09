<?php 
include "config.php";
include "incl/header.inc";
if(!isset($chat)){die('</head><body class="z"></body></html>');}
check_user();
?>
<?php print "<script type=\"text/javascript\">refr=$default_rate*1000</script>\n";?>
</head><body class="z"><form name="fms" action="chat.php" method="post" target="b" onsubmit="return entry_ok('<?php print $lang[29];?>')">
<input type="hidden" name="last" value="0" />
<input type="hidden" name="time_offset" value="<?php print $time_offset;?>" />
<input type="hidden" name="name" value="<?php print $name;?>" />
<input type="hidden" name="xpas" value="<?php print $xpas;?>" />
<table width="100%" cellspacing="3" cellpadding="0" summary=""><tr>
<td width="2%"><a href="info.php?why=link" onclick="return chat()" title="<?php print $lang[15];?>"><?php show_pic($pics[3],0); ?></a></td>
<td width="20%" class="l">
<input type="text" name="entry" size="40" class="g" maxlength="<?php print $entry_length;?>" /><input type="image" src="<?php print $skin_dir;?>/space.png" /></td>
<td width="2%"><a href="info.php?why=link" onclick="if(entry_ok()){document.fms.submit()};return false" title="<?php print $lang[26];?>"><?php show_pic($pics[4],0); ?></a></td>
<td width="2%"><a href="info.php?why=link" onclick="return show_hist()" title="<?php print $lang[17];?>"><?php show_pic($pics[5],0); ?></a></td>
<td width="2%" valign="middle" class="l">
<?php 
$rr_pic1=explode("|",$pics[11]);
$rr_pic2=explode("|",$pics[12]);
$r_rate=explode(":",$refresh_rate);

for($i=0;$i<5;$i++){
if(is_integer($i/2)){$hspace=1;}else{$hspace=0;}
print "<a href=\"info.php?why=link\" onclick=\"return change_rate('$r_rate[$i]',im$i,'$skin_dir/$rr_pic1[0]','$skin_dir/$rr_pic2[4]')\" title=\"$lang[15]: $r_rate[$i] $lang[19]\"><img src=\"$skin_dir/$rr_pic1[0]\" border=\"0\" width=\"$rr_pic1[1]\" height=\"$rr_pic1[2]\" name=\"im$i\" alt=\"$lang[15]: $r_rate[$i] $lang[19]\" hspace=\"$hspace\" onmouseover=\"return over_out(this,'$rr_pic2[4]','$skin_dir/$rr_pic1[4]')\" onmouseout=\"return over_out(this,'$rr_pic2[4]','$skin_dir/$rr_pic1[0]')\" /></a>";
}
print '</td><td width="2%">'."\n";
$rr_pic=explode("|",$pics[10]);
print "<a href=\"info.php?why=link\" onclick=\"if(onff==1){onff=0;document.sndp.src='$skin_dir/$rr_pic[4]'}else{onff=1;document.sndp.src='$skin_dir/$rr_pic[0]'};return false\" title=\"$lang[55]\"><img src=\"$skin_dir/$rr_pic[0]\" border=\"0\" name=\"sndp\" width=\"$rr_pic[1]\" height=\"$rr_pic[2]\" alt=\"$lang[55]\" /></a>";

?></td><td align="right" width="70%"><a href="info.php?why=link" onclick="return log_out()" title="<?php print $lang[18];?>"><?php show_pic($pics[6],0); ?></a></td>
</tr></table></form><script type="text/javascript">ldd=1;</script></body></html>