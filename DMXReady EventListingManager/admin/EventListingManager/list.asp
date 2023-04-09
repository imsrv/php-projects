<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/eventlistingmanager.asp" -->
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_eventlistingmanager_STRING
Category.Source = "SELECT tblEventCategory.CategoryID, tblEventCategory.CategoryName  FROM tblEventListings INNER JOIN tblEventCategory ON tblEventListings.CategoryID = tblEventCategory.CategoryID  GROUP BY tblEventCategory.CategoryID, tblEventCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim eventlist__MMColParam1
eventlist__MMColParam1 = "%"
If (Request.Form("search") <> "") Then 
  eventlist__MMColParam1 = Request.Form("search")        
End If
%>
<%
Dim eventlist__MMColParam2
eventlist__MMColParam2 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  eventlist__MMColParam2 = Request.QueryString("ItemID") 
End If
%>
<%
Dim eventlist__MMColParam3
eventlist__MMColParam3 = "%"
If (Request.Form("searchcat")  <> "") Then 
  eventlist__MMColParam3 = Request.Form("searchcat") 
End If
%>
<%
set eventlist = Server.CreateObject("ADODB.Recordset")
eventlist.ActiveConnection = MM_eventlistingmanager_STRING
eventlist.Source = "SELECT tblEventListings.*, tblEventCategory.CategoryDesc, tblEventCategory.CategoryName  FROM tblEventCategory INNER JOIN tblEventListings ON tblEventCategory.CategoryID = tblEventListings.CategoryID  WHERE tblEventCategory.CategoryName Like '" + Replace(eventlist__MMColParam3, "'", "''") + "'  AND tblEventListings.ItemID Like '" + Replace(eventlist__MMColParam2, "'", "''") + "' AND (tblEventListings.ItemDesc Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' OR tblEventListings.ItemName Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' OR tblEventListings.EventLocation Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' )   ORDER BY EventStartDate"
eventlist.CursorType = 0
eventlist.CursorLocation = 2
eventlist.LockType = 3
eventlist.Open()
eventlist_numRows = 0
%>
<%
Dim Repeat1__numRows
Repeat1__numRows = -1
Dim Repeat1__index
Repeat1__index = 0
eventlist_numRows = eventlist_numRows + Repeat1__numRows
%>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head>
<title>Event Listing Manager</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr>
    <td height="24" width="60%" valign="baseline"><form action="" method="post" name="form2" id="form2">
        <div align="center">
          <% If Not Category.EOF Or Not Category.BOF Then %>
Search by Category
<select name="searchcat" id="searchcat" >
              <option selected value="%" <%If (Not isNull(Request.Form("search"))) Then If ("xyz" = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
              All</option>
              <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(Request.Form("search"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
            <input name="submit2" type="submit" value="Go">
            <% End If ' end Not Category.EOF Or NOT Category.BOF %>

        </div>
    </form></td>
    <td height="24" width="40%" valign="baseline"><form name="form" method="post" action="">
        <div align="center">Search by Keyword
            <input name="search" type="text" id="search">
            <input type="submit" value="Go" name="submit">
        </div>
    </form></td>
  </tr>
</table>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader">
    <td colspan="2"> Category</td>
    <td width="18%">Event Name</td>
    <td width="18%">Date</td>
    <td width="19%">Location</td>
    <td width="13%"><div align="center">Activated</div>
    </td>
    <td width="14%">
      <div align="center"><a href="insert.asp">Insert New</a></div>
    </td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT eventlist.EOF)) 
%>
  <% If Not eventlist.EOF Or Not eventlist.BOF Then %>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
    <td width="2%" height="13"> <strong>
      <%Response.Write(RecordCounter)
RecordCounter = RecordCounter %>
    . </strong> </td>
    <td width="16%" height="13"><%=(eventlist.Fields.Item("CategoryName").Value)%></td>
    <td height="13"><%=(eventlist.Fields.Item("ItemName").Value)%> </td>
    <td height="13"><%=(eventlist.Fields.Item("EventStartDate").Value)%></td>
    <td height="13"><%=Replace(eventlist.Fields.Item("EventLocation").Value,Chr(13),"<BR>")%></td>
    <td width="13%" height="13">
      <div align="center">
        <input name="checkbox" type="checkbox" disabled="disabled" value="True" <%If (CStr((eventlist.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%>>
      </div>
    </td>
    <td width="14%" height="13"><div align="center"><a href="update.asp?ItemID=<%=(eventlist.Fields.Item("ItemID").Value)%>">Edit</a> | <a href="delete.asp?ItemID=<%=(eventlist.Fields.Item("ItemID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% End If ' end Not eventlist.EOF Or NOT eventlist.BOF %>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  eventlist.MoveNext()
Wend
%>

</table>
<% If eventlist.EOF And eventlist.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end eventlist.EOF And eventlist.BOF %>
</body>
</html>
<%
Category.Close()
Set Category = Nothing
%>
<%
eventlist.Close()
Set eventlist = Nothing
%>
