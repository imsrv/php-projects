<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th class="thTop" colspan="2" height="25"><b>{BOX_NAME}</b></th>
  </tr>
</table>
<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th colspan="1" align="left" height="28" class="nav" nowrap="nowrap">{L_MESSAGE}</th>
  </tr>
</table>


  <table align="CENTER" class="forumline" border="0" cellpadding="4" cellspacing="1" width="717">
<form method="post" action="{S_PRIVMSGS_ACTION}">
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
	  <td class="row3" colspan="3" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />
	  </td>
	</tr>
  </table>
  <table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
    <td align="left"></td>
    <td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="LEFT" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="LEFT" valign="TOP"></td>
          <td align="RIGHT" valign="TOP"><span class="gensmall"></span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
<br>
<table width="717" cellspacing="2" border="0" align="center" cellpadding="0">
  <tr> 
    <td align="left" valign="middle"><span class="nav">{REPLY_PM_IMG}</span></td>
    <td align="RIGHT" valign="middle"><table height="" cellspacing="0" cellpadding="" border="0">
        <tr valign="middle"> 
          <td>{INBOX_IMG}</td>
          <td><span class="cattitle">{INBOX}&nbsp;&nbsp;</span></td>
          <td>{SENTBOX_IMG}</td>
          <td><span class="cattitle">{SENTBOX}&nbsp;&nbsp;</span></td>
          <td>{OUTBOX_IMG}</td>
          <td><span class="cattitle">{OUTBOX}&nbsp;&nbsp;</span></td>
          <td>{SAVEBOX_IMG}</td>
          <td><span class="cattitle">{SAVEBOX}</span></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>


<br>
<table width="717" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
  </tr>
</table>
