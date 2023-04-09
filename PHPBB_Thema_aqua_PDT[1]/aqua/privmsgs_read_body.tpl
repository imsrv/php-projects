
<table cellspacing="2" cellpadding="2" border="0" align="center">
<tr> 
<td valign="middle">{INBOX_IMG}</td>
<td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
<td valign="middle">{SENTBOX_IMG}</td>
<td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
<td valign="middle">{OUTBOX_IMG}</td>
<td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
<td valign="middle">{SAVEBOX_IMG}</td>
<td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
</tr>
</table>

<br clear="all" />

<form method="post" action="{S_PRIVMSGS_ACTION}">
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
<td valign="middle">{REPLY_PM_IMG}</td>
<td width="100%"><span class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr1.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0" class="forumline">
<tr> 
<th colspan="3" class="thHead" nowrap="nowrap">{BOX_NAME} :: {L_MESSAGE}</th>
</tr>
<tr> 
<td class="row2" nowrap="nowrap"><span class="genmed">{L_FROM}:</span></td>
<td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_FROM}</span></td>
</tr>
<tr> 
<td class="row2" nowrap="nowrap"><span class="genmed">{L_TO}:</span></td>
<td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_TO}</span></td>
</tr>
<tr> 
<td class="row2" nowrap="nowrap"><span class="genmed">{L_POSTED}:</span></td>
<td width="100%" class="row2" colspan="2"><span class="genmed">{POST_DATE}</span></td>
</tr>
<tr> 
<td class="row2" nowrap="nowrap"><span class="genmed">{L_SUBJECT}:</span></td>
<td width="100%" class="row2"><span class="genmed">{POST_SUBJECT}</span></td>
<td nowrap="nowrap" class="row2" align="right"> {QUOTE_PM_IMG} {EDIT_PM_IMG}</td>
</tr>
<tr> 
<td valign="top" colspan="3" class="row1">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="9" height="9"><img src="templates/aqua/images/profileul.gif" width="9" height="9"></td>
<td height="9" background="templates/aqua/images/profileum.gif"></td>
<td width="9" height="9"><img src="templates/aqua/images/profileur.gif" width="9" height="9"></td>
</tr>
<tr>
<td width="9" background="templates/aqua/images/profileml.gif"></td>
<td background="templates/aqua/images/profilemm.gif"><span class="postbody">{MESSAGE}</span></td>
<td width="9" background="templates/aqua/images/profilemr.gif"></td>
</tr>
<tr>
<td width="9" height="9"><img src="templates/aqua/images/profiledl.gif" width="9" height="9"></td>
<td height="9" background="templates/aqua/images/profiledm.gif"></td>
<td width="9" height="9"><img src="templates/aqua/images/profiledr.gif" width="9" height="9"></td>
</tr>
</table>
</td>
</tr>
<tr> 
<td width="78%" height="28" valign="bottom" colspan="3" class="row1"> 
<table cellspacing="0" cellpadding="0" border="0" height="18">
<tr> 
<td valign="middle" nowrap="nowrap">{PROFILE_IMG} {PM_IMG} {EMAIL_IMG} 
  {WWW_IMG} {AIM_IMG} {YIM_IMG} {MSN_IMG}</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><script language="JavaScript" type="text/javascript"><!-- 

if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
document.write('{ICQ_IMG}');
else
document.write('<div style="position:relative"><div style="position:absolute">{ICQ_IMG}</div><div style="position:absolute;left:3px">{ICQ_STATUS_IMG}</div></div>');
  
  //--></script><noscript>{ICQ_IMG}</noscript></td>
</tr>
</table>
</td>
</tr>
<tr align="center">
<td class="row1" colspan="3" height="28"> {S_HIDDEN_FIELDS} 
<input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />
&nbsp; 
<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />
</td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
<table width="90%" cellspacing="2" border="0" align="center" cellpadding="2">
<tr> 
<td>{REPLY_PM_IMG}</td>
<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
</tr>
</table>
</form>

<table width="90%" cellspacing="2" border="0" align="center" cellpadding="2">
<tr> 
<td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
</tr>
</table>
