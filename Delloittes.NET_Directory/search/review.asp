<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<!--#include file="includes/review_functions.asp"-->
<html>

<head>

<title>Rate &amp; Review</title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="includes/functions.js"></script>

<script langauge="javascript">
<!--

// Required for client side form validation

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
	if (val.Title.value == "")
	{alert ("Please provide your review title");}
	else if (val.FullName.value == "")
	{alert ("Please provide your full name");}
	else if (val.Comments.value.length + 1 >= 551)
	{alert ("Maximum characters reached for comments field.\n\n");}
	else if (val.Comments.value == "")
	{alert ("Please provide your comments");}
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

	If Request.QueryString("action") <> "addreview" then ' if not from form

		DrawSelectedResource SiteID ' show resource to review
		DrawReviewForm ' show review form
		
	Else

		DrawSelectedResource SiteID ' show resource reviewed
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


