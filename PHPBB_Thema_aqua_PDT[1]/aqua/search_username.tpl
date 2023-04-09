
<script language="javascript" type="text/javascript">
<!--
function refresh_username(selected_username)
{
opener.document.forms['post'].username.value = selected_username;
opener.focus();
window.close();
}
//-->
</script>

<form method="post" name="search" action="{S_SEARCH_ACTION}">
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0" class="forumline">
<tr> 
<th class="thHead" height="25">{L_SEARCH_USERNAME}</th>
</tr>
<tr> 
<td valign="top" class="row1"><span class="genmed"><br /><input type="text" name="search_username" value="{USERNAME}" class="post" />&nbsp; <input type="submit" name="search" value="{L_SEARCH}" class="liteoption" /></span><br /><span class="gensmall">{L_SEARCH_EXPLAIN}</span><br />
<!-- BEGIN switch_select_name -->
<span class="genmed">{L_UPDATE_USERNAME}<br /><select name="username_list">{S_USERNAME_OPTIONS}</select>&nbsp; <input type="submit" class="liteoption" onClick="refresh_username(this.form.username_list.options[this.form.username_list.selectedIndex].value);return false;" name="use" value="{L_SELECT}" /></span><br />
<!-- END switch_select_name -->
<br /><span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span></td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
</form>