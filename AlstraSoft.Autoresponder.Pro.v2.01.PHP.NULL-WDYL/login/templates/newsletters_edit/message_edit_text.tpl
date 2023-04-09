<form name="form_message_edit" action="do_modify_message.php" method="post">
<input type="hidden" name="template_id" value="{TEMPLATE_ID}">
<input type="hidden" name="message_id" value="{MESSAGE_ID}">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Edit newsletter: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="{SUBJECT}" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Newsletter Type:</b></td>
			<td>[ <b>plain text</b> ] [ <a href="newsletters_edit.php?selected={SELECTED}&type=html">html enhanced</a> ]</td>
			<input type="hidden" name="type" value="">
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>
				<input type="checkbox" class="noborder" name="disabled" {DISABLED}>&nbsp;<b>Disable</b>
			</td>
			<td>
				<font size="1">You can temporarily disable a newsletter, so that it won't be delivered to your prospects until you re-enable it.</font>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>
				<b>Interval:</b>
			</td>
			<td>
				<input type="text" name="interval" value="{INTERVAL}" size="5">
				&nbsp;(max. 9999) 
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2">
				<b>Body:</b><br>
				<textarea name="body" cols="60" rows="15">{BODY}</textarea>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2"><input type="submit" value="Update Newsletter"></td>
		</tr>
		</table>
	</td>
</tr>
</form>
