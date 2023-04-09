 
<table width="717" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
  <tr> 
    <th width="4%" height="25" class="thCornerL" nowrap="nowrap">&nbsp;</th>
    <th class="thTop" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
    <th class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
    <th class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
    <th class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
    <th class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
    <th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  <tr align="LEFT"> 
    <th height="25" colspan="7" nowrap="nowrap" class="nav">{L_SEARCH_MATCHES}</th>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
    <td class="row1" align="center" valign="middle"><img src="{searchresults.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{searchresults.L_TOPIC_FOLDER_ALT}" title="{searchresults.L_TOPIC_FOLDER_ALT}" /></td>
    <td class="row1"><span class="gen"><a href="{searchresults.U_VIEW_FORUM}" class="gen">{searchresults.FORUM_NAME}</a></span></td>
    <td class="row2" onmouseover="this.style.backgroundColor='#E3E3E3'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{searchresults.U_VIEW_TOPIC}'"><span class="gen">{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="gen">{searchresults.TOPIC_TITLE}</a></span><br /> 
      <span class="gensmall">{searchresults.GOTO_PAGE}</span></td>
    <td class="row1" align="center" valign="middle"><span class="name">{searchresults.TOPIC_AUTHOR}</span></td>
    <td class="row2" align="center" valign="middle"><span class="postdetails">{searchresults.REPLIES}</span></td>
    <td class="row1" align="center" valign="middle"><span class="postdetails">{searchresults.VIEWS}</span></td>
    <td class="row2" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{searchresults.LAST_POST_TIME}<br />
      {searchresults.LAST_POST_AUTHOR} {searchresults.LAST_POST_IMG}</span></td>
  </tr>
  <!-- END searchresults -->
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
          <td align="LEFT" valign="TOP"></td>
          <td align="RIGHT" valign="TOP"><span class="gensmall">{PAGE_NUMBER}<br />
            {PAGINATION}</span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
<br>
<table align="center" width="717" cellspacing="0" border="0" cellpadding="0">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
