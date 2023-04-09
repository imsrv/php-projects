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
<tr><td width="50%" valign=top><a href="$cgi/adcjoin.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/joinus.gif" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="$cgi/adcstats.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/stats.gif" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="$cgi/adctop.pl?lang=$data{lang}"><img src="$adcenter/images/$data{lang}/topten.gif" border=0></a>
</td><td valign=top width="50%" align=center>
<table width="100%" cellspacing=0>
<tr><td align=center><font size=1>
<form action="$cgi/adcstat.pl" method=post>
<input type=hidden name=lang value=$data{lang}><input type=hidden name=method value=genstats>
<table width="100%" cellpadding=5 cellspacing=0><tr><td bgcolor="#82C7DB"><font size=1>
Login <input type=text name=name size=8 maxlength=8> Password <input type=password name=password size=8 maxlength=8>
</font></td></tr><tr><td bgcolor="#97D0E1" align=right>
<input type="image" border=0 src="$adcenter/images/$data{lang}/login.gif">
</td></tr></table>
</form></font>
</td></tr>
</table>
</td></tr>
<tr><td align=center colspan=2>
<hr size="1" color="#000000" width="534">
</td></tr>
<tr><td align=center colspan=2>
<font size=4><b>CONFIRM DATA</b></font>
<form action="$cgi/adcreg.pl" method=post>
<input type=hidden name=lang value="$data{lang}">
<table width="100%">
<tr><td width="25%"><font size=2><b>Name</b></font></td>
<td width="75%" colspan="3"><input type="text" name="Name" size="51" value="$data{Name}"></td></tr>
<tr><td><font size=2><b>Address</b></font></td>
<td colspan="3"><input type="text" name="Address" size="51" value="$data{Address}"></td></tr>
<tr><td width="25%"><font size=2><b>City</b></font></td>
<td width="25%"><input type="text" name="City" size="18" value="$data{City}"></td>
<td width="15%"><font size=2><b>State, zip</b></font></td>
<td width="35%"><input type="text" name="ZipCode" size="14" value="$data{ZipCode}"></td></tr>
<tr><td><font size=2><b>Country</b></font></td>
<td colspan="3"><select name="Country" size="1">
$countries
</select></td></tr>
<tr><td><font size=2><b>Phone</b></font></td>
<td><input type="text" name="Phone" size="18" value="$data{Phone}"></td>
<td><font size=2><b>E-mail</b></font></td>
<td><input type="text" name="EMail" size="14" value="$data{EMail}"></td></tr>
<tr><td><font size=2><b>Show in public records?</b></font></td>
<td>$showcheck</td></tr>
<tr><td colspan="4" align="center"><font color="#FFFFFF"><small><small><small>PLEASE, CHECK ALL DATA AGAIN AND CONFIRM REGISTRATION</small></small></small></font></td></tr>
<tr><td><font size=2><b>Username</b></font></td>
<td colspan="3"><input type="text" name="Username" size="51" maxlength="8" value="$data{Username}"></td></tr>
<tr><td><font size=2><b>Password</b></font></td>
<td colspan="3"><input type="text" name="Password" size="51" maxlength="8" value="$data{Password}"></td></tr>
<tr><td><font size=2><b>URL</b></font></td>
<td colspan="3"><input type="text" name="URL" size="51" value="$data{URL}"></td></tr>
<tr><td><font size=2><b>Site title</b></font></td>
<td colspan="3"><input type="text" name="Sitetitle" size="51" value="$data{Sitetitle}"></td></tr>
<tr><td><font size=2><b>Category</b></font></td>
<td colspan="3">
<SELECT NAME="Category">
$categories
</SELECT></td></tr>
<tr><td><font size=2><b>Site description</b></font></td>
<td colspan="3"><input type="text" name="Description" size="51" value="$data{Description}"></td></tr>
<tr><td><font size=2><b>Keywords</b></font></td>
<td colspan="3"><input type="text" name="Keywords" size="51" value="$data{Keywords}"></td></tr>
<tr><td colspan="4" align="center"><br><br><input type="image" src="$adcenter/images/$data{lang}/proceed.gif"></td></tr>
</table></form>
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