<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>Edit template: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">

		<form id="form_message_edit" action="do_modify_message.php" method="post">
		<input type="hidden" name="message_id" value="{MESSAGE_ID}">
		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="{SUBJECT}" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Message Type:</b></td>
			<td>[ <a href="newsletter_templates.php?selected={SELECTED}&type=text">plain text</a> ] [ <b>html enhanced</b> ]</td>
			<input type="hidden" name="type" value="html">
		</tr>
		<textarea name="body" style="display: none" cols="60" rows="15">{BODY}</textarea>
		</form>

		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2">
				<b>Body:</b><br><br>

				<!-- HTML EDITOR -->
				<object id="richedit" style="BACKGROUND-COLOR: buttonface" data="../login/rte/richedit.html" 
				width="600" height="300" type="text/x-scriptlet" VIEWASTEXT>
				</object>

				<!-- Glue to populate the editor with HTML from database -->
				<SCRIPT language="JavaScript" event="onload" for="window">
					richedit.options = "history=yes;source=no;";
					richedit.docHtml = form_message_edit.body.innerText;
				</SCRIPT>
				<!-- HTML EDITOR -->

			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2"><input type="button" value="Update Template" onClick="MakeSubmit();"></td>
		</tr>
		</table>

		{THUMBNAIL_FORM}

	</td>
</tr>

<script language="JavaScript">
function MakeSubmit()
{
	form_message_edit.body.value = richedit.docHtml;
	form_message_edit.submit();	
}
</script>
