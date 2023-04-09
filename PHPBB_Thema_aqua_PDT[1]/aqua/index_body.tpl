<div align="center">
<div style="width:90%">
<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
<table width="90%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="20"><img src="templates/aqua/images/loingl.gif"><a name="login"></a></td>
<td align="center" background="templates/aqua/images/loingm.gif"><span class="cattitle">{L_LOGIN_LOGOUT}</span><br>
<span class="gensmall">{L_USERNAME}: <input class="post" type="text" name="username" size="10" />
&nbsp;&nbsp;&nbsp;{L_PASSWORD}: <input class="post" type="password" name="password" size="10" maxlength="32" />
&nbsp;&nbsp;&nbsp;&nbsp;{L_AUTO_LOGIN} <input class="text" type="checkbox" name="autologin" />
&nbsp;&nbsp;&nbsp; <input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
</span></td>
<td width="20" align="right"><img src="templates/aqua/images/loingr.gif"></td>
</tr>
</table>
</form></div>
<!-- END switch_user_logged_out -->
</div>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="50%">
<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span>
</td>
<td width="50%" align="right">
<img src="templates/aqua/images/aqua_button01.gif" align="absmiddle">
<span class="gensmall">
<!-- BEGIN switch_user_logged_in -->
<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a>
<a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a>
<!-- END switch_user_logged_in -->
<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
<a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a>
</span>
</td>
</tr>
</table>
<table width="90%" align="center" cellpadding="1" cellspacing="1" border="0" class="forumline">
<!-- BEGIN catrow -->
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" class="forumline">
<tr> 
<th height="22" colspan="2" align="left" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
<th width="50" height="22" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
<th width="50" height="22" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
<th width="130" height="22" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- BEGIN forumrow -->
<tr> 
<td class="row2" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
<td class="row2" width="100%" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br />
</span><span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
</span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
<td width="130" height="50" align="center" valign="middle" nowrap="nowrap" class="row2"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
</tr>
<!-- END forumrow -->
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
<br />
<!-- END catrow -->
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbwm.gif">
<tr> 
<td><img src="templates/aqua/images/aquatbwl.gif"></td>
<td valign="top"><a href="{U_VIEWONLINE}"><img src="templates/aqua/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" border="0" /></a><br /><br />
<span class="gensmall">{S_TIMEZONE}</span><br />
<span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}<br />
{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}<br />{L_ONLINE_EXPLAIN}
</span><br />
<!-- BEGIN switch_user_logged_in -->
<span class="gensmall">{LAST_VISIT_DATE}</span><br />
<!-- END switch_user_logged_in -->
<span class="gensmall">{CURRENT_TIME}</span><br />
</td>
<td align="right"><img src="templates/aqua/images/aquatbwr.gif"></td>
</tr>
</table>
<br clear="all" />
<table cellspacing="3" border="0" align="center" cellpadding="0">
<tr>
<td width="20" align="center"><img src="templates/aqua/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
<td><span class="gensmall">{L_NEW_POSTS}</span></td>
<td>&nbsp;&nbsp;</td>
<td width="20" align="center"><img src="templates/aqua/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
<td>&nbsp;&nbsp;</td>
<td width="20" align="center"><img src="templates/aqua/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
</tr>
</table>
