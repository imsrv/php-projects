<?php include "config.php";include "incl/header.inc";?>
</head><body class="x">
<table width="100%" cellspacing="0" cellpadding="0"><tr><td width="1%">
<?php if(is_file("$skin_dir/custom-left.inc")){include "$skin_dir/custom-left.inc";}?></td>
<td width="99%" class="k" valign="top" align="right">
<table width="100%" cellspacing="3" cellpadding="0"><tr>
<td width="2%"><a href="index.php?admin=1" target="_blank" title="<?php print $lang[51];?>"><?php if(isset($chat)){show_pic($pics[0],0);} ?></a></td>
<td width="2%"><a href="info.php?why=link" onclick="qpe=window.open('smilies.php','smilies','width=150,height=150,resizable=1');qpe.focus();return false" title="<?php print $lang[13];?>"><?php if(isset($chat)&&count($smilies)>0){show_pic($pics[1],0);} ?></a></td>
<td width="96%" align="right"><?php if(is_file("$skin_dir/custom-right.inc")){include "$skin_dir/custom-right.inc";}?></td>
</tr></table><a href="info.php?why=link" onclick="window.open('info.php','info','width=200,height=160,resizable=1');return false">about</a>&nbsp;</td></tr></table></body></html>