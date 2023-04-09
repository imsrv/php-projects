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
</table>
<!--NON-STATIC-->
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<div align=center><table border=0 width="100%" cellpadding=3>
<tr><td width="50%" valign=top><div STYLE="text-align:justify;"><font size=2>
Welcome to our banner network. Join us now and your banner will be shown on all the sites of our banner network. It's really the best business solution. If you are already our member, you can track the statistics for your banner in our member's section. Thank you for choosing us.
</font></div><br>
<a href="$cgi/adcjoin.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/joinus.gif" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="$cgi/adcstats.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/stats.gif" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="$cgi/adctop.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/topten.gif" border=0></a>
</td><td valign=top width="50%" align=center>
<table width="100%" cellspacing=0>
<tr><td align=center>
<form action="$cgi/adcstat.pl" method=post>
<input type=hidden name=lang value="$data{lang}"><input type=hidden name=method value=genstats>
<table width="100%" cellpadding=5 cellspacing=0>
<tr><td bgcolor="#82C7DB"><font size=1>
<font size=1><b>$error</b></font>
Login <font size=2><input type=text name=name size=8 maxlength=8></font> Password <font size=2><input type=password name=password size=8 maxlength=8></font>
</font></td></tr><tr><td bgcolor="#97D0E1" align=right>
<input type="image" border=0 src="$adcenter/images/$data{lang}/login.gif">
</td></tr></table>
</form>
</td></tr>
<tr><td align=right>
<form action="$cgi/adclost.pl" method=post>
<input type=hidden name=lang value="$data{lang}">
<table width="100%" cellpadding=5 cellspacing=0><tr><td bgcolor="#82C7DB" align=center colspan=2><font size=2>
<b>RETRIEVE FORGOTTEN PASSWORD<br><font size=1>$error1</font></b>
</font></td></tr>
<tr><td bgcolor="#97D0E1" align=right>
<input type="image" border=0 src="$adcenter/images/$data{lang}/email.gif" width=105 height=23>
</td>
<td bgcolor="#97D0E1" align=right><input type=text name=EMail size=17></td>
</tr></table>
</form>
</td></tr>
</table>
</td></tr>
<tr><td align=center colspan=2>
<hr size="1" color="#000000" width="534">
</td></tr>
<tr><td align=center colspan=2>
<font size=4><b>SEARCH THE EXCHANGE</b></font>
<form action="$cgi/adcsrch.pl" method=post>
<input type=hidden name=lang value="$data{lang}">
<table width="100%"><tr><td align=right>
<select name=type><option value="web">Web</option><option value="people">People</option></select><input type=text name=words size=40><br><font size=2>Search a people by <select name="searchby"><option value="name">Name</option><option value="address">Address</option><option value="city">City</option><option value="country">Country</option><option value="phone">Phone</option><option value="email">Email</option></select></font></td><td align=left valign=top>
<input type="image" border="0" src="$adcenter/images/$data{lang}/search.gif" width="142" height="23">
</td></tr></table></form>
</td></tr>
<tr><td align=center colspan=2>
<div align=right>
<table width="93%">
$result
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
<br><a href="http://www.td-systems.com/"><img src="$adcenter/images/powered.gif" border=0></a>
<p><font face="Arial" color="#000000" size="1"><b>$copyright</b></font></p><p>&nbsp;</td></tr>
</table></center></div></td>
<td bgcolor="#3E5B68" height="100%" background="$adcenter/images/$data{lang}/linepix.gif" align="center"><img border="0" src="$adcenter/images/$data{lang}/linepix.gif" width="1" height="100%"> <p>&nbsp;</td></tr>
</table></center></div></td></tr></table></center></div>
</font>
</body>
</html>