<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title><?=$art['title']?></title>
<link rel="stylesheet" href="/main.css">
</head>
<body topmargin=0 leftmargin=0 bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="4" align="center" bgcolor="#6B7594"><img src="/p.gif" width="1" height="43" border="0"><img src="/img/logo.gif" alt="" width="339" height="36" border="0"></td>
	</tr>
	<tr>
		<td bgcolor="#000000">&nbsp;</td>
		<td colspan="3" bgcolor="#000000"><?=modules('sys_top_menu')?></td>
	</tr>
	<tr>
		<td width="25"><img src="/p.gif" width="25" height="1" border="0"></td>
		<td width="95%">
			<img src="/p.gif" width="1" height="7" border="0"><br>
			<!--- Content START --->
			<?=$art['text']?><br>
			<!--- Content END --->
			<?=modules('listing')?><br>
			<br><img src="/p.gif" width="1" height="15" border="0"><br>
		</td>
		<td width="25" background="/img/d.gif"><img src="/p.gif" width="25" height="1" border="0"></td>
		<td width="220" valign="top">
			<img src="/p.gif" width="220" height="1" border="0"><img src="/p.gif" width="1" height="23" border="0"><br>
			<font class="naviMain"><strong>Навигация по сайту.</strong></font>
			<br><img src="/p.gif" width="1" height="7" border="0"><br>
			<?=modules('sys_nav_menu')?>			
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#000000" valign="middle"><img src="/p.gif" width="1" height="13" border="0"><font class="cp">Copyright 2000-2002 by Vadim Kravciuk</font></td>
	</tr>
</table>

</body>
</html>
