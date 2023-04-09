<table width="90%" border="0" align="center">
<tr>
<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a><br />
<span class="gensmall"><b>{PAGINATION}</b><br />
&nbsp; </span></td>
</tr>
</table>

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
<td align="left" valign="bottom" nowrap="nowrap"><span class="nav"><a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>
  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr1.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="forumline">
<tr align="right">
<td class="catHead" colspan="2" height="28"><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
</tr>
{POLL_DISPLAY}
</table>
<!-- BEGIN postrow -->
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="forumline">
<tr>
<th class="thLeft" width="150" height="26" nowrap="nowrap">{L_AUTHOR}</th>
<th class="thRight" nowrap="nowrap">{L_MESSAGE}</th>
</tr>
<tr>
<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="9" height="9"><img src="templates/aqua/images/profileul.gif" width="9" height="9"></td>
    <td height="9" background="templates/aqua/images/profileum.gif"></td>
    <td width="9" height="9"><img src="templates/aqua/images/profileur.gif" width="9" height="9"></td>
  </tr>
  <tr>
    <td width="9" background="templates/aqua/images/profileml.gif"></td>
    <td background="templates/aqua/images/profilemm.gif"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}</span><br /></td>
    <td width="9" background="templates/aqua/images/profilemr.gif"></td>
  </tr>
  <tr>
    <td width="9" height="9"><img src="templates/aqua/images/profiledl.gif" width="9" height="9"></td>
    <td height="9" background="templates/aqua/images/profiledm.gif"></td>
    <td width="9" height="9"><img src="templates/aqua/images/profiledr.gif" width="9" height="9"></td>
  </tr>
</table></td>
<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="100%"><a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: {postrow.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
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
<td class="{postrow.ROW_CLASS}" width="150" align="left" valign="middle"><a href="#top" class="nav"><img src="templates/aqua/images/top.gif" alt="{L_BACK_TO_TOP}" border="0"></a></td>
<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
<tr>
<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}
<script language="JavaScript" type="text/javascript"><!--

if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
document.write(' {postrow.ICQ_IMG}');
else
document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.ICQ_IMG}</div><div style="position:absolute;left:5px;top:1px">{postrow.ICQ_STATUS_IMG}</div></div>');

//--></script><noscript>{postrow.ICQ_IMG}</noscript></td>
</tr>
</table></td>
</tr>
<!-- END postrow -->
</table>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="forumline">
<tr align="center">
<td class="catBottom" colspan="2" height="28"><table cellspacing="0" cellpadding="0" border="0">
<tr><form method="post" action="{S_POST_DAYS_ACTION}">
<td align="center"><span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span></td>
</form></tr>
</table></td>
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
<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>
  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span>
</td>
</tr>
<tr>
<td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
</tr>
</table>

<table width="90%" cellspacing="2" border="0" align="center">
<tr>
<td width="40%" valign="top" nowrap="nowrap" align="left"><span class="gensmall">{S_WATCH_TOPIC}</span><br />
&nbsp;<br />
{S_TOPIC_ADMIN}</td>
<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
</tr>
</table>