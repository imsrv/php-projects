<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<!--#include file="includes/error_functions.asp"-->
<html>

<head>

<title>Report Error</title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="includes/functions.js"></SCRIPT>

<script langauge="javascript">
<!--
	function CheckErrorForm(theForm)
	{
	var passed = false;
	if (theForm.FullName.value == "")
	{alert ("Please provide your full name");}
	else if (theForm.EmailAddress.value == "")
	{alert ("Please provide your email address");}
	else if (theForm.Nature.value == "")
	{alert ("Please specify the nature of the error.");}
	else
	 { passed = true; }
	return passed;
	}
//-->
</script>

</head>

<body bgcolor="#FFFFFF">

<% 

	DrawSelectedResource SiteID
	response.write "<br>"
	
	If Request.ServerVariables("REQUEST_METHOD") <> "POST" then 
		DrawErrorForm
	Else
		DrawErrorThankYou
	End If

%>

</body>
</html>


