<?php 
include "config.php";
if(isset($time_cookie)&&!headers_sent()){setcookie('blabtime',$time_cookie,time()+86400*100,'/');}
include "incl/header.inc";
if(isset($time_cookie)){die('</head><body class="y" onload="self.close()"></body></html>');}
?>
</head><body class="y">
<table align="center" width="135" class="t" cellpadding="0" cellspacing="0"><tr><td>
<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1">
<tr><td class="c"><?php print $lang[24];?></td></tr>
<tr><td class="a" nowrap="nowrap"><div class="k">

<?php 
for($i=-12;$i<=13;$i++){if($i!=0){$gmt='';}else{$gmt='&nbsp;GMT';}
$show_time=gmdate($time_format,time()+$i*3600);
print "<a href=\"info.php?why=link\" style=\"text-decoration:none\" onclick=\"return set_offset('$i')\">".$show_time.$gmt."</a>";
if($i==$time_offset){print ' &not;';}
print "<br />\n";}
?></div></td></tr></table></td></tr></table></td></tr></table></body></html>