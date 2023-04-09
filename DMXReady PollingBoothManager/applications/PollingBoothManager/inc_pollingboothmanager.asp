<!--#include virtual="/Connections/pollingboothmanager.asp" -->
<% If Request.QueryString("QuestionID") <> "" Then 
varDisplayStatus = "%"
Else
varDisplayStatus = "True"
End If
%>
<% If Request.Form("Vote") = "Vote" Then %>
<%
if(Request.Form("AnswerID") <> "") then cmdUpdateAns__varANS = Request.Form("AnswerID")
%>
<%
if(Request.Form("QuestionID") <> "") then cmdUpdateQuest__varQUEST = Request.Form("QuestionID")
%>
<% If Request.Cookies(cmdUpdateQuest__varQUEST) <> "" Then %>
<%
If Request.QueryString <> "" Then
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "&voted=yes"
Else
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "?voted=yes"
End If
	Response.Redirect rp_redirect
%>
<% Else %>
<%
set cmdUpdateAns = Server.CreateObject("ADODB.Command")
cmdUpdateAns.ActiveConnection = MM_pollingboothmanager_STRING
cmdUpdateAns.CommandText = "UPDATE tblPBM_PollAnswers  SET Votes = Votes +1, LastVote = date()  WHERE AnswerID = " + Replace(cmdUpdateAns__varANS, "'", "''") + " "
cmdUpdateAns.CommandType = 1
cmdUpdateAns.CommandTimeout = 0
cmdUpdateAns.Prepared = true
cmdUpdateAns.Execute()
%>
<%
set cmdUpdateQuest = Server.CreateObject("ADODB.Command")
cmdUpdateQuest.ActiveConnection = MM_pollingboothmanager_STRING
cmdUpdateQuest.CommandText = "UPDATE tblPBM_PollQuestions  SET TotalVotes = TotalVotes +1  WHERE QuestionID = " + Replace(cmdUpdateQuest__varQUEST, "'", "''") + " "
cmdUpdateQuest.CommandType = 1
cmdUpdateQuest.CommandTimeout = 0
cmdUpdateQuest.Prepared = true
cmdUpdateQuest.Execute()
%>
<%
Response.Cookies(cmdUpdateQuest__varQUEST) = (cmdUpdateAns__varANS)
Response.Cookies(cmdUpdateQuest__varQUEST).Expires = Date + 1000
%>
<%
If Request.QueryString("QuestionID") <> "" Then
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "&view=results"
Else
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "?view=results" & "&QuestionID=" & cmdUpdateQuest__varQUEST
End If
	Response.Redirect rp_redirect
%>
<% End If %>
<% End If %>
<%
Dim rsQuestions__value1
rsQuestions__value1 = "%"
If (request.querystring("QuestionID") <> "") Then 
  rsQuestions__value1 = request.querystring("QuestionID")
End If
%>
<%
Dim rsQuestions__value2
rsQuestions__value2 = "True"
If (varDisplayStatus  <> "") Then 
  rsQuestions__value2 = varDisplayStatus 
End If
%>
<%
set rsQuestions = Server.CreateObject("ADODB.Recordset")
rsQuestions.ActiveConnection = MM_pollingboothmanager_STRING
rsQuestions.Source = "SELECT tblPBM_PollAnswers.*, tblPBM_PollQuestions.*  FROM tblPBM_PollAnswers INNER JOIN tblPBM_PollQuestions ON tblPBM_PollAnswers.QuestionIDkey = tblPBM_PollQuestions.QuestionID  WHERE tblPBM_PollQuestions.QuestionID LIKE '" + Replace(rsQuestions__value1, "'", "''") + "' AND  tblPBM_PollQuestions.DisplayStatus LIKE '" + Replace(rsQuestions__value2, "'", "''") + "'"
rsQuestions.CursorType = 0
rsQuestions.CursorLocation = 2
rsQuestions.LockType = 3
rsQuestions.Open()
rsQuestions_numRows = 0
%>
<%
Dim rsResult__value1
rsResult__value1 = "999"
If (Request.QueryString("QuestionID")   <> "") Then 
  rsResult__value1 = Request.QueryString("QuestionID")  
End If
%>
<%
set rsResult = Server.CreateObject("ADODB.Recordset")
rsResult.ActiveConnection = MM_pollingboothmanager_STRING
rsResult.Source = "SELECT tblPBM_PollQuestions.QuestionID, QuestionValue, DateAdded, TotalVotes, AnswerValue, Votes, LastVote, ((Votes/TotalVotes)*100) AS PER, QuestionDescription  FROM tblPBM_PollQuestions INNER JOIN tblPBM_PollAnswers ON tblPBM_PollQuestions.QuestionID = tblPBM_PollAnswers.QuestionIDkey  WHERE tblPBM_PollQuestions.QuestionID = " + Replace(rsResult__value1, "'", "''") + ""
rsResult.CursorType = 0
rsResult.CursorLocation = 2
rsResult.LockType = 3
rsResult.Open()
rsResult_numRows = 0
%>
<%
set rsArchive = Server.CreateObject("ADODB.Recordset")
rsArchive.ActiveConnection = MM_pollingboothmanager_STRING
rsArchive.Source = "SELECT *  FROM tblPBM_PollQuestions  WHERE DisplayStatus <> 'True' AND Activated = 'True'"
rsArchive.CursorType = 0
rsArchive.CursorLocation = 2
rsArchive.LockType = 3
rsArchive.Open()
rsArchive_numRows = 0
%>
<%
Dim Repeat_rsQuestions__numRows
Dim Repeat_rsQuestions__index

Repeat_rsQuestions__numRows = -1
Repeat_rsQuestions__index = 0
rsQuestions_numRows = rsQuestions_numRows + Repeat_rsQuestions__numRows
%>
<%
Dim Repeat_rsArchive__numRows
Dim Repeat_rsArchive__index

Repeat_rsArchive__numRows = -1
Repeat_rsArchive__index = 0
rsArchive_numRows = rsArchive_numRows + Repeat_rsArchive__numRows
%>
<%
Dim Repeat_rsResult__numRows
Dim Repeat_rsResult__index

Repeat_rsResult__numRows = -1
Repeat_rsResult__index = 0
rsResult_numRows = rsResult_numRows + Repeat_rsResult__numRows
%>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../../styles.css" rel="stylesheet" type="text/css">
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td width="0"> <div align="left">
      <% If Not rsQuestions.EOF Or Not rsQuestions.BOF Then %>
      <a href="../../applications/PollingBoothManager/inc_pollingboothmanager.asp">Current
          Poll</a>
		  <%else%>
		  Polling Booth is Closed
      <% End If ' end Not rsQuestions.EOF Or NOT rsQuestions.BOF %>
</div></td>
    <td width="0"> <div align="center"></div></td>
    <td width="0"><div align="right"><a href="?view=archive">Archived Polls</a></div></td>
  </tr>
</table>

<%
' Declare our variable
Dim view
view = Request.QueryString("view")
Select Case view
	Case ""
%>
<% if Request.QueryString("voted") = "yes" Then %>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#FF0000" bgcolor="#FFFFCC">
          <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Your
                    vote was not accepted because you have voted on this poll
              before.</font></td>
          </tr>
</table>
			  <%end if%>
<form action="" method="post" name="Vote" id="Vote">
<% If Not rsQuestions.EOF Or Not rsQuestions.BOF Then %>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
      <td><% if rsQuestions.Fields.Item("QuestionImage").Value <> "" Then %>
        <img src="../../applications/PollingBoothManager/images/<%=(rsQuestions.Fields.Item("QuestionImage").Value)%>" width="100" hspace="5" align="left">
        <%end if%>
        <p><strong><font color="#FF0000" size="2"><%=(rsQuestions.Fields.Item("QuestionValue").Value)%></font></strong> <br>
          <b>Description:</b> <%=(rsQuestions.Fields.Item("QuestionDescription").Value)%> </p>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font color="#FF0000"> </font></b></font><font size="1"><font face="Verdana, Arial, Helvetica, sans-serif"><i> (<%=(rsQuestions.Fields.Item("TotalVotes").Value)%> votes
                - From <%=(rsQuestions.Fields.Item("DateAdded").Value)%> to
                  <%response.write(date())%>
    )</i></font></font> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font color="#FF0000">
    <input type="hidden" name="QuestionID" value="<%=((rsQuestions.Fields.Item("QuestionID").Value))%>">
    </font></b></font><font face="Verdana, Arial, Helvetica, sans-serif">[<a href="?view=results&QuestionID=<%=(rsQuestions.Fields.Item("QuestionID").Value)%>">VIEW
    RESULTS</a>]</font></p></td>
    </tr>
    <tr>
      <td>      
        <% 
While ((Repeat_rsQuestions__numRows <> 0) AND (NOT rsQuestions.EOF)) 
%>
        <table border="0" cellspacing="0" cellpadding="3" width="100%">
              <tr valign="middle" class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
                <td align="left" valign="top" width="2%">
                  <input type="radio" name="AnswerID" value="<%=(rsQuestions.Fields.Item("AnswerID").Value)%>">
                <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font color="#FF0000"> </font></b></font> </td>
                <td align="left" valign="top" width="62%"><i><strong>			<%=(rsQuestions.Fields.Item("AnswerValue").Value)%></strong></i></td>
                <td align="left" valign="top" width="36%"><i><strong>
                <% if rsQuestions.Fields.Item("AnswerImage").Value <> "" Then %>
                <img src="../../applications/PollingBoothManager/images/<%=(rsQuestions.Fields.Item("AnswerImage").Value)%>" width="50" hspace="5">
                <%end if%>
                </strong></i></td>
          </tr>
        </table>
        <% 
  Repeat_rsQuestions__index=Repeat_rsQuestions__index+1
  Repeat_rsQuestions__numRows=Repeat_rsQuestions__numRows-1
  rsQuestions.MoveNext()
Wend
%>
        <input name="Vote" type="submit" id="Vote" value="Vote">
        <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font color="#FF0000"> </font></b></font>
      </td>
    </tr>
</table>
<% End If ' end Not rsQuestions.EOF Or NOT rsQuestions.BOF %>
</form>
<% Case "archive" %>
    <% If Not rsArchive.EOF Or Not rsArchive.BOF Then %> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	 <tr>
    <td height="56" valign="top"><b><font color="#FF0000">Old polls that have
            been archived</font></b>
      <ol>
                    <% 
While ((Repeat_rsArchive__numRows <> 0) AND (NOT rsArchive.EOF)) 
%>
                    <li><font size="2"><%=(rsArchive.Fields.Item("QuestionValue").Value)%></font>  | <a href="?view=results&QuestionID=<%=(rsArchive.Fields.Item("QuestionID").Value)%>">View
                    Results</a>
                    <% 
  Repeat_rsArchive__index=Repeat_rsArchive__index+1
  Repeat_rsArchive__numRows=Repeat_rsArchive__numRows-1
  rsArchive.MoveNext()
Wend
%>                  
                    </li>
</ol>                  
    </td>
</tr> 
</table> 
<% End If ' end Not rsArchive.EOF Or NOT rsArchive.BOF %>
<% Case "results"%>
<% If Not rsResult.EOF Or Not rsResult.BOF Then %>
<table width="100%" height="168" border="0" cellpadding="3" cellspacing="0">
  <tr align="LEFT" valign="MIDDLE">
    <td valign="top"> <font size="1" color="#009999"><b><font size="2" color="#FF0000"><%=(rsResult.Fields.Item("QuestionValue").Value)%></font></b></font> <br>
    <b>Description:</b> <%=(rsResult.Fields.Item("QuestionDescription").Value)%><b><br>
    From</b> <font color="#FF0000"><%=(rsResult.Fields.Item("DateAdded").Value)%></font> <b>to</b> <font color="#FF0000">
    <%response.write(date())%>
    <br>
    <b>Number of votes:</b> <font color="#FF0000"><%=(rsResult.Fields.Item("TotalVotes").Value)%> votes </font>
</font><br>
<br></td>
  </tr>
  <tr align="right" valign="MIDDLE">
    <td valign="top">
      <% 
While ((Repeat_rsResult__numRows <> 0) AND (NOT rsResult.EOF)) 
%>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td width="172" align="right" valign="middle"><b><font color="#0000FF"><%=(rsResult.Fields.Item("AnswerValue").Value)%></font></b></td>
                <td align="left" valign="top">
                  <table width="<%=(rsResult.Fields.Item("PER").Value)%>%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
                    <tr>
                      <td align="right" valign="middle" height="19"><font color="#FF0000"><font color="#FFFFFF"><i><b><%= FormatNumber((rsResult.Fields.Item("PER").Value), 0, -2, -2, -2) %></b></i></font></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000"><font color="#FFFFFF"><i><b>%</b></i></font></font></td>
                    </tr>
                  </table>
                  <font color="#0000FF"><%=(rsResult.Fields.Item("Votes").Value)%> votes</font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font color="#009900"> </font></b></font></td>
              </tr>
      </table>
            <% 
  Repeat_rsResult__index=Repeat_rsResult__index+1
  Repeat_rsResult__numRows=Repeat_rsResult__numRows-1
  rsResult.MoveNext()
Wend
%>
    </td>
  </tr>
</table>
<% End If ' end Not rsResult.EOF Or NOT rsResult.BOF %>
<% Case Else %> 
<%End Select%>
<%
rsQuestions.Close()
Set rsQuestions = Nothing
%>
<%
rsResult.Close()
%>
  <%
rsArchive.Close()
%>
