<form action="{S_LOGIN_ACTION}" method="post" target="_top">
<table width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr> 
<td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbwm.gif">
<tr> 
<td><img src="templates/aqua/images/aquatbwl.gif"></td>
<td valign="top">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr align="center" valign="middle">
<td height="50" colspan="2"><span class="aquawords">{L_ENTER_PASSWORD}</span></td>
</tr>
<tr> 
<td width="45%" align="right"><span class="gen">{L_USERNAME}:</span></td>
<td> 
<input type="text" name="username" size="25" maxlength="40" value="{USERNAME}" />
</td>
</tr>
<tr> 
<td align="right"><span class="gen">{L_PASSWORD}:</span></td>
<td> 
<input type="password" name="password" size="25" maxlength="32" />
</td>
</tr>
<tr align="center"> 
<td colspan="2"><span class="gen">{L_AUTO_LOGIN}: <input type="checkbox" name="autologin" /></span></td>
</tr>
<tr align="center"> 
<td colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="login" class="mainoption" value="{L_LOGIN}" /></td>
</tr>
<tr align="center"> 
<td colspan="2"><span class="gensmall"><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a></span></td>
</tr>
</table>
</td>
<td align="right"><img src="templates/aqua/images/aquatbwr.gif"></td>
</tr>
</table>
</form>