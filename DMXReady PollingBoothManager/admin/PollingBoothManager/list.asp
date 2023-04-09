<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include virtual="/Connections/pollingboothmanager.asp" -->
<%
' *** Edit Operations: declare variables

Dim MM_editAction
Dim MM_abortEdit
Dim MM_editQuery
Dim MM_editCmd

Dim MM_editConnection
Dim MM_editTable
Dim MM_editRedirectUrl
Dim MM_editColumn
Dim MM_recordId

Dim MM_fieldsStr
Dim MM_columnsStr
Dim MM_fields
Dim MM_columns
Dim MM_typeArray
Dim MM_formVal
Dim MM_delim
Dim MM_altVal
Dim MM_emptyVal
Dim MM_i

MM_editAction = CStr(Request.ServerVariables("SCRIPT_NAME"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Request.QueryString
End If

' boolean to abort record edit
MM_abortEdit = false

' query string to execute
MM_editQuery = ""
%>
<%
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "AddQuestion") Then

  MM_editConnection = MM_pollingboothmanager_STRING
  MM_editTable = "tblPBM_PollQuestions"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "QuestionValue|value|Activated|value|QuestionDescription|value|DateAdded|value|TotalVotes|value|DisplayStatus|value"
  MM_columnsStr = "QuestionValue|',none,''|Activated|',none,''|QuestionDescription|',none,''|DateAdded|',none,NULL|TotalVotes|none,none,NULL|DisplayStatus|',none,''"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
  If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If

End If
%>
<%
' *** Insert Record: construct a sql insert statement and execute it

Dim MM_tableValues
Dim MM_dbValues

If (CStr(Request("MM_insert")) <> "") Then

  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_formVal = MM_fields(MM_i+1)
    MM_typeArray = Split(MM_columns(MM_i+1),",")
    MM_delim = MM_typeArray(0)
    If (MM_delim = "none") Then MM_delim = ""
    MM_altVal = MM_typeArray(1)
    If (MM_altVal = "none") Then MM_altVal = ""
    MM_emptyVal = MM_typeArray(2)
    If (MM_emptyVal = "none") Then MM_emptyVal = ""
    If (MM_formVal = "") Then
      MM_formVal = MM_emptyVal
    Else
      If (MM_altVal <> "") Then
        MM_formVal = MM_altVal
      ElseIf (MM_delim = "'") Then  ' escape quotes
        MM_formVal = "'" & Replace(MM_formVal,"'","''") & "'"
      Else
        MM_formVal = MM_delim + MM_formVal + MM_delim
      End If
    End If
    If (MM_i <> LBound(MM_fields)) Then
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End If
    MM_tableValues = MM_tableValues & MM_columns(MM_i)
    MM_dbValues = MM_dbValues & MM_formVal
  Next
  MM_editQuery = "insert into " & MM_editTable & " (" & MM_tableValues & ") values (" & MM_dbValues & ")"

  If (Not MM_abortEdit) Then
    ' execute the insert
    Set MM_editCmd = Server.CreateObject("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_editConnection
    MM_editCmd.CommandText = MM_editQuery
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close

    If (MM_editRedirectUrl <> "") Then
      Response.Redirect(MM_editRedirectUrl)
    End If
  End If

End If
%>
<%
set rsQuestions = Server.CreateObject("ADODB.Recordset")
rsQuestions.ActiveConnection = MM_pollingboothmanager_STRING
rsQuestions.Source = "SELECT *  FROM tblPBM_PollQuestions  ORDER BY QuestionID ASC"
rsQuestions.CursorType = 0
rsQuestions.CursorLocation = 2
rsQuestions.LockType = 3
rsQuestions.Open()
rsQuestions_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
rsQuestions_numRows = rsQuestions_numRows + Repeat1__numRows
%>
<%
Dim Repeat2__numRows
Dim Repeat2__index

Repeat2__numRows = -1
Repeat2__index = 0
rsQuestions_numRows = rsQuestions_numRows + Repeat2__numRows
%>
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>					
function DoDateTime(str, nNamedFormat, nLCID)				
	dim strRet								
	dim nOldLCID								
										
	strRet = str								
	If (nLCID > -1) Then							
		oldLCID = Session.LCID						
	End If									
										
	On Error Resume Next							
										
	If (nLCID > -1) Then							
		Session.LCID = nLCID						
	End If									
										
	If ((nLCID < 0) Or (Session.LCID = nLCID)) Then				
		strRet = FormatDateTime(str, nNamedFormat)			
	End If									
										
	If (nLCID > -1) Then							
		Session.LCID = oldLCID						
	End If									
										
	DoDateTime = strRet							
End Function									
</SCRIPT>									
<html>
<head>
<title>Polling Booth Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">

<SCRIPT LANGUAGE="JavaScript">
<!--
<!-- Original:  Mike Best (mike.best@hei-usa.com) -->
<!-- Web Site:  http://www.hei-usa.com -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function checkBoxValidate(cb) {
for (j = 0; j < 8; j++) {
if (eval("document.UpdateQuestion.DisplayStatus[" + j + "].checked") == true) {
document.UpdateQuestion.DisplayStatus[j].checked = false;
if (j == cb) {
document.UpdateQuestion.DisplayStatus[j].checked = true;
         }
      }
   }
}
//  End -->

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="AddQuestion" id="AddQuestion">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="0" height="27">Add New Poll/Question:</td>
      <td width="0" valign="middle">
        <input name="QuestionValue" type="text" id="QuestionValue" size="60">
        <input name="Activated" type="hidden" id="Activated" value="True">
        <input name="QuestionDescription" type="hidden" id="QuestionDescription" value="Enter Description">
        <input name="DateAdded" type="hidden" id="DateAdded" value="<%= DoDateTime(Date(), 2, 7177) %>">
        <input name="TotalVotes" type="hidden" id="TotalVotes" value="0">
		<input name="DisplayStatus" type="hidden" id="DisplayStatus" value="False">
<input name="Submit2" type="submit" value="Add" size="10" height="10">
<input type="hidden" name="MM_insert" value="AddQuestion">
</td>
    </tr>
  </table>
</form>   
<form action="script_update_list.asp" method="post" name="UpdateQuestion" id="UpdateQuestion">
  <div align="right"> </div>
  <table width="100%" height="32" border="0" cellpadding="3" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="0">Poll ID</td>
      <td width="0">Date Added</td>
      <td width="0">Question</td>
      <td width="0"><div align="center">Total Votes</div></td>
      <td width="0"><div align="center">Display</div></td>
      <td width="0"><div align="center">Archive</div>
      </td>
      <td width="0"><div align="center"></div>
          <div align="center">Delete</div>
      </td>
      <td width="0"><div align="center">Actions</div>
      </td>
    </tr>
    <% Dim iCount
  iCount = 0
%>
    <% 
While ((Repeat1__numRows <> 0) AND (NOT rsQuestions.EOF)) 
%>
    <tr valign="middle" class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
      <td width="0"><%=(rsQuestions.Fields.Item("QuestionID").Value)%></td>
      <td width="0"><%=(rsQuestions.Fields.Item("DateAdded").Value)%></td>
      <td width="0">
        <div align="left">
          <input name="<%= (iCount & ".ID") %>" type="hidden" value="<%=(rsQuestions.Fields.Item("QuestionID").Value)%>">
	                <% If (rsQuestions.Fields.Item("DisplayStatus").Value) = "True" Then%> 
                      <font color="#FF0000"><strong>Active</strong></font>
                      <%end if%>	
          <%=(rsQuestions.Fields.Item("QuestionValue").Value)%>
  
        </div></td>
      <td width="0"><div align="center"><%=(rsQuestions.Fields.Item("TotalVotes").Value)%></div></td>
      <td width="0"><div align="center">
          <% nextnumber = nextnumber +1 %>
          <input <%If rsQuestions.Fields.Item("DisplayStatus").Value = "True" Then Response.Write("checked") : Response.Write("")%> name="<%= (iCount & ".DisplayStatus") %>" type="checkbox" id="DisplayStatus" value="True" onClick="javascript:checkBoxValidate(<%=nextnumber-1%>)">
          </div>
      </td>
      <td width="0" align="center"><label> </label>
          <input <%If (rsQuestions.Fields.Item("Activated").Value) = "True" Then Response.Write("checked") : Response.Write("")%> name="<%= (iCount & ".Activated") %>" type="checkbox" value="True">
      </td>
      <td width="0">        <div align="center">
          <input name="<%= (iCount & ".Check") %>" type="checkbox" value="Remove">
        </div>
      </td>
      <td width="0">
        <div align="center" ><a href="javascript:;" onClick="MM_openBrWindow('updateQuestion.asp?QuestionID=<%=(rsQuestions.Fields.Item("QuestionID").Value)%>','Question','scrollbars=yes,resizable=yes,width=600,height=400')">Edit
                Question</a> | <a href="javascript:;" onClick="MM_openBrWindow('updateAnswer.asp?QuestionID=<%=(rsQuestions.Fields.Item("QuestionID").Value)%>','Answers','scrollbars=yes,resizable=yes,width=600,height=400')">Add/Edit
            Answers</a>
<% If (rsQuestions.Fields.Item("DisplayStatus").Value) = "True" then %>
| <a href="javascript:;" onClick="MM_openBrWindow('preview.asp','Preview','scrollbars=yes,resizable=yes,width=600,height=400')">Preview</a>
<%else%>
| <a href="javascript:;" onClick="MM_openBrWindow('preview.asp?QuestionID=<%=(rsQuestions.Fields.Item("QuestionID").Value)%>','Preview','scrollbars=yes,resizable=yes,width=600,height=400')">Preview</a>
<%end if%>
	    </div>
      </td>
    </tr>
    <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  rsQuestions.MoveNext()
  iCount = iCount + 1
Wend
%>
  </table>
  <p align="right">
    <input type="hidden" name="Count" value="<%= iCount - 1 %>">
    <input name="Submit3" type="submit" id="Submit33" value="Save">
</p>
</form>
</body>
</html>
<%
rsQuestions.Close()
%>
