<%@ Language=VBScript %>

<!--#Include File="Cadmin.asp"-->
<%
Set Rs=Conn.Execute ("Select * From Companies Where CustomerID=(" & Request.QueryString ("ID")+0 & ") And CompanyUserName=('" & encode(Request.Form ("OLD1")) & "') And CompanyPassword=('" & encode(Request.Form ("OLD2")) & "')")
If Not Rs.EOF Then
	If Request.Form ("password1")=Request.Form ("password2") Then
		Query="Update Companies Set "
		Query=Query & "CompanyPassword='" & encode(Request.Form ("password2")) & "'"
		Query=Query & " Where CustomerID=" & Request.QueryString ("ID")+0
		Conn.Execute (Query)
		Session("P")=encode(Request.Form ("password2"))
		'------Close conn object----------
		Conn.close
	Else
		Session("MSG")="Your two Passwords did not match."
		'------Close conn object----------
		Conn.close
		Response.Redirect "../C_change.asp?ID=" & Request.QueryString ("ID")
		
	End If
Else
Session("MSG")="Sorry! Wrong user name or password."
'------Close conn object----------
		Conn.close
Response.Redirect "../C_change.asp?ID=" & Request.QueryString ("ID")
End If
'------Close conn object----------
		'Conn.close
Response.Redirect "../C_center.asp?ID=" & Request.QueryString ("ID")
%>
