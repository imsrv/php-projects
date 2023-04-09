<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" alt="" width="30"/></th>
		<th width="100%"><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a></th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<td width="50%" class="cat" align="left">
			<span class="gensmall">
			<!-- BEGIN switch_user_logged_in -->
			<img src="templates/Avalanche/images/icon_latest_reply.gif" alt="" /> {LAST_VISIT_DATE}<br />
			<!-- END switch_user_logged_in -->
			<img src="templates/Avalanche/images/icon_latest_reply.gif" alt="" /> {CURRENT_TIME}</span>
		</td>
		<td class="cat" align="right">
			<!-- BEGIN switch_user_logged_in -->
				<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
			<!-- END switch_user_logged_in -->
			<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
		</td>
	</tr>
</table>
<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<span class="gensmall">{L_USERNAME}: <input class="post" type="text" name="username" size="15" /> &nbsp;&nbsp;&nbsp;{L_PASSWORD}: <input class="post" type="password" name="password" size="15" maxlength="32" />&nbsp;&nbsp; &nbsp;&nbsp;{L_AUTO_LOGIN} <input class="text" type="checkbox" name="autologin" />&nbsp;&nbsp;&nbsp; <input type="submit" class="mainoption" name="login" value="{L_LOGIN}" /></span>
		</td>
	</tr>
</table>
</form>
<!-- END switch_user_logged_out -->
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center"><span class="gensmall">{S_TIMEZONE}</span></td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br />

<!-- BEGIN catrow -->
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft_quote.gif" alt="" width="30"/></th>
		<th width="100%">{L_FORUM}</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="2" cellspacing="0" border="0" class="forumline">
	<tr> 
		<td class="cat" colspan="2"><a href="{catrow.U_VIEWCAT}"><img src="templates/Avalanche/images/arrow_down.gif" alt="" border="0" /></a> {catrow.CAT_DESC}</td>
		<td class="cat" align="center">{L_TOPICS}</td>
		<td class="cat" align="center">{L_POSTS}</td>
		<td class="cat" align="center">{L_LASTPOST}</td>
	</tr>
	<!-- BEGIN forumrow -->
	<tr>
		<td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="30" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
		<td class="row1" height="50"><div class="forumlink"><a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a></div>
		<div class="genmed">{catrow.forumrow.FORUM_DESC}</div>
		<div class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</div></td>
		<td width="45" class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
		<td width="45" class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
		<td width="175" class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
	</tr>
	<!-- END forumrow -->
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>
<br />
<!-- END catrow -->

<table width="100%" cellpadding="0" cellspacing="0">
	<tr> 
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" alt="" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" alt="" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
	<tr>
		<td class="cat" colspan="3"><img src="templates/Avalanche/images/icon_latest_reply.gif" alt="" /> <a href="{U_VIEWONLINE}" class="cat">{L_WHO_IS_ONLINE}</a></td>
	</tr>
	<tr>
		<td class="row1" align="center" valign="middle" rowspan="2">
		<img src="templates/Avalanche/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" border="0" />
		</td>
		<td class="row1" align="left" width="100%" colspan="2"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left" colspan="2"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" style="width: 400px;" align="center">
			<span class="gensmall">{L_ONLINE_EXPLAIN}</span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br clear="all" />
<table cellspacing="3" border="0" align="center" cellpadding="0">
	<tr>
		<td width="20" align="center"><img src="templates/Avalanche/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
		<td><span class="gensmall">{L_NEW_POSTS}</span></td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="templates/Avalanche/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
		<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="templates/Avalanche/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
		<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
	</tr>
</table>
