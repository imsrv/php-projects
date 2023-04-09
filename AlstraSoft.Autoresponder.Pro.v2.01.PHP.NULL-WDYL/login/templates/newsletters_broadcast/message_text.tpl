<form name="form_broadcast" action="do_broadcast.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>New broadcast newsletter: </b>
	</td>
	<td bgColor="white" valign="top">
		<table width="100%" border="0" cellPadding="0" cellSpacing="0">

		<tr>
			<td width="25%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="" size="43"></td>
		</tr>
		<tr height="10"><td></td></tr>
		<tr>
			<td><b>Newsletter Type:</b></td>
			<td>[ <b>plain text</b> ] [ <a href="newsletters_broadcast.php?type=html">html enhanced</a> ]</td>
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
			<td valign="top"><b>Delivery Date:</b></td>
			<td>
				<input type="radio" name="delivery_type" value="asap" class="noborder" checked>Deliver ASAP<br>
				<input type="radio" name="delivery_type" value="future" class="noborder">Deliver in future:
				&nbsp;<br><select 
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
				<input type="submit" value="Broadcast!">
			</td>
			<td>
				<font color="red"><b>This may take a few moments - press only ONCE!</b></font>
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>
