<form method="post" action="{S_MODCP_ACTION}">
<table width="90%" border="0" align="center">
<tr> 
<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"><span class="aquawords">{L_MOD_CP}</span></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="forumline">
<tr> 
<th width="4%" class="thLeft" nowrap="nowrap">&nbsp;</th>
<th nowrap="nowrap"><div align="left">&nbsp;{L_TOPICS}&nbsp;</div></th>
<th width="8%" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
<th width="17%" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
<th width="5%" class="thRight" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
</tr>
<!-- BEGIN topicrow -->
<tr> 
<td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="17" height="17" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
<td class="row1">&nbsp;<span class="topictitle">{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span></td>
<td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
<td class="row1" align="center" valign="middle"><span class="postdetails">{topicrow.LAST_POST_TIME}</span></td>
<td class="row2" align="center" valign="middle"> 
<input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" />
</td>
</tr>
<!-- END topicrow -->
<tr align="center"> 
<td height="29" colspan="5" class="row2"> {S_HIDDEN_FIELDS} 
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
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
<table width="90%" border="0" align="center">
<tr> 
<td align="left" valign="middle"><span class="nav">{PAGE_NUMBER}</b></span></td>
<td align="center" valign="middle"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span></td>
</tr>
</table>
</form>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr> 
<td align="right">{JUMPBOX}</td>
</tr>
</table>