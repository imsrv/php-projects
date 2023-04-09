<%


If Session("FullName") = "" or Session("UserID") = "" then 
	response.redirect("login.asp")
end if
%>