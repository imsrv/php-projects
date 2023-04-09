<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/faqsmanager.asp" -->
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
If (CStr(Request("MM_insert")) <> "") Then
  MM_editConnection = MM_faqsmanager_STRING
  MM_editTable = "Faq"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "CategoryID|value|Faq_Question|value|Faq_Answer|value|Faq_Related_Link|value|Activated|value"
  MM_columnsStr = "CategoryID|none,none,NULL|FaqQuestion|',none,''|FaqAnswer|',none,''|FaqRelatedLink|',none,''|Activated|',none,''"
  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  ' set the form values
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(i+1) = CStr(Request.Form(MM_fields(i)))
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
set List_Faq = Server.CreateObject("ADODB.Recordset")
List_Faq.ActiveConnection = MM_faqsmanager_STRING
List_Faq.Source = "SELECT *  FROM Faq"
List_Faq.CursorType = 0
List_Faq.CursorLocation = 2
List_Faq.LockType = 3
List_Faq.Open()
List_Faq_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_faqsmanager_STRING
Category.Source = "SELECT *  FROM FaqCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<head>
<title>Insert</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
      <form method="POST" action="<%=MM_editAction%>" name="form1">
        <table width="100%" align="center" class="tableborder">
          <tr valign="baseline">
            <td colspan="2" align="right" nowrap class="tableheader">Insert New FAQ</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Category:</td>
            <td>
              <select name="CategoryID">
                <%
While (NOT Category.EOF)
%>
                <option value="<%=(Category.Fields.Item("CategoryID").Value)%>"><%=(Category.Fields.Item("CategoryName").Value)%></option>
                <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
      category</a> <img src="questionmark.gif" alt="Select a category that best describes the FAQ i.e. Shipping & Handling" width="15" height="15"></td>
          </tr>
          <tr>
            <td align="right" valign="top" nowrap class="tableheader">Faq Question:</td>
            <td valign="baseline">
              <textarea name="Faq_Question" cols="50" rows="5"></textarea>
            <img src="questionmark.gif" alt="Enter the Frequesntly Asked Question" width="15" height="15">            </td>
          </tr>
          <tr>
            <td align="right" valign="top" nowrap class="tableheader">Faq Answer:</td>
            <td valign="baseline">
              <textarea name="Faq_Answer" cols="50" rows="5"></textarea>
            <img src="questionmark.gif" alt="Enter the answer to the Frequesntly Asked Question" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Faq Related Link:</td>
            <td>
              <input type="text" name="Faq_Related_Link" value="http://" size="32">
            <img src="questionmark.gif" alt="Provide a link to additional information regarding the FAQ i.e. http://www.dmxready.com" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Activated:</td>
            <td>
              <input type="checkbox" name="Activated" value=True checked>
            <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">&nbsp;</td>
            <td>
              <input name="submit" type="submit" value="Publish to FAQ page">
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<%
List_Faq.Close()
%>
<%
Category.Close()
%>



