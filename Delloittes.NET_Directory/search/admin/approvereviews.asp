<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!--#include file="includes/approve_functions.asp"-->

<% if session("admin") = False then response.redirect("default.asp") %> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<% response.expires = 0 %>
<html>
<head>
	<title>deloittes.NET Directory - Approve Reviews</title>
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
	{alert ("Please provide a review title");}
	else if (val.fullname.value == "")
	{alert ("Please provide a full name");}
	else if (val.comments.value == "")
	{alert ("Please provide comments");}
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

ShowReviewHead()

If Request.Querystring("action") = "" then
ShowUnapprovedReviews()
ElseIf Request.Querystring("action") = "approve" then
ShowSingleReview Request.Querystring("reviewID")
DrawReviewForm Request.Querystring("reviewID")
elseif Request.Querystring("action") = "add2directory" then
DoReviewUpdate Request.Form("reviewID")
ShowSingleReview Request.Form("reviewID")
elseif Request.Querystring("action") = "delete" then
ShowSingleReview Request.Querystring("ID")
ShowReviewDelete
elseif Request.Querystring("action") = "dodelete" then
DeleteReview Request.Querystring("ID")
elseif Request.Querystring("action") = "justapprove" then
JustApproveReview Request.Querystring("reviewID")
end if
		
ShowFooter() 
		
%>

</td>
</tr>
</table>


</body>
</html>
