<!-- <form method="post" action="{S_POST_DAYS_ACTION}"> -->
<table align="CENTER" class="forumline" border="0" cellpadding="4" cellspacing="1" width="717">
  <tr> 
    <th colspan="2" align="center" height="25" class="thCornerL" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
    <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
    <th width="100" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
    <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
    <th align="center" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  <tr> 
    <th colspan="6" align="left" height="28" class="nav" nowrap="nowrap"><a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></th>
  </tr>
  <!-- BEGIN topicrow -->
  <tr> 
    <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
    <td class="row1" width="100%" onmouseover="this.style.backgroundColor='#232323'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{topicrow.U_VIEW_TOPIC}'"><span class="genmed">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="genmed">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
      {topicrow.GOTO_PAGE}</span></td>
    <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
    <td class="row2" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
    <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
    <td class="row3" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />
      {topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
  </tr>
  <!-- END topicrow -->
  <!-- BEGIN switch_no_topics -->
  <tr> 
    <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen"><br />{L_NO_TOPICS}<br /><br /></span></td>
  </tr>
  <!-- END switch_no_topics -->
  <!--
	<tr> 
	  <td class="catBottom" align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp; 
		<input type="submit" class="liteoption" value="{L_GO}" name="submit" />
		</span></td>
	</tr>
	-->
</table>
<table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left"><span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_TOPICS_READ}</a></span></td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr><th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="LEFT" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="LEFT" valign="TOP"><span class="gensmall">{L_MODERATOR}: {MODERATORS}<br />{LOGGED_IN_USER_LIST}</span></td>
          <td align="RIGHT" valign="TOP"><span class="gensmall">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>



<br>
<table align="CENTER" width="715" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
  </tr>
</table>
<br>
  <!-- </form> -->
  <table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td align="right">{JUMPBOX}</td>
    </tr>
  </table>
  <table width="717" cellspacing="0" border="0" align="center" cellpadding="0">
    <tr> 
      <td align="left" valign="top"><table cellspacing="3" cellpadding="0" border="0">
          <tr> 
            <td width="20" align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="19" height="18" /></td>
            <td class="gensmall">{L_NEW_POSTS}</td>
            <td>&nbsp;&nbsp;</td>
            <td width="20" align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="19" height="18" /></td>
            <td class="gensmall">{L_NO_NEW_POSTS}</td>
            <td>&nbsp;&nbsp;</td>
            <td width="20" align="center"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" width="19" height="18" /></td>
            <td class="gensmall">{L_ANNOUNCEMENT}</td>
          </tr>
          <tr> 
            <td width="20" align="center"><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" width="19" height="18" /></td>
            <td class="gensmall">{L_NEW_POSTS_HOT}</td>
            <td>&nbsp;&nbsp;</td>
            <td width="20" align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" width="19" height="18" /></td>
            <td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
            <td>&nbsp;&nbsp;</td>
            <td width="20" align="center"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" width="19" height="18" /></td>
            <td class="gensmall">{L_STICKY}</td>
          </tr>
          <tr> 
            <td class="gensmall"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_TOPIC_LOCKED}" width="19" height="18" /></td>
            <td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
            <td>&nbsp;&nbsp;</td>
            <td class="gensmall"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_TOPIC_LOCKED}" width="19" height="18" /></td>
            <td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
          </tr>
        </table></td>
      <td align="right"><span class="gensmall">{S_AUTH_LIST}</span></td>
    </tr>
  </table>
  <br />
