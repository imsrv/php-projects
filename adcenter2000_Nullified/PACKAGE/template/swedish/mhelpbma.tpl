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
<font color="#ffffff" size="5" face="Verdana,Arial,Helvetica"><b>BANNER N�TVERK</b></font></td></tr>
<tr><td width="100%" align="center" valign="top"><table border="0" width="540">
<tr><td width="100%" align="center"><table border="1" width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
<tr><td width="100%">
<form action="$cgi/adcstat.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="lang" value="$data{lang}">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>HJ�LP MENY</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>
<option value="h_genstat">�vergripande statistik Hj�lp</option>
<option value="h_monstat">M�nads Statisik Hj�lp</option>
<option value="h_daystat">Daglig Statisik Hj�lp</option>
<option value="h_hrsstat">Statisik per timme Hj�lp</option>
<option value="h_extstat">Ut�kad Statisik Hj�lp</option>
<option value="h_hcostat">HTML kod Hj�lp</option>
<option value="h_gsestat">Generella inst�llningar Hj�lp</option>
<option value="h_psestat">Personliga inst�llningar Hj�lp</option>
<option value="h_bmastat">Banner Hj�lp</option>
</select></font></td>
<td width="27%" align="right"><input type=image border=0 src="$adcenter/images/$data{lang}/goto.gif" width="70" height="23"></td></tr>
</table>
</form>
</td>
</tr>
</table>
<!--NON-STATIC-->
<br>
<div align="center"><center><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<font size=5 color="#000000">BANNER</font>
<br><font size=2>
H�r kan du ladda upp din banner:
<br><br><b>Ladda upp GIF, JPG, JAVA, FLASH:</b>
<br>Var noga med att se till att din banner har r�tt storlek. Info om Java and Flash banners: Du m�ste se till att du l�nkar din banner till <b><i>$cgi/adcrdst.pl?$data{name}&bannernumber</i></b>, annars kommer inte systemet att r�kna klick fr�n bannern.
<br><br><b>Ladda upp HTML banner:</b>
<br>Vad �r en HTML banner? Det �r bara ren HTML text. Du kan anv�nda detta i m�nga fall. Det popul�raste s�ttet att anv�nda formul�r i banners. Tex, om du har en s�kmotor p� din hemsida s� kan du ha ett formul�r direkt i din banner. Du m�ste vara s�ker p� att ditt script accepterar data fr�n formul�r genomby GET metod. Du beh�ver bara "kopiera & klistra in" din HTML kod med formul�r och g�ra f�ljande �ndringar:
<br><i>L�gg till "hidden fields"</i> - f�rst med "name" <b>url</b> och "value" <i><b>url_till_ditt_script</b></i>, n�sta med "name" <b>bun</b> och "value" <b>$data{name}</b> och det tredje med "name" <b>spot</b> och "value" <i><b>bannernumber</b></i>
<br><i>�ndra "action" i &lt;form&gt; tag</i> - du m�ste �ndra det till <b>$cgi/adcrdht.pl</b> annars kommer inte systemet r�kna klick.
</font></td></tr>
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