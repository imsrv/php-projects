
<h1>Upload Logo</h1>

<P>Here you can upload the logo of your site that will appear in most page headers. This MOD works well with the MOD, "Room for Bigger Logos", as it allows bigger logos to be diplayed without irregularity. Remember, the file name must be "logo_phpBB.gif".</p>
// edit logo-image by abcde

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" height="27">Upload</th>
	</tr>
	<tr>
		<td class="row1" align="center">
	<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="logo_confirm.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
<input name="userfile" type="file" />
<input type="submit" class="mainoption" name="add" value="Upload Logo" />
	</tr>
</table></form>
