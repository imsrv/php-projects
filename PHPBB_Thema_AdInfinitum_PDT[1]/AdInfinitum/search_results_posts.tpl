<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th class="thTop" height="25" width="150"><b>{L_AUTHOR}</b></th>
    <th class="thTop" nowrap="nowrap"><b>{L_MESSAGE}</b></th>
  </tr>
  <tr align="LEFT"> 
    <th height="25" colspan="2" class="nav"><span class="maintitle">{L_SEARCH_MATCHES}</span></th>
	</tr>
</table>






<table border="0" cellpadding="3" cellspacing="1" width="717" class="forumline" align="center">
  <!-- BEGIN searchresults -->
  <tr> 
    <td class="row2" colspan="2" height="28"><span class="gen">{L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="gen">{searchresults.TOPIC_TITLE}</a></span></td>
  </tr>
  <tr> 
    <td width="150" align="left" valign="top" class="row1" rowspan="2"><span class="name">{searchresults.POSTER_NAME}</span><br /> 
      <br /> <span class="postdetails">{L_REPLIES}: {searchresults.TOPIC_REPLIES}<br />
      {L_VIEWS}: {searchresults.TOPIC_VIEWS}</span><br /> </td>
    <td valign="top" class="row1"><img src="{searchresults.MINI_POST_IMG}" width="12" height="9" alt="{searchresults.L_MINI_POST_ALT}" title="{searchresults.L_MINI_POST_ALT}" border="0" /><span class="postdetails">{L_FORUM}:&nbsp;<a href="{searchresults.U_FORUM}" class="postdetails">{searchresults.FORUM_NAME}</a>&nbsp; 
      &nbsp;{L_POSTED}: {searchresults.POST_DATE}&nbsp; &nbsp;{L_SUBJECT}: <a href="{searchresults.U_POST}">{searchresults.POST_SUBJECT}</a></span></td>
  </tr>
  <tr> 
    <td valign="top" class="row1"><span class="postbody">{searchresults.MESSAGE}</span></td>
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
