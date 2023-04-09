<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">
			<a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> Log In
		</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall">{S_TIMEZONE}</span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br />
<form action="{S_LOGIN_ACTION}" method="post" target="_top">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">Log in</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
		<td class="cat" colspan="2">{L_ENTER_PASSWORD}</td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_USERNAME}:</span></td>
		<td class="row1" align="left"><input type="text" name="username" size="25" class="post" maxlength="40" value="{USERNAME}" /></td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_PASSWORD}:</span></td>
		<td class="row1" align="left" width="50%">
			<input type="password" name="password" class="post" size="25" maxlength="32" />
		</td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_AUTO_LOGIN}:</span></td>
		<td class="row1"><input type="checkbox" name="autologin" /></td>
	</tr>
	<tr align="center">
		<td colspan="2" class="row3">{S_HIDDEN_FIELDS}<input type="submit" name="login" class="mainoption" value="{L_LOGIN}" />
		<div class="gensmall"><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a></div></td>
	</tr>
</table>
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

</form>
