<table align="CENTER" class="forumline" width="717" cellpadding="4" cellspacing="1" border="0">
<form method="post" action="{S_MODCP_ACTION}">
    <tr>
      <th width="4%" class="thTop" nowrap="nowrap">&nbsp;</th>
      <th nowrap="nowrap" class="thTop">&nbsp;{L_TOPICS}&nbsp;</th>
      <th width="8%" nowrap="nowrap" class="thTop">&nbsp;{L_REPLIES}&nbsp;</th>
      <th width="17%" nowrap="nowrap" class="thTop">&nbsp;{L_LASTPOST}&nbsp;</th>
      <th width="5%" class="thTop" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
    </tr>
    <tr align="LEFT"> 
      <td class="catHead" colspan="5" height="28"><span class="nav">{L_MOD_CP}</span> 
      </td>
    </tr>
    <tr align="LEFT"> 
      <td class="row1" colspan="5"><table align="LEFT" cellspacing="1" cellpadding="5" border="0"><td><span class="gen"><br />{L_MOD_CP_EXPLAIN}<br /><br /></span></td></table></td>
    </tr>
  <tr> 
    <td class="spaceRow" colspan="5" height="1"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="1" height="1" /></td>
  </tr>
    <!-- BEGIN topicrow -->
    <tr> 
      <td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
      <td class="row1" width="" onmouseover="this.style.backgroundColor='#313131'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{topicrow.U_VIEW_TOPIC}'"><span class="gen">{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="gen">{topicrow.TOPIC_TITLE}</a></span></td>
      <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
      <td class="row1" align="center" valign="middle"><span class="postdetails">{topicrow.LAST_POST_TIME}</span></td>
      <td class="row3" align="center" valign="middle"> <input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" /> 
      </td>
    </tr>
    <!-- END topicrow -->
    <tr align="right"> 
      <td class="row3" colspan="5" height="29"> {S_HIDDEN_FIELDS} 
        <input type="submit" name="delete" class="liteoption" value="{L_DELETE}" /> 
        &nbsp; <input type="submit" name="move" class="liteoption" value="{L_MOVE}" /> 
        &nbsp; <input type="submit" name="lock" class="liteoption" value="{L_LOCK}" /> 
        &nbsp; <input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}" /> 
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
          <td align="RIGHT" valign="TOP"><span class="gen">{PAGE_NUMBER}<br />
            {PAGINATION}</span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
        </tr>
      </table></th>
  </tr>
</form>
</table>

<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="right">{JUMPBOX}</td>
  </tr>
</table>