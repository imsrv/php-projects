<form action="{S_PROFILE_ACTION}" method="post">
<table width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr> 
<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center" class="forumline">
<tr> 
<th class="thHead" colspan="{S_COLSPAN}" height="25" valign="middle">{L_AVATAR_GALLERY}</th>
</tr>
<tr> 
<td align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_CATEGORY}:&nbsp;{S_CATEGORY_SELECT}&nbsp;<input type="submit" class="liteoption" value="{L_GO}" name="avatargallery" /></span></td>
</tr>
<!-- BEGIN avatar_row -->
<tr> 
<!-- BEGIN avatar_column -->
<td class="row1" align="center"><img src="{avatar_row.avatar_column.AVATAR_IMAGE}" alt="{avatar_row.avatar_column.AVATAR_NAME}" title="{avatar_row.avatar_column.AVATAR_NAME}" /></td>
<!-- END avatar_column -->
</tr>
<tr>
<!-- BEGIN avatar_option_column -->
<td class="row2" align="center"><input type="radio" name="avatarselect" value="{avatar_row.avatar_option_column.S_OPTIONS_AVATAR}" /></td>
<!-- END avatar_option_column -->
</tr>

<!-- END avatar_row -->
<tr> 
<td colspan="{S_COLSPAN}" align="center" height="28">{S_HIDDEN_FIELDS} 
<input type="submit" name="submitavatar" value="{L_SELECT_AVATAR}" class="mainoption" />
&nbsp;&nbsp; 
<input type="submit" name="cancelavatar" value="{L_RETURN_PROFILE}" class="liteoption" />
</td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
</form>