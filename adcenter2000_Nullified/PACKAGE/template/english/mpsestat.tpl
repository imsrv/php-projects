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
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td><form method="post" action="$cgi/adcstat.pl"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_personal"><input type="hidden" name="pemail" value="$uemail">
<a href="$cgi/adcstat.pl?name=$data{name}&password=$data{password}&method=h_psestat&lang=$data{lang}" target="_blank"><img src="$adcenter/images/$data{lang}/info.gif" border=0 alt="GET HELP"></a>&nbsp;&nbsp;<font size=5 color="#000000">PERSONAL SETTINGS</font>
<table border="0" width="100%" bgcolor="#97D0E1" cellspacing="0" cellpadding="0">
<tr><td width="50%" bgcolor="#82c7db"><font size="2">&nbsp;Name</font></td>
<td width="50%" bgcolor="#82c7db"><input type="text" name="realname" size="48" value="$name"></td></tr>
<tr><td width="50%"><font size="2">&nbsp;Address</font></td>
<td width="50%"><input type="text" name="street" size="48" value="$street"></td></tr>
<tr><td width="50%" bgcolor="#82c7db"><font size="2">&nbsp;City</font></td>
<td width="50%" bgcolor="#82c7db"><input type="text" name="city" size="48" value="$city"></td></tr>
<tr><td width="50%"><font size="2">&nbsp;Zip/State</font></td>
<td width="50%"><input type="text" name="zip" size="48" value="$zip"></td></tr>
<tr><td width="50%" bgcolor="#82c7db"><font size="2">&nbsp;Country</font></td>
<td width="50%" bgcolor="#82c7db"><select name="country">
$result
</select></td></tr>
<tr><td width="50%"><font size="2">&nbsp;Phone</font></td>
<td width="50%"><input type="text" name="phone" size="48" value="$phone"></td></tr>
<tr><td width="50%" bgcolor="#82c7db"><font size="2">&nbsp;Email</font></td>
<td width="50%" bgcolor="#82c7db"><input type="text" name="uemail" size="48" value="$uemail"></td></tr>
<tr><td width="50%"><font size="2">&nbsp;Show in public records</font></td>
<td width="50%">$result2</td></tr>
<tr><td colspan=2 align="right"><input type="image" border=0 src="$adcenter/images/$data{lang}/proceed.gif" width=83 height=23>
</td></tr>
</table></form></td></tr>
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