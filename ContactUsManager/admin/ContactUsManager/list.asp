<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/contactusmanager.asp" -->
<%
Dim contactus__MMColParam1
contactus__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  contactus__MMColParam1 = Request.Form("search")  
End If
%>
<%
set contactus = Server.CreateObject("ADODB.Recordset")
contactus.ActiveConnection = MM_contactusmanager_STRING
contactus.Source = "SELECT tblContactUs.*, tblContactUsCategory.CategoryName  FROM tblContactUsCategory RIGHT JOIN tblContactUs ON tblContactUsCategory.CategoryID = tblContactUs.CategoryID  WHERE tblContactUsCategory.CategoryName Like '" + Replace(contactus__MMColParam1, "'", "''") + "'  OR tblContactUs.FirstName Like '%" + Replace(contactus__MMColParam1, "'", "''") + "%'  OR tblContactUs.LastName Like '%" + Replace(contactus__MMColParam1, "'", "''") + "%'  ORDER BY tblContactUsCategory.CategoryName"
contactus.CursorType = 0
contactus.CursorLocation = 2
contactus.LockType = 3
contactus.Open()
contactus_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_contactusmanager_STRING
Category.Source = "SELECT tblContactUsCategory.*  FROM tblContactUsCategory  ORDER BY tblContactUsCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
contactus_numRows = contactus_numRows + Repeat1__numRows
%>
<html>
<head>
<title>Contact Us Manager</title>
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
<table width="100%" height="42" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="17" width="50%"> 
      <form name="form1" method="post" action="">
        <div align="center">Search by Department
          <select name="Search" id="Search">
          <option value="%" <%If (Not isNull(Request.Form("search"))) Then If ("%" = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
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
          <input type="submit" value="Go" name="submit2">
        </div>
      </form>
    </td>
    <td height="17" width="50%"> 
      <form name="form" method="post" action="">
        <div align="center">Search by Name
          <input type="text" name="Search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>

<% If Not contactus.EOF Or Not contactus.BOF Then %>
<form action="update_list.asp" method="post">
  <table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="3%">&nbsp; </td>
      <td width="27%">Contact Name</td>
      <td width="17%">Email Address</td>
      <td width="20%">Update Department</td>
      <td width="15%"><div align="center">Activated</div>
      </td>
      <td width="6%"><div align="center"></div>
          <div align="center">Delete</div>
      </td>
      <td width="12%"><div align="center"><a href="insert.asp">Insert New Contact</a></div>
      </td>
    </tr>
    <% Dim iCount
  iCount = 0
%>
    <% 
While ((Repeat1__numRows <> 0) AND (NOT contactus.EOF)) 
%>
    <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
      <td height="13"> <strong>
        <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>
        . </strong> <div align="center"></div>
      </td>
      <td width="27%" height="13">
        <input name="<%= (iCount & ".FirstName") %>" type="text" value="<%=(contactus.Fields.Item("FirstName").Value)%>" size="15">
		<input name="<%= (iCount & ".LastName") %>" type="text" value="<%=(contactus.Fields.Item("LastName").Value)%>" size="20">
      </td>
      <td width="17%" height="13"><input name="<%= (iCount & ".EmailAddress") %>" type="text" value="<%=(contactus.Fields.Item("EmailAddress").Value)%>" size="25">
      </td>
      <td width="20%" height="13"><input name="<%= (iCount & ".ContactID") %>" type="hidden" value="<%=(contactus.Fields.Item("ContactID").Value)%>">
          <select name="<%= (iCount & ".CategoryID") %>" id="<%= (iCount & ".CategoryID") %>">
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((contactus.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((contactus.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
        | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Edit Dept</a></td>
      <td width="15%" height="13" align="center"><label>
        <input <%If (CStr((contactus.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="<%= (iCount & ".Activated") %>" value="True">
        Yes</label>
          <label>
          <input <%If (CStr((contactus.Fields.Item("Activated").Value)) = CStr("False")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="<%= (iCount & ".Activated") %>" value="False">
        No</label>
      </td>
      <td height="13">
        <div align="center">
          <label> </label>
        </div>
        <div align="center">
          <input name="<%= (iCount & ".Check") %>" type="checkbox" value="Remove">
        </div>
      </td>
      <td height="13"><div align="center"><a href="update.asp?ContactID=<%=(contactus.Fields.Item("ContactID").Value)%>"> Edit
            Contact Details</a></div>
      </td>
    </tr>
    <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  contactus.MoveNext()
  iCount = iCount + 1
Wend
%>
  </table>
  <p>
    <input name="Submit" type="submit" id="Submit" value="Update">
    <input type="hidden" name="Count" value="<%= iCount - 1 %>">
  </p>
</form>
<% End If ' end Not contactus.EOF Or NOT contactus.BOF %>
<% If contactus.EOF And contactus.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end contactus.EOF And contactus.BOF %>

</body>
</html>
<%
contactus.Close()
%>
  <%
Category.Close()
%>

