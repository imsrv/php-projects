<?php 
include "config.php";
include "incl/header.inc";
?>
</head><body class="y">
<table align="center" width="120" class="t" cellpadding="0" cellspacing="0"><tr><td>
<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1">
<tr><td class="c"><?php print $lang[13];?></td></tr>
<tr><td class="a" align="center">
<?php 
for($i=0;$i<count($smilies);$i++){
if(isset($smilies[$i])&&strlen($smilies[$i])>9){
$row=explode('|',$smilies[$i]);

print "<a href=\"info.php?why=link\" title=\"$row[4]\" onclick=\"return add_smiley(' $row[0] ')\">";
print "<img src=\"$skin_dir/$row[1]\" width=\"$row[2]\" height=\"$row[3]\" border=\"0\" hspace=\"2\" vspace=\"2\" alt=\"$row[4]\" /></a> ";
}}

?></td></tr></table></td></tr></table></td></tr></table></body></html>