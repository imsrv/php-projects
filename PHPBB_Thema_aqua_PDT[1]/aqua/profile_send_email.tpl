
<script language="JavaScript" type="text/javascript">
<!--
function checkForm(formObj) {

formErrors = false;    

if (formObj.message.value.length < 2) {
formErrors = "{L_EMPTY_MESSAGE_EMAIL}";
}
else if ( formObj.subject.value.length < 2)
{
formErrors = "{L_EMPTY_SUBJECT_EMAIL}";
}

if (formErrors) {
alert(formErrors);
return false;
}
}
//-->
</script>

<form action="{S_POST_ACTION}" method="post" name="post" onSubmit="return checkForm(this)">

{ERROR_BOX}

<table width="90%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr>
<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbm.gif">
<tr align="center" background="templates/aqua/images/aquatbm.gif"> 
<td width="33%" height="22" align="left"><img src="templates/aqua/images/aquatbl.gif" width="22" height="22"></td>
<td width="33%" height="22" align="center"><span class="aquawords">{L_SEND_EMAIL_MSG}</span></td>
<td width="33%" height="22" align="right"><img src="templates/aqua/images/aquatbr.gif" width="79" height="22"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="90%" class="forumline" align="center">
<tr> 
<td class="row1" width="22%"><span class="gen"><b>{L_RECIPIENT}</b></span></td>
<td class="row2" width="78%"><span class="gen"><b>{USERNAME}</b></span> </td>
</tr>
<tr> 
<td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
<td class="row2" width="78%"><span class="gen"><input type="text" name="subject" size="45" maxlength="100" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" /></span> </td>
</tr>
<tr> 
<td class="row1" valign="top"><span class="gen"><b>{L_MESSAGE_BODY}</b></span><br /><span class="gensmall">{L_MESSAGE_BODY_DESC}</span></td>
<td class="row2"><span class="gen"><textarea name="message" rows="25" cols="40" wrap="virtual" style="width:500px" tabindex="3" class="post">{MESSAGE}</textarea></span></td>
</tr>
<tr> 
<td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span></td>
<td class="row2"><table cellspacing="0" cellpadding="1" border="0">
<tr> 
<td><input type="checkbox" name="cc_email"  value="1" checked="checked" /></td>
<td><span class="gen">{L_CC_EMAIL}</span></td>
</tr>
</table></td>
</tr>
<tr>
<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" tabindex="6" name="submit" class="mainoption" value="{L_SEND_EMAIL}" /></td>
</tr>
</table>
<table width="90%" height="22"  border="0" align="center" cellpadding="0" cellspacing="0" background="templates/aqua/images/aquatbdm.gif">
<tr>
<td><img src="templates/aqua/images/aquatbdl.gif"></td>
<td align="right"><img src="templates/aqua/images/aquatbdr.gif"></td>
</tr>
</table>
<table width="90%" cellspacing="0" border="0" align="center" cellpadding="0">
<tr> 
<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
</tr>
</table></form>

<table width="90%" cellspacing="0" border="0" align="center">
<tr>
<td valign="top" align="right">{JUMPBOX}</td>
</tr>
</table>