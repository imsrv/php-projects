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
<tr><td>
<a href="$cgi/adcstat.pl?name=$data{name}&password=$data{password}&method=h_genstat&lang=$data{lang}" target="_blank"><img src="$adcenter/images/$data{lang}/info.gif" border=0 alt="GET HELP"></a>&nbsp;&nbsp;<font size=5 color="#000000">GLOBAL STATS</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>Joining date</b></font></td><td width="60%" align="right"><font size=2><b>$joindate[0]</b></font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Impressions</b></font></td><td width="60%" align="right" bgcolor="#82C7DB"><font size=2>$globimp</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Clicks</b></font></td><td width="60%" align="right"><font size=2>$globclc</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>Click Through Ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$globrat %</font></td></tr>
<tr><td colspan=2 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>global stats for <b>$data{name}</b></font></td></tr>
</table></td></tr>
<tr><td>
<font size=5 color="#000000">CREDITS INFO</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Unused impression credits</b></font></td><td width="60%" align="right"><font size=2>$impres</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Unused click credits</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$cli</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Last added impression credits</b></font></td><td width="60%" align="right"><font size=2>$lastimp[0] ($lastimp[1])</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Last added click credits</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$lastclc[0] ($lastclc[1])</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Exchange ratio</b></font></td><td width="60%" align="right"><font size=2>$uratio</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Banners "weight"</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$weight</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Your status</b></font></td><td width="60%" align="right"><font size=2>$usersts</font></td></tr>
<tr><td colspan=2 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>global stats for <b>$data{name}</b></font></td></tr>
</table>
</td></tr>
<tr><td>
<form action="$cgi/adcstat.pl" method="post">
<font size=5 color="#000000">REFERAL INFO</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Refered users</b></font></td><td width="60%" align="right"><font size=2>$refusers</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Referal ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$refratio</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Earned credits</b></font></td><td width="60%" align="right"><font size=2>$refcredit</font></td></tr>
<tr><td colspan=2 align="right"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_resetrefer"><input type="hidden" name="spot" value="$data{spot}"><input type="image" border=0 src="$adcenter/images/$data{lang}/reset.gif" width=105 height=23></td></tr>
</table></form>
</td></tr>
<tr><td>
<font size=5 color="#000000">AFFILIATE INFO</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Total impression</b></font></td><td width="60%" align="right"><font size=2>$affilx</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Total clicks</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$affilc</font></td></tr>
<tr><td colspan=2 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>global stats for <b>$data{name}</b></font></td></tr>
</table>
</td></tr>
<tr><td>
<br><br>
<table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>BANNER $data{spot} STATS</b></font></td></tr>
<tr><td width="100%" valign=middle><font size=2 face="Verdana,Arial,Helvetica">$spots</font></td></tr>
</table>
</td>
</tr>
</table>
</td></tr>
<tr><td>
<font size=5 color="#000000">SINCE JOINING</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Joining date</b></font></td><td width="60%" align="right"><font size=2><b>$joindate[0]</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Impressions</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$genimp</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Clicks</b></font></td><td width="60%" align="right"><font size=2>$genclc</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Click Through Ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$genrat %</font></td></tr>
<tr><td colspan=2 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>global stats for <b>$data{name}</b></font></td></tr>
</table>
</td></tr>
<tr><td>
<font size=5 color="#000000">FOR CURRENT BANNER</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Banner was uploaded at</b></font></td><td width="60%" align="right"><font size=2><b>$bannerdate[0]</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Impressions</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$banimp</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Clicks</b></font></td><td width="60%" align="right"><font size=2>$banclc</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Click Through Ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$banrat %</font></td></tr>
<tr><td colspan=2 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>global stats for <b>$data{name}</b></font></td></tr>
</table>
</td></tr>
<tr><td>
<form action="$cgi/adcstat.pl" method="post">
<font size=5 color="#000000">SINCE LAST RESET</font>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="40%" valign="top"><font size=2><b>Last reset at</b></font></td><td width="60%" align="right"><font size=2><b>$resetdate[0]</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Impressions</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$resimp</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Clicks</b></font></td><td width="60%" align="right"><font size=2>$resclc</font></td></tr>
<tr><td width="40%" bgcolor="#82c7db" valign="top"><font size=2><b>Click Through Ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$resrat %</font></td></tr>
<tr><td colspan=2 align="right"><input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_resetstats"><input type="hidden" name="spot" value="$data{spot}"><input type="image" border=0 src="$adcenter/images/$data{lang}/reset.gif" width=105 height=23></td></tr>
</table>
</form>
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