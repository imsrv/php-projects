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
<font color="#ffffff" size="5" face="Verdana,Arial,Helvetica"><b>BANNER N�TVERK</b></font></td></tr>
<tr><td width="100%" align="center" valign="top"><table border="0" width="540">
<tr><td width="100%" align="center"><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
</table>
<!--NON-STATIC-->
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<div align=center><table border=0 width="100%" cellpadding=3>
<tr><td align=center>
<font size=4><b>S�K</b></font>
<form action="$cgi/adcsrch.pl" method=post>
<input type=hidden name=lang value="$data{lang}">
<table width="100%"><tr><td align=right>
<select name=type><option value="web">Web</option><option value="people">Personer</option></select><input type=text name=words size=40><br><font size=2>S�k efter person, genom <select name="searchby"><option value="name">Namn</option><option value="address">Adress</option><option value="city">Kommun</option><option value="country">Land</option><option value="phone">Tele</option><option value="email">E-post</option></select></font></td><td align=left valign=top>
<input type="image" border="0" src="$adcenter/images/$data{lang}/search.gif" width="142" height="23">
</td></tr></table></form>
</td></tr>
<tr><td align=center>
<a href="$cgi/adcindex.pl?lang=$data{lang}"><font size=3 color=black><b>Kategorier:</b></font></a><a href="$cgi/adcbrow.pl?lang=$data{lang}&cat=$argum"><font size=3 color=black><b> $data{cat}:</b></font></a><font size=3 color=black><b> $data{subcat}</b></font><br><br>
<div align=right>
<table width="93%">
<tr><td>
@result
</td></tr>
<tr><td>
<br><br>
@footer
</td></tr>
</table></div>
</td></tr>
</table></div>
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