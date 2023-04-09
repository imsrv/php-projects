<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="cat" height="25">{L_PM}</td>
	  <td class="cat">{L_USERNAME}</td>
	  <td class="cat">{L_POSTS}</td>
	  <td class="cat">{L_FROM}</td>
	  <td class="cat">{L_EMAIL}</td>
	  <td class="cat">{L_WEBSITE}</td>
	  <td class="cat">{L_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1" colspan="8" height="28"><span class="cattitle">{L_PENDING_MEMBERS}</span></td>
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
	  <td class="row3" colspan="8" align="right"><span class="cattitle"> 
		<input type="submit" name="approve" value="{L_APPROVE_SELECTED}" class="mainoption" />
		&nbsp; 
		<input type="submit" name="deny" value="{L_DENY_SELECTED}" class="liteoption" />
		</span></td>
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