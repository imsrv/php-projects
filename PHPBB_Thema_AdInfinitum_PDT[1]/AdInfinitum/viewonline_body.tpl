 
<table align="CENTER" class="forumline" width="717" cellpadding="4" cellspacing="1" border="0">
  <tr> 
	<th width="35%" class="thTop" height="25">&nbsp;{L_USERNAME}&nbsp;</th>
	<th width="25%" class="thTop">&nbsp;{L_LAST_UPDATE}&nbsp;</th>
	<th width="40%" class="thTop">&nbsp;{L_FORUM_LOCATION}&nbsp;</th>
  </tr>
  <tr> 
	<td class="catSides" colspan="3" height="28"><span class="nav"><b>{TOTAL_REGISTERED_USERS_ONLINE}</b></span></td>
  </tr>
  <!-- BEGIN reg_user_row -->
  <tr> 
	<td width="35%" class="row1" onmouseover="this.style.backgroundColor='#232323'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{topicrow.U_VIEW_TOPIC}'">&nbsp;<span class="gen"><a href="{reg_user_row.U_USER_PROFILE}" class="gen">{reg_user_row.USERNAME}</a></span>&nbsp;</td>
	<td width="25%" align="center" nowrap="nowrap" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen">{reg_user_row.LASTUPDATE}</span>&nbsp;</td>
	<td width="40%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_FORUM_LOCATION}" class="gen">{reg_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
  </tr>
  <!-- END reg_user_row -->
  
  <!-- BEGIN guest_user_row -->
  
  <tr> 
	<td class="catSides" colspan="3" height="28"><span class="nav"><b>{TOTAL_GUEST_USERS_ONLINE}</b></span></td>
  </tr>
  
  <tr> 
	<td width="35%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.USERNAME}</span>&nbsp;</td>
	<td width="25%" align="center" nowrap="nowrap" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.LASTUPDATE}</span>&nbsp;</td>
	<td width="40%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_FORUM_LOCATION}" class="gen">{guest_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
  </tr>
  <!-- END guest_user_row -->
</table>

<table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
    <td align="left"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
    <td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
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
<br>
<table width="717" cellspacing="0" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
