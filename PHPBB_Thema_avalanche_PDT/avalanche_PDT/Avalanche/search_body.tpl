
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">
			<a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> {L_SEARCH}
		</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
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
<form action="{S_SEARCH_ACTION}" method="POST">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">Search</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table class="forumline" width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr> 
		<td class="cat" colspan="4" height="25">{L_SEARCH_QUERY}</td>
	</tr>
	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br /><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_keywords" size="30" /><br /><input type="radio" name="search_terms" value="any" checked="checked" /> {L_SEARCH_ANY_TERMS}<br /><input type="radio" name="search_terms" value="all" /> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br /><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_author" size="30" /></span></td>
	</tr>
	<tr> 
		<td class="cat" colspan="4" height="25">{L_SEARCH_OPTIONS}</td>
	</tr>
</table>
<table class="forumline" width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FORUM}:&nbsp;</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="search_forum">{S_FORUM_OPTIONS}</select></span></td>
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_SEARCH_PREVIOUS}:&nbsp;</span></td>
		<td class="row2" valign="middle"><span class="genmed"><select class="post" name="search_time">{S_TIME_OPTIONS}</select><br /><input type="radio" name="search_fields" value="all" checked="checked" /> {L_SEARCH_MESSAGE_TITLE}<br /><input type="radio" name="search_fields" value="msgonly" /> {L_SEARCH_MESSAGE_ONLY}</span></td>
	</tr>
	<tr> 
		<td class="row1" align="right"><span class="gen">{L_CATEGORY}:&nbsp;</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="search_cat">{S_CATEGORY_OPTIONS}
		</select></span></td>
		<td class="row1" align="right"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row2" valign="middle" nowrap="nowrap"><span class="genmed"><select class="post" name="sort_by">{S_SORT_OPTIONS}</select><br /><input type="radio" name="sort_dir" value="ASC" /> {L_SORT_ASCENDING}<br /><input type="radio" name="sort_dir" value="DESC" checked /> {L_SORT_DESCENDING}</span>&nbsp;</td>
	</tr>
	<tr> 
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row2" nowrap="nowrap"><input type="radio" name="show_results" value="posts" /><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked" />{L_TOPICS}</span></td>
		<td class="row1" align="right"><span class="gen">{L_RETURN_FIRST}</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="return_chars">{S_CHARACTER_OPTIONS}</select> {L_CHARACTERS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="28">{S_HIDDEN_FIELDS}<input class="liteoption" type="submit" value="{L_SEARCH}" /></td>
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

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>