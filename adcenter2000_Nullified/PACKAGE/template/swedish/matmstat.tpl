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
<font size="4" face="Verdana,Arial,Helvetica"><b>BANNER $data{spot} ADMINISTRATION</b></font></td></tr>
<tr><td width="100%" valign=middle><font size=2 face="Verdana,Arial,Helvetica">$spots</font></td></tr>
</table>
</td>
</tr>
</table>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">TIDSINSTÄLLNING FÖR DIN BANNER</font><br>
<font size=2>
Ange max tillåtna visningar för varje tidsperiod.</font>
<form action="$cgi/adcstat.pl" method="post">
<input type="hidden" name="lang" value="$data{lang}"><input type="hidden" name="spot" value="$data{spot}"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_settime">
<table border="0" width="100%" cellpadding="0" cellspacing=0 bgcolor="#97d0e1">
<tr><td width="30%" valign="top"><font size=2><b>Förmiddag</b></font></td><td width="20%"><font size=2><b>Visningar</b></font></td><td width="30%" valign="top"><font size=2><b>Eftermiddag</b></font></td><td width="20%"><font size=2><b>Visningar</b></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>00:00-01:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res0" value="$res[0]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>12:00-13:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res12" value="$res[12]"></font></td></tr>
<tr><td width="30%"><font size=1><b>01:00-02:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res1" value="$res[1]"></font></td><td width="30%"><font size=1><b>13:00-14:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res13" value="$res[13]"></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>02:00-03:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res2" value="$res[2]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>14:00-15:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res14" value="$res[14]"></font></td></tr>
<tr><td width="30%"><font size=1><b>03:00-04:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res3" value="$res[3]"></font></td><td width="30%"><font size=1><b>15:00-16:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res15" value="$res[15]"></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>04:00-05:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res4" value="$res[4]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>16:00-17:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res16" value="$res[16]"></font></td></tr>
<tr><td width="30%"><font size=1><b>05:00-06:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res5" value="$res[5]"></font></td><td width="30%"><font size=1><b>17:00-18:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res17" value="$res[17]"></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>06:00-07:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res6" value="$res[6]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>18:00-19:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res18" value="$res[18]"></font></td></tr>
<tr><td width="30%"><font size=1><b>07:00-08:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res7" value="$res[7]"></font></td><td width="30%"><font size=1><b>19:00-20:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res19" value="$res[19]"></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>08:00-09:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res8" value="$res[8]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>20:00-21:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res20" value="$res[20]"></font></td></tr>
<tr><td width="30%"><font size=1><b>09:00-10:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res9" value="$res[9]"></font></td><td width="30%"><font size=1><b>21:00-22:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res21" value="$res[21]"></font></td></tr>
<tr><td width="30%" bgcolor="#82c7db"><font size=1><b>10:00-11:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res10" value="$res[10]"></font></td><td width="30%" bgcolor="#82c7db"><font size=1><b>22:00-23:00</b></font></td><td width="20%" align="right" bgcolor="#82c7db"><font size=2><input type="text" name="res22" value="$res[22]"></font></td></tr>
<tr><td width="30%"><font size=1><b>11:00-12:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res11" value="$res[11]"></font></td><td width="30%"><font size=1><b>23:00-24:00</b></font></td><td width="20%" align="right"><font size=2><input type="text" name="res23" value="$res[23]"></font></td></tr>
<tr><td colspan=4 align="right"><input type="image" border=0 src="$adcenter/images/$data{lang}/proceed.gif" width=83 height=23></td></tr>
</table></form>
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