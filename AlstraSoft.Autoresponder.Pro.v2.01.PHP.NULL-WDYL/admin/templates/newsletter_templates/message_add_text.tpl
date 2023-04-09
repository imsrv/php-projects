<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Add new template: </b>
	</td>
	<td bgColor="white" valign="top">

		<form name="form_message_add" action="do_add_message.php" method="post">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Message Type:</b></td>
			<td>[ <b>plain text</b> ] [ <a href="newsletter_templates.php?type=html">html enhanced</a> ]</td>
			<input type="hidden" name="type" value="">
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2">
				<b>Body:</b><br>
				<textarea name="body" cols="60" rows="15"></textarea>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2"><input type="submit" value="Add Template"></td>
		</tr>
		</table>
		</form>

		{THUMBNAIL_FORM}

	</td>
</tr>
