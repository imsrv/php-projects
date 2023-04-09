<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/settingsfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>

	<title>deloittes.NET Directory - Directory Settings</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
	
<script langauge="javascript">
<!--

function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else 
	countfield.value = maxlimit - field.value.length;
}

function checkForm(val)
{
	var passed = false;
	if (val.directoryname.value == "")
	{alert ("Please provide a directory title");}
	else if (val.emailforresourcesubmission.checked == true && val.emailaddress.value == "")
	{alert ("Please provide your email address if you wish to receive resource email notifications.");}
	else if (val.emailforreviewsubmission.checked == true && val.emailaddress.value == "")
	{alert ("Please provide your email address if you wish to receive review email notifications.");}
	else if (val.emailforerrorsubmission.checked == true && val.emailaddress.value == "")
	{alert ("Please provide your email address if you wish to receive error email notifications.");}
	else
	 { passed = true; }
	return passed;
}

//-->
</script>

</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0">

<% ShowHeader() %>

<table width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="18%" bgcolor="#F6F6F6" valign="top"><!--#include file="includes/navigation.asp"--></td>
<td width="1" bgcolor="#bbbbbb"><img src="" width="1"></td>
<td width="82%" valign="top"><br>

<% 	
	
	Header()

	If Request.Querystring("action") = "" then
	DrawSettingsForm()
	ElseIf Request.Querystring("action") = "update" then
	UpdateConfig
	ShowSave
	DrawSettingsForm
	end if
			
	ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
