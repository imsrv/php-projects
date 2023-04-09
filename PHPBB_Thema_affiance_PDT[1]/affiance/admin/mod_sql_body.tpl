<h2>{L_STEP}</h2> 
<h3>{L_ALTERATIONS}</h3>
<p>{L_SQL_INTRO}</p>

<form method="post" action="{S_ACTION}">
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="90%" class="thCornerL" height="25">{L_PSEUDO}</th>
	<th width="10%" height="25" class="thCornerR">{L_ALLOW}</th>
  </tr>
  <!-- xBEGIN sql_row -->
<!--
  <tr> 
	<td width="90%" class="{sql_row.ROW_CLASS}">&nbsp;<span class="gen">{sql_row.DISPLAY_SQL}</span>&nbsp;</td>
	<td width="10%" align="center" class="{sql_row.ROW_CLASS}">
		<input type="hidden" name="{sql_row.CHECK_NAME}" value="{sql_row.SQL}">
		<input type="checkbox" name="check_{sql_row.CHECK_NAME}" checked="checked">
	</td>
  </tr>
-->
<tr><td colspan="2" class="row1" height="40" valign="middle"><span class="gen">{L_SQL_ALPHA2}</td></tr>
  <!-- xEND sql_row -->

  <tr>
	<td class="catBottom"  colspan="2" align="center" height="28">
		{HIDDEN}
		<input type="hidden" name="mode" value="post_process">
		<input type="hidden" name="SQL_lines" value="{SQL_LINES}">
		<input type="hidden" name="themes" value="{THEMES}">
		<input type="hidden" name="languages" value="{LANGUAGES}">
		<input type="hidden" name="files" value="{FILES}">
		<input type="hidden" name="num_proc" value="{PROCESSED}">
		<input type="hidden" name="num_unproc" value="{UNPROCESSED}">
		<input type="hidden" name="install_file" value="{MOD_FILE}">
		<input type="hidden" name="install_path" value="{MOD_PATH}">
		<input type="hidden" name="password" value="{EM_PASS}">
		<input type="submit" name="post" class="mainoption" value="{L_COMPLETE}" /></center>
	</td>
  </tr>
</table>
<br />
</form>
<br />
