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
<form action="$cgi/adcadm.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>ADMIN SECTION NAVIGATOR</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica">
<select name=method>
<option $selected{genset} value="genset">General Settings</option>
<option $selected{globstats} value="globstats">Global Stats</option>
<option $selected{analyze} value="analyze">Cheat Analyzer</option>
<option $selected{userman} value="userman">User Management</option>
<option $selected{banners} value="banners">Banners Overview</option>
<option $selected{sbanners} value="sbanners">SwimBanners Overview</option>
<option $selected{txbanners} value="txbanners">TX Ads Overview</option>
<option $selected{tasman} value="tasman">Categories</option>
<option $selected{countman} value="countman">Countries</option>
<option $selected{faq} value="faq">FAQ Menu</option>
<option $selected{maillist} value="maillist">Mailing List</option>
<option value="backindex">Back to index page</option>
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
<br><font size=5 color=black>GLOBAL STATS</font>
<table border="0" width="100%" cellpadding="1" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total members</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><b>$members</b></font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total impressions</b></font></td><td width="60%" align="right"><font size=2>$genimp</font></td></tr>
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total clicks</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$genclc</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total impressions today</b></font></td><td width="60%" align="right"><font size=2>$todimp</font></td></tr>
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total clicks today</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$todclc</font></td></tr>
</table>
</td></tr>
<tr><td width="100%">
<br><font size=5 color=black>SWIMBANNER STATS</font>
<table border="0" width="100%" cellpadding="1" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total impressions</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$genimpsb</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total clicks</b></font></td><td width="60%" align="right"><font size=2>$genclcsb</font></td></tr>
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total impressions today</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$todimpsb</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total clicks today</b></font></td><td width="60%" align="right"><font size=2>$todclcsb</font></td></tr>
</table>
</td></tr>
<tr><td width="100%">
<br><font size=5 color=black>TX STATS</font>
<table border="0" width="100%" cellpadding="1" cellspacing=0 bgcolor="#97D0E1">
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total impressions</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$genimptx</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total clicks</b></font></td><td width="60%" align="right"><font size=2>$genclctx</font></td></tr>
<tr><td width="40%" valign="top" bgcolor="#82c7db"><font size=2><b>Total impressions today</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2>$todimptx</font></td></tr>
<tr><td width="40%" valign="top"><font size=2><b>Total clicks today</b></font></td><td width="60%" align="right"><font size=2>$todclctx</font></td></tr>
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