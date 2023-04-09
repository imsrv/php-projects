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
<form action="$cgi/adcadm.pl" method="get"><input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}">
<table border="0" width="100%">
<tr><td width="100%" colspan="2">
<font size="4" face="Verdana,Arial,Helvetica"><b>HELP SECTION NAVIGATOR</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>
<option value="h_genset">General Settings Help</option>
<option value="h_userman">Users Management Help</option>
<option value="h_analyze">Cheat Analyzer Help</option>
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
<font size=5 color="#000000">GENERAL SETTINGS</font>
<br><font size=2>
Here you can configure your system:
<br><br><b>Global variables:</b>
<br><i>Exchange title</i> - your exchange system title (name)
<br><i>SystemID</i> - specify operating system of your server. Set it to "Unix" if you set up system on Unix based server, or set it to "Windows" if on WinNT based server. Please, note, if you are using Apache Web server on WinNT server, you must set it to "Unix".
<br><i>Path to ADCenter directory</i> - specify full path to ADC2000 root directory
<br><i>Path to databases directory</i> - path to databases directory. Its a path to directory where you places files from /bases directory. Please, note, you must place your databases in the directory, not accessible via Web for security reason.
<br><i>URL to ADCenter directory</i> - specify full url to ADC2000 root directory
<br><i>URL to CGI-BIN directory</i> - specify full url to the directory where you placed all *.pl files for ADC2000
<br><i>Path to sendmail</i> - path to sendmail program on your server. If your server is NT based and you havent sendmail, ask us for free copy of SimpleMail program. System will send messages via sendmail program only if SMTP Server variable is "NULL" (empty).
<br><i>SMTP Server</i> - specify host name of your SMTP server. Leave empty if you will use sendmail for mail sending.
<br><i>SMTP port</i> - port for connection to your SMTP server. Usually, 25.
<br><i>Admin email</i> - your email address
<br><i>URL to your site</i> - full url to your site
<br><i>Default internal account</i> - specify account username what will be your default exchange account. Please, note, you must create account before and upload banners for all spots and services
<br><i>Records per page</i> - how many records will be placed per page for numerated data
<br><i>Local timezone</i> - Difference between your local time your want to use with system and GMT
<br><i>Default reason</i> - specify default reason for banner rejecting
<br><i>Default language</i> - if language is not specified, default language will be used
<br><br><b>Cheat analyzer variables:</b>
<br><i>Log if cant resolve referer page (1-yes,0-no)</i> - Log event if system cant resolve referer page (URL where banner was shown/clicked)
<br><i>Log if cant resolve user agent (1-yes,0-no)</i> - Log event if system cant resolve user agent (browser of visitor)
<br><i>Impressions per browser limit</i> - How many banners can be showed for one browser per session (until it will be closed) without logging
<br><i>Clicks per browser limit</i> - How many banners can be clicked from one browser per session (until it will be closed) without logging
<br><i>IPs per browser limit</i> - How many IPs can be used by one browser per session (until it will be closed) without logging
<br><i>Log if cookie duplicates found (1-yes,0-no)</i> - In fact it cant be duplicated, because each banner call using randomize number (banner session). If you'll find it - there is big probability of cheating by software (99,9% of programs cant generate random numbers, but without this parameter banner will not be shown)
<br><i>Min CTR allowed</i> - Min allowed value for users CTR (click/impressions*100 %)
<br><i>Max CTR allowed</i> - Max allowed value for users CTR (click/impressions*100 %)
<br><br><b>Banner exchange variables:</b>
<br><i>Default ratio</i> - Default ratio for banner exchange. Showing how many impression credits user earn for each banner impression on his site. "1:2" means - user will earn 1 credit for 2 impressions
<br><i>Default click ratio</i> - Default click ratio for banner (or click) exchange. Showing how many impression (or click - if click exchange is enabled) credits user earn when someone click on banner shown on his site.
<br><i>Default referal ratio</i> - showing how many impression credits user get for each impression on the site of user refered by him.
<br><i>Enable click exchange</i> - Set it to 1 if enabled, 0 if disabled. Allow users to earn click credits.
<br><i>Default user weight</i> - how many records this account will has in banner pool
<br><i>Starting bonus credits</i> - how many impression credits user get when register with exchange system
<br><i>Alternative text</i> - ALT text for banners
<br><i>Max number of banners</i> - set here number of banner spots you purchased, do not set it more, or system will not work properly.
<br><i>Banner width</i> - Width for each banner spot, delimeted by comma
<br><i>Banner height</i> - Height for each banner spot, delimeted by comma
<br><i>Enable minibanner</i> - Enable (1) of disable (0) minibanner for each banner spot, delimeted by comma
<br><i>Minibanner height</i> - height for minibanner
<br><i>Max banner weight</i> - Max allowed weight for each banner spot, delimeted by comma (bytes)
<br><br><b>SwimBanner exchange variables:</b>
<br><i>Default ratio</i> - Default ratio for swimbanner exchange. Showing how many impression credits user earn for each banner impression on his site. "1:2" means - user will earn 1 credit for 2 impressions
<br><i>Default click ratio</i> - Default click ratio for banner (or click) exchange. Showing how many impression (or click - if click exchange is enabled) credits user earn when someone click on banner shown on his site.
<br><i>Enable SwimBanner</i> - Enable (1) or disable (0) this service. Do not enable it if you not purchased module for this service, or system will not work properly
<br><i>Enable click exchange</i> - Set it to 1 if enabled, 0 if disabled. Allow users to earn click credits.
<br><i>Starting bonus credits</i> - how many impression credits user get when register with exchange system
<br><i>Max banner weight</i> - Max allowed weight for banner (bytes)
<br><i>Banner width</i> - Width for banner (pixels)
<br><br><b>TX variables:</b>
<br><i>Default ratio</i> - Default ratio for text exchange. Showing how many impression credits user earn for each banner impression on his site. "1:2" means - user will earn 1 credit for 2 impressions
<br><i>Default click ratio</i> - Default click ratio for banner (or click) exchange. Showing how many impression (or click - if click exchange is enabled) credits user earn when someone click on banner shown on his site.
<br><i>Enable TX</i> - Enable (1) or disable (0) this service. Do not enable it if you not purchased module for this service, or system will not work properly
<br><i>Enable click exchange</i> - Set it to 1 if enabled, 0 if disabled. Allow users to earn click credits.
<br><i>Starting bonus credits</i> - how many impression credits user get when register with exchange system
<br><i>Min tickerline width</i> - Min allowed width for tickerline (pixels)
<br><i>Max tickerline width</i> - Max allowed width for tickerline (pixels)
<br><br><b>Counter variables:</b>
<br><i>Enable counter</i> - Enable (1) or disable (0) this service. Do not enable it if you not purchased module for this service, or system will not work properly
<br><i>Alternative text</i> - ALT text for counter picture.
<br><br><b>Maillist variables:</b>
<br><i>Enable maillist</i> - Enable (1) or disable (0) this service. Do not enable it if you not purchased module for this service, or system will not work properly
</font></td></tr>
</table></center></div>
<!--NON-STATIC-->
</td></tr></table>
</td></tr></table>
</td></tr></table>
<div align="center"><center><table border="0" width="100%" cellspacing="1" cellpadding="0">
<tr><td width="100%" align="center"><hr size="1" color="#000000" width="534">
<p><font face="Arial" color="#000000" size="1"><b>Copyright ©&nbsp; TRXX Programming Group. 2000 All Rights Reserved.</b></font></p><p>&nbsp;</td></tr>
</table></center></div></td>
<td bgcolor="#3E5B68" height="100%" background="$adcenter/images/$data{lang}/linepix.gif" align="center"><img border="0" src="$adcenter/images/$data{lang}/linepix.gif" width="1" height="100%"> <p>&nbsp;</td></tr>
</table></center></div></td></tr></table></center></div>
</font>
</body>
</html>