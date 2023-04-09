<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> Private Message</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table cellspacing="0" cellpadding="4" border="0" width="100%" align="center">
  <tr> 
	<td class="cat" width="90"  valign="middle">&nbsp;</td>
	<td class="cat" valign="middle">{INBOX_IMG}</td>
	<td class="cat" valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
	<td class="cat" valign="middle">{SENTBOX_IMG}</td>
	<td class="cat" valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
	<td class="cat" valign="middle">{OUTBOX_IMG}</td>
	<td class="cat" valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
	<td class="cat" valign="middle">{SAVEBOX_IMG}</td>
	<td class="cat" valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
	<td class="cat" width="90" valign="middle">&nbsp;</td>
  </tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall">{S_TIMEZONE}</span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>


<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td valign="middle">{REPLY_PM_IMG}</td>
	</tr>
</table>

<br />
<form method="post" action="{S_PRIVMSGS_ACTION}">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th>&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing=0" width="100%" class="forumline">
	<tr> 
	  <td colspan="3" class="cat" nowrap="nowrap">{BOX_NAME} :: {L_MESSAGE}</td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_FROM}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_FROM}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_TO}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_TO}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_POSTED}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{POST_DATE}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_SUBJECT}:</span></td>
	  <td width="100%" class="row2"><span class="genmed">{POST_SUBJECT}</span></td>
	  <td nowrap="nowrap" class="row2" align="right"> {QUOTE_PM_IMG} {EDIT_PM_IMG}</td>
	</tr>
	<tr> 
	  <td valign="top" colspan="3" class="row1"><span class="postbody">{MESSAGE}</span></td>
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
	<tr>
	  <td class="catBottom" colspan="3" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />
	  </td>
	</tr>
  </table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="#top" class="gensmall">Back To Top</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>
</form>

<br />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
  </tr>
</table>