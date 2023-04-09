<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th class="thTop" colspan="2" height="25"><b>{L_GROUP_MEMBERSHIP_DETAILS}</b></th>
  </tr>
</table>
<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">

<!-- BEGIN switch_groups_joined -->
  <tr> 
    <th colspan="1" align="left" height="28" class="nav" nowrap="nowrap">{L_GROUP_MEMBERSHIP_DETAILS}</th>
  </tr>
  <!-- BEGIN switch_groups_member -->
</table>







<table align="CENTER" class="forumline" width="717" cellpadding="4" cellspacing="1" border="0">
  
  

  <tr> 
	<td class="row1"><table align="LEFT" cellspacing="1" cellpadding="5" border="0"><td><span class="gen">{L_YOU_BELONG_GROUPS}</span></td></table></td>
	<td class="row2" align="LEFT"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><table align="LEFT" cellspacing="1" cellpadding="1" border="0"><td><span class="gensmall">{GROUP_MEMBER_SELECT}</span></td></table></td>
			<td align="RIGHT" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
  </tr>
  <!-- END switch_groups_member -->
  <!-- BEGIN switch_groups_pending -->
  <tr> 
	<td class="row1"><table align="LEFT" cellspacing="1" cellpadding="5" border="0"><td><span class="gen">{L_PENDING_GROUPS}</span></td></table></td>
	<td class="row2" align="LEFT"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><table align="LEFT" cellspacing="1" cellpadding="1" border="0"><td><span class="gen">{GROUP_PENDING_SELECT}</span></td></table></td>
			<td align="RIGHT" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
  </tr>
  <!-- END switch_groups_pending -->
  <!-- END switch_groups_joined -->
  <!-- BEGIN switch_groups_remaining -->
  <tr align="LEFT"> 
	<th colspan="2" class="nav" height="25">{L_JOIN_A_GROUP}</th>
  </tr>
  <tr> 
	<td class="row1" height="28"><table align="LEFT" cellspacing="1" cellpadding="5" border="0"><td><span class="gen">{L_SELECT_A_GROUP}</span></td></table></td>
	<td class="row2" align="LEFT"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><table align="LEFT" cellspacing="0" cellpadding="1" border="0"><td><span class="gensmall">{GROUP_LIST_SELECT}</span></td></table></td>
			<td align="RIGHT" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
  </tr></td><!-- END switch_groups_remaining --></table>
  
</table>

<table width="717" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="LEFT" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="LEFT" valign="TOP"></td>
          <td align="RIGHT" valign="TOP"><span class="gensmall"></span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
<br clear="all" />

<table width="717" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
