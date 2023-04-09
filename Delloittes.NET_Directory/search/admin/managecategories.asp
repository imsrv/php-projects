<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/managecatfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<% response.expires = 0 %>
<html>
<head>
	<title>deloittes.NET Directory - Manage Directory</title>
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
	if (val.cattitle.value == "")
	{alert ("Please provide a category title");}
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

Dim HowManyListings

If Request.Querystring("action") = "" then
Header()
ShowInfo
ShowDirectory() ' write the directory to screen
elseif Request.Querystring("action") = "modify" then
Header()
ShowModifyCategoryForm
elseif Request.Querystring("action") = "modifyname" then
Header()
ShowModifyCategoryNameForm
elseif Request.Querystring("action") = "updatecategoryname" then
Header()
UpdateCatInfo cint(request.form("currentcategory"))
response.write "<script>location = 'managecategories.asp?action=updatecomplete&id=" & cint(request.form("currentcategory")) & "&parentid=" & cint(request.form("parentid")) & "';</script>"
elseif Request.Querystring("action") = "updatecategory" then
Header()
UpdateCatInfo cint(request.form("currentcategory"))

	UpdateCatIDs cint(request.form("currentcategory"))
	HowManyListings = ReturnNumberOfSitesForCategory (cint(request.form("currentcategory")))
	AddCategoryCounts cint(request.form("category"))
	SubtractCategoryCounts cint(request.form("parentid"))

response.write "<script>location = 'managecategories.asp?action=updatecomplete&id=" & cint(request.form("currentcategory")) & "&parentid=" & cint(request.form("parentid")) & "';</script>"
elseif Request.Querystring("action") = "updatecomplete" then
Header()
UpdateComplete()
ShowDirectory() ' write the directory to screen
elseif request.querystring("action") = "delete" then
Header()
ShowSingleCategory cint(request.querystring("ID"))
ShowDelete() 
elseif request.querystring("action") = "dodelete" then
HowManyListings = ReturnNumberOfSitesForCategory (cint(request.querystring("id")))
SubtractCategoryCounts cint(request.querystring("parentid"))
DeleteCategory cint(request.querystring("ID"))
response.write "<script>location = 'managecategories.asp?action=deletecomplete&id=" & cint(request.querystring("parentid")) & "';</script>"
elseif request.querystring("action") = "deletecomplete" then
Header()
DeleteComplete()
ShowDirectory() ' write the directory to screen
end if		

ShowKey()
ShowFooter()

%>

</td>
</tr>
</table>


</body>
</html>

