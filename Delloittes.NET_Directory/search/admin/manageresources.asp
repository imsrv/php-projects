<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/modifyfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>deloittes.NET Directory - Modify Resources</title>
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
	else if (val.description.value == "")
	{alert ("Please provide a resource description");}
	else if (val.url.value == "")
	{alert ("Please provide a resource URL");}
	else if (val.fullname.value == "")
	{alert ("Please provide a author full name");}
	else if (val.emailaddress.value == "")
	{alert ("Please provide a author email address");}
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
ShowSearch()
ElseIf Request.Querystring("action") = "search" then
DrawResults()
ElseIf request.querystring("action") = "modify" then
ShowSingleResource request.querystring("siteID")
DrawEditForm request.querystring("siteID")
ElseIf request.querystring("action") = "moveresource" then
ShowSingleResource request.querystring("siteID")
ShowMoveForm request.querystring("siteID"),request.querystring("currentcatid")
ElseIf request.querystring("action") = "moveresourceupdate" then
if request.form("currentcategory") <> request.form("category") then
UpdateSiteCategory cint(request.querystring("siteid"))
AddCategoryCounts cint(request.form("category"))
SubtractCategoryCounts cint(request.form("currentcategory"))
end if
response.write "<script>location = 'manageresources.asp?action=movecomplete&siteid=" & request.querystring("siteid") & "';</script>"
elseif request.querystring("action") = "movecomplete" then
ShowSingleResource Request.querystring("SiteID")
MoveComplete
elseif request.querystring("action") = "updateresource" then
DoUpdate Request.Form("SiteID")
ShowSingleResource Request.Form("SiteID")
elseif request.querystring("action") = "delete" then
ShowSingleResource request.querystring("siteID")
ShowDelete() 
elseif request.querystring("action") = "dodelete" then
ShowSingleResource request.querystring("ID")
DeleteResource request.querystring("ID")
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
