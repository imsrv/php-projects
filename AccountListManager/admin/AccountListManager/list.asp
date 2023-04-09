<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/accountlistmanager.asp" -->
<%
Dim List_Accounts__MMColParam1
List_Accounts__MMColParam1 = "%"
if (Request("search")  <> "") then List_Accounts__MMColParam1 = Request("search") 
%>
<%
Dim List_Accounts__MMColParam2
List_Accounts__MMColParam2 = "%"
if (Request("searchcat")  <> "") then List_Accounts__MMColParam2 = Request("searchcat") 
%>
<%
set List_Accounts = Server.CreateObject("ADODB.Recordset")
List_Accounts.ActiveConnection = MM_accountlistmanager_STRING
List_Accounts.Source = "SELECT tblAM_Accounts.*, tblAM_AccountsCategory.CategoryValue, tblAM_AccountsCategory.ParentCategoryID, tblAM_AccountsCategory.CategoryDesc  FROM tblAM_AccountsCategory RIGHT JOIN tblAM_Accounts ON tblAM_AccountsCategory.CategoryID = tblAM_Accounts.AccountCategoryID  WHERE tblAM_AccountsCategory.CategoryValue Like '" + Replace(List_Accounts__MMColParam2, "'", "''") + "'  AND (tblAM_Accounts.AccountName1 Like '%" + Replace(List_Accounts__MMColParam1, "'", "''") + "%' OR tblAM_Accounts.AccountName2 Like '%" + Replace(List_Accounts__MMColParam1, "'", "''") + "%')  ORDER BY tblAM_Accounts.AccountName1"
List_Accounts.CursorType = 0
List_Accounts.CursorLocation = 2
List_Accounts.LockType = 3
List_Accounts.Open()
List_Accounts_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_accountlistmanager_STRING
Category.Source = "SELECT tblAM_AccountsCategory.CategoryValue, tblAM_AccountsCategory.CategoryLabel, tblAM_AccountsCategory.CategoryID  FROM tblAM_Accounts LEFT JOIN tblAM_AccountsCategory ON tblAM_Accounts.AccountCategoryID = tblAM_AccountsCategory.CategoryID  GROUP BY tblAM_AccountsCategory.CategoryValue,tblAM_AccountsCategory.CategoryLabel,tblAM_AccountsCategory.CategoryID HAVING (((tblAM_AccountsCategory.CategoryValue) Is Not Null))"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim List_AccountsRepeat__numRows
List_AccountsRepeat__numRows = 25
Dim List_AccountsRepeat__index
List_AccountsRepeat__index = 0
List_Accounts_numRows = List_Accounts_numRows + List_AccountsRepeat__numRows
%>
  <% If Not List_Accounts.EOF Or Not List_Accounts.BOF Then %>
<%
'  *** Recordset Stats, Move To Record, and Go To Record: declare stats variables

Dim List_Accounts_total
Dim List_Accounts_first
Dim List_Accounts_last

' set the record count
List_Accounts_total = List_Accounts.RecordCount

' set the number of rows displayed on this page
If (List_Accounts_numRows < 0) Then
  List_Accounts_numRows = List_Accounts_total
Elseif (List_Accounts_numRows = 0) Then
  List_Accounts_numRows = 1
End If

' set the first and last displayed record
List_Accounts_first = 1
List_Accounts_last  = List_Accounts_first + List_Accounts_numRows - 1

' if we have the correct record count, check the other stats
If (List_Accounts_total <> -1) Then
  If (List_Accounts_first > List_Accounts_total) Then
    List_Accounts_first = List_Accounts_total
  End If
  If (List_Accounts_last > List_Accounts_total) Then
    List_Accounts_last = List_Accounts_total
  End If
  If (List_Accounts_numRows > List_Accounts_total) Then
    List_Accounts_numRows = List_Accounts_total
  End If
End If
%>
<%
' *** Recordset Stats: if we don't know the record count, manually count them

If (List_Accounts_total = -1) Then

  ' count the total records by iterating through the recordset
  List_Accounts_total=0
  While (Not List_Accounts.EOF)
    List_Accounts_total = List_Accounts_total + 1
    List_Accounts.MoveNext
  Wend

  ' reset the cursor to the beginning
  If (List_Accounts.CursorType > 0) Then
    List_Accounts.MoveFirst
  Else
    List_Accounts.Requery
  End If

  ' set the number of rows displayed on this page
  If (List_Accounts_numRows < 0 Or List_Accounts_numRows > List_Accounts_total) Then
    List_Accounts_numRows = List_Accounts_total
  End If

  ' set the first and last displayed record
  List_Accounts_first = 1
  List_Accounts_last = List_Accounts_first + List_Accounts_numRows - 1
  
  If (List_Accounts_first > List_Accounts_total) Then
    List_Accounts_first = List_Accounts_total
  End If
  If (List_Accounts_last > List_Accounts_total) Then
    List_Accounts_last = List_Accounts_total
  End If

End If
%>
<%
Dim MM_paramName 
%>
<%
' *** Move To Record and Go To Record: declare variables

Dim MM_rs
Dim MM_rsCount
Dim MM_size
Dim MM_uniqueCol
Dim MM_offset
Dim MM_atTotal
Dim MM_paramIsDefined

Dim MM_param
Dim MM_index

Set MM_rs    = List_Accounts
MM_rsCount   = List_Accounts_total
MM_size      = List_Accounts_numRows
MM_uniqueCol = ""
MM_paramName = ""
MM_offset = 0
MM_atTotal = false
MM_paramIsDefined = false
If (MM_paramName <> "") Then
  MM_paramIsDefined = (Request.QueryString(MM_paramName) <> "")
End If
%>
<%
' *** Move To Record: handle 'index' or 'offset' parameter

if (Not MM_paramIsDefined And MM_rsCount <> 0) then

  ' use index parameter if defined, otherwise use offset parameter
  MM_param = Request.QueryString("index")
  If (MM_param = "") Then
    MM_param = Request.QueryString("offset")
  End If
  If (MM_param <> "") Then
    MM_offset = Int(MM_param)
  End If

  ' if we have a record count, check if we are past the end of the recordset
  If (MM_rsCount <> -1) Then
    If (MM_offset >= MM_rsCount Or MM_offset = -1) Then  ' past end or move last
      If ((MM_rsCount Mod MM_size) > 0) Then         ' last page not a full repeat region
        MM_offset = MM_rsCount - (MM_rsCount Mod MM_size)
      Else
        MM_offset = MM_rsCount - MM_size
      End If
    End If
  End If

  ' move the cursor to the selected record
  MM_index = 0
  While ((Not MM_rs.EOF) And (MM_index < MM_offset Or MM_offset = -1))
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend
  If (MM_rs.EOF) Then 
    MM_offset = MM_index  ' set MM_offset to the last possible record
  End If

End If
%>
<%
' *** Move To Record: if we dont know the record count, check the display range

If (MM_rsCount = -1) Then

  ' walk to the end of the display range for this page
  MM_index = MM_offset
  While (Not MM_rs.EOF And (MM_size < 0 Or MM_index < MM_offset + MM_size))
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend

  ' if we walked off the end of the recordset, set MM_rsCount and MM_size
  If (MM_rs.EOF) Then
    MM_rsCount = MM_index
    If (MM_size < 0 Or MM_size > MM_rsCount) Then
      MM_size = MM_rsCount
    End If
  End If

  ' if we walked off the end, set the offset based on page size
  If (MM_rs.EOF And Not MM_paramIsDefined) Then
    If (MM_offset > MM_rsCount - MM_size Or MM_offset = -1) Then
      If ((MM_rsCount Mod MM_size) > 0) Then
        MM_offset = MM_rsCount - (MM_rsCount Mod MM_size)
      Else
        MM_offset = MM_rsCount - MM_size
      End If
    End If
  End If

  ' reset the cursor to the beginning
  If (MM_rs.CursorType > 0) Then
    MM_rs.MoveFirst
  Else
    MM_rs.Requery
  End If

  ' move the cursor to the selected record
  MM_index = 0
  While (Not MM_rs.EOF And MM_index < MM_offset)
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend
End If
%>
<%
' *** Move To Record: update recordset stats

' set the first and last displayed record
List_Accounts_first = MM_offset + 1
List_Accounts_last  = MM_offset + MM_size

If (MM_rsCount <> -1) Then
  If (List_Accounts_first > MM_rsCount) Then
    List_Accounts_first = MM_rsCount
  End If
  If (List_Accounts_last > MM_rsCount) Then
    List_Accounts_last = MM_rsCount
  End If
End If

' set the boolean used by hide region to check if we are on the last record
MM_atTotal = (MM_rsCount <> -1 And MM_offset + MM_size >= MM_rsCount)
%>
<%
' *** Go To Record and Move To Record: create strings for maintaining URL and Form parameters

Dim MM_keepNone
Dim MM_keepURL
Dim MM_keepForm
Dim MM_keepBoth

Dim MM_removeList
Dim MM_item
Dim MM_nextItem

' create the list of parameters which should not be maintained
MM_removeList = "&index="
If (MM_paramName <> "") Then
  MM_removeList = MM_removeList & "&" & MM_paramName & "="
End If

MM_keepURL=""
MM_keepForm=""
MM_keepBoth=""
MM_keepNone=""

' add the URL parameters to the MM_keepURL string
For Each MM_item In Request.QueryString
  MM_nextItem = "&" & MM_item & "="
  If (InStr(1,MM_removeList,MM_nextItem,1) = 0) Then
    MM_keepURL = MM_keepURL & MM_nextItem & Server.URLencode(Request.QueryString(MM_item))
  End If
Next

' add the Form variables to the MM_keepForm string
For Each MM_item In Request.Form
  MM_nextItem = "&" & MM_item & "="
  If (InStr(1,MM_removeList,MM_nextItem,1) = 0) Then
    MM_keepForm = MM_keepForm & MM_nextItem & Server.URLencode(Request.Form(MM_item))
  End If
Next

' create the Form + URL string and remove the intial '&' from each of the strings
MM_keepBoth = MM_keepURL & MM_keepForm
If (MM_keepBoth <> "") Then 
  MM_keepBoth = Right(MM_keepBoth, Len(MM_keepBoth) - 1)
End If
If (MM_keepURL <> "")  Then
  MM_keepURL  = Right(MM_keepURL, Len(MM_keepURL) - 1)
End If
If (MM_keepForm <> "") Then
  MM_keepForm = Right(MM_keepForm, Len(MM_keepForm) - 1)
End If

' a utility function used for adding additional parameters to these strings
Function MM_joinChar(firstItem)
  If (firstItem <> "") Then
    MM_joinChar = "&"
  Else
    MM_joinChar = ""
  End If
End Function
%>
<%
' *** Move To Record: set the strings for the first, last, next, and previous links

Dim MM_keepMove
Dim MM_moveParam
Dim MM_moveFirst
Dim MM_moveLast
Dim MM_moveNext
Dim MM_movePrev

Dim MM_urlStr
Dim MM_paramList
Dim MM_paramIndex
Dim MM_nextParam

MM_keepMove = MM_keepBoth
MM_moveParam = "index"

' if the page has a repeated region, remove 'offset' from the maintained parameters
If (MM_size > 1) Then
  MM_moveParam = "offset"
  If (MM_keepMove <> "") Then
    MM_paramList = Split(MM_keepMove, "&")
    MM_keepMove = ""
    For MM_paramIndex = 0 To UBound(MM_paramList)
      MM_nextParam = Left(MM_paramList(MM_paramIndex), InStr(MM_paramList(MM_paramIndex),"=") - 1)
      If (StrComp(MM_nextParam,MM_moveParam,1) <> 0) Then
        MM_keepMove = MM_keepMove & "&" & MM_paramList(MM_paramIndex)
      End If
    Next
    If (MM_keepMove <> "") Then
      MM_keepMove = Right(MM_keepMove, Len(MM_keepMove) - 1)
    End If
  End If
End If

' set the strings for the move to links
If (MM_keepMove <> "") Then 
  MM_keepMove = MM_keepMove & "&"
End If

MM_urlStr = Request.ServerVariables("URL") & "?" & MM_keepMove & MM_moveParam & "="

MM_moveFirst = MM_urlStr & "0"
MM_moveLast  = MM_urlStr & "-1"
MM_moveNext  = MM_urlStr & CStr(MM_offset + MM_size)
If (MM_offset - MM_size < 0) Then
  MM_movePrev = MM_urlStr & "0"
Else
  MM_movePrev = MM_urlStr & CStr(MM_offset - MM_size)
End If
%>
<%end if%>
<html>
<head>
<title>Account List Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
      <form name="form1" method="post" action="">
	  <table width="100%" height="23" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="21" width="50%"> 
        <div align="left">Search by <%=(Category.Fields.Item("CategoryLabel").Value)%>
           <select name="searchcat" id="searchcat">
             <option value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
              All</option>
             <%
While (NOT Category.EOF)
%>
             <option value="<%=(Category.Fields.Item("CategoryValue").Value)%>" <%If (Not isNull(Request.Form("searchcat"))) Then If (CStr(Category.Fields.Item("CategoryValue").Value) = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
          <input type="submit" value="Go" name="submit2">
        </div>
    </td>
    <td height="21" width="50%"> 
        <div align="right">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>
    </td>
  </tr>
</table> 
</form>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
    <td width="0"></td>
    <td width="0">Name</td>
    <td width="0">Category</td>
    <td width="0">AccountID</td>
    <td width="0">Address</td>
    <td width="0">City</td>
    <td width="0"><div align="center"> <a href="insert.asp">Insert New</a></div></td>
  </tr>
      <% Dim iCount
  iCount = 0
%>
  <% 
While ((List_AccountsRepeat__numRows <> 0) AND (NOT List_Accounts.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
    <td width="0" height="13">      <strong><strong><%Response.Write(RecordCounter + MM_offset)%>
        . </strong>
    </strong>   </td>
    <td width="0"><%=(List_Accounts.Fields.Item("AccountName1").Value)%></td>
    <td width="0" height="13"><%=(List_Accounts.Fields.Item("CategoryValue").Value)%> </td>
    <td width="0" height="13"><%=(List_Accounts.Fields.Item("AccountID").Value)%></td>
    <td width="0" height="13"><%=(List_Accounts.Fields.Item("AccountAddress1").Value)%> </td>
    <td width="0" height="13"><%=(List_Accounts.Fields.Item("AccountCity").Value)%> </td>
    <td width="0" height="13"> 
      <div align="center"><a href="update.asp?AccountID=<%=(List_Accounts.Fields.Item("AccountID").Value)%>">Edit</a> 
        | <a href="delete.asp?AccountID=<%=(List_Accounts.Fields.Item("AccountID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% 
  List_AccountsRepeat__index=List_AccountsRepeat__index+1
  List_AccountsRepeat__numRows=List_AccountsRepeat__numRows-1
  List_Accounts.MoveNext()
Wend
%>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"><br>
        <% If Not List_Accounts.EOF Or Not List_Accounts.BOF Then %>
        <table border="0" width="40%" align="center">
          <tr>
            <td width="23%" align="center">
              <% If MM_offset <> 0 Then %>
              <a href="<%=MM_moveFirst%>">First</a>
              <% End If ' end MM_offset <> 0 %>
            </td>
            <td width="31%" align="center">
              <% If MM_offset <> 0 Then %>
              <a href="<%=MM_movePrev%>">Previous</a>
              <% End If ' end MM_offset <> 0 %>
            </td>
            <td width="23%" align="center">
              <% If Not MM_atTotal Then %>
              <a href="<%=MM_moveNext%>">Next</a>
              <% End If ' end Not MM_atTotal %>
            </td>
            <td width="23%" align="center">
              <% If Not MM_atTotal Then %>
              <a href="<%=MM_moveLast%>">Last</a>
              <% End If ' end Not MM_atTotal %>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center">&nbsp; Records <strong><%=(List_Accounts_first)%></strong> to <strong><%=(List_Accounts_last)%></strong> of <strong><%=(List_Accounts_total)%></strong> </td>
          </tr>
        </table>
        <% End If ' end Not List_Accounts.EOF Or NOT List_Accounts.BOF %>
</div></td>
  </tr>
</table><% If List_Accounts.EOF And List_Accounts.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end List_Accounts.EOF And List_Accounts.BOF %>
</body>
</html>
<%
List_Accounts.Close()
%>
