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
<a href="$cgi/adcadm.pl?name=$data{name}&password=$data{password}&method=h_userman" target="_blank"><img src="$adcenter/images/info.gif" border=0 alt="GET HELP"></a>&nbsp;&nbsp;<font size=5 color=black>OPERATION STATUS</font>
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="100%" bgcolor="#82c7db"><font size="2">$statusline</font></td></tr>
</table></td></tr>
<tr><td width="100%">
<br><font size=5 color=black>CHANGE ADMIN LOGIN/PASSWORD</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_admin">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Login</b></font></td>
<td width="65%" bgcolor="#82c7db" align="right"><input type="text" name="nname" size="48" maxlength=8 value="$data{name}"></td></tr>
<tr><td width="35%"><font size="2"><b>Password</b></font></td>
<td width="65%" align="right"><input type="text" name="npassword" maxlength=8 size="48" value="$data{password}"></td></tr>
<tr><td colspan=2 align="right" bgcolor="#82c7db"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>CHANGE USER STATUS</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Username</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="text" name="username" size="48"></td></tr>
<tr><td width="35%"><font size="2"><b>Status</b></font></td>
<td width="65%" align="right"><select name="method">
<option value="m_enable">Enabled</option>
<option value="m_disable">Disabled</option>
<option value="userman">---------------------------</option>
<option value="m_free">Free</option>
<option value="m_advertiser">Advertiser</option>
<option value="userman">---------------------------</option>
<option value="m_expired">Expirable</option>
<option value="m_nonexpired">Non-expirable</option>
<option value="userman">---------------------------</option>
<option value="m_untrust">Untrusted</option>
<option value="m_trust">Trusted</option>
<option value="userman">---------------------------</option>
<option value="m_standard">Approval required</option>
<option value="m_autoaccept">Auto-accept</option>
<option value="userman">---------------------------</option>
<option value="m_remove">CANCEL ACCOUNT</option>
</select>
</td></tr>
<tr><td width="35%" bgcolor="#82c7db"></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>GET USERLIST</font>
<form method="post" action="$cgi/adcadm.pl" target="_blank">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="get_userlist">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Accounts type</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="type">
<option value="all">All accounts</option>
<option value="enable">Enabled accounts</option>
<option value="disable">Disabled accounts</option>
<option value="free">Free accounts</option>
<option value="advertiser">Advertiser accounts</option>
<option value="expirable">Expirable accounts</option>
<option value="nonexpirable">Non-expirable accounts</option>
<option value="untrust">Untrusted accounts</option>
<option value="trust">Trusted accounts</option>
<option value="standard">Approval required accounts</option>
<option value="autoaccept">Auto-accept accounts</option>
<option value="blitz">Blitz pool list</option>
<option value="inactive">Inactive accounts</option>
</select></td></tr>
<tr><td colspan=2 align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>GET STATS</font>
<form method="post" action="$cgi/adcadm.pl" target="_blank">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="get_userstats">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Stats type</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="type">
<option value="affiliate">Affiliate</option>
<option value="bx">Banner Exchange</option>
<option value="sbx">SwimBanner Exchange</option>
<option value="tx">TX Exchange</option>
</select></td></tr>
<tr><td colspan=2 align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>ADD CREDITS TO USER</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Username</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="text" name="username" size="48"></td></tr>
<tr><td width="35%"><font size="2"><b>Amount</b></font></td>
<td width="65%" align="right"><input type="text" name="cred" size="48"></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Credits type</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="method">
<option value="impcred">Impressions credits</option>
<option value="clccred">Click credits</option>
</select></td></tr>
<tr><td width="35%"><font size="2"><b>Service</b></font></td>
<td width="65%" align="right"><select name="service">
<option value="bx">Banner Exchange</option>
<option value="sbx">SwimBanner Exchange</option>
<option value="tx">TX Exchange</option>
</select></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>For</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="for">
<option value="user">Selected user</option>
<option value="trust">All trusted users</option>
<option value="all">All users</option>
</select>
</td></tr>
<tr><td width="35%"></td>
<td width="65%" align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>CHANGE IMPRESSION RATIO</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_ratio">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Username</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="text" name="username" size="48"></td></tr>
<tr><td width="35%"><font size="2"><b>Ratio</b></font></td>
<td width="65%" align="right"><input type="text" name="ratio" size="48"></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>For</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="for">
<option value="user">Selected user</option>
<option value="trust">All trusted users</option>
<option value="all">All users</option>
</select>
</td></tr>
<tr><td width="35%"></td>
<td width="65%" align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>SET "WEIGHT" FOR USER</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}"><input type="hidden" name="method" value="m_wght">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="1">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Username</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="text" name="username" size="48"></td></tr>
<tr><td width="35%"><font size="2"><b>Weight</b></font></td>
<td width="65%" align="right"><select name="wght"><option>1<option>2<option>3<option>4<option>5<option>6<option>7<option>8<option>9<option>10<option>11<option>12<option>13<option>14<option>15<option>16<option>17<option>18<option>19<option>20<option>21<option>22<option>23<option>24<option>25<option>26<option>27<option>28<option>29<option>30<option>31<option>32<option>33<option>34<option>35<option>36<option>37<option>38<option>39<option>40<option>41<option>42<option>43<option>44<option>45<option>46<option>47<option>48<option>49<option>50<option>51<option>52<option>53<option>54<option>55<option>56<option>57<option>58<option>59<option>60<option>61<option>62<option>63<option>64<option>65<option>66<option>67<option>68<option>69<option>70<option>71<option>72<option>73<option>74<option>75<option>76<option>77<option>78<option>79<option>80<option>81<option>82<option>83<option>84<option>85<option>86<option>87<option>88<option>89<option>90<option>91<option>92<option>93<option>94<option>95<option>96<option>97<option>98<option>99<option>100</select></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>For</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="for">
<option value="user">Selected user</option>
<option value="advertiser">All advertisers</option>
</select>
</td></tr>
<tr><td width="35%"></td>
<td width="65%" align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
</table></form></td></tr>
<tr><td width="100%">
<font size=5 color=black>BLITZ MODE</font>
<form method="post" action="$cgi/adcadm.pl">
<input type="hidden" name="name" value="$data{name}"><input type="hidden" name="password" value="$data{password}">
<table bgcolor="#97D0E1" border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Username</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><input type="text" name="username" size="48"></td></tr>
<tr><td width="35%"><font size="2"><b>Credits amount</b></font></td>
<td width="65%" align="right"><input type="text" name="cred" size="48"></td></tr>
<tr><td width="35%" bgcolor="#82c7db"><font size="2"><b>Method</b></font></td>
<td width="65%" align="right" bgcolor="#82c7db"><select name="method">
<option value="blitz">Add user to pool</option>
<option value="rem_blitz">Remove user from pool</option>
<option value="res_blitz">Reset pool</option>
</select>
</td></tr>
<tr><td width="35%"></td>
<td width="65%" align="right"><input type="image" border=0 src="$adcenter/images/proceed.gif" width=83 height=23></td></tr>
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