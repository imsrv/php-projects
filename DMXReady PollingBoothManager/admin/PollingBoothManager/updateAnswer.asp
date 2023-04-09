<%@LANGUAGE="VBSCRIPT"%>
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

If (CStr(Request("MM_insert")) = "insertAnswers") Then

  MM_editConnection = MM_pollingboothmanager_STRING
  MM_editTable = "tblPBM_PollAnswers"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "AnswerValue|value|QuestionIDkey|value"
  MM_columnsStr = "AnswerValue|',none,''|QuestionIDkey|none,none,NULL"

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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "updateAnswers" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_pollingboothmanager_STRING
  MM_editTable = "tblPBM_PollAnswers"
  MM_editColumn = "AnswerID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "AnswerValue|value|AnswerDescription|value|AnswerImage|value"
  MM_columnsStr = "AnswerValue|',none,''|AnswerDescription|',none,''|AnswerImage|',none,''"

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
' *** Update Record: construct a sql update statement and execute it

If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then

  ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
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
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(MM_i) & " = " & MM_formVal
  Next
  MM_editQuery = MM_editQuery & " where " & MM_editColumn & " = " & MM_recordId

  If (Not MM_abortEdit) Then
    ' execute the update
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
Dim rsQuestion__MMColParam
rsQuestion__MMColParam = "17"
If (Request.QueryString("QuestionID")   <> "") Then 
  rsQuestion__MMColParam = Request.QueryString("QuestionID")  
End If
%>
<%
set rsQuestion = Server.CreateObject("ADODB.Recordset")
rsQuestion.ActiveConnection = MM_pollingboothmanager_STRING
rsQuestion.Source = "SELECT tblPBM_PollQuestions.*, tblPBM_PollAnswers.*  FROM tblPBM_PollAnswers RIGHT JOIN tblPBM_PollQuestions ON tblPBM_PollAnswers.QuestionIDkey = tblPBM_PollQuestions.QuestionID  WHERE QuestionID = " + Replace(rsQuestion__MMColParam, "'", "''") + ""
rsQuestion.CursorType = 0
rsQuestion.CursorLocation = 2
rsQuestion.LockType = 3
rsQuestion.Open()
rsQuestion_numRows = 0
%>
<%
Dim rsAnswer__MMColParam
rsAnswer__MMColParam = "0"
If (Request.QueryString("AnswerID")    <> "") Then 
  rsAnswer__MMColParam = Request.QueryString("AnswerID")   
End If
%>
<%
set rsAnswer = Server.CreateObject("ADODB.Recordset")
rsAnswer.ActiveConnection = MM_pollingboothmanager_STRING
rsAnswer.Source = "SELECT *  FROM tblPBM_PollAnswers  WHERE AnswerID = " + Replace(rsAnswer__MMColParam, "'", "''") + ""
rsAnswer.CursorType = 0
rsAnswer.CursorLocation = 2
rsAnswer.LockType = 3
rsAnswer.Open()
rsAnswer_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
rsQuestion_numRows = rsQuestion_numRows + Repeat1__numRows
%>
<script language="JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') {
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (val<min || max<val) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<link href="../styles.css" rel="stylesheet" type="text/css">

  <title><%=(rsQuestion.Fields.Item("QuestionValue").Value)%></title>
  <script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
  </script>
  <form action="<%=MM_editAction%>" method="POST" name="insertAnswers" id="insertAnswers">
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableborder">
    <tr valign="top">
      <td height="34" align="right" ><div align="left">
        <p><font size="3"><em><a href="updateQuestion.asp?QuestionID=<%=(rsQuestion.Fields.Item("QuestionID").Value)%>"><strong><%=(rsQuestion.Fields.Item("QuestionValue").Value)%></strong></a></em></font><br>
        <%=(rsQuestion.Fields.Item("QuestionDescription").Value)%> </p>
      </div></td>
    </tr>
    <tr>
      <td class="tableheader">
Add an answer:
            <input name="AnswerValue" type="text" id="AnswerValue" size="40" maxlength="40">
            <input name="QuestionIDkey" type="hidden" id="QuestionIDkey" value="<%=((rsQuestion.Fields.Item("QuestionID").Value))%>">
            <input type="hidden" name="MM_insert" value="insertAnswers">
            <input type="submit" name="Submit" value="Add">
      </td>
    </tr>
    <tr>
      <td align="right" valign="top">
            <% 
While ((Repeat1__numRows <> 0) AND (NOT rsQuestion.EOF)) 
%>
           <table width="100%" cellpadding="2" cellspacing="0" <% if Request.QueryString("AnswerID") = "" & (rsQuestion.Fields.Item("AnswerID").Value) then %> class="rowActive" <%else%> <%end if%> >
              <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
               <td width="0">
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>.&nbsp;<strong><%=(rsQuestion.Fields.Item("AnswerValue").Value)%></strong> 
        <% if rsQuestion.Fields.Item("AnswerImage").Value <> "" then %>
        <img src="/applications/PollingBoothManager/images/<%=(rsQuestion.Fields.Item("AnswerImage").Value)%>" width="20">
        <% end if%>

              </td>
               <td width="0"><p align="right"><a href="?QuestionID=<%=request.querystring("QuestionID")%>&AnswerID=<%=(rsQuestion.Fields.Item("AnswerID").Value)%>">Edit</a> | <a href="delete.asp?AnswerID=<%=(rsQuestion.Fields.Item("AnswerID").Value)%>&QuestionID=<%=(rsQuestion.Fields.Item("QuestionID").Value)%>">Delete</a></p>
               </td>
             </tr>
           </table>
            
           <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  rsQuestion.MoveNext()
Wend
%>
        
      </ol></td>
  </tr>
</table>
</form>
<% If Not rsAnswer.EOF Or Not rsAnswer.BOF Then %>
<form action="<%=MM_editAction%>" method="POST" name="updateAnswers" id="updateAnswers">
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableborder">
    <tr>
      <td width="15%" class="tableheader">Answer:</td>
      <td width="85%" class="tablebody"><input name="AnswerValue" type="text" id="AnswerValue" value="<%=(rsAnswer.Fields.Item("AnswerValue").Value)%>"></td>
    </tr>
    <tr>
      <td class="tableheader">Answer Description:</td>
      <td class="tablebody"><textarea name="AnswerDescription" id="AnswerDescription"><%=(rsAnswer.Fields.Item("AnswerDescription").Value)%></textarea></td>
    </tr>
    <tr>
      <td class="tableheader">Answer Image:</td>
      <td class="tablebody">        <% if rsAnswer.Fields.Item("AnswerImage").Value <> "" then %>
          <img src="/applications/PollingBoothManager/images/<%=(rsAnswer.Fields.Item("AnswerImage").Value)%>" alt="Click to Zoom" width="100"> <br>
          <input name="AnswerImage" type="text" id="AnswerImage" value="<%=(rsAnswer.Fields.Item("AnswerImage").Value)%>">
          <% end if%>
    | <a href="javascript:;" onClick="MM_openBrWindow('upload_imageAnswer.asp?AnswerID=<%=(rsAnswer.Fields.Item("AnswerID").Value)%>','Image','scrollbars=yes,width=300,height=150')">Upload
    Image</a> </td>
    </tr>
    <tr>
      <td class="tableheader">&nbsp;</td>
      <td class="tablebody"><input type="submit" name="Submit3" value="Save">
</td>
    </tr>
  </table>
  <input type="hidden" name="MM_recordId" value="<%= rsAnswer.Fields.Item("AnswerID").Value %>">
  <input type="hidden" name="MM_update" value="updateAnswers">
</form>
<% End If ' end Not rsAnswer.EOF Or NOT rsAnswer.BOF %>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><a href="javascript:history.go(-1);">Go
    back</a></td>
    <td width="50%"><div align="right"><a href="javascript:self.close()">Close</a></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<div align="center"></div>
  </body>
</html><%
rsQuestion.Close()
Set rsQuestion = Nothing
%>
<%
rsAnswer.Close()
Set rsAnswer = Nothing
%>
