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
<font size="4" face="Verdana,Arial,Helvetica"><b>TX2000 MENU NAVIGATOR</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{tx} value=tx>Global stats</option><option $selectede{montlytx} value=montlytx>Monthly stats</option><option $selectede{dailytx} value=dailytx>Daily stats</option><option $selectede{hourlytx} value=hourlytx>Hourly stats</option><option $selectede{mantx} value=mantx>Manage Ads</option><option $selectede{htmltx} value=htmltx>Get HTML code</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">HTML CODE</font><br>
<font size=2><form>
Want to join our text exchange? Easy place following code to your html page:<br>
<b><font size="2">
<center><textarea cols=62 rows=8>
<!--Begin $owntitle TX code-->
<script type="text/javascript" language="Javascript" src="$cgi/nph-adctx.pl?$data{name}"></script>
<!--End $owntitle TX code-->
</textarea></center></font></b><br>
</form></font>
<table width=100%>
<tr><td><font size=3><b>Customize it!</b></font>
<form action="$cgi/adcstat.pl" method=post>
<table bgcolor="#97D0E1"><tr><td bgcolor="#82C7DB">
<input type=hidden name=lang value="$data{lang}">
<input type=hidden name=name value="$data{name}">
<input type=hidden name=password value="$data{password}">
<input type=hidden name=method value=customtx>
<font size=2>Background color #</font></td>
<td bgcolor="#82C7DB"><input type=text name=bgcol value="$bgcol" maxlength=6></td></tr>
<tr><td>
<font size=2>Font color #</font></td>
<td><input type=text name=fncol value="$fncol" maxlength=6></td></tr>
<tr><td bgcolor="#82C7DB">
<font size=2>Line width</font></td>
<td bgcolor="#82C7DB"><select name=boxwidth size=2>
$boxwidth
</select>
</td></tr>
<tr><td bgcolor="#82C7DB">
<font size=2>Speed</font></td>
<td bgcolor="#82C7DB"><select name=bgimg>$speed</select>
</td></tr>
<tr><td colspan=2 align=right>
<input type="image" border=0 src="$adcenter/images/$data{lang}/proceed.gif" width=83 height=23>
</td></tr>
</table></form></td>
<td align=center valign=middle>
</td></tr></table></td></tr>
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