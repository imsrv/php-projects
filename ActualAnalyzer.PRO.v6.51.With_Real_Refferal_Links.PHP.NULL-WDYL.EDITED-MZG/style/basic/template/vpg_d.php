<?php
$top=<<<TOP
<DIV class=bor750><a name="%%REF%%"></a><table width=750 border=0 cellspacing=0 cellpadding=0><tr height=20><td background="%%RF%%style/%%STYLE%%/image/bg.gif" align=left>
<table width=750 border=0 cellspacing=0 cellpadding=0><tr><td><font color="#FFFFFF"><SPAN class=f12>&nbsp;&nbsp;<b>%%HEADER%%%%RHEADER%% / %%THEADER%%</b></SPAN></font></td>

TOP;

$button=<<<BUTTON
<td width=23><a href="%%MODULE%%.php" onclick="return false"><img width=14 height=14 src="%%RF%%style/%%STYLE%%/image/%%ELEM%%.gif" title="%%TITLE%%" border=0 onclick='FormPict(view,%%MODULE%%,"%%PICTID%%","%%REF%%","%%ELEM%%","%%PREF%%")'></a></td>

BUTTON;

$etop=<<<ETOP
</tr></table></td></tr><tr bgcolor="#FFFFFF" height=20><td><SPAN class=f11>&nbsp;&nbsp;%%SHOWING%% %%RANGE%% %%FPG%%</SPAN></td></tr><tr><td>
<table width=750 border=0 cellspacing=1 cellpadding=0><tr bgcolor="#CCCCCC" height=20 align=center><td width=48><SPAN class=f11><b>N</b></SPAN></td>
<td width=299><table width="100%" border=0 cellspacing=0 cellpadding=0><tr valign=center align=center>
<td><div class=stabl><input name="%%STAB%%_1" width=14 height=14 type=image src="%%RF%%style/%%STYLE%%/image/sort.gif" title="%%SORTBYN%%" border=0></div></td>
<td width="100%"><SPAN class=f11><b>%%GRPG%%</b>&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></td></tr></table></td><td width=99><table width="100%" border=0 cellspacing=0 cellpadding=0>
<tr valign=center align=center><td><div class=stabl><input name="%%STAB%%_2" width=14 height=14 type=image src="%%RF%%style/%%STYLE%%/image/sort.gif" title="%%SORT%%" border=0></div></td>
<td width="100%"><SPAN class=f11><b>%%TOTAL%%</b>&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></td></tr></table></td><td width=99><table width="100%" border=0 cellspacing=0 cellpadding=0>
<tr valign=center align=center><td><div class=stabl><input name="%%STAB%%_2" width=14 height=14 type=image src="%%RF%%style/%%STYLE%%/image/sort.gif" title="%%SORTBYP%%" border=0></div></td>
<td width="100%"><SPAN class=f11><b>%</b>&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></td></tr></table></td><td width=198><SPAN class=f11><b>%%GRAPHIC%%</b></SPAN></td></tr>

ETOP;

$empty=<<<EMPTY
<tr height=20 bgcolor="#EEEEEE" align=center onmouseover="this.className='sel'" onmouseout="this.className='usel'"><td colspan=5><SPAN class=f11><i>%%TEXT%%</i></SPAN></td></tr>

EMPTY;

$centerp=<<<CENTERP
<tr height=20 bgcolor="#EEEEEE" align=center onmouseover="this.className='sel'" onmouseout="this.className='usel'"><td><SPAN class=f11>%%NUM%%</SPAN></td>
<td><table width="100%" border=0 cellspacing=0 cellpadding=0><tr valign=center><td><div class=stabl><a href="view.php" onclick="return false"><img width=14 height=14 src="%%RF%%style/%%STYLE%%/image/info.gif" title="%%DETAIL%%" border=0 onclick='FormIdExt(view,"%%PGID%%","%%REF%%")'></a></div></td>
<td width="100%"><div class=stabl><a href="%%PGURL%%" title="%%GRPG%%" style="color:#000000" target=_blank><code class=f9>%%GRPGSHORT%%</code></a></div></td>
</tr></table></td><td><SPAN class=f11>%%TOTAL%%</SPAN></td><td><SPAN class=f11>%%PER%%</SPAN></td><td align=left><table border=0 cellspacing=0 cellpadding=0>
<tr valign=center><td><img border=0 height=16 width=3 src="%%RF%%style/%%STYLE%%/image/left.gif"></td><td><img border=0 height=16 width="%%GRAPHIC%%" src="%%RF%%style/%%STYLE%%/image/center.gif"></td>
<td><img border=0 height=16 width=7 src="%%RF%%style/%%STYLE%%/image/right.gif"></td></tr></table></td></tr>

CENTERP;

$centerg=<<<CENTERG
<tr height=20 bgcolor="#EEEEEE" align=center onmouseover="this.className='sel'" onmouseout="this.className='usel'"><td><SPAN class=f11>%%NUM%%</SPAN></td>
<td><table width="100%" border=0 cellspacing=0 cellpadding=0><tr valign=center>
<td><div class=stabl><a href="view.php" onclick="return false"><img width=14 height=14 src="%%RF%%style/%%STYLE%%/image/info.gif" title="%%DETAIL%%" border=0 onclick='FormTimIdExt(view,"%%INTERVAL%%","%%PGID%%","%%REF%%")'></a></div></td>
<td width="100%"><div class=stabl><code class=f9>%%GRPG%%</code></div></td></tr></table></td><td><SPAN class=f11>%%TOTAL%%</SPAN></td>
<td><SPAN class=f11>%%PER%%</SPAN></td><td align=left><table border=0 cellspacing=0 cellpadding=0><tr valign=center>
<td><img border=0 height=16 width=3 src="%%RF%%style/%%STYLE%%/image/left.gif"></td><td><img border=0 height=16 width="%%GRAPHIC%%" src="%%RF%%style/%%STYLE%%/image/center.gif"></td>
<td><img border=0 height=16 width=7 src="%%RF%%style/%%STYLE%%/image/right.gif"></td></tr></table></td></tr>

CENTERG;

$delimiter=<<<DELIMITER
<tr bgcolor="#CCCCCC" height=20 align=center><td colspan=2><input type=hidden name=listcur value=%%LISTCUR%%><input type=hidden name=listlen value=%%LISTLEN%%>
<table width="100%" border=0 cellspacing=0 cellpadding=0><tr>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/lbeg.gif" title="%%LBEG%%" border=0 onclick='ListPos(view,"lbeg","%%REF%%")'></a></td>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/lllscr.gif" title="%%LLLSCR%%" border=0 onclick='ListPos(view,"lllscr","%%REF%%")'></a></td>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/llscr.gif" title="%%LLSCR%%" border=0 onclick='ListPos(view,"llscr","%%REF%%")'></a></td>
<td width="100%" align=center><SPAN class=f11><b>%%RANGE%%</b></SPAN></td>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/lrscr.gif" title="%%LRSCR%%" border=0 onclick='ListPos(view,"lrscr","%%REF%%")'></a></td>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/lrlscr.gif" title="%%LRLSCR%%" border=0 onclick='ListPos(view,"lrlscr","%%REF%%")'></a></td>
<td><a href="view.php" onclick="return false"><img width=20 height=20 src="%%RF%%style/%%STYLE%%/image/lend.gif" title="%%LEND%%" border=0 onclick='ListPos(view,"lend","%%REF%%")'></a></td>
</tr></table></td><td><SPAN class=f11><b>%%TOTAL%%</b></SPAN></td><td><SPAN class=f11><b>%%PER%%</b></SPAN></td><td><SPAN class=f11><b>-</b></SPAN></td></tr>

DELIMITER;

$foot=<<<FOOT
<tr height=20 bgcolor="#EEEEEE" align=center onmouseover="this.className='sel'" onmouseout="this.className='usel'"><td colspan=2><SPAN class=f11>%%NAME%%</SPAN></td>
<td><SPAN class=f11>%%TOTAL%%</SPAN></td><td><SPAN class=f11>%%PER%%</SPAN></td><td align=left><table border=0 cellspacing=0 cellpadding=0><tr valign=center>
<td><img border=0 height=16 width=3 src="%%RF%%style/%%STYLE%%/image/left.gif"></td><td><img border=0 height=16 width="%%GRAPHIC%%" src="%%RF%%style/%%STYLE%%/image/center.gif"></td>
<td><img border=0 height=16 width=7 src="%%RF%%style/%%STYLE%%/image/right.gif"></td></tr></table></td></tr>

FOOT;

$delimiter2=<<<DELIMITER2
<tr height=20 bgcolor="#CCCCCC" align=center><td colspan=2><SPAN class=f11><b>%%NAME%%</b></SPAN></td><td><SPAN class=f11><b>%%TOTAL%%</b></SPAN></td>
<td><SPAN class=f11><b>%%PER%%</b></SPAN></td><td><SPAN class=f11><b>-</b></SPAN></td></tr>

DELIMITER2;

$bottom=<<<BOTTOM
</table></td></tr><tr height=20>
<td background="%%RF%%style/%%STYLE%%/image/bg2.gif" align=right><SPAN class=f10><a href="#top" style="color:#000000"><b>%%BACKTT%%</b></a>&nbsp;&nbsp;</SPAN></td>
</tr></table></DIV><br>

BOTTOM;
?>