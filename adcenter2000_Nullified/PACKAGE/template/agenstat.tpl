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
<a href="$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=h_genset" target="_blank"><img src="$adcenter/images/info.gif" border=0 alt="GET HELP"></a>&nbsp;&nbsp;<font size=5>GENERAL SETTINGS</font>
<form action="$cgi/adcadm.pl" method="post">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="a_general">
<table border="0" width="100%" cellpadding="0" bgcolor="#97D0E1">
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Exchange title</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="owntitle" value="$owntitle"></font></td></tr>
<tr><td width="40%"><font size=1><b>SystemID</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="sysid" value="$sysid"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Path to ADCenter directory</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="adcpath" value="$adcpath"></font></td></tr>
<tr><td width="40%"><font size=1><b>Path to databases directory</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="basepath" value="$basepath"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>URL to ADCenter directory</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="adcenter" value="$adcenter"></font></td></tr>
<tr><td width="40%"><font size=1><b>URL to CGI-BIN directory</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="cgi" value="$cgi"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Path to sendmail</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="progmail" value="$progmail"></font></td></tr>
<tr><td width="40%"><font size=1><b>SMTP server</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="smtpserver" value="$smtpserver"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>SMTP port</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="smtpport" value="$smtpport"></font></td></tr>
<tr><td width="40%"><font size=1><b>Admin e-mail</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="email" value="$email"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>URL to your site</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="furl" value="$furl"></font></td></tr>
<tr><td width="40%"><font size=1><b>Default internal account</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="yourname" value="$yourname"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Records per page</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="reclimit" value="$reclimit"></font></td></tr>
<tr><td width="40%"><font size=1><b>Local timezone</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="gmtzone" value="$gmtzone"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Copyright</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="copyright" value="$copyright"></font></td></tr>
<tr><td width="40%"><font size=1><b>Inactive limit</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="inlim" value="$inlim"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default reason</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="defaultreason" value="$defaultreason"></font></td></tr>
<tr><td width="40%"><font size=1><b>Default language</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="defaultlanguage" value="$defaultlanguage"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>Cheat Analyzer variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Log if cant resolve referer page (1-yes,0-no)</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="logrefererfault" value="$logrefererfault"></font></td></tr>
<tr><td width="40%"><font size=1><b>Log if cant resolve user agent (1-yes,0-no)</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="logagentfault" value="$logagentfault"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Impressions per browser limit</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="logallowimpperbrowser" value="$logallowimpperbrowser"></font></td></tr>
<tr><td width="40%"><font size=1><b>Clicks per browser limit</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="logallowclcperbrowser" value="$logallowclcperbrowser"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>IPs per browser limit</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="logallowipperbrowser" value="$logallowipperbrowser"></font></td></tr>
<tr><td width="40%"><font size=1><b>Log if cookie duplicates found (1-yes,0-no)</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="logcookieduplicates" value="$logcookieduplicates"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Min CTR allowed (%)</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="minctr" value="$minctr"></font></td></tr>
<tr><td width="40%"><font size=1><b>Max CTR allowed (%)</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="maxctr" value="$maxctr"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>Banner exchange variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="defaultratio" value="$defaultratio"></font></td></tr>
<tr><td width="40%"><font size=1><b>Default clicks ratio</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="clickratio" value="$clickratio"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default referal ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="refratio" value="$refratio"></font></td></tr>
<tr><td width="40%"><font size=1><b>Enable click exchange</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="enablece" value="$enablece"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default user weight</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="weighttype" value="$weighttype"></font></td></tr>
<tr><td width="40%"><font size=1><b>Starting bonus credits</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="startcred" value="$startcred"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Alternative text</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="bxalt" value="$bxalt"></font></td></tr>
<tr><td width="40%"><font size=1><b>Max number of banners</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="totalbanner" value="$totalbanner"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Banner width</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="banwidth" value="$banwidth"></font></td></tr>
<tr><td width="40%"><font size=1><b>Banner height</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="banheight" value="$banheight"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Enable minibanner</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="enablemb" value="$enablemb"></font></td></tr>
<tr><td width="40%"><font size=1><b>Minibanner height</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="mbanheight" value="$mbanheight"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Max banner weight (bytes)</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="mfilesize" value="$mfilesize"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>SwimBanner exchange variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="defaultratiosb" value="$defaultratiosb"></font></td></tr>
<tr><td width="40%"><font size=1><b>Default clicks ratio</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="clickratiosb" value="$clickratiosb"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Enable SwimBanner</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="enableswim" value="$enableswim"></font></td></tr>
<tr><td width="40%"><font size=1><b>Enable click exchange</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="enablecesb" value="$enablecesb"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Starting bonus credits</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="startcredsb" value="$startcredsb"></font></td></tr>
<tr><td width="40%"><font size=1><b>Max banner weight (bytes)</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="sbsize" value="$sbsize"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Banner width</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="sbwidth" value="$sbwidth"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>TX variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Default ratio</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="defaultratiotx" value="$defaultratiotx"></font></td></tr>
<tr><td width="40%"><font size=1><b>Default clicks ratio</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="clickratiotx" value="$clickratiotx"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Enable TX</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="enabletex" value="$enabletex"></font></td></tr>
<tr><td width="40%"><font size=1><b>Enable click exchange</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="enablecetx" value="$enablecetx"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Starting bonus credits</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="startcredtx" value="$startcredtx"></font></td></tr>
<tr><td width="40%"><font size=1><b>Min tickerline width (bytes)</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="stxw" value="$stxw"></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Max tickerline width</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="etxw" value="$etxw"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>Counter variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Enable counter</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="enablecounter" value="$enablecounter"></font></td></tr>
<tr><td width="40%"><font size=1><b>Alternative text</b></font></td><td width="60%" align="right"><font size=2><input type="text" size=48 name="counteralt" value="$counteralt"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3><b>Maillist variables</b></font></td></tr>
<tr><td width="40%" bgcolor="#82c7db"><font size=1><b>Enable maillist</b></font></td><td width="60%" align="right" bgcolor="#82c7db"><font size=2><input type="text" size=48 name="enablemaillist" value="$enablemaillist"></font></td></tr>
<tr><td width="40%" colspan=2><font size=3>Your license number $license. </font></td></tr>
<tr><td colspan=2 align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
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
<td bgcolor="#3E5B68" height="100%" background="$adcenter/images/linepix.gif" align="center"><img border="0" src="$adcenter/images/linepix.gif" width="1" height="100%"> <p>&nbsp;</td></tr>
</table></center></div></td></tr></table></center></div>
</font>
</body>
</html>