<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
	<!-- BEGIN switch_user_logged_in -->
		<td class="tab2"><span class="tab">{LAST_VISIT_DATE}</td>
	<!-- END switch_user_logged_in -->
		<td
	<!-- BEGIN switch_user_logged_out -->
		width="50%"
	<!-- END switch_user_logged_out -->
		 class="tab2"><span class="tab">{S_TIMEZONE}</span></td>
		<td class="tab2right"><span class="tab">{CURRENT_TIME}</span></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<th class="cattitle" colspan="4" style="border:solid #232323;border-width:1 1 2 1"><a href="{U_INDEX}" class="cattitle">{L_INDEX}</a></th>
	</tr>
</table>
<br />
<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr>
	<!-- BEGIN switch_user_logged_in -->
		<td class="tabs"><a href="{U_SEARCH_NEW}" class="tab">{L_SEARCH_NEW}</a></td>
		<td class="tabs"><a class="tab" href="{U_SEARCH_SELF}">{L_SEARCH_SELF}</a></td>
	<!-- END switch_user_logged_in -->
		<td class="tabs"><a href="{U_SEARCH_UNANSWERED}" class="tab">{L_SEARCH_UNANSWERED}</a></td>
		<td class="tabs" style="border-right-width:1px;"><a class="tab" href="{U_MARK_READ}">{L_MARK_FORUMS_READ}</td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" class="forumline">
  <tr> 
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  <tr>
	<td colspan="4" style="line-height:2px;">&nbsp;</td>
  </tr>
  <!-- BEGIN catrow -->
  <tr> 
	<td class="catLeft" colspan="2" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="catLeft" colspan="3" align="right">&nbsp;</td>
  </tr>
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="row1" align="center" valign="middle"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="25" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" width="100%" style="border-right:solid 1px #232323;"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br />
	  </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  </span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
	<td class="row2" align="center" valign="middle" style="border-right:solid 1px #232323;"><span class="genmed">{catrow.forumrow.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" style="border-right:solid 1px #232323;"><span class="genmed">{catrow.forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" nowrap="nowrap"> <span class="genmed">{catrow.forumrow.LAST_POST}</span></td>
  </tr>
   <!-- END forumrow -->
    <!-- END catrow -->
</table>
<br clear="all" />

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="templates/affiance/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/affiance/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/affiance/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>
<br />

<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
  <tr> 
	<td class="catHead" style="border-style:none;" colspan="3" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
  </tr>
  <tr>
	<td class="tab2" style="border-width:1 1 0 0;">{TOTAL_USERS}</td>
	<td class="tab2" style="border-width:1 1 0 0;">{TOTAL_POSTS}</td>
	<td class="tab2" style="border-width:1 0 1 0;">{RECORD_USERS}</td>
  </tr>
  <tr>
	<td colspan="3" class="row1" align="left" ><span class="gensmall">{NEWEST_USER} <br /> {TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />
	{LOGGED_IN_USER_LIST}</span></td>
  </tr>
 <tr>
	<td colspan="3" class="tabs" style="border-width:0 0 0 0;">{L_ONLINE_EXPLAIN}</td>
 </tr>
</table>
<!-- BEGIN switch_user_logged_out -->
<br />
<form method="post" action="{S_LOGIN_ACTION}">
  <table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="catHead" height="28" style="border-style:none;"><a name="login"></a><span class="cattitle">{L_LOGIN_LOGOUT}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="center" valign="middle" height="28"><span class="gensmall">{L_USERNAME}: 
		<input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;&nbsp;{L_PASSWORD}: 
		<input class="post" type="password" name="password" size="10" maxlength="32" />
		&nbsp;&nbsp; &nbsp;&nbsp;{L_AUTO_LOGIN} 
		<input class="text" type="checkbox" name="autologin" />
		&nbsp;&nbsp;&nbsp; 
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
		</span> </td>
	</tr>
  </table>
</form>
<!-- END switch_user_logged_out -->