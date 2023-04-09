<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<!--#include file="includes/newsletter_functions.asp"-->
<html><head>

<title>Newsletter</title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="includes/functions.js"></script>

<script langauge="javascript">
<!--

function checkForm(val)
{
	var passed = false;
	if (val.email.value == "")
	{alert ("Please provide a email address");}
	 else if (val.email.value.indexOf("@") == -1 || val.email.value.indexOf(".") == -1) 
	{alert ("Please provide a valid email address");}
	else
	 { passed = true; }
	return passed;
}

function RemoveFromNewsletter(val)	{	

	if (val.email.value == "")	
	{alert ("You must enter an email address to be removed from our mailing list");}
	else
	{location = "newsletter.asp?action=remove&email=" + val.email.value;}
	
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

	If request.querystring("action") = "" then ' if not from form
		DrawNewsletterForm ' show newsletter form
	Elseif request.querystring("action") = "add" then
		CheckAddEmailAddress()
	Elseif request.querystring("action") = "remove" then
		CheckRemoveEmailAddress()
	End If


%>

</td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" bgcolor="#fdfdfd"><% ShowDirectoryStatisics() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
</table><br>

</body>
</html>

