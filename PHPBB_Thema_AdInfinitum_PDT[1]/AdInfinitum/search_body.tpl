<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th class="thTop" colspan="2" height="25"><b>{L_SEARCH_QUERY}</b></th>
  </tr>
</table>
<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th colspan="1" align="left" height="28" class="nav" nowrap="nowrap">{L_SEARCH_QUERY}</th>
  </tr>
</table>





  <table align="CENTER" class="forumline" width="717" cellpadding="4" cellspacing="1" border="0">
<form action="{S_SEARCH_ACTION}" method="POST">
	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br /><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_keywords" size="30" /><br /><input type="radio" name="search_terms" value="any" checked="checked" /> {L_SEARCH_ANY_TERMS}<br /><input type="radio" name="search_terms" value="all" /> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br /><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_author" size="30" /></span></td>
	</tr>
	<tr align="LEFT"> 
		<th height="25" colspan="4" class="nav">{L_SEARCH_OPTIONS}</th>
	</tr>
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
	<tr align="RIGHT"> 
		<td class="row3" colspan="4" height="28">{S_HIDDEN_FIELDS}<input class="liteoption" type="submit" value="{L_SEARCH}" /></td>
	</tr>
	</form>
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
          <td align="RIGHT" valign="TOP"><span class="gensmall"></span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>
