<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<!--#include file="includes/search_functions.asp"-->
<html>

<head>

<title>

<% 
if request.querystring("action") = "" then 
response.write "Search Results"
elseif request.querystring("action") = "new" then 
response.write "What's New!"
elseif request.querystring("action") = "hot" then 
response.write"What's Hot!"
elseif request.querystring("action") = "fav" then 
response.write "Favorites"
end if %>

</title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="includes/functions.js"></script>

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
	
	ShowNavigation()
	SearchSites() 
	
%>

</td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" bgcolor="#fdfdfd"><% ShowDirectoryStatisics() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
</table><br>

</body>
</html>
