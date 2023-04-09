<!--#Include File="../../data_connection/DsN_Connection.asp"-->
<%
	'-------------------------------------------

	If Request("ID")=empty Or Session("U")=Empty Or Session("P")=EMpty Then
		Response.Redirect "default.asp"
	End If

	Set Conn=Server.CreateObject ("ADODB.Connection")
	Conn.Open DsNAd,uid,pwd

	Query="Select * From Companies Where CompanyUserName='" &_
		   Session("U") & "' and CompanyPassword='" &_
		   Session("P") & "' AND CustomerID=" & Request("ID")+0
	Set CheckFirstCome=Conn.Execute (Query)
	If CheckFirstCome.EOF Then
		Response.Redirect "default.asp"
	End If

	'-------------------------------------------

	'Error Massage.
	Sub ErrMSG
		If Session("MSG")<>Empty Then
			%>
			<div align=center><%=Session("MSG")%></div>
			<%
			Session("MSG")=Abandon
		End If
	End Sub

	'-------------------------------------------

	FUNCTION Print_Date (ByVal Str)
	
		IF LEN(Str)=8 THEN
			Print_Date=Mid(Str,5,2)&"/"&Mid(Str,7,2)&"/"&Mid(Str,1,4)
		ELSE
			Print_Date=""
		END IF
	
	END FUNCTION

	'-------------------------------------------
%>
<SCRIPT LANGUAGE=Jscript RUNAT=Server>
function encode(str){
	return escape(str);
	}
function decode(str){
	return unescape(str);
	}
</SCRIPT>
