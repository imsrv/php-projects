<form action="{S_GROUPCP_ACTION}" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">
			<a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> <a href="{U_GROUP_CP}" class="thCenter">{L_USERGROUPS}</a>
		</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center"><span class="gensmall">{S_TIMEZONE}</span></td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table class="forumline" width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td class="cat" colspan="7">{L_GROUP_INFORMATION}</td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_GROUP_NAME}:</span></td>
		<td class="row2"><span class="gen"><b>{GROUP_NAME}</b></span></td>
	</tr>
	<tr> 
		<td class="row1" width="20%"><span class="gen">{L_GROUP_DESC}:</span></td>
		<td class="row2"><span class="gen">{GROUP_DESC}</span></td>
	</tr>
	<tr> 
		<td class="row1" width="20%"><span class="gen">{L_GROUP_MEMBERSHIP}:</span></td>
		<td class="row2"><span class="gen">{GROUP_DETAILS} &nbsp;&nbsp;
		<!-- BEGIN switch_subscribe_group_input -->
		<input class="mainoption" type="submit" name="joingroup" value="{L_JOIN_GROUP}" />
		<!-- END switch_subscribe_group_input -->
		<!-- BEGIN switch_unsubscribe_group_input -->
		<input class="mainoption" type="submit" name="unsub" value="{L_UNSUBSCRIBE_GROUP}" />
		<!-- END switch_unsubscribe_group_input -->
		</span></td>
	</tr>
	<!-- BEGIN switch_mod_option -->
	<tr> 
		<td class="row1" width="20%"><span class="gen">{L_GROUP_TYPE}:</span></td>
		<td class="row2"><span class="gen"><span class="gen"><input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN} &nbsp;&nbsp; <input class="mainoption" type="submit" name="groupstatus" value="{L_UPDATE}" /></span></td>
	</tr>
	<!-- END switch_mod_option -->
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

{S_HIDDEN_FIELDS}
</form>
<br />


<form action="{S_GROUPCP_ACTION}" method="post" name="post">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="cat">{L_PM}</td>
	  <td class="cat">{L_USERNAME}</td>
	  <td class="cat">{L_POSTS}</td>
	  <td class="cat">{L_FROM}</td>
	  <td class="cat">{L_EMAIL}</td>
	  <td class="cat">{L_WEBSITE}</td>
	  <td class="cat">{L_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row3" colspan="8"><span class="cattitle">{L_GROUP_MODERATOR}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="center"> {MOD_PM_IMG} </td>
	  <td class="row1" align="center"><span class="gen"><a href="{U_MOD_VIEWPROFILE}" class="gen">{MOD_USERNAME}</a></span></td>
	  <td class="row1" align="center" valign="middle"><span class="gen">{MOD_POSTS}</span></td>
	  <td class="row1" align="center" valign="middle"><span class="gen">{MOD_FROM}</span></td>
	  <td class="row1" align="center" valign="middle"><span class="gen">{MOD_EMAIL_IMG}</span></td>
	  <td class="row1" align="center">{MOD_WWW_IMG}</td>
	  <td class="row1" align="center"> &nbsp; </td>
	</tr>
	<tr> 
	  <td class="row3" colspan="8"><span class="cattitle">{L_GROUP_MEMBERS}</span></td>
	</tr>
	<!-- BEGIN member_row -->
	<tr> 
	  <td class="{member_row.ROW_CLASS}" align="center"> {member_row.PM_IMG} </td>
	  <td class="{member_row.ROW_CLASS}" align="center"><span class="gen"><a href="{member_row.U_VIEWPROFILE}" class="gen">{member_row.USERNAME}</a></span></td>
	  <td class="{member_row.ROW_CLASS}" align="center"><span class="gen">{member_row.POSTS}</span></td>
	  <td class="{member_row.ROW_CLASS}" align="center"><span class="gen"> {member_row.FROM} 
		</span></td>
	  <td class="{member_row.ROW_CLASS}" align="center" valign="middle"><span class="gen">{member_row.EMAIL_IMG}</span></td>
	  <td class="{member_row.ROW_CLASS}" align="center"> {member_row.WWW_IMG}</td>
	  <td class="{member_row.ROW_CLASS}" align="center"> 
	  <!-- BEGIN switch_mod_option -->
	  <input type="checkbox" name="members[]" value="{member_row.USER_ID}" /> 
	  <!-- END switch_mod_option -->
	  </td>
	</tr>
	<!-- END member_row -->

	<!-- BEGIN switch_no_members -->
	<tr> 
	  <td class="row1" colspan="7" align="center"><span class="gen">{L_NO_MEMBERS}</span></td>
	</tr>
	<!-- END switch_no_members -->

	<!-- BEGIN switch_hidden_group -->
	<tr> 
	  <td class="row1" colspan="7" align="center"><span class="gen">{L_HIDDEN_MEMBERS}</span></td>
	</tr>
	<!-- END switch_hidden_group -->

	<!-- BEGIN switch_mod_option -->
	<tr>
		<td class="row3" align="right" colspan="8"><span class="cattitle">
			<input type="submit" name="remove" value="{L_REMOVE_SELECTED}" class="mainoption" />
		</td>
	</tr>
	<!-- END switch_mod_option -->
	<tr>
		<td colspan="8" align="right" class="row3" valign="top">
		<!-- BEGIN switch_mod_option -->
		<span class="genmed"><input type="text"  class="post" name="username" maxlength="50" size="20" /> <input type="submit" name="add" value="{L_ADD_MEMBER}" class="mainoption" /> <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></span>
		<!-- END switch_mod_option --></td>
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

{PENDING_USER_BOX}

{S_HIDDEN_FIELDS}</form>

<br clear="all" />
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}<br />{PAGINATION}</span></td>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>