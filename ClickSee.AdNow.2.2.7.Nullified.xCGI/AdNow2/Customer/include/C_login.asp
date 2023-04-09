<%@ Language=VBScript %>
<!--#Include File="../../data_connection/DsN_Connection.asp"-->
<%
Session.TimeOut=30

Set Conn=Server.CreateObject ("ADODB.Connection")
Conn.Open DsNad,uid,pwd

CheckPassword="Select * From Companies " &_
			  "Where CompanyUserName='" & encode(Request.Form ("Username")) & "'" &_
			  " And CompanyPassword='" & encode(Request.Form ("Password")) & "'"
Set Rs=Conn.Execute (CheckPassword)


If Rs.EOF And Session("EnablePassWord")<>4Then
	Session("EnablePassWord")=Session("EnablePassWord")+1
    Session("Wstr")= "Incorrect username or password. Please try again."
    '------Close conn object----------
		Conn.close
	Response.Redirect "../default.asp"
ElseIf Session("EnablePassWord")>=4 Then
	Session("EnablePassWord")=Abandon
	Session("Wstr")= "Incorrect username or password. Please try again."
	'------Close conn object----------
		Conn.close
	Response.Redirect "../default.asp"
ElseIf Not Rs.EOF Then
	Session("EnablePassWord")=Abandon
	Session("U")=Rs("CompanyUserName")
	Session("P")=Rs("CompanyPassword")
	Response.Redirect "../C_center.asp?ID=" & Rs("CustomerID")
End If

%>

<%'---------------------------------%>
<SCRIPT LANGUAGE=JScript RUNAT=Server>
function encode(str) {
	return escape(str);
}

function decode(str) {
	return unescape(str);
}
</SCRIPT>
<%'---------------------------------%>




