<!--#include virtual="/Connections/secureloginmanager.asp" -->
<%
Dim RSauthFailedURL
Dim RSauthFailedURL_numRows

Set RSauthFailedURL = Server.CreateObject("ADODB.Recordset")
RSauthFailedURL.ActiveConnection = MM_secureloginmanager_STRING
RSauthFailedURL.Source = "SELECT *  FROM tblSLM_SecurityPreferences"
RSauthFailedURL.CursorType = 0
RSauthFailedURL.CursorLocation = 2
RSauthFailedURL.LockType = 1
RSauthFailedURL.Open()

RSauthFailedURL_numRows = 0
%>
<%
Dim UnauthorizedAccessURL
UnauthorizedAccessURL = RSauthFailedURL.Fields.Item("UnauthorizedAccessURL").Value
%>
<%
' *** Restrict Access To Page: Grant or deny access to this page
MM_authorizedUsers="3"
MM_authFailedURL= UnauthorizedAccessURL
MM_grantAccess=false
If Session("MM_Username") <> "" Then
  If (false Or CStr(Session("MM_UserAuthorization"))="") Or _
         (InStr(1,MM_authorizedUsers,Session("MM_UserAuthorization"))>=1) Then
    MM_grantAccess = true
  End If
End If
If Not MM_grantAccess Then
  MM_qsChar = "?"
  If (InStr(1,MM_authFailedURL,"?") >= 1) Then MM_qsChar = "&"
  MM_referrer = Request.ServerVariables("URL")
  if (Len(Request.QueryString()) > 0) Then MM_referrer = MM_referrer & "?" & Request.QueryString()
  MM_authFailedURL = MM_authFailedURL & MM_qsChar & "accessdenied=" & Server.URLEncode(MM_referrer)
  Response.Redirect(MM_authFailedURL)
End If
%>
<%
RSauthFailedURL.Close()
Set RSauthFailedURL = Nothing
%>
