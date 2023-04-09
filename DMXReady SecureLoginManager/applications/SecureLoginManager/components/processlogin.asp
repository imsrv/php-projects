<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/secureloginmanager.asp" -->
<%
Dim process_login__value1
process_login__value1 = "999"
If (Session("MM_UserAuthorization") <> "") Then 
  process_login__value1 = Session("MM_UserAuthorization")
End If
%>
<%
Dim process_login
Dim process_login_numRows

Set process_login = Server.CreateObject("ADODB.Recordset")
process_login.ActiveConnection = MM_secureloginmanager_STRING
process_login.Source = "SELECT *  FROM tblSLM_Security  WHERE SecurityLevelID = " + Replace(process_login__value1, "'", "''") + ""
process_login.CursorType = 0
process_login.CursorLocation = 2
process_login.LockType = 1
process_login.Open()

process_login_numRows = 0
%>
<% if(Session("MM_Username") <> "") then %>
<% if(Session("MM_Username") <> "") then cmdCountLogin__OEColParam = Session("MM_Username")%>
<% if(Session("MM_Username") <> "") then cmdLastDate__OEColParam = Session("MM_Username")%>
<%
set cmdLastDate = Server.CreateObject("ADODB.Command")
cmdLastDate.ActiveConnection = MM_secureloginmanager_STRING
cmdLastDate.CommandText = "UPDATE tblMM_Members  SET LastDateAccessed = Now()  WHERE Username = '" + Replace(cmdLastDate__OEColParam, "'", "''") + "' "
cmdLastDate.CommandType = 1
cmdLastDate.CommandTimeout = 0
cmdLastDate.Prepared = true
cmdLastDate.Execute()
%>
<%
set cmdCountLogin = Server.CreateObject("ADODB.Command")
cmdCountLogin.ActiveConnection = MM_secureloginmanager_STRING
cmdCountLogin.CommandText = "UPDATE tblMM_Members  SET LoginCount = LoginCount + 1  WHERE Username = '" + Replace(cmdCountLogin__OEColParam, "'", "''") + "' "
cmdCountLogin.CommandType = 1
cmdCountLogin.CommandTimeout = 0
cmdCountLogin.Prepared = true
cmdCountLogin.Execute()
%>
<%
Dim rp_redirectsuccess
rp_redirectsuccess = process_login.Fields.Item("LoginSuccessURL").Value
Response.Redirect rp_redirectsuccess
%>
<%end if%>
<% if Not (Session("MM_Username") <> "") then %>
<%
Dim rp_redirectfailed
If instr(Request.ServerVariables("HTTP_REFERER"),"?") Then
rp_redirectfailed = Request.ServerVariables("HTTP_REFERER") & "&valid=false"
Else
rp_redirectfailed = Request.ServerVariables("HTTP_REFERER") & "?valid=false"
End If
Response.Redirect rp_redirectfailed
%>
<%end if%>
<%
process_login.Close()
Set process_login = Nothing
%>
