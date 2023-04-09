 
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



  
<table align="CENTER" class="forumline" border="0" cellpadding="3" cellspacing="1" width="717"><form method="post" name="privmsg_list" action="{S_PRIVMSGS_ACTION}">
  <tr> 
    <th width="5%" height="25" class="thTop" nowrap="nowrap">&nbsp;{L_FLAG}&nbsp;</th>
    <th width="55%" class="thTop" nowrap="nowrap">&nbsp;{L_SUBJECT}&nbsp;</th>
    <th width="20%" class="thTop" nowrap="nowrap">&nbsp;{L_FROM_OR_TO}&nbsp;</th>
    <th width="15%" class="thTop" nowrap="nowrap">&nbsp;{L_DATE}&nbsp;</th>
    <th width="5%" class="thTop" nowrap="nowrap">&nbsp;{L_MARK}&nbsp;</th>
  </tr>
  <tr> 
    <th colspan="5" align="left" height="28" class="nav" nowrap="nowrap">Private Messages</th>
  </tr>
  <!-- BEGIN listrow -->
  <tr> 
    <td class="row1" width="5%" align="center" valign="middle"><img src="{listrow.PRIVMSG_FOLDER_IMG}" width="19" height="18" alt="{listrow.L_PRIVMSG_FOLDER_ALT}" title="{listrow.L_PRIVMSG_FOLDER_ALT}" /></td>
    <td width="55%" valign="middle" class="row1" onmouseover="this.style.backgroundColor='#232323'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{listrow.U_READ}'"><span class="gen">&nbsp;<a href="{listrow.U_READ}" class="gen">{listrow.SUBJECT}</a></span></td>
    <td width="20%" valign="middle" align="center" class="row2"><span class="name">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}" class="name">{listrow.FROM}</a></span></td>
    <td width="15%" align="center" valign="middle" class="row1"><span class="postdetails">{listrow.DATE}</span></td>
    <td width="5%" align="center" valign="middle" class="row3"><span class="postdetails"> 
      <input type="checkbox" name="mark[]2" value="{listrow.S_MARK_ID}" />
      </span></td>
  </tr>
  <!-- END listrow -->
  <!-- BEGIN switch_no_messages -->
  <tr> 
    <td class="row1" colspan="5" align="center" valign="middle"><span class="gen"><br />
      {L_NO_MESSAGES}<br />
      <br />
      </span></td>
  </tr>
  <!-- END switch_no_messages -->
  <tr> 
    <td class="row3" colspan="5" height="28" align="right"> {S_HIDDEN_FIELDS} 
      <input type="submit" name="save" value="{L_SAVE_MARKED}" class="mainoption" /> 
      &nbsp; <input type="submit" name="delete" value="{L_DELETE_MARKED}" class="liteoption" /> 
      &nbsp; <input type="submit" name="deleteall" value="{L_DELETE_ALL}" class="liteoption" /> 
    </td>
  </tr>
  <tr> 
    <td class="spaceRow" colspan="5" height="1"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="1" height="1" /></td>
  </tr>

</table>

  
<table width="717" cellspacing="2" cellpadding="4" border="0" align="center">

  <tr> 
    <td align="right" nowrap="nowrap" class="row1"><span class="gen">{L_DISPLAY_MESSAGES}: 
      <select name="msgdays">{S_SELECT_MSG_DAYS}
		
      </select>
      <input type="submit" value="{L_GO}" name="submit_msgdays" class="liteoption" />
      </span></td>
  </tr>
</table>
<table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
    <td align="left"><span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> ~ <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></span></td>
    <td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="LEFT" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="LEFT" valign="TOP"></td>
          <td align="RIGHT" valign="TOP"><span class="gen">{PAGE_NUMBER}<br />
            {PAGINATION}</span></td>
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
    <td align="left" valign="middle"><span class="nav">{POST_PM_IMG}</span></td>
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
  </tr></form>
</table>
 
 
 
 
 
 
  
<br>
<table border="0" cellspacing="0" cellpadding="0" align="center" width="717">
  <tr> 
    <td align="LEFT"> 
      <!-- BEGIN switch_box_size_notice -->
      <table align="LEFT" class="bodyline" width="175" cellspacing="1" cellpadding="2" border="0">
        <tr> 
          <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
        </tr>
        <tr> 
          <td colspan="3" width="175" class="row2"> <table cellspacing="0" cellpadding="1" border="0">
              <tr> 
                <td bgcolor="{T_TD_COLOR2}"><img src="templates/AdInfinitum/images/spacer.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="8" alt="{INBOX_LIMIT_PERCENT}" /></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td width="33%" class="row1"><span class="gensmall">0%</span></td>
          <td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
          <td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
        </tr>
      </table>
      <!-- END switch_box_size_notice -->
    </td>
    <td align="right" width="18"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="16" height="1" /> 
    </td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="2">
  <tr> 
	<td align="right" valign="top">{JUMPBOX}</td>
  </tr>
</table>

