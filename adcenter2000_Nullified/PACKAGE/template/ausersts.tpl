<html>
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>ADCenter 2000</title></head>
<body background="$adcenter/images/globalbk.gif" bgcolor="#2275A0" text="#000000" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<font face=arial>
<div align="center"><center>
<table border="0" width="562" cellspacing="0" cellpadding="0" height="100%">
<tr><td width="100%" background="$adcenter/images/washedbk.jpg" bgcolor="#7DB8D3" valign="top">
<div align="center"><center>
<table border="0" width="560" cellspacing="0" cellpadding="0" height="100%">
<tr><td width="1" bgcolor="#3E5B68" height="100%" background="$adcenter/images/linepix.gif">
<img border="0" src="$adcenter/images/linepix.gif" width="1" height="100%"> <p>&nbsp;</td>
<td height="100%" valign="top">
<table border="0" cellspacing="0" cellpadding="0" height="384">
<tr><td width="100%" valign="top" height="84"><p align="center">
<img border="0" src="$adcenter/images/top.jpg" width="561" height="84"></td></tr>
<tr><td width="100%" height="300" valign="top" align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td width="100%" background="$adcenter/images/globalbk.gif" align="center">
<font color="#ffffff" size="5" face="Verdana,Arial,Helvetica"><b>BANNER NETWORK</b></font></td></tr>
<tr><td width="100%" align="center" valign="top"><table border="0" width="540">
<tr><td width="100%" align="center"><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<form action="$cgi/adcadm.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="get_userstats">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>CHOOSE STATS TYPE</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica">
<select name="type">
<option $selected{affiliate} value="affiliate">Affiliate</option>
<option $selected{bx} value="bx">Banner Exchange</option>
<option $selected{sbx} value="sbx">SwimBanner Exchange</option>
<option $selected{tx} value="tx">TX Exchange</option>
</select></font></td>
<td width="27%" align="right"><input type=image border=0 src="$adcenter/images/goto.gif" width="70" height="23"></td></tr>
</table>
</form>
</td>
</tr>
</table>
<!--NON-STATIC-->
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td width="100%">
<font size=5 color=black>STATS ($data{type})</font>
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="50%" background="$adcenter/images/globalbk.gif"><font size=2 color=white><b>Username</b></font></td><td width="25%" background="$adcenter/images/globalbk.gif"><font size=2 color=white><b>Impressions</b></font></td><td width="25%" background="$adcenter/images/globalbk.gif"><font size=2 color=white><b>Clicks</b></font></td></tr>
@result
<tr><td colspan=3 align=center><form action="$cgi/adcadm.pl" method=post><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="type" value="$data{type}"><input type="hidden" name="method" value="reset_userstats"><input type=image border=0 src="$adcenter/images/clear.gif"></form></td></tr>
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
<td bgcolor="#3E5B68" height="100%" background="$adcenter/images/linepix.gif" align="center"><img border="0" src="$adcenter/images/linepix.gif" width="1" height="100%"> <p>&nbsp;</td></tr>
</table></center></div></td></tr></table></center></div>
</font>
</body>
</html>