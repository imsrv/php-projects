<br clear="all" />
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="forumline">
<tr> 
<th class="thCornerL" height="25">{L_PM}</th>
<th class="thTop">{L_USERNAME}</th>
<th class="thTop">{L_POSTS}</th>
<th class="thTop">{L_FROM}</th>
<th class="thTop">{L_EMAIL}</th>
<th class="thTop">{L_WEBSITE}</th>
<th class="thCornerR">{L_SELECT}</th>
</tr>
<tr> 
<td class="catSides" colspan="8" height="28"><span class="cattitle">{L_PENDING_MEMBERS}</span></td>
</tr>
<!-- BEGIN pending_members_row -->
<tr> 
<td class="{pending_members_row.ROW_CLASS}" align="center"> {pending_members_row.PM_IMG} 
</td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen"><a href="{pending_members_row.U_VIEWPROFILE}" class="gen">{pending_members_row.USERNAME}</a></span></td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.POSTS}</span></td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.FROM}</span></td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.EMAIL_IMG}</span></td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.WWW_IMG}</span></td>
<td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gensmall"> <input type="checkbox" name="pending_members[]" value="{pending_members_row.USER_ID}" checked="checked" /></span></td>
</tr>
<!-- END pending_members_row -->
<tr> 
<td class="cat" colspan="8" align="right"><span class="cattitle"> 
<input type="submit" name="approve" value="{L_APPROVE_SELECTED}" class="mainoption" />
&nbsp; 
<input type="submit" name="deny" value="{L_DENY_SELECTED}" class="liteoption" />
</span></td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>