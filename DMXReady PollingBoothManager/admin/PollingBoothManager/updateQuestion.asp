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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "updateQuestion" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_pollingboothmanager_STRING
  MM_editTable = "tblPBM_PollQuestions"
  MM_editColumn = "QuestionID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "QuestionValue|value|QuestionDescription|value|QuestionImage|value"
  MM_columnsStr = "QuestionValue|',none,''|QuestionDescription|',none,''|QuestionImage|',none,''"

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
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="updateQuestion" id="updateQuestion">
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableborder">
  <tr>
    <td width="15%" class="tableheader">Question:</td>
    <td class="tablebody"><input name="QuestionValue" type="text" value="<%=(rsQuestion.Fields.Item("QuestionValue").Value)%>" size="60">      <div align="right"></div>
    </td>
    </tr>
  <tr>
    <td class="tableheader">Question Description:</td>
    <td class="tablebody"><textarea name="QuestionDescription" cols="40" rows="2"><%=(rsQuestion.Fields.Item("QuestionDescription").Value)%></textarea>
    </td>
  </tr>
  <tr>
    <td class="tableheader">Question Image:</td>
    <td class="tablebody">        <% if rsQuestion.Fields.Item("QuestionImage").Value <> "" then %>
          <img src="/applications/PollingBoothManager/images/<%=(rsQuestion.Fields.Item("QuestionImage").Value)%>" alt="Click to Zoom" width="100"> <br>
          <input name="QuestionImage" type="text" id="QuestionImage" value="<%=(rsQuestion.Fields.Item("QuestionImage").Value)%>">
          <% end if%>
        | <a href="javascript:;" onClick="MM_openBrWindow('upload_imageQuestion.asp?QuestionID=<%=(rsQuestion.Fields.Item("QuestionID").Value)%>','Image','scrollbars=yes,width=300,height=150')">Upload
        Image</a> </td></tr>
  <tr>
    <td class="tableheader">&nbsp;</td>
    <td class="tablebody"><input type="submit" name="Submit32" value="Save"></td>
  </tr>
</table>




<input type="hidden" name="MM_update" value="updateQuestion">
<input type="hidden" name="MM_recordId" value="<%= rsQuestion.Fields.Item("QuestionID").Value %>">
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="0"><a href="javascript:history.go(-1);">Go back</a></td>
    <td width="0"><div align="center"><a href="updateAnswer.asp?QuestionID=<%=(rsQuestion.Fields.Item("QuestionID").Value)%>">Edit Answers</a></div></td>
    <td width="0"><div align="right"><a href="closewindow_redirect.asp">Close</a></div>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html><%
rsQuestion.Close()
Set rsQuestion = Nothing
%>
<%
rsAnswer.Close()
Set rsAnswer = Nothing
%>
