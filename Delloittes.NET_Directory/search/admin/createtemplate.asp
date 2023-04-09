<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/newtemplatefunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<% if session("admin") = False then response.redirect("default.asp") %> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>deloittes.NET Directory - Newsletter Format</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
	
<script langauge="javascript">
<!--

function checkForm(val)
{
	var passed = false;
	if (val.tempname.value == "")
	{alert ("You must provide a template name");}
	else if (val.tempsubject.value == "")
	{alert ("You must provide a subject line");}
	else if (val.template.value == "")
	{alert ("You must provide a template");}
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
<td width="1" bgcolor="#d2d2d2"><img src="" width="1"></td>
<td width="82%" valign="top"><br>

<% 	
	
Header()

If Request.Querystring("action") = "" then
ShowCreateTemplateForm()
ElseIf Request.Querystring("action") = "save" then
AddTemplate()
ShowSave()
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
