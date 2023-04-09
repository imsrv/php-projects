
<form action="{S_PROFILE_ACTION}" method="post">
<table width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr> 
<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"><span class="aquawords">{L_SEND_PASSWORD}</span></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="forumline">
<tr> 
<td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
</tr>
<tr> 
<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
<td class="row2"> 
<input type="text" class="post" style="width: 200px" name="username" size="25" maxlength="40" value="{USERNAME}" />
</td>
</tr>
<tr> 
<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
<td class="row2"> 
<input type="text" class="post" style="width: 200px" name="email" size="25" maxlength="255" value="{EMAIL}" />
</td>
</tr>
<tr> 
<td colspan="2" align="center" height="28">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
</td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
</form>