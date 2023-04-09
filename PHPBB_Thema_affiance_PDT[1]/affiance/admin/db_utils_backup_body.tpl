
<h1>{L_DATABASE_BACKUP}</h1>

<P>{L_BACKUP_EXPLAIN}</p>

<form method="post" action="{S_DBUTILS_ACTION}"><table cellspacing="0" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2" class="thHead">{L_BACKUP_OPTIONS}</th>
	</tr>
	<tr>
		<td class="row2"><span class="gen">{L_FULL_BACKUP}</span></td>
		<td class="row2"><input type="radio" name="backup_type" value="full" checked /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_STRUCTURE_BACKUP}</span></td>
		<td class="row1"><input type="radio" name="backup_type" value="structure" /></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">{L_DATA_BACKUP}</span></td>
		<td class="row2"><input type="radio" name="backup_type" value="data" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_ADDITIONAL_TABLES}</span></td>
		<td class="row1"><input class="post" type="text" name="additional_tables" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_GZIP_COMPRESS}</span></td>
		<td class="row1"><span class="gen">{L_NO} <input type="radio" name="gzipcompress" value="0" checked /> &nbsp;{L_YES} <input type="radio" name="gzipcompress" value="1" /></span></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="backupstart" value="{L_START_BACKUP}" class="mainoption" /></td>
	</tr>
</table></form>
