<br>
<h2>{L_SETTINGS}</h2>
<p>{L_DESC}</p>
<form action="{S_ACTION}" name="settings" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<th colspan="2">{L_PW_TITLE}</th>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2"><span class="gen">{L_PW_DESC}</span></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_PW_SET}</span></td>
		<td class="row2"><input type="password" name="em_pass" value="{EM_PASS}"></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_PW_CONFIRM}</span></td>
		<td class="row2"><input type="password" name="em_pass_confirm" value=""></td>
	</tr>
	<tr>
		<th colspan="2">{L_FILE_TITLE}</th>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2"><span class="gen">{L_FILE_DESC}</span></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FILE_READ}</span></td>
		<td class="row2"><select style="width:140px" name="sel_read">{SELECT_READ}</select></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FILE_WRITE}</span></td>
		<td class="row2"><select style="width:140px" name="sel_write">{SELECT_WRITE}</select></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FILE_MOVE}</span></td>
		<td class="row2"><select style="width:140px" name="sel_move">{SELECT_MOVE}</select></td>
	</tr>


	<tr>
		<th colspan="2">{L_FTP_TITLE}</th>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2"><span class="gen">{L_FTP_DESC}</span></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FTP_DIR}</span></td>
		<td class="row2"><input type="text" name="ftp_dir" value="{FTP_PATH}"> (ex: public_html/phpBB2)</td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FTP_USER}</span></td>
		<td class="row2"><input type="text" name="ftp_user" value="{FTP_USER}"></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FTP_PASS}</span></td>
		<td class="row2"><input type="password" name="ftp_pass" value="{FTP_PASS}"></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FTP_HOST}</span></td>
		<td class="row2"><input type="text" name="ftp_host" value="{FTP_HOST}"></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_FTP_EXT}</span></td>
		<td class="row2">
			<input type="radio" name="ftp_type" value="ext" {FTP_EXT}><span class="gen">{L_YES}</span>&nbsp;&nbsp;
			<input type="radio" name="ftp_type" value="fsock" {FTP_FSOCK}>{L_NO}</span>&nbsp;&nbsp;<span class="gen">{L_FTP_EXT_WARN}</span>
		</td>
	</tr>
	<tr> 
		<td class="catbottom" align="center" colspan="2">
			<?php echo "$hidden\n"; ?>
			<input type="hidden" name="mode" value="{MODE}">
			<input class="mainoption" type="submit" value="{L_SUBMIT}" />&nbsp;
		</td>
	</tr>
</table>
</form>
