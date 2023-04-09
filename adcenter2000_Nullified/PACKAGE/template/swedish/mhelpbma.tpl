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
<font size="4" face="Verdana,Arial,Helvetica"><b>HJÄLP MENY</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>
<option value="h_genstat">Övergripande statistik Hjälp</option>
<option value="h_monstat">Månads Statisik Hjälp</option>
<option value="h_daystat">Daglig Statisik Hjälp</option>
<option value="h_hrsstat">Statisik per timme Hjälp</option>
<option value="h_extstat">Utökad Statisik Hjälp</option>
<option value="h_hcostat">HTML kod Hjälp</option>
<option value="h_gsestat">Generella inställningar Hjälp</option>
<option value="h_psestat">Personliga inställningar Hjälp</option>
<option value="h_bmastat">Banner Hjälp</option>
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
Här kan du ladda upp din banner:
<br><br><b>Ladda upp GIF, JPG, JAVA, FLASH:</b>
<br>Var noga med att se till att din banner har rätt storlek. Info om Java and Flash banners: Du måste se till att du länkar din banner till <b><i>$cgi/adcrdst.pl?$data{name}&bannernumber</i></b>, annars kommer inte systemet att räkna klick från bannern.
<br><br><b>Ladda upp HTML banner:</b>
<br>Vad är en HTML banner? Det är bara ren HTML text. Du kan använda detta i många fall. Det populäraste sättet att använda formulär i banners. Tex, om du har en sökmotor på din hemsida så kan du ha ett formulär direkt i din banner. Du måste vara säker på att ditt script accepterar data från formulär genomby GET metod. Du behöver bara "kopiera & klistra in" din HTML kod med formulär och göra följande ändringar:
<br><i>Lägg till "hidden fields"</i> - först med "name" <b>url</b> och "value" <i><b>url_till_ditt_script</b></i>, nästa med "name" <b>bun</b> och "value" <b>$data{name}</b> och det tredje med "name" <b>spot</b> och "value" <i><b>bannernumber</b></i>
<br><i>Ändra "action" i &lt;form&gt; tag</i> - du måste ändra det till <b>$cgi/adcrdht.pl</b> annars kommer inte systemet räkna klick.
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