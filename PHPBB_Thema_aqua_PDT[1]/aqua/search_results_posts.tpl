 
<table width="90%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr> 
<td align="left" valign="bottom"><span class="maintitle">{L_SEARCH_MATCHES}</span><br /></td>
</tr>
</table>

<table width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr> 
<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="90%" class="forumline" align="center">
<tr> 
<th width="150" height="25" class="thCornerL" nowrap="nowrap">{L_AUTHOR}</th>
<th width="100%" class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
</tr>
<!-- BEGIN searchresults -->
<tr> 
<td class="catHead" colspan="2" height="28"><span class="topictitle"><img src="templates/aqua/images/folder.gif" align="absmiddle">&nbsp; {L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span></td>
</tr>
<tr> 
<td width="150" align="left" valign="top" class="row1" rowspan="2"><span class="name"><b>{searchresults.POSTER_NAME}</b></span><br />
<br />
<span class="postdetails">{L_REPLIES}: <b>{searchresults.TOPIC_REPLIES}</b><br />
  {L_VIEWS}: <b>{searchresults.TOPIC_VIEWS}</b></span><br />
</td>
<td width="100%" valign="top" class="row1"><img src="{searchresults.MINI_POST_IMG}" width="12" height="9" alt="{searchresults.L_MINI_POST_ALT}" title="{searchresults.L_MINI_POST_ALT}" border="0" /><span class="postdetails">{L_FORUM}:&nbsp;<b><a href="{searchresults.U_FORUM}" class="postdetails">{searchresults.FORUM_NAME}</a></b>&nbsp; &nbsp;{L_POSTED}: {searchresults.POST_DATE}&nbsp; &nbsp;{L_SUBJECT}: <b><a href="{searchresults.U_POST}">{searchresults.POST_SUBJECT}</a></b></span></td>
</tr>
<tr>
<td valign="top" class="row1"><span class="postbody">{searchresults.MESSAGE}</span></td>
</tr>
<!-- END searchresults -->
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
<table width="90%" cellspacing="0" border="0" align="center" cellpadding="0">
<tr> 
<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span><br /><span class="gensmall">{S_TIMEZONE}</span></td>
</tr>
</table>

<table width="90%" border="0" align="center">
<tr> 
<td valign="top" align="right">{JUMPBOX}</td>
</tr>
</table>
