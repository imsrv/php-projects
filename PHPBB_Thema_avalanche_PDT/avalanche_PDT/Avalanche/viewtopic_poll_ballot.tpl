<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<form method="POST" action="{S_POLL_ACTION}">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td class="cat" align="center"><b>{POLL_QUESTION}</b></td>
	</tr>
	<tr>
		<td class="row1" align="center">
			<table cellspacing="0" cellpadding="2" border="0">
				<!-- BEGIN poll_option -->
				<tr>
					<td><input type="radio" name="vote_id" value="{poll_option.POLL_OPTION_ID}" /></td>
					<td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
				</tr>
				<!-- END poll_option -->
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1" align="center">
			<input type="submit" name="submit" value="{L_SUBMIT_VOTE}" class="liteoption" />
			<div class="gensmall"><b><a href="{U_VIEW_RESULTS}" class="gensmall">{L_VIEW_RESULTS}</a></b>
			</div>
		</td>
	</tr>
</table>
{S_HIDDEN_FIELDS}
</form>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="#top" class="gensmall">Back To Top</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>