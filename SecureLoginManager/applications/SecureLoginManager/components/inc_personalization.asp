<!--#include virtual="/Connections/secureloginmanager.asp" -->
<%
Dim personalization__MMColParam
personalization__MMColParam = "0"
If (Request.Form("EmailAddress")     <> "") Then 
  personalization__MMColParam = Request.Form("EmailAddress")    
End If
%>
<%
Dim personalization__MMColParam1
personalization__MMColParam1 = "0"
If (Session("MM_Username") <> "") Then 
  personalization__MMColParam1 = Session("MM_Username")
End If
%>
<%
set personalization = Server.CreateObject("ADODB.Recordset")
personalization.ActiveConnection = MM_secureloginmanager_STRING
personalization.Source = "SELECT tblMM_Members.*, tblSLM_Security.SecurityLevelName, tblSLM_Security.SecurityLevelDesc, tblSLM_Security.LoginSuccessURL,  tblSLM_Security.LogoutURL  FROM tblSLM_Security RIGHT JOIN tblMM_Members ON tblSLM_Security.SecurityLevelID = tblMM_Members.SecurityLevelID  WHERE EmailAddress = '" + Replace(personalization__MMColParam, "'", "''") + "' OR UserName = '" + Replace(personalization__MMColParam1, "'", "''") + "'"
personalization.CursorType = 0
personalization.CursorLocation = 2
personalization.LockType = 3
personalization.Open()
personalization_numRows = 0
%>
<%
Dim LogoutURL
LogoutURL = personalization.Fields.Item("LogoutURL").Value
%>
<%
' *** Logout the current user.
MM_Logout = CStr(Request.ServerVariables("URL")) & "?MM_Logoutnow=1"
If (CStr(Request("MM_Logoutnow")) = "1") Then
  Session.Contents.Remove("MM_Username")
  Session.Contents.Remove("MM_UserAuthorization")
  MM_logoutRedirectPage = LogoutURL
  ' redirect with URL parameters (remove the "MM_Logoutnow" query param).
  if (MM_logoutRedirectPage = "") Then MM_logoutRedirectPage = CStr(Request.ServerVariables("URL"))
  If (InStr(1, UC_redirectPage, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
    MM_newQS = "?"
    For Each Item In Request.QueryString
      If (Item <> "MM_Logoutnow") Then
        If (Len(MM_newQS) > 1) Then MM_newQS = MM_newQS & "&"
        MM_newQS = MM_newQS & Item & "=" & Server.URLencode(Request.QueryString(Item))
      End If
    Next
    if (Len(MM_newQS) > 1) Then MM_logoutRedirectPage = MM_logoutRedirectPage & MM_newQS
  End If
  Response.Redirect(MM_logoutRedirectPage)
End If
%>
<% if Session("MM_Username") <> "" then %>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><h3 align="center">&nbsp;</h3>
      <h3 align="center">Congratulations <font color="#FF0000"><%=(personalization.Fields.Item("FirstName").Value)%></font>, You have successfully logged in !!!</h3>      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><p align="center">You last logged in on <%=(personalization.Fields.Item("LastDateAccessed").Value)%>.
      You have logged into our system exactly <%=(personalization.Fields.Item("LoginCount").Value)%> times.</p>
      <p>&nbsp;     </p>      
    <div align="center"><a href="<%= MM_Logout %>">Log Out</a></div></td>
  </tr>
</table>
<%end if%>
<%
personalization.Close()
%>
