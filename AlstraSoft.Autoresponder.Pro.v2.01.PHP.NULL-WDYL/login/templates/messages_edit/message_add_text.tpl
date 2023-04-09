<form name="form_message_add" action="do_add_message.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Add new message: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">
		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Message Type:</b></td>
			<td>[ <b>plain text</b> ] [ <a href="messages_edit.php?type=html">html enhanced</a> ]</td>
			<input type="hidden" name="type" value="">
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>
				<input type="checkbox" class="noborder" name="disabled">&nbsp;<b>Disable</b>
			</td>
			<td>
				<font size="1">You can temporarily disable a message, so that it won't be delivered to your prospects until you re-enable it.</font>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>
				<b>Interval:</b>
			</td>
			<td>
				<input type="text" name="interval" value="0" size="5">
				&nbsp;(max. 9999) 
			</td>
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
			<td colspan="2"><input type="submit" value="Add Message"></td>
		</tr>
		</table>
	</td>
</tr>
</form>
