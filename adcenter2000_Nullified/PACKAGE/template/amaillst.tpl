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
<font size=5>MAILING LIST</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="a_maillist">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0" style="border: 0px none rgb(0,0,0)">
<tr><td colspan=2 align=center><font size="2">You have <b>$total</b> subscribers</font></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Subject</b></font></td>
<td width="65%" bgcolor="#82c7db" ><input type="text" name="subject" size="51" value="$owntitle Newsletter"></td></tr>
<tr><td colspan=2 align="center"><textarea name="body" cols=63 rows=5></textarea></td></tr>
<tr><td colspan=2 align="center" bgcolor="#82c7db"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5>ADD TO MAILLIST</font>
<br><font size=2>You can add several emails, comma separated</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="addmail">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0" style="border: 0px none rgb(0,0,0)">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Email</b></font></td>
<td width="65%" bgcolor="#82c7db"><input type="text" name="email" size="51"></td></tr>
<tr><td colspan=2 align="center"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5>REMOVE FROM MAILLIST</font>
<br><font size=2>You can remove several emails, comma separated</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="remmail">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0" style="border: 0px none rgb(0,0,0)">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Email</b></font></td>
<td width="65%" bgcolor="#82c7db"><input type="text" name="email" size="51"></td></tr>
<tr><td colspan=2 align="center"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5>GET MAILLIST</font>
<form method="post" action="$cgi/adcadm.pl" target="_blank">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="get_maillist">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0" style="border: 0px none rgb(0,0,0)">
<tr><td align="center"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
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