<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%"><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" />
			<a href="{U_VIEW_FORUM}" class="thCenter">{FORUM_NAME}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> {TOPIC_TITLE}</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" class="forumline" cellspacing="0" cellpadding="5" border="0" align="center">
	<tr>
		<td class="cat"><div style="padding: 3px;">
			<img src="templates/Avalanche/images/icon_latest_reply.gif" /> <a href="{U_VIEW_OLDER_TOPIC}">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}">{L_VIEW_NEXT_TOPIC}</a></div>
		</td>
		<form method="post" action="{S_POST_DAYS_ACTION}">
		<td align="right" class="cat">
			<span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span>
		</td>
		</form>
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
		<td align="left"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

{POLL_DISPLAY}
<!-- BEGIN postrow -->
<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft_quote.gif" width="30"/></th>
		<th>{postrow.POST_DATE}</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table class="forumline" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="cat" width="150" nowrap="nowrap"><a href="{postrow.U_MINI_POST}"><img src="templates/Avalanche/images/arrow_down.gif" alt="" border="0" /></a> {L_AUTHOR}</td>
		<td class="cat" nowrap="nowrap">{L_MESSAGE}</td>
	</tr>
	<tr>
		<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}</span><br /></td>
		<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><span class="postdetails"><b>{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</b></span></td>
				<td valign="top" nowrap="nowrap">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} {postrow.DELETE_IMG} {postrow.IP_IMG}</td>
			</tr>
			<tr> 
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><span class="postbody">{postrow.MESSAGE}{postrow.SIGNATURE}</span><span class="gensmall">{postrow.EDITED_MESSAGE}</span></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="{postrow.ROW_CLASS}" width="150" align="left" valign="middle">&nbsp;</td>
		<td class="{postrow.ROW_CLASS}" width="100%" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" width="18">
			<tr> 
				<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {postrow.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{postrow.ICQ_STATUS_IMG}</div></div>');
				
				//--></script><noscript>{postrow.ICQ_IMG}</noscript></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td colspan="2" class="row2"></td>
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
<!-- END postrow -->


<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td align="left"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th>&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td class="cat" valign="top" nowrap="nowrap"><span class="gensmall">{S_AUTH_LIST}</span></td>
		<td class="cat" width="50%" valign="top" nowrap="nowrap" align="left">
			<span class="gensmall">{S_WATCH_TOPIC}</span><br /><br />{S_TOPIC_ADMIN}
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

<br clear="all" />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>
