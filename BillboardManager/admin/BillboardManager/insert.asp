<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/billboardmanager.asp" -->
<%
' *** declare variables
TM_editAction = CStr(Request("URL"))
If (Request.QueryString <> "") Then
  TM_editAction = TM_editAction & "?" & Request.QueryString
End If
' boolean to abort record edit
TM_abortEdit = false
%>
<%
' *** Insert Record and retrieve autonumber: set variables
If (CStr(Request("TM_insert")) <> "") Then
  MM_editConnection = MM_billboardmanager_STRING
  TM_editTable = "Billboard"
  TM_editRedirectUrl = "update.asp"
  TM_fieldsStr  = "CategoryID|value|ItemName|value|DateAdded|value|ItemMemo|value|ItemDesc|value|Activated|value"
  TM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|DateAdded|',none,''|ItemMemo|',none,''|ItemDesc|',none,''|Activated|',none,''"
  ' create the TM_fields and TM_columns arrays
  TM_fields = Split(TM_fieldsStr, "|")
  TM_columns = Split(TM_columnsStr, "|")  
  ' set the form values
  For i = LBound(TM_fields) To UBound(TM_fields) Step 2
    TM_fields(i+1) = CStr(Request.Form(TM_fields(i)))
  Next

' append the query string to the redirect URL
  If (TM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, TM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      TM_editRedirectUrl = TM_editRedirectUrl & "?" & Request.QueryString
    Else
      TM_editRedirectUrl = TM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If
  TM_dontClose = false
Else
  TM_dontClose = true
End If
%>
<%
' *** Insert Record and retrieve autonumber for MS Access
' *** ID value is stored in the TM_editCmd("youridcolumn") value
If (CStr(Request("TM_insert")) <> "") Then
  ' create the sql insert statement
  TM_tableValues = ""
  TM_dbValues = ""
  For i = LBound(TM_fields) To UBound(TM_fields) Step 2
    FormVal = TM_fields(i+1)
    TM_typeArray = Split(TM_columns(i+1),",")
    Delim = TM_typeArray(0)
    If (Delim = "none") Then Delim = ""
    AltVal = TM_typeArray(1)
    If (AltVal = "none") Then AltVal = ""
    EmptyVal = TM_typeArray(2)
    If (EmptyVal = "none") Then EmptyVal = ""
	if (EmptyVal = "NULL") then EmptyVal = ""
    If (FormVal = "") Then
      FormVal = EmptyVal
    Else
      If (AltVal <> "") Then
        FormVal = AltVal
      End If
    End If
	TM_fields(i+1) = FormVal
  Next
  If (Not TM_abortEdit) Then
    ' execute the insert using the AddNew method
    set TM_editCmd = Server.CreateObject("ADODB.Recordset")
    TM_editCmd.ActiveConnection = MM_editConnection
    TM_editCmd.CursorType = 1
    TM_editCmd.LockType = 3
    TM_editCmd.Source = TM_editTable
    TM_editCmd.Open
    TM_editCmd.AddNew 
	For i = LBound(TM_fields) To UBound(TM_fields) Step 2
	'If a value for the column name was passed in,
	'set the column name equal to the value passed through the form...
	if Len(TM_fields(i+1)) > 0 AND TM_fields(i+1)<> "''" then
		TM_editCmd.Fields(TM_columns(i)) = TM_fields(i+1)
	end if
    Next
    TM_editCmd.Update
    Session("ItemID") = TM_editCmd("ItemID")
     If (TM_editRedirectUrl <> "") Then
      TM_editCmd.ActiveConnection.Close
      Response.Redirect(TM_editRedirectUrl)
    End If
  End If
End If
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_billboardmanager_STRING
Category.Source = "SELECT *  FROM BillboardCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
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
<title>Insert</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td> 
      <form ACTION="<%=TM_editAction%>" METHOD="POST" name="Insert" id="Insert">
        <table width="100%" align="center" class="tableborder">
          <tr> 
            <td colspan="2" align="right" valign="baseline" nowrap class="tableheader">Update Billboard Item</td>
          </tr>
          <tr> 
            <td width="12%" align="right" valign="baseline" nowrap class="tableheader">Category:</td>
            <td width="88%" valign="baseline" class="tablebody"> 
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
              | <a href="add_category.asp">add a new category</a> </td>
          </tr>
          <tr> 
            <td width="12%" align="right" valign="baseline" nowrap class="tableheader">Item Name:</td>
            <td class="tablebody" width="88%"> 
              <textarea name="ItemName" cols="60" rows="2"></textarea>
            </td>
          </tr>
          <tr> 
            <td width="12%" height="23" align="right" valign="baseline" nowrap class="tableheader">&nbsp;</td>
            <td width="88%" valign="baseline" class="tablebody">
<input type="submit" value="Continue">
              <input name="DateAdded" type="hidden" id="DateAdded" value="<%= DoDateTime(Date(), 2, 7177) %>">
            <input name="ItemMemo" type="hidden" id="ItemMemo" value="Enter Details">
            <input name="ItemDesc" type="hidden" id="ItemDesc" value="Enter Short Description">
            <input name="Activated" type="hidden" id="Activated" value="True"></td>
          </tr>
        </table>
        <input type="hidden" name="TM_insert" value="true">
</form>
    </td>
  </tr>
</table>
</body>
</html>
<% If Not TM_dontClose Then TM_editCmd.ActiveConnection.Close %>
<%
Category.Close()
%>

