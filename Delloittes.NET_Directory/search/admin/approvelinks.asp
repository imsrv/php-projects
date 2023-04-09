<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!--#include file="includes/approve_functions.asp"-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<% response.expires = 0 %>

<html>
<head>
	<title>deloittes.NET Directory - Approve Resources</title>
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
	if (val.title.value == "")
	{alert ("Please provide a resource title");}
	else if (val.url.value == "")
	{alert ("Please provide a resource URL");}
	else if (val.description.value == "")
	{alert ("Please provide a resource description");}
	else if (val.description.value.length + 1 >= 250)
	{alert ("Maximum characters reached for description field.\n\n");}
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

ShowApproveResourceHead

If Request.Querystring("action") = "" then
ShowUnapprovedResources()
ElseIf Request.Querystring("action") = "approve" then
ShowSingleResource Request.Querystring("siteID"), False
DrawEditForm Request.Querystring("siteID")
elseif Request.Querystring("action") = "add2directory" then
DoUpdate Request.Form("siteID")
ShowSingleResource Request.Form("siteID"), True
elseif Request.Querystring("action") = "delete" then
ShowSingleResource Request.Querystring("ID"), False
ShowDelete
elseif Request.Querystring("action") = "dodelete" then
DeleteResource Request.Querystring("ID")
elseif Request.Querystring("action") = "justapprove" then
JustApprove Request.Querystring("siteID")
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>

