<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft">
			<img src="templates/Avalanche/images/thLeft.gif" width="30"/>
		</th>
		<th width="100%">
			<a href="{U_INDEX}" class="thCenter">{L_INDEX}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" />
			<a href="{U_SEARCH}" class="thCenter">{L_SEARCH}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> Search Results
		</th>
		<th class="thRight">
			<img src="templates/Avalanche/images/thRight.gif" width="30"/>
		</th>
	</tr>
</table>
<table width="100%" class="forumline" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left" class="cat">{L_SEARCH_MATCHES}</td>
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

<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">Search Results</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="2" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
		<td width="4%" height="25" class="cat" nowrap="nowrap">&nbsp;</th>
		<td class="cat" nowrap="nowrap">{L_FORUM}</td>
		<td class="cat" nowrap="nowrap">{L_TOPICS}</td>
		<td class="cat" nowrap="nowrap">{L_AUTHOR}</td>
		<td class="cat" nowrap="nowrap">{L_REPLIES}</td>
		<td class="cat" nowrap="nowrap">{L_VIEWS}</td>
		<td class="cat" nowrap="nowrap">{L_LASTPOST}</td>
	</tr>
	<!-- BEGIN searchresults -->
	<tr>
		<td class="row1" align="center" valign="middle"><img src="{searchresults.TOPIC_FOLDER_IMG}" width="20" height="20" alt="{searchresults.L_TOPIC_FOLDER_ALT}" title="{searchresults.L_TOPIC_FOLDER_ALT}" /></td>
		<td class="row1"><span class="forumlink"><a href="{searchresults.U_VIEW_FORUM}" class="forumlink">{searchresults.FORUM_NAME}</a></span></td>
		<td class="row2"><span class="topictitle">{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span><br /><span class="gensmall">{searchresults.GOTO_PAGE}</span></td>
		<td class="row1" align="center" valign="middle"><span class="name">{searchresults.TOPIC_AUTHOR}</span></td>
		<td class="row2" align="center" valign="middle"><span class="postdetails">{searchresults.REPLIES}</span></td>
		<td class="row1" align="center" valign="middle"><span class="postdetails">{searchresults.VIEWS}</span></td>
		<td class="row2" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{searchresults.LAST_POST_TIME}<br />{searchresults.LAST_POST_AUTHOR} {searchresults.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END searchresults -->
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

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>
