<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!--#include file="includes/sendnewsletterfunctions.asp"-->


<% if session("admin") = False then response.redirect("default.asp") %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>deloittes.NET Directory - Send Newsletter</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">

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
	ShowTemplates()
	ElseIf Request.Querystring("action") = "preview" then
	ConstructNewsletter()
	ShowPreview()
	ElseIf Request.Querystring("action") = "dosend" then
	SendNewsletter()
	ShowSent()
	ShowPreview()
	end if
			
	ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
