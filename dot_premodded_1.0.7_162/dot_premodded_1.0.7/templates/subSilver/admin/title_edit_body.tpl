
<h1>{ADMIN_TITLE}</h1>

<p>{ADMIN_TITLE_EXPLAIN}</p>

<form action="{S_TITLE_ACTION}" method="post"><table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th class="thTop" colspan="2">{L_TITLE_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_TITLE_INFO}</span></td>
		<td class="row2"><input class="post" type="text" name="title_info" size="35" maxlength="255" value="{TITLE_INFO}" /></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_PERM_INFO}</span><br />		<span class="gensmall">{L_PERM_EXPLAIN}</span></td>
		<td class="row2"><span class="post"><input type="checkbox" name="admin_auth" {ADMIN_CHECKED}/>&nbsp;{ADMIN}</br><input type="checkbox" name="mod_auth" {MOD_CHECKED}/>&nbsp;{MODERATOR}</br><input type="checkbox" name="poster_auth" {POSTER_CHECKED}/>&nbsp;{POSTER}</span></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_DATE_FORMAT}</span><br />		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="date_format" size="15" maxlength="255" value="{DATE_FORMAT}" /></td>
	</tr>

	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>