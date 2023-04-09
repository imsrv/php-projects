<?php
include "incl/admin.inc";
include "incl/header.inc";
if(isset($w)&&$w=='clear'){save_file($log_file,'',0);}
?>
</head><body class="y"><?php include "incl/fms.inc";?>
<form action="admin.php" onsubmit="return false">
<table align="center" width="440" class="t"><tr><td class="k" align="right">
<a style="text-decoration:none" href="info.php?why=link" onclick="return go_url('admin.php?w=0',5,0)"><?php print $lang[15];?></a> |
<a style="text-decoration:none" href="info.php?why=link" onclick="return go_url('admin.php?w=clear',5,0)"><?php print $lang[69];?></a> |
<a style="text-decoration:none" href="info.php?why=link" onclick="return go_url('admin.php?w=logout',5,0)"><?php print $lang[18];?></a>

<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="f">
<table width="100%" cellpadding="8" cellspacing="1">
<?php print '<tr><td class="c" align="left" colspan="3"><b>'.$room_name.'</b></td></tr>';
include 'incl/aroom.inc';?>
</table></td></tr></table><br />

<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td align="right" nowrap="nowrap">
<select class="k" onchange="document.forms[0].rating.value=this.value">
<option value="5">- Excellent -</option>
<option value="4">- Very good -</option>
<option value="3">- Good -</option>
<option value="2">- Fair -</option>
<option value="1">- Poor -</option></select>
<input type="button" class="h" style="font-size:9px" value="rate-it@hotscripts.com" onclick="document.forms[0].submit()" />
</td></tr></table>
</td></tr></table></form></body></html>