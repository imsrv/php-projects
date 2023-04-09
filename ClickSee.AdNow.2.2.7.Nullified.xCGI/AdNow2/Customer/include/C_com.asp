<%@ Language=VBScript %>

<!--#Include File="Cadmin.asp"-->
<%
If trim(request("text1"))=empty Then
	Session("MSG")="Please enter Company Name."
	'------Close conn object----------
		Conn.close
	Response.Redirect "../C_prof.asp?ID=" & Request.QueryString ("ID")
End If
Query="Update Companies Set CompanyName='" & encode(Request.Form ("text1")) & "'"
Query=Query & ", CompanyAddress1='" & encode(Request.Form ("text2")) & "'"
Query=Query & ", CompanyAddress2='" & encode(Request.Form ("text4")) & "'"
Query=Query & ", CompanyCity='" & encode(Request.Form ("text5")) & "'"
Query=Query & ", CompanyState='" & encode(Request.Form ("text6")) & "'"
Query=Query & ", CompanyPostalCode='" & encode(Request.Form ("text7")) & "'"
Query=Query & ", ContactName='" & encode(Request.Form ("text8")) & "'"
Query=Query & ", CompanyCountry='" & encode(Request.Form ("text9")) & "'"
Query=Query & ", ContactEmail='" & encode(Request.Form ("text10")) & "'"
Query=Query & ", CompanyURL='" & encode(Request.Form ("text11")) & "'"
Query=Query & ", CompanyPhoneVoice='" & encode(Request.Form ("text12")) & "'"
Query=Query & ", CompanyPhoneFax='" & encode(Request.Form ("text13")) & "'"
Query=Query & " Where CustomerID=" & Request.QueryString ("ID")+0
Conn.Execute (Query)
'------Close conn object----------
		Conn.close
Response.Redirect "../C_center.asp?ID=" & Request.QueryString ("ID")
%>
