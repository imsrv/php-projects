<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th style="height: 20px;" class="thLeft">
			<img src="templates/Avalanche/images/thLeft.gif" width="30"/>
		</th>
		<th style="height: 20px;" width="100%">
			<a href="{U_INDEX}" class="thCenter">{L_INDEX}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" />
			<a href="{U_SEARCH}" class="thCenter">{L_SEARCH}</a>
			<img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> Search Results
		</th>
		<th style="height: 20px;" class="thRight">
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
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="forumline" align="center">
	<tr>
		<td width="150" height="25" class="cat" nowrap="nowrap">{L_AUTHOR}</td>
		<td class="cat" nowrap="nowrap">{L_MESSAGE}</td>
	</tr>
	<!-- BEGIN searchresults -->
	<tr>
		<td class="row3" colspan="2" height="28"><span class="topictitle"><img src="templates/Avalanche/images/folder.gif" align="absmiddle">&nbsp; {L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span></td>
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
