		<form name="form_image_upload" action="do_upload.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="selected" value="{SELECTED}">
		<input type="hidden" name="type" value="{TYPE}">

		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr height="30"><td></td></tr>
		<tr>
			<td width="140" valign="top"><b>Thumbnail Image:</b></td>
			<td>{THUMBNAIL_IMAGE}</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td valign="top"><b>New Thumbnail:</b></td>
			<td>
				<input type="file" name="imagefile" style="width: 270px">
				{OVERWRITE_WARNING}
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td></td>
			<td><input type="submit" value=" Upload "></td>
		</tr>
		</table>
		</form>