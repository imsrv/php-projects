<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!--#include file="includes/profilefunctions.asp"-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>deloittes.NET Directory - Edit Profile</title>
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

If Request.Querystring("action") = "" then
Header()
DrawProfileForm request.querystring("id")
ElseIf Request.Querystring("action") = "update" then
UpdateProfile()
Header()
ShowSave()
DrawProfileForm request.querystring("id")
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
