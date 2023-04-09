<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/managelistfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>deloittes.NET Directory - Manage Mailing List</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
	
<script langauge="javascript">
<!--

function checkForm(val)
{
	var passed = false;
	if (val.fullname.value == "")
	{alert ("Please provide your full name");}
	else if (val.username.value == "")
	{alert ("Please provide a username");}
	else if (val.password.value == "")
	{alert ("Please provide a password");}
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
ShowConfirmation ReturnNumberForMailingList & " users subscribed to your mailing list."
ShowList()
ElseIf Request.Querystring("action") = "delete" then
ShowDelete()
ElseIf Request.Querystring("action") = "dodelete" then
DeleteUser()
ShowConfirmation "User Deleted."
ShowList()
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
