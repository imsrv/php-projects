<!-- Designed by TRXX Programming Group | (c) 1998-2000 -->
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
<font color="#ffffff" size="5" face="Verdana,Arial,Helvetica"><b>BANNER NÄTVERK</b></font></td></tr>
<tr><td width="100%" align="center" valign="top"><table border="0" width="540">
<tr><td width="100%" align="center"><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<form action="$cgi/adcstat.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="lang" value="$data{lang}">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>MEDLEMSAVDELNINGAR</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>$data{methods}</select></font></td>
<td width="27%" align="right"><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr>
</table>
</form>
</td>
</tr>
</table>
<!--NON-STATIC-->
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<table border="0" width="100%">
<tr><td width="100%"><font size="4" face="Verdana,Arial,Helvetica"><b>TX2000 MENY</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{tx} value=tx>Övergripande statistik</option><option $selectede{montlytx} value=montlytx>Månads Statisik</option><option $selectede{dailytx} value=dailytx>Daglig Statisik</option><option $selectede{hourlytx} value=hourlytx>Statisik per timme</option><option $selectede{mantx} value=mantx>Banner</option><option $selectede{htmltx} value=htmltx>HTML kod</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">TEXT-ANNONS</font>
<form action="$cgi/adcstat.pl" method=post><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="remadtx">
<br><table border="0" width="100%" cellpadding="2" cellspacing="0" bgcolor="#97d0e1">
<tr><td width="90%" valign="top"><font size=2><b>Annons</b></font></td><td width="10%" align="right"><font size=2><b>Ta bort</b></font></td></tr>
@adtxt
</table></form>
</td></tr>
<tr><td>
<form action="$cgi/adcstat.pl" method=post><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="addadtx">
<br><table border="0" width="100%" cellpadding="2" cellspacing="0" bgcolor="#97d0e1">
<tr><td width="20%" valign="top" bgcolor="#82C7DB"><font size=2><b>Ny text</b></font></td><td width="80%" align="right" bgcolor="#82C7DB"><font size=2><textarea name=ad cols=40 rows=6></textarea></font></td></tr>
<tr><td align=right colspan=2><font size=2><input type="image" border=0 src="$adcenter/images/$data{lang}/proceed.gif" width=83 height=23></font></td></tr>
</table></form>
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