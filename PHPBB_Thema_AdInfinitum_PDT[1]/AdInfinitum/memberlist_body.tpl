<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
	<tr> 
	  <th height="25" class="thCornerL" nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_EMAIL}</th>
	  <th class="thTop" nowrap="nowrap">{L_FROM}</th>
	  <th class="thTop" nowrap="nowrap">{L_JOINED}</th>
	  <th class="thTop" nowrap="nowrap">{L_POSTS}</th>
	  <th class="thTop" nowrap="nowrap">{L_WEBSITE}</th>
	</tr>
	<tr align="LEFT">
	  <th height="25" colspan="8" class="nav">Memberlist</th>
	</tr>
  <form method="post" action="{S_MODE_ACTION}">
	
	<!-- BEGIN memberrow -->
	<tr> 
	  <td class="{memberrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
	  <td class="{memberrow.ROW_CLASS}" align="center" onmouseover="this.style.backgroundColor='#2B2B2B'; this.style.cursor='hand';" onMouseOut=this.style.backgroundColor="" onclick="window.location.href='{memberrow.U_VIEWPROFILE}'"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.FROM}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
	</tr>
	<!-- END memberrow -->
  </table>
<table width="717" cellspacing="2" cellpadding="5" border="0" align="center">
  <tr> 
    <td class="spaceRow" colspan="2" height="1"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="1" height="1" /></td>
  </tr>
	<tr> 
	  <td align="right" nowrap="nowrap" class="row1"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
  </table>



  
<table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
    <td align="left"></td>
    <td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="CENTER" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="RIGHT" valign="TOP"><span class="gensmall">{PAGE_NUMBER}<br />
            {PAGINATION}</span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
        </tr>
      </table></th>
  </tr>

</table>
<br>




<table align="center" width="717" cellspacing="2" border="0" cellpadding="0">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
  </form>
</table>



