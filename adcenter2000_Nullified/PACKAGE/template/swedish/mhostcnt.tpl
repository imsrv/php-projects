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
<tr><td width="50%"><font size="4" face="Verdana,Arial,Helvetica"><b>RÄKNARE MENY</b></font></td>
<td width="50%" align=right><font size="4" face="Verdana,Arial,Helvetica"><b>VÄLJ DATUM</b></font></td></tr>
<tr><td width="100%" valign=center><font size=2 face="Verdana,Arial,Helvetica"><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=lang value=$data{lang}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><select name=method><option $selectede{visitors} value=visitors>Övergripande statistik</option><option $selectede{montlycount} value=montlycount>Månads Statisik</option><option $selectede{montlyucount} value=montlyucount>Unik Månads Statisik</option><option $selectede{dailycount} value=dailycount>Daglig Statisik</option><option $selectede{dailyucount} value=dailyucount>Unik Daglig Statisik</option><option $selectede{hourlycount} value=hourlycount>Statisik per timme</option><option $selectede{hourlyucount} value=hourlyucount>Unik Statisik per timme</option><option $selectede{htmlcounter} value=htmlcounter>HTML kod</option></select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr></table></form></font></td>
<td><form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=spot value=$data{spot}><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=hourlycount><input type="hidden" name="lang" value="$data{lang}"><input type=text name=date value=$data{date} size=2><select name=month><option $selected{Jan} value=Jan>Januari</option><option $selected{Feb} value=Feb>Februari</option><option $selected{Mar} value=Mar>Mars</option><option $selected{Apr} value=Apr>April</option><option $selected{May} value=May>Maj</option><option $selected{Jun} value=Jun>Juni</option><option $selected{Jul} value=Jul>Juli</option><option $selected{Aug} value=Aug>Augusti</option><option $selected{Sep} value=Sep>September</option><option $selected{Oct} value=Oct>Oktober</option><option $selected{Nov} value=Nov>November</option><option $selected{Dec} value=Dec>December</option></select><input type=text name=year value=$data{year} size=4></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/getstats.gif" width="96" height="23"></td></tr></table></form></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">RÄKNARE - STATISTIK PER TIMME</font>
<div align=center><center><table width="346" bgcolor=white cellpadding=0 cellspacing=0 border=1><tr><td><table width="346" bgcolor=white cellpadding=0 cellspacing=0>
<tr><td colspan=2><center><font face="Lucida Console" size=1 color=red><br>Totala besökare under $data{date} $data{month} $data{year}: $totimp </font><br><br></center></td><td width=60 rowspan=3>&nbsp;</td></tr>
<tr><td valign=top align=right width=60><font face="Lucida Console" size=1>$item1&nbsp;&nbsp;</font></td><td width=286 height=103 rowspan=4 background="$adcenter/images/$data{lang}/sgrid.gif" valign="bottom">
$result
</td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item2&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item3&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>$item4&nbsp;&nbsp;</font></td></tr>
<tr><td valign=top align=right><font face="Lucida Console" size=1>0&nbsp;&nbsp;</font></td><td><img src="$adcenter/images/$data{lang}/timebar.gif"></td></tr>
</table></td></tr></table></center></div><br>
<table border="0" width="100%" cellpadding="2" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top"><font size=2><b>Tid</b></font></td><td width="30%" align="right"><font size=2><b>Visningar</b></font></td><td width="30%" align="right"><font size=2><b>Klick</b></font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>00:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[0]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[0]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>01:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[1]</font></td><td width="30%" align="right"><font size=2>$dclc[1]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>02:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[2]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[2]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>03:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[3]</font></td><td width="30%" align="right"><font size=2>$dclc[3]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>04:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[4]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[4]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>05:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[5]</font></td><td width="30%" align="right"><font size=2>$dclc[5]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>06:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[6]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[6]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>07:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[7]</font></td><td width="30%" align="right"><font size=2>$dclc[7]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>08:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[8]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[8]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>09:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[9]</font></td><td width="30%" align="right"><font size=2>$dclc[9]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>10:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[10]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[10]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>11:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[11]</font></td><td width="30%" align="right"><font size=2>$dclc[11]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>12:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[12]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[12]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>13:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[13]</font></td><td width="30%" align="right"><font size=2>$dclc[13]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>14:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[14]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[14]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>15:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[15]</font></td><td width="30%" align="right"><font size=2>$dclc[15]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>16:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[16]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[16]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>17:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[17]</font></td><td width="30%" align="right"><font size=2>$dclc[17]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>18:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[18]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[18]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>19:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[19]</font></td><td width="30%" align="right"><font size=2>$dclc[19]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>20:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[20]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[20]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>21:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[21]</font></td><td width="30%" align="right"><font size=2>$dclc[21]</font></td></tr>
<tr><td width="40%" bgcolor="#82C7DB" valign="top"><font size=2><b>22:00</b></font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dimp[22]</font></td><td width="30%" align="right" bgcolor="#82C7DB"><font size=2>$dclc[22]</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>23:00</b></font></td><td width="30%" align="right"><font size=2>$dimp[23]</font></td><td width="30%" align="right"><font size=2>$dclc[23]</font></td></tr>
<tr><td colspan=3 background="$adcenter/images/$data{lang}/globalbk.gif"><font color=white size=1>Statisik per timme för <b>$data{name}</b> ($data{month} $data{date} $data{year})</font></td></tr>
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