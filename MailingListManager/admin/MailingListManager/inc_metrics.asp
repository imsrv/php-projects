<!--#include virtual="/Connections/mailinglistmanager.asp" -->
<%
set deactivated = Server.CreateObject("ADODB.Recordset")
deactivated.ActiveConnection = MM_mailinglistmanager_STRING
deactivated.Source = "SELECT Count(tblMemberList.MemberID) AS TotalDeActivated  FROM tblMemberList  WHERE tblMemberList.Activated='False'"
deactivated.CursorType = 0
deactivated.CursorLocation = 2
deactivated.LockType = 3
deactivated.Open()
deactivated_numRows = 0
%>
<%
set activated = Server.CreateObject("ADODB.Recordset")
activated.ActiveConnection = MM_mailinglistmanager_STRING
activated.Source = "SELECT Count(tblMemberList.MemberID) AS TotalActivated  FROM tblMemberList  WHERE tblMemberList.Activated='True'"
activated.CursorType = 0
activated.CursorLocation = 2
activated.LockType = 3
activated.Open()
activated_numRows = 0
%>
<%
Dim activity
Dim activity_numRows

Set activity = Server.CreateObject("ADODB.Recordset")
activity.ActiveConnection = MM_mailinglistmanager_STRING
activity.Source = "SELECT Max(tblMailingListActivity.TimeStamp) AS LastOfTimeStamp, Count(tblMailingListActivity.ActivityID) AS CountOfActivityID, Sum(tblMailingListActivity.EmailCount) AS SumOfEmailCount  FROM tblMailingListActivity"
activity.CursorType = 0
activity.CursorLocation = 2
activity.LockType = 1
activity.Open()

activity_numRows = 0
%>
<table width="100%" height="40" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr class="tableheader">
    <td width="33%" height="20">Total Members: <font color="#FF0000"><%=(deactivated.Fields.Item("TotalDeActivated").Value + activated.Fields.Item("TotalActivated").Value)%></font></td>
    <td>Total Active Members: <font color="#FF0000"><%=(activated.Fields.Item("TotalActivated").Value)%></font></td>
    <td width="33%">Total NON-Active Members: <font color="#FF0000"><%=(deactivated.Fields.Item("TotalDeActivated").Value)%></font></td>
  </tr>
  <tr class="tableheader">
    <td height="20">Total Number of Email Campaigns: <font color="#FF0000"><%=(activity.Fields.Item("CountOfActivityID").Value)%></font> </td>
    <td>Last Campaign Date: <font color="#FF0000"><%=(activity.Fields.Item("LastOfTimeStamp").Value)%></font></td>
    <td>Total Emails Sent: <font color="#FF0000"><%=(activity.Fields.Item("SumOfEmailCount").Value)%></font></td>
  </tr>
</table>
<%
deactivated.Close()
%>
<%
activated.Close()
%>
<%
activity.Close()
Set activity = Nothing
%>
