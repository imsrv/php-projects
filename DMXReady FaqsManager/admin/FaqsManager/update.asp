<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/faqsmanager.asp" -->
<%
Dim List_Faq__update
List_Faq__update = "1000"
If (Request.QueryString("ItemID")  <> "") Then 
  List_Faq__update = Request.QueryString("ItemID") 
End If
%>
<%
' *** Edit Operations: declare variables
MM_editAction = CStr(Request("URL"))
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
If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_faqsmanager_STRING
  MM_editTable = "Faq"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
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
' *** Update Record: construct a sql update statement and execute it
If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then
  ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    FormVal = MM_fields(i+1)
    MM_typeArray = Split(MM_columns(i+1),",")
    Delim = MM_typeArray(0)
    If (Delim = "none") Then Delim = ""
    AltVal = MM_typeArray(1)
    If (AltVal = "none") Then AltVal = ""
    EmptyVal = MM_typeArray(2)
    If (EmptyVal = "none") Then EmptyVal = ""
    If (FormVal = "") Then
      FormVal = EmptyVal
    Else
      If (AltVal <> "") Then
        FormVal = AltVal
      ElseIf (Delim = "'") Then  ' escape quotes
        FormVal = "'" & Replace(FormVal,"'","''") & "'"
      Else
        FormVal = Delim + FormVal + Delim
      End If
    End If
    If (i <> LBound(MM_fields)) Then
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(i) & " = " & FormVal
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
set List_Faq = Server.CreateObject("ADODB.Recordset")
List_Faq.ActiveConnection = MM_faqsmanager_STRING
List_Faq.Source = "SELECT Faq.*, FaqCategory.CategoryName, FaqCategory.ParentCategoryID, FaqCategory.CategoryDesc  FROM FaqCategory RIGHT JOIN Faq ON FaqCategory.CategoryID = Faq.CategoryID  WHERE ItemID = " + Replace(List_Faq__update, "'", "''") + ""
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
<title>Update</title>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td> 
      <form method="POST" action="<%=MM_editAction%>" name="form1">
        <table width="100%" align="center" class="tableborder">
          <tr valign="baseline">
            <td colspan="2" align="right" nowrap class="tableheader">Update Record</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Category:</td>
            <td>
              <select name="CategoryID">
                <%
While (NOT Category.EOF)
%>
                <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((List_Faq.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((List_Faq.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
              <textarea name="Faq_Question" cols="50" rows="5"><%=(List_Faq.Fields.Item("FaqQuestion").Value)%></textarea>
            <img src="questionmark.gif" alt="Enter the Frequesntly Asked Question" width="15" height="15">            </td>
          </tr>
          <tr>
            <td align="right" valign="top" nowrap class="tableheader">Faq Answer:</td>
            <td valign="baseline">
              <textarea name="Faq_Answer" cols="50" rows="5"><%=(List_Faq.Fields.Item("FaqAnswer").Value)%></textarea>
            <img src="questionmark.gif" alt="Enter the answer to the Frequesntly Asked Question" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Faq Related Link:</td>
            <td>
              <input type="text" name="Faq_Related_Link" value="<%=(List_Faq.Fields.Item("FaqRelatedLink").Value)%>" size="32">
            <img src="questionmark.gif" alt="Provide a link to additional information regarding the FAQ i.e. http://www.dmxready.com" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">Activated:</td>
            <td>
            <input <%If (CStr((List_Faq.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True">
            <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15">            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader">&nbsp;</td>
            <td>
              <input name="submit" type="submit" value="Publish to FAQ page">
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1">
<input type="hidden" name="MM_recordId" value="<%= List_Faq.Fields.Item("ItemID").Value %>">
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<%
List_Faq.Close()
%>
<%
Category.Close()
%>
