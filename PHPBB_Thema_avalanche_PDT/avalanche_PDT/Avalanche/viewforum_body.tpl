<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" alt="" width="30"/></th>
		<th width="100%"><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> {FORUM_NAME}</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table width="100%" class="forumline" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<td class="cat"><div style="padding: 3px;"><img src="templates/Avalanche/images/icon_latest_reply.gif" alt="" /> {L_MODERATOR}: {MODERATORS}<br />
		<img src="templates/Avalanche/images/icon_latest_reply.gif" alt="" /> {LOGGED_IN_USER_LIST}</div></td>
		<td align="right" width="50%" class="cat">
			<form method="post" action="{S_POST_DAYS_ACTION}">
			<span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp; 
			<input type="submit" class="liteoption" value="{L_GO}" name="submit" /></span>
			</form>
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


<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td align="left"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft_quote.gif" alt="" width="30"/></th>
		<th>{FORUM_NAME}</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline">
	<tr>
		<td colspan="2" align="center" class="cat" nowrap="nowrap">{L_TOPICS}</td>
		<td width="50" align="center" class="cat" nowrap="nowrap">{L_REPLIES}</td>
		<td width="100" align="center" class="cat" nowrap="nowrap">{L_AUTHOR}</td>
		<td width="50" align="center" class="cat" nowrap="nowrap">{L_VIEWS}</td>
		<td align="center" class="cat" nowrap="nowrap">{L_LASTPOST}</td>
	</tr>
	<!-- BEGIN topicrow -->
	<tr> 
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="20" height="20" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
	  <td class="row2" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr> 
	  <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
  </table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_TOPICS_READ}</a></td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>



<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td align="left"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>


<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" alt="" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" align="center" cellpadding="0">
	<tr>
		<td align="left" valign="top" class="cat"><table cellspacing="3" cellpadding="0" border="0">
			<tr>
				<td width="20" align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="20" height="20" /></td>
				<td class="gensmall">{L_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="20" height="20" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" width="20" height="20" /></td>
				<td class="gensmall">{L_ANNOUNCEMENT}</td>
			</tr>
			<tr> 
				<td width="20" align="center"><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" width="20" height="20" /></td>
				<td class="gensmall">[ Popular ]</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" width="20" height="20" /></td>
				<td class="gensmall">[ Popular ]</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" width="20" height="20" /></td>
				<td class="gensmall">{L_STICKY}</td>
			</tr>
			<tr>
				<td class="gensmall" align="center"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_LOCKED}" height="20" /></td>
				<td class="gensmall">[ Locked ]</td>
				<td>&nbsp;&nbsp;</td>
				<td class="gensmall"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_LOCKED}" width="20" height="20" /></td>
				<td class="gensmall">[ Locked ]</td>
			</tr>
		</table></td>
		<td align="right" class="cat"><div style="padding-top: 3px;padding-bottom: 3px;" class="gensmall">{S_AUTH_LIST}</div></td>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center"><a href="#top" class="gensmall">Back To Top</a></td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br clear="all" />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>