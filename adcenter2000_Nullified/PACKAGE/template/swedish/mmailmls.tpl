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
<br><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>MAILINGLISTA MENY</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{sendml} value=sendml>Skicka e-post</option><option $selectede{htmlmail} value=htmlmail>HTML kod</option><option $selectede{edmtemp} value=edmtemp>Fot/Huvud mallar</option><option $selectede{edptemp} value=edptemp>Sid mallar</option><option $selectede{manml} value=manml>Underhåll listan</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">SKICKAR E-POST - STATUS</font>
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0" style="border: 0px none rgb(0,0,0)">
<tr><td><font size=2>Skickar e-post till $count medlemmar</font></td></tr>
</table></td></tr>
</table></center></div>
<script language="Javascript" type="text/javascript">
window.open("$cgi/nph-adcmmail.pl?method=maillist&name=$data{name}&password=$data{password}&email=$data{email}&num=$num", 'f', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=113,height=135');
</script>
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