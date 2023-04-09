<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>New broadcast message: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">

		<form id="form_broadcast_dumb" onSubmit="return false;">
		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Message Type:</b></td>
			<td>[ <a href="messages_broadcast.php">plain text</a> ] [ <b>html enhanced</b> ]</td>
		</tr>
		</form>

		<tr height="10"><td></td></tr>
		<tr>
			<td colspan="2">
				<b>Body:</b><br><br>

				<!-- HTML EDITOR -->
				<object id="richedit" style="BACKGROUND-COLOR: buttonface" data="rte/richedit.html" 
				width="600" height="300" type="text/x-scriptlet" VIEWASTEXT>
				</object>

				<!-- Glue to populate the editor with HTML from database -->
				<SCRIPT language="JavaScript" event="onload" for="window">
					richedit.options = "history=yes;source=no;";
					richedit.docHtml = "";
				</SCRIPT>
				<!-- HTML EDITOR -->

			</td>
		</tr>
		<tr height="10"><td></td></tr>

		<form id="form_broadcast" action="do_broadcast.php" method="post">
		<!-- hidden items -->
		<input type="hidden" name="type" value="html">
		<input type="hidden" name="subject" value="">
		<textarea name="body" style="display: none" cols="60" rows="15"></textarea>
		<!-- end hidden items -->

		<tr>
			<td valign="top"><b>Delivery Date:</b></td>
			<td>
				<input type="radio" name="delivery_type" value="asap" class="noborder" checked>Deliver ASAP<br>
				<input type="radio" name="delivery_type" value="future" class="noborder">Deliver in future:
				&nbsp;&nbsp;<select 
				name="delivery_day">
				{DAY_LIST}
				</select>&nbsp;<select 
				name="delivery_month">
				{MONTH_LIST}
				</select>&nbsp;<select 
				name="delivery_year">
				{YEAR_LIST}
				</select>,&nbsp;time:&nbsp;<select 
				name="delivery_hour">
				{HOUR_LIST}
				</select>&nbsp;<select 
				name="delivery_minute">
				{MINUTE_LIST}
				</select>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td valign="top"><b>Broadcast Type:</b></td>
			<td>
				<input type="radio" name="broadcast_type" value="to_active_prospects" class="noborder" checked>Broadcast to active prospects only<br>
				<input type="radio" name="broadcast_type" value="to_inactive_prospects" class="noborder">Broadcast to inactive prospects only<br>
				<input type="radio" name="broadcast_type" value="to_mailing_list" class="noborder">Broadcast to entire mailing list<br>
			</td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td>
				<input type="submit" value="Broadcast!" onClick="CopyValuesHere();">
			</td>
			<td>
				<font color="red"><b>This may take a few moments - press only ONCE!</b></font>
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>

<script language="JavaScript">
function CopyValuesHere()
{
	form_broadcast.subject = form_broadcast_dumb.subject.value;
	form_broadcast.body = richedit.docHtml;

	return true;
}
</script>