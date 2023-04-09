 
<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.privmsg_list.length; i++)
		{
			document.privmsg_list.elements[i].checked = status;
		}
	}
</script>


<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> Private Message</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  <tr>
	<td class="cat" valign="middle" align="center" width="100%">
<table cellspacing="2" cellpadding="2" border="0" align="center">
  <tr>
	<td valign="middle">{INBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{INBOX}</span></td>
	<td valign="middle">{SENTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SENTBOX}</span></td>
	<td valign="middle">{OUTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{OUTBOX}</span></td>
	<td valign="middle">{SAVEBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
  </tr>
</table>
	</td>
	<td align="right"> 
	  <!-- BEGIN switch_box_size_notice -->
	  <table width="175" cellspacing="0" cellpadding="2" border="0">
		<tr> 
		  <td colspan="3" width="175" class="row3" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
		</tr>
		<tr> 
		  <td colspan="3" width="175" class="row3">
			<table cellspacing="0" cellpadding="1" border="0">
			  <tr> 
				<td bgcolor="{T_TD_COLOR2}"><img src="templates/Avalanche/images/spacer.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="8" alt="{INBOX_LIMIT_PERCENT}" /></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<tr> 
		  <td width="33%" class="row3"><span class="gensmall">0%</span></td>
		  <td width="34%" align="center" class="row3"><span class="gensmall">50%</span></td>
		  <td width="33%" align="right" class="row3"><span class="gensmall">100%</span></td>
		</tr>
	  </table>
	  <!-- END switch_box_size_notice -->
	</td>
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

<form method="post" name="privmsg_list" action="{S_PRIVMSGS_ACTION}">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
	  <td align="left" valign="middle" width="50%">{POST_PM_IMG}</td>
	  <td align="right" nowrap="nowrap"><span class="nav">{L_DISPLAY_MESSAGES}: 
		<select name="msgdays">{S_SELECT_MSG_DAYS}
		</select>
		<input type="submit" value="{L_GO}" name="submit_msgdays" class="liteoption" />
		</span></td>
	</tr>
</table>

<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline">
	<tr> 
	  <td width="5%" class="cat" nowrap="nowrap">&nbsp;{L_FLAG}</td>
	  <td width="55%" class="cat" nowrap="nowrap">&nbsp;{L_SUBJECT}</td>
	  <td width="20%" class="cat" nowrap="nowrap">&nbsp;{L_FROM_OR_TO}</td>
	  <td width="15%" class="cat" nowrap="nowrap">&nbsp;{L_DATE}</td>
	  <td width="5%" class="cat" nowrap="nowrap">&nbsp;{L_MARK}</td>
	</tr>
	<!-- BEGIN listrow -->
	<tr> 
	  <td class="{listrow.ROW_CLASS}" width="5%" align="center" valign="middle"><img src="{listrow.PRIVMSG_FOLDER_IMG}" width="20" height="20" alt="{listrow.L_PRIVMSG_FOLDER_ALT}" title="{listrow.L_PRIVMSG_FOLDER_ALT}" /></td>
	  <td width="55%" valign="middle" class="{listrow.ROW_CLASS}"><span class="topictitle">&nbsp;<a href="{listrow.U_READ}" class="topictitle">{listrow.SUBJECT}</a></span></td>
	  <td width="20%" valign="middle" align="center" class="{listrow.ROW_CLASS}"><span class="name">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}" class="name">{listrow.FROM}</a></span></td>
	  <td width="15%" align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails">{listrow.DATE}</span></td>
	  <td width="5%" align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails"> 
		<input type="checkbox" name="mark[]2" value="{listrow.S_MARK_ID}" />
		</span></td>
	</tr>
	<!-- END listrow -->
	<!-- BEGIN switch_no_messages -->
	<tr> 
	  <td class="row1" colspan="5" align="center" valign="middle"><span class="gen">{L_NO_MESSAGES}</span></td>
	</tr>
	<!-- END switch_no_messages -->
	<tr> 
	  <td class="catBottom" colspan="5" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MARKED}" class="mainoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MARKED}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="deleteall" value="{L_DELETE_ALL}" class="liteoption" />
	  </td>
	</tr>
  </table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>
</form>

<br clear="all" />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>