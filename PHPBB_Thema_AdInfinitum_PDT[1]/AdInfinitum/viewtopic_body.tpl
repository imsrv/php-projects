 
<table align="CENTER" class="forumline" width="717" cellspacing="1" cellpadding="5" border="0">
  <tr> 
    <th class="thCornerL" width="150" height="26" nowrap="nowrap">{L_AUTHOR}</th>
    <th class="thTop" nowrap="nowrap">{L_MESSAGE}</th>
  </tr>
  <tr> 
    <th colspan="6" align="left" height="28" class="nav" nowrap="nowrap"><a class="nav" href="{U_VIEW_FORUM}"><</a>&nbsp;&nbsp;<a class="nav" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a></th>
  </tr>
  {POLL_DISPLAY} 
  <!-- BEGIN postrow -->
  <tr>
    <td align="left" valign="MIDDLE" class="row3"><table width="100%" border="0" cellspacing="2" cellpadding="0"><td><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span></td></table></td>
    <td class="row3" height="28" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr> 
          <td width="100%"><a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: 
            {postrow.POST_DATE}<span class="gen">&nbsp;</span> 
            <!-- &nbsp; &nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span> -->
            </span></td>
          <td valign="top" nowrap="nowrap">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} 
            {postrow.DELETE_IMG} {postrow.IP_IMG}</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td class="{postrow.ROW_CLASS}" width="150" align="left" valign="top" bordercolor="#FFFFFF"> 
	
<table width="" border="1" cellspacing="" cellpadding="1" bordercolor="#2B2B2B" bgcolor="#FFFFFF">
  <tr>
    <td><div align="center">
	
<table width="">
  <tr>
    <td>{postrow.POSTER_AVATAR}</td>
	</tr>
</table>

	</div></td>
  </tr>
</table>


 <table width="100%" border="0" cellspacing="2" cellpadding="0"><td>
      <span class="postdetails">{postrow.POSTER_RANK}<br />
      {postrow.RANK_IMAGE}<br />
      <br />
      {postrow.POSTER_JOINED}<br />
      {postrow.POSTER_POSTS}<br />
      {postrow.POSTER_FROM}</span><br /></td></table></td>
    <td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><span class="postbody">{postrow.MESSAGE}{postrow.SIGNATURE}</span><span class="gensmall"><i>{postrow.EDITED_MESSAGE}</i></span></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td class="{postrow.ROW_CLASS}" width="150" align="left" valign="middle"><table width="100%" border="0" cellspacing="2" cellpadding="0"><td><span class="genmed"><a href="#top" class="genmed">{L_BACK_TO_TOP}</a></span></td></table></td>
    <td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
        <tr> 
          <td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} 
            {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} 
            {postrow.MSN_IMG} <script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {postrow.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{postrow.ICQ_STATUS_IMG}</div></div>');
				
				//--></script> <noscript>
            {postrow.ICQ_IMG}</noscript></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td class="spaceRow" colspan="2" height="1"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="1" height="1" /></td>
  </tr>
  <!-- END postrow -->
  <tr align="RIGHT"> 
    <td class="row1" colspan="2" height="28"><table cellspacing="0" cellpadding="0" border="0">
        <tr> 
          <form method="post" action="{S_POST_DAYS_ACTION}">
            <td align="center"><span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp; 
              <input type="submit" value="{L_GO}" class="liteoption" name="submit" />
              </span></td>
          </form>
        </tr>
      </table></td>
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
          <td align="LEFT" valign="TOP"><span class="genmed"><a href="{U_VIEW_NEWER_TOPIC}" class="genmed">{L_VIEW_NEXT_TOPIC}</a><br /><a href="{U_VIEW_OLDER_TOPIC}" class="genmed">{L_VIEW_PREVIOUS_TOPIC}</a></span></td>
          <td align="RIGHT" valign="TOP"><span class="gensmall">{PAGE_NUMBER}<br />
            {PAGINATION}</span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
            -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
<br>
<table align="CENTER" width="715" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
  </tr>
</table>
<br>
<table width="717" cellspacing="0" border="0" align="center">
  <tr> 
	<td width="40%" valign="top" nowrap="nowrap" align="left"><span class="gensmall">{S_WATCH_TOPIC}</span><br />
	  &nbsp;<br />
	  {S_TOPIC_ADMIN}</td>
	<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
  </tr>
</table>
<br />