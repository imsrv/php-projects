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
<font size="4" face="Verdana,Arial,Helvetica"><b>HELP SECTION NAVIGATOR</b></font></td></tr>
<tr><td width="73%"><font size=2 face="Verdana,Arial,Helvetica"><select name=method>
<option value="h_genstat">General Stats Help</option>
<option value="h_monstat">Monthly Stats Help</option>
<option value="h_daystat">Daily Stats Help</option>
<option value="h_hrsstat">Hourly Stats Help</option>
<option value="h_extstat">Extended Stats Help</option>
<option value="h_hcostat">HTML Code Help</option>
<option value="h_gsestat">General Settings Help</option>
<option value="h_psestat">Personal Settings Help</option>
<option value="h_bmastat">Banner Management Help</option>
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
<font size=5 color="#000000">UPLOAD BANNER</font>
<br><font size=2>
Here you can upload your banner:
<br><br><b>Upload GIF, JPG, JAVA, FLASH:</b>
<br>Be sure your banner has correct dimensions. Its very important. Some notes about Java and Flash banners. Be sure that you linked your banner to <b><i>$cgi/adcrdst.pl?$data{name}&bannernumber</i></b>, or system will not count clicks for this banner.
<br><br><b>Upload HTML banner:</b>
<br>What is HTML banner? Its just HTML text. You can use it in many cases. Most popular is using forms in banners. For example, if you have navigator on your site, you can use it in the banner. But be sure that your script accept data from form by GET method. You must only "copy&paste" the part of you HTML page with form and make following changes:
<br><i>Add hidden fields</i> - first with name <b>url</b> and value <i><b>url_to_your_script</b></i>, second with name <b>bun</b> and value <b>$data{name}</b> and third with name <b>spot</b> and value <i><b>bannernumber</b></i>
<br><i>Change action in &lt;form&gt; tag</i> - you must change it to <b>$cgi/adcrdht.pl</b> or system will not count clicks.
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