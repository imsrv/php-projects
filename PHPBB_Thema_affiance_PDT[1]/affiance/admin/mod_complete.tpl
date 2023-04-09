<script language="JavaScript" type="text/javascript">
<!--
function helpwin(mylink)
{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
		href=mylink;
	else
		href=mylink.href;
	window.open(href, 'easymod_help', 'width=800,height=600,scrollbars=yes');
	return false;
}
//-->
</script>

<h2>{L_STEP}</h2> 
<h3>{L_COMPLETE}</h3>
<p>{L_COMP_DESC}</p>

<form action="{S_ACTION}" name="install" method="post">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL" colspan="2" width="100%">{L_MOD_DATA}</th>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_MOD_TITLE}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{TITLE} &nbsp;&nbsp;&nbsp; {VERSION} &nbsp;&nbsp;&nbsp; {MOD_FILE}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_AUTHOR}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{AUTHOR} &nbsp;&nbsp;&nbsp; {EMAIL} &nbsp;&nbsp;&nbsp; {REAL_NAME} &nbsp;&nbsp;&nbsp; <a href="{URL}" target="_blank">{URL}</a></span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_THEMES}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{THEMES}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_LANGUAGES}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{LANGUAGES}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_FILES}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{FILES}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_PROCESSED}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{PROCESSED}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">{L_UNPROCESSED}:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">{UNPROCESSED}</span></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="25%"><span class="gen">Database Alterations:</span></td>
		<td class="row2" align="left" width="75%"><span class="gen">Tables Added: N/A&nbsp;&nbsp;&nbsp; Tables Altered: N/A&nbsp;&nbsp;&nbsp; Rows Added: N/A</span></td>
	</tr>
</table>
</form>

<br />
<form action="{S_ACTION}" method="post">
<input type="hidden" name="mode" value="download_backup">
<input type="hidden" name="install_file" value="{MOD_FILE}">
<input type="hidden" name="install_path" value="{MOD_PATH}">
<input type="hidden" name="mod_count" value="{MOD_COUNT}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL" colspan="2">{L_MAKING_BACKUPS}</th>
	</tr>
	<!-- BEGIN backups -->
	<tr>
		<td class="row1" align="left" height=25 width="50%"><span class="gen">{backups.FROM}</span></td>
		<td class="row2" align="left" height=25 width="50%"><span class="gen">{backups.TO}</span></td>
	</tr>
	<!-- END backups -->
</table>
</form>

<br />
<table width="100%">
<tr><td><span class="gen">THIS TEXT WILL DEPEND ON MOVE METHOD:</span></td></tr>
<tr><td>
<form action="{S_ACTION}" method="post">
<input type="hidden" name="mode" value="download_file">
<input type="hidden" name="install_file" value="{MOD_FILE}">
<input type="hidden" name="install_path" value="{MOD_PATH}">
<input type="hidden" name="mod_count" value="{MOD_COUNT}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thCornerL">{L_COPY_FROM}</th>
		<th class="thCornerR">{L_COPY_TO}</th>
		<th class="thCornerR">{L_COPY_STATUS}</th>
	</tr>
	<!-- BEGIN files -->
	<tr>
		<td class="row1" align="left" height=25 width="50%"><span class="gen">{files.FROM}</span></td>
		<td class="row2" align="left" height=25 width="50%"><span class="gen">{files.TO}</span></td>
		<td class="row2" align="left" height=25 width="*"><span class="gen">{files.COMPLETED}</span></td>
	</tr>

	<!-- END files -->
</table>
</form>
</td></tr></table>

