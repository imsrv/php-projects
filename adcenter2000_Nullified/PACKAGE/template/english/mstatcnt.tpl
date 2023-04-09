<html>
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>ADCenter 2000</title></head>
<body background="$adcenter/images/$data{lang}/globalbk.gif" bgcolor="#2275A0" text="#000000" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<font face=arial>
<div align="center"><center>
<table border="0" width="562" cellspacing="0" cellpadding="0" height="100%">
<tr><td width="100%" background="$adcenter/images/$data{lang}/washedbk.jpg" bgcolor="#7DB8D3" valign="top">
<div align="center"><center>
<table border="0" width="560" cellspacing="0" cellpadding="0" height="100%">
<tr><td width="1" bgcolor="#3E5B68" height="100%" background="$adcenter/images/$data{lang}/linepix.gif">
<img border="0" src="$adcenter/images/$data{lang}/linepix.gif" width="1" height="100%"> <p>&nbsp;</td>
<td height="100%" valign="top">
<table border="0" cellspacing="0" cellpadding="0" height="384">
<tr><td width="100%" valign="top" height="84"><p align="center">
<img border="0" src="$adcenter/images/$data{lang}/top.jpg" width="561" height="84"></td></tr>
<tr><td width="100%" height="300" valign="top" align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td width="100%" background="$adcenter/images/$data{lang}/globalbk.gif" align="center">
<font color="#ffffff" size="5" face="Verdana,Arial,Helvetica"><b>BANNER NETWORK</b></font></td></tr>
<tr><td width="100%" align="center" valign="top"><table border="0" width="540">
<tr><td width="100%" align="center"><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<form action="$cgi/adcstat.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="lang" value="$data{lang}">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>MEMBERS SECTION NAVIGATOR</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>$data{methods}</select></font></td>
<td width="27%" align="right"><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr>
</table>
</form>
</td>
</tr>
</table>
<!--NON-STATIC-->
<br><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>COUNTER MENU NAVIGATOR</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{visitors} value=visitors>Counter stats</option><option $selectede{montlycount} value=montlycount>Monthly stats</option><option $selectede{montlyucount} value=montlyucount>Unique monthly stats</option><option $selectede{dailycount} value=dailycount>Daily stats</option><option $selectede{dailyucount} value=dailyucount>Unique daily stats</option><option $selectede{hourlycount} value=hourlycount>Hourly stats</option><option $selectede{hourlyucount} value=hourlyucount>Unique hourly stats</option><option $selectede{htmlcounter} value=htmlcounter>Get HTML code</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<form action="$cgi/adcstat.pl" method=post>
<font size=5 color="#000000">COUNTER PRESET</font>
<table border="0" width="100%" cellspacing=0 cellpadding="2" bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>Total preset</b></font></td><td width="60%" align="right"><font size=2><input type=text name=tpreset value="$tpreset" size=14></font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Unique preset</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2><input type=text name=upreset value="$upreset" size=14></font></td></tr>
<tr><td width="100%" valign="top" align=right colspan=2><input type=hidden name=name value=$data{name}><input type=hidden name=lang value=$data{lang}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=presetcounter><input type="image" border=0 src="$adcenter/images/$data{lang}/proceed.gif"></td></tr>
</table>
</form></td></tr>
<tr><td>
<form action="$cgi/adcstat.pl" method=post>
<font size=5 color="#000000">GLOBAL STATS</font>
<table border="0" width="100%" cellspacing=0 cellpadding="2" bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>Total visitors</b></font></td><td width="60%" align="right"><font size=2>$globcnt</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Unique visitors</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2>$unqcnt</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Popularity index</b></font></td><td width="60%" align="right"><font size=2>$popularity</font></td></tr>
<tr><td width="100%" bgcolor="#82C7DB" valign="top" align=right colspan=2><input type=hidden name=name value=$data{name}><input type=hidden name=lang value=$data{lang}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=clearcounter><input type="image" border=0 src="$adcenter/images/$data{lang}/reset.gif" width=105 height=23></td></tr>
</table>
</form></td></tr>
<tr><td>
<font size=5 color="#000000">EXTENTED STATS</font>
<br><font size=5 color="#000000">BROWSER</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>Internet Explorer</b></font></td><td width="60%" align="right"><font size=2>$ext{IE}</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Netscape</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2>$ext{netscape}</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Other</b></font></td><td width="60%" align="right"><font size=2>$ext{bother}</font></td></tr>
</table>
</td></tr>
<tr><td>
<font size=5 color="#000000">RESOLUTION</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>640x480</b></font></td><td width="60%" align="right"><font size=2>$ext{r640}</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>800x600</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2>$ext{r800}</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>1024x768</b></font></td><td width="60%" align="right"><font size=2>$ext{r1024}</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Other</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2>$ext{rother}</font></td></tr>
</table>
</td></tr>
<tr><td>
<font size=5 color="#000000">GEOGRAPHY</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97D0E1">
$result
</table>
</td></tr>
</table></center></div>
<!--NON-STATIC-->
</td></tr></table>
</td></tr></table>
</td></tr></table>
<div align="center"><center><table border="0" width="100%" cellspacing="1" cellpadding="0">
<tr><td width="100%" align="center"><hr size="1" color="#000000" width="534">
<p><font face="Arial" color="#000000" size="1"><b>$copyright</b></font></p><p>&nbsp;</td></tr>
</table></center></div></td>
<td bgcolor="#3E5B68" height="100%" background="$adcenter/images/$data{lang}/linepix.gif" align="center"><img border="0" src="$adcenter/images/$data{lang}/linepix.gif" width="1" height="100%"> <p>&nbsp;</td></tr>
</table></center></div></td></tr></table></center></div>
</font>
</body>
</html>