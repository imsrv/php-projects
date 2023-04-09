<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<!--#include file="includes/addresource_functions.asp"-->

<html>

<head><title>Add Listing</title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="includes/functions.js"></script>

<script langauge="javascript">
<!--

function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}

function checkForm(frm)
{
	var passed = false;
	if (frm.Title.value == "")
	{alert ("Please specify a listing title");}
	else if (frm.description.value == "")
	{alert ("Please supply a listing description");}
	else if (frm.URL.value == "http://" || frmAddResource.URL.value == "")
	{alert ("Please specify a listing URL");}
	else if (frm.ContactName.value == "")
	{alert ("Please supply a contact name");}
	else if (frm.ContactEmail.value == "")
	{alert ("Please supply a contact email address");}
	else
	 { passed = true; }
	return passed;
}

//-->
</script>

</head>

<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF">

<table cellpadding="8" cellspacing="0" width="100%">
<tr><td colspan="2" bgcolor="#F1F1F1" height="70">&nbsp;<img src="images/logo.gif"></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" valign="bottom" align="right" bgcolor="#fdfdfd"><% ShowFeatures() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr>
<td class='bgnotile' height='100%' width="175" valign="top" bgcolor="#f5f5f5"><% ShowNewsletterBox() %><br><% ShowAdminLink() %></td>
<td valign="top">

<% 

	ShowSearchOptions()
	
	'------------------------
	
	ShowNavigation
	response.write "<br>"

	If Request.QueryString("action") <> "add" then ' if not from form
		DrawAddNewResource 
	Else
		DrawThankYou ' draw thank you message
	End If



%>

</td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" bgcolor="#fdfdfd"><% ShowDirectoryStatisics() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
</table><br>

</body>
</html>

