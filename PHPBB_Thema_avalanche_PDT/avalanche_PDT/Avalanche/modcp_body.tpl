<form method="post" action="{S_MODCP_ACTION}">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> <a href="{U_VIEW_FORUM}" class="thCenter">{FORUM_NAME}</a></th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
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

<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="cat" colspan="5">{L_MOD_CP}</td>
	</tr>
	<tr> 
	  <td class="row1" colspan="5" align="center"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <td width="4%" class="cat"></td>
	  <td class="cat">{L_TOPICS}</td>
	  <td width="8%" class="cat">{L_REPLIES}</td>
	  <td width="17%" class="cat">{L_LASTPOST}</td>
	  <td width="5%" class="cat">{L_SELECT}</td>
	</tr>
	<!-- BEGIN topicrow -->
	<tr> 
	  <td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="20" height="20" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row1">&nbsp;<span class="topictitle">{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row1" align="center" valign="middle"><span class="postdetails">{topicrow.LAST_POST_TIME}</span></td>
	  <td class="row2" align="center" valign="middle"> 
		<input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" />
	  </td>
	</tr>
	<!-- END topicrow -->
	<tr align="right"> 
	  <td class="row3" colspan="5" height="29"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}" />
		&nbsp; 
		<input type="submit" name="move" class="liteoption" value="{L_MOVE}" />
		&nbsp; 
		<input type="submit" name="lock" class="liteoption" value="{L_LOCK}" />
		&nbsp; 
		<input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}" />
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

<br clear="all" />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>

