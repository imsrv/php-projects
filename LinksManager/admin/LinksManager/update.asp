<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/linksmanager.asp" -->
<%
Dim List__update
List__update = "1000"
If (Request.QueryString("ItemID")  <> "") Then 
  List__update = Request.QueryString("ItemID") 
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
  MM_editConnection = MM_linksmanager_STRING
  MM_editTable = "Links"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "LinkName|value|LinkUrl|value|LinkDescription|value|CategoryID|value|Activated|value"
  MM_columnsStr = "ItemName|',none,''|ItemUrl|',none,''|ItemDesc|',none,''|CategoryID|none,none,NULL|Activated|',none,''"
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
set List = Server.CreateObject("ADODB.Recordset")
List.ActiveConnection = MM_linksmanager_STRING
List.Source = "SELECT Links.*, LinksCategory.CategoryName, LinksCategory.ParentCategoryID, LinksCategory.CategoryDesc  FROM LinksCategory RIGHT JOIN Links ON LinksCategory.CategoryID = Links.CategoryID  WHERE ItemID = " + Replace(List__update, "'", "''") + "  ORDER BY Links.DateAdded"
List.CursorType = 0
List.CursorLocation = 2
List.LockType = 3
List.Open()
List_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_linksmanager_STRING
Category.Source = "SELECT *  FROM LinksCategory ORDER BY CategoryID"
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
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="240">
  <tr> 
    <td> 
      <form method="POST" action="<%=MM_editAction%>" name="form1">
        <table width="100%" align="center" class="tableborder">
          <tr valign="baseline"> 
            <td colspan="2" align="right" nowrap class="tableheader">Update Existing Link </td>
          </tr>
          <tr valign="baseline"> 
            <td width="11%" align="right" nowrap class="tableheader">Link Name:</td>
            <td width="89%"> 
           <input type="text" name="LinkName" value="<%=(List.Fields.Item("ItemName").Value)%>" size="50">
           <img src="questionmark.gif" alt="Enter a short name to identify the link i.e &quot;City Hall&quot;" width="15" height="15"></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap class="tableheader">Link Url:</td>
           <td> 
              <input type="text" name="LinkUrl" value="<%=(List.Fields.Item("ItemUrl").Value)%>" size="50">
              <img src="questionmark.gif" alt="Enter the actual URL link i.e. http://www.cityhall.com" width="15" height="15"></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap class="tableheader"> URL</td>
            <td><a href="<%=(List.Fields.Item("ItemUrl").Value)%>" target="_blank"><%=(List.Fields.Item("ItemUrl").Value)%></a> </td>
          </tr>
          <tr> 
            <td align="right" valign="top" nowrap class="tableheader">Link Description:</td>
            <td valign="baseline"> 
              <textarea name="LinkDescription" cols="50" rows="3"><%=(List.Fields.Item("ItemDesc").Value)%></textarea>
              <img src="questionmark.gif" alt="Enter a description of this link i.e. &quot;This is a link to the official website of City Hall" width="15" height="15"></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap class="tableheader">Category:</td>
            <td> 
              <select name="CategoryID">
               <%
While (NOT Category.EOF)
%>
                <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%if (CStr(Category.Fields.Item("CategoryID").Value) = CStr(List.Fields.Item("CategoryID").Value)) then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
              <img src="questionmark.gif" alt="(select a category that best desribes the link i.e. &quot;Government Offices&quot; )" width="15" height="15"> 
              | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
      category</a> </td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap class="tableheader">Activated:</td>
            <td> 
             <input type="checkbox" name="Activated" <%If (CStr(List.Fields.Item("Activated").Value) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> value="True">
              <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15"></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap class="tableheader">Date Added:</td>
            <td><%=(List.Fields.Item("DateAdded").Value)%>
            </td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap class="tableheader">&nbsp;</td>
            <td> 
              <input type="submit" value="Publish To Links Page">
            </td>
          </tr>
        </table>   
<input type="hidden" name="MM_update" value="form1">
<input type="hidden" name="MM_recordId" value="<%= List.Fields.Item("ItemID").Value %>">
      </form>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<%
List.Close()
%>
<%
Category.Close()
%>
