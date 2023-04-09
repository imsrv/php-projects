<%
Dim rp_redirect
rp_redirect = Request.ServerVariables("HTTP_REFERER")
response.redirect rp_redirect 
%>