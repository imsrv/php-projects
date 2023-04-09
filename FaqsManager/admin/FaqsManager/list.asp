<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/faqsmanager.asp" -->
<%
Dim List_Faq__value2
List_Faq__value2 = "%"
If (Request.Form("search")   <> "") Then 
  List_Faq__value2 = Request.Form("search")  
End If
%>
<%
set List_Faq = Server.CreateObject("ADODB.Recordset")
List_Faq.ActiveConnection = MM_faqsmanager_STRING
List_Faq.Source = "SELECT Faq.*, FaqCategory.CategoryDesc, FaqCategory.CategoryName  FROM FaqCategory INNER JOIN Faq ON FaqCategory.CategoryID = Faq.CategoryID  WHERE Faq.Activated = 'True' AND FaqCategory.CategoryName LIKE '" + Replace(List_Faq__value2, "'", "''") + "' OR  FaqQuestion LIKE '%" + Replace(List_Faq__value2, "'", "''") + "%' OR  FaqAnswer LIKE '%" + Replace(List_Faq__value2, "'", "''") + "%'  ORDER BY  FaqCategory.CategoryID"
List_Faq.CursorType = 0
List_Faq.CursorLocation = 2
List_Faq.LockType = 3
List_Faq.Open()
List_Faq_numRows = 0
%>
<%
Dim Repeat1__numRows
Repeat1__numRows = -1
Dim Repeat1__index
Repeat1__index = 0
List_Faq_numRows = List_Faq_numRows + Repeat1__numRows
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_faqsmanager_STRING
Category.Source = "SELECT *  FROM FaqCategory"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head>
<title>Faqs Manager</title>
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
    <td height="24" width="60%" valign="baseline">
		<form action="" method="post" name="form2" id="form2">  
		  <div align="center">Search by Category <select name="search" id="search" >
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
          </div>
	  </form>
    </td>
    <td height="24" width="40%" valign="baseline"> 
      <form name="form" method="post" action="">
        <div align="center">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
    <td colspan="2"> Category</td>
    <td>FAQ Question</td>
    <td width="27%"><div align="center"><a href="insert.asp">Insert New</a></div></td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT List_Faq.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
    <td width="2%" height="13">      <strong>
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter %>.      </strong>   </td>
    <td width="16%" height="13"><%=(List_Faq.Fields.Item("CategoryName").Value)%></td>
    <td height="13"><%=(List_Faq.Fields.Item("FaqQuestion").Value)%> </td>
    <td width="27%" height="13"> 
      <div align="center"><a href="update.asp?ItemID=<%=(List_Faq.Fields.Item("ItemID").Value)%>">Edit</a> 
        | <a href="delete.asp?ItemID=<%=(List_Faq.Fields.Item("ItemID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  List_Faq.MoveNext()
Wend
%>
</table>
</body>
</html>
<%
List_Faq.Close()
%>
<%
Category.Close()
Set Category = Nothing
%>
