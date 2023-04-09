<!--#include file="includes/functions.asp"-->
<%

Dim Favorites, CheckEx
Favorites = Request.Cookies("Favorites") ' read cookie
CheckEx = InStr(1,Request.Cookies("Favorites"),request.querystring("id")) ' check if resource ID is already in cookie
If CheckEx = False then Favorites = Favorites & request.querystring("id") & ", " ' not in cookie append to end
Response.Cookies("Favorites") = Favorites ' re-write cookie
Response.Cookies("Favorites").Expires = now + 365

%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>	
<title>Resource Bookmarked</title>
<link href="includes/style.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="includes/functions.js"></SCRIPT>	
</head>

<body>

<%


If CheckEx = False then 
response.write "<font class='general_text'>"
response.write "<b>This listing has been added to your favorites...</b>"
else
response.write "<font class='general_text_red'>"
response.write "<img src='images/warning.gif' align='absmiddle'> ERROR: This listing is already within your favorites..."
end if
response.write "</font>"
response.write "<br><br>"

DrawSelectedResource request.querystring("id")

response.write "<font class='general_text'>"
response.write "<br><a href='javascript:window.close()' class='general_text'><b>Close Window</b></a>"
response.write "</font>"
%>

</body>
</html>
