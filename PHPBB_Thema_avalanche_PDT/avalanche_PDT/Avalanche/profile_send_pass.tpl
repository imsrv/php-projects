
<form action="{S_PROFILE_ACTION}" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="forumline">
	<tr> 
	  <td class="cat" colspan="2" height="25" valign="middle">{L_SEND_PASSWORD}</td>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px" name="username" size="25" maxlength="40" value="{USERNAME}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px" name="email" size="25" maxlength="255" value="{EMAIL}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row3" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	  </td>
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
