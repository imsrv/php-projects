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
<br>
<table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<table border="0" width="100%">
<tr><td width="50%"><font size="4" face="Verdana,Arial,Helvetica"><b>TX2000 MENU NAVIGATOR</b></font></td>
<td width="50%" align=right><font size="4" face="Verdana,Arial,Helvetica"><b>CHOOSE YEAR</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{tx} value=tx>Global stats</option><option $selectede{montlytx} value=montlytx>Monthly stats</option><option $selectede{dailytx} value=dailytx>Daily stats</option><option $selectede{hourlytx} value=hourlytx>Hourly stats</option><option $selectede{mantx} value=mantx>Manage Ads</option><option $selectede{htmltx} value=htmltx>Get HTML code</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td>
<td><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=spot value=$data{spot}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=montlytx><input type="hidden" name="lang" value="$data{lang}"><input type=text name=year value=$data{year} size=4></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/getstats.gif" width="96" height="23"></td></tr></table></form></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td width="100%" colspan=2>
<font size=5 color="#000000">MONTHLY STATS</font></td></tr>
<tr><td width="30%">
<div align=center><center><table width=$table bgcolor=white cellpadding=0 cellspacing=0 border=1><tr><td><table width=$table bgcolor=white cellpadding=0 cellspacing=0 border=0>
<tr><td colspan=2><center><font face="Lucida Console" size=1 color=red><br>Total impressions for $data{year}: $totimp </font><br><br></center></td><td width=60 rowspan=3>&nbsp;</td></tr>
<tr><td valign=top align=right width=60><font face="Lucida Console" size=1>$item1&nbsp;&nbsp;</font></td><td width=$tablewidth height=103 rowspan=4 background="$adcenter/images/$data{lang}/sgrid.gif" valign="bottom">
$result1
</td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item2&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item3&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item4&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>0&nbsp;&nbsp;</font></td><td><img src="$adcenter/images/$data{lang}/monbar.gif"></td></tr>
</table></td></tr></table></center></div>
<div align=center><center><table width=$table bgcolor=white cellpadding=0 cellspacing=0 border=1><tr><td><table width=$table bgcolor=white cellpadding=0 cellspacing=0>
<tr><td colspan=2><center><font face="Lucida Console" size=1 color=red><br>Total clicks for $data{year}: $totclc </font><br><br></center></td><td width=60 rowspan=3>&nbsp;</td></tr>
<tr><td valign=top align=right width=60><font face="Lucida Console" size=1>$itm1&nbsp;&nbsp;</font></td><td width=$tablewidth height=103 rowspan=4 background="$adcenter/images/$data{lang}/sgrid.gif" valign="bottom">
$result2
</td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$itm2&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$itm3&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$itm4&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>0&nbsp;&nbsp;</font></td><td><img src="$adcenter/images/$data{lang}/monbar.gif"></td></tr>
</table></td></tr></table></center></div></td><td width="70%" valign=top>
<table border="0" width="100%" cellspacing=0 cellpadding="2" bgcolor="#97d0e1">
<tr><td width="60%" valign="top"><font size=2><b>Month</b></font></td><td width="20%" align="right"><font size=2><b>Impressions</b></font></td><td width="20%" align="right"><font size=2><b>Clicks</b></font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>January</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[1]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[1]</font></td></tr>
<tr><td><font size=2><b>February</b></font></td><td align="right"><font size=2>$mimp[2]</font></td><td align="right"><font size=2>$mclc[2]</font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>March</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[3]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[3]</font></td></tr>
<tr><td><font size=2><b>April</b></font></td><td align="right"><font size=2>$mimp[4]</font></td><td align="right"><font size=2>$mclc[4]</font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>May</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[5]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[5]</font></td></tr>
<tr><td><font size=2><b>June</b></font></td><td align="right"><font size=2>$mimp[6]</font></td><td align="right"><font size=2>$mclc[6]</font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>July</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[7]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[7]</font></td></tr>
<tr><td><font size=2><b>August</b></font></td><td align="right"><font size=2>$mimp[8]</font></td><td align="right"><font size=2>$mclc[8]</font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>September</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[9]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[9]</font></td></tr>
<tr><td><font size=2><b>October</b></font></td><td align="right"><font size=2>$mimp[10]</font></td><td align="right"><font size=2>$mclc[10]</font></td></tr>
<tr><td bgcolor="#82C7DB"><font size=2><b>November</b></font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mimp[11]</font></td><td align="right" bgcolor="#82C7DB"><font size=2>$mclc[11]</font></td></tr>
<tr><td><font size=2><b>December</b></font></td><td align="right"><font size=2>$mimp[12]</font></td><td align="right"><font size=2>$mclc[12]</font></td></tr>
<tr><td colspan=3 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>Monthly stats for <b>$data{name}</b> ($data{year})</font></td></tr>
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