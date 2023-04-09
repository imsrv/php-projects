<!--#include virtual="/Connections/faqsmanager.asp" -->
<%
Dim faqlist__value1
faqlist__value1 = "0"
If (Request.QueryString("ItemID")       <> "") Then 
  faqlist__value1 = Request.QueryString("ItemID")      
End If
%>
<%
set faqlist = Server.CreateObject("ADODB.Recordset")
faqlist.ActiveConnection = MM_faqsmanager_STRING
faqlist.Source = "SELECT Faq.*, FaqCategory.CategoryDesc, FaqCategory.CategoryName  FROM FaqCategory INNER JOIN Faq ON FaqCategory.CategoryID = Faq.CategoryID  WHERE Faq.Activated = 'True' AND Faq.ItemID LIKE '" + Replace(faqlist__value1, "'", "''") + "'"
faqlist.CursorType = 0
faqlist.CursorLocation = 2
faqlist.LockType = 3
faqlist.Open()
faqlist_numRows = 0
%>
<%
Dim questionfaqlist__value1
questionfaqlist__value1 = "%"
If (request.form("search")   <> "") Then 
  questionfaqlist__value1 = request.form("search")  
End If
%>
<%
Dim questionfaqlist__value2
questionfaqlist__value2 = "%"
If (request.form("searchcat")  <> "") Then 
  questionfaqlist__value2 = request.form("searchcat") 
End If
%>
<%
set questionfaqlist = Server.CreateObject("ADODB.Recordset")
questionfaqlist.ActiveConnection = MM_faqsmanager_STRING
questionfaqlist.Source = "SELECT Faq.*, FaqCategory.CategoryDesc, FaqCategory.CategoryName  FROM FaqCategory INNER JOIN Faq ON FaqCategory.CategoryID = Faq.CategoryID  WHERE Faq.Activated = 'True' AND FaqCategory.CategoryName LIKE '" + Replace(questionfaqlist__value2, "'", "''") + "' AND ( FaqQuestion LIKE '%" + Replace(questionfaqlist__value1, "'", "''") + "%' OR  FaqAnswer LIKE '%" + Replace(questionfaqlist__value1, "'", "''") + "%')  ORDER BY FaqCategory.CategoryID"
questionfaqlist.CursorType = 0
questionfaqlist.CursorLocation = 2
questionfaqlist.LockType = 3
questionfaqlist.Open()
questionfaqlist_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_faqsmanager_STRING
Category.Source = "SELECT FaqCategory.CategoryName  FROM FaqCategory INNER JOIN Faq ON FaqCategory.CategoryID = Faq.CategoryID  GROUP BY FaqCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeatfaqfaqlist__numRows
Dim Repeatfaqfaqlist__index

Repeatfaqfaqlist__numRows = -1
Repeatfaqfaqlist__index = 0
faqlist_numRows = faqlist_numRows + Repeatfaqfaqlist__numRows
%>
<%
Dim Repeatquestionfaqlist__numRows
Dim Repeatquestionfaqlist__index

Repeatquestionfaqlist__numRows = -1
Repeatquestionfaqlist__index = 0
questionfaqlist_numRows = questionfaqlist_numRows + Repeatquestionfaqlist__numRows
%>
<%
Dim Repeatfaqcategory__numRows
Dim Repeatfaqcategory__index

Repeatfaqcategory__numRows = -1
Repeatfaqcategory__index = 0
Category_numRows = Category_numRows + Repeatfaqcategory__numRows
%>
<% Dim TFM_nestfaqcat, lastTFM_nestfaqcat%>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<link href="../../styles.css" rel="stylesheet" type="text/css">
<form action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>" method="post" name="form2" id="form2">  
 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr class="tableheader"> 
    <td height="24" width="50%" valign="baseline">
      <div align="center">Search by Category 
          <select name="searchcat" id="searchcat" >
	        <option selected value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
	        <%
While (NOT Category.EOF)
%>
	        <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(Request.Form("searchcat"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
  
    </div></td>
    <td height="24" width="50%" valign="baseline"> 
          <div align="center">
            Search by Keyword 
            <input name="search" type="text" id="search">
            <input type="submit" value="Go" name="submit">
          </div></td>
  </tr>
</table>
</form>
<% If Not faqlist.EOF Or Not faqlist.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder">
  <tr class="tableheader" valign="top">
    <td><%=(faqlist.Fields.Item("CategoryName").Value)%> <%=(faqlist.Fields.Item("CategoryDesc").Value)%></td>
  </tr>
  <% 
While ((Repeatfaqfaqlist__numRows <> 0) AND (NOT faqlist.EOF)) 
%>
<tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
<td valign="top"><br><strong>
  <%=(faqlist.Fields.Item("FaqQuestion").Value)%></strong>
    <br>
    <br>    
    <%=Replace(faqlist.Fields.Item("FaqAnswer").Value,Chr(13),"<BR>")%>    
	 <p>
	   <% If (faqlist.Fields.Item("FaqRelatedLink").Value) <> "" Then %>
   See related Item:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="<%=(faqlist.Fields.Item("FaqRelatedLink").Value)%>" target="_blank"><%=(faqlist.Fields.Item("FaqRelatedLink").Value)%></a>
   <%end if%>
	 </p>  
	<p align="left"><a href="javascript:history.go(-1);">Go
            back</a><br>
    </p>
</td>
  </tr>
  <% 
  Repeatfaqfaqlist__index=Repeatfaqfaqlist__index+1
  Repeatfaqfaqlist__numRows=Repeatfaqfaqlist__numRows-1
  faqlist.MoveNext()
Wend
%>
</table>
<% End If ' end Not faqlist.EOF Or NOT faqlist.BOF %>    
         <% if Not Request.QueryString("ItemID") <> "" then %> 
<% 
While ((Repeatquestionfaqlist__numRows <> 0) AND (NOT questionfaqlist.EOF)) 
%>

          <table width="100%" cellpadding="0" cellspacing="0" border="0" >
              <tr valign>
                <td valign="top" > <% TFM_nestfaqcat = questionfaqlist.Fields.Item("CategoryName").Value
If lastTFM_nestfaqcat <> TFM_nestfaqcat Then 
	lastTFM_nestfaqcat = TFM_nestfaqcat %>                  <br>                  <strong><%=(questionfaqlist.Fields.Item("CategoryName").Value)%></strong>                    <%End If 'End Basic-UltraDev Simulated Nested Repeat %>        
                </td>
              </tr>
              <tr valign>
                <td valign="top" >
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="14">
                    <tr>
                      <td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td width="99%" height="15"><li><a href="<%=Request.ServerVariables("URL")%>?ItemID=<%=(questionfaqlist.Fields.Item("ItemID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>"><%=(questionfaqlist.Fields.Item("FaqQuestion").Value)%></a> </li>
                      </td>
                    </tr>
                  </table>
  </td>
            </tr>
          </table>
<% 
  Repeatquestionfaqlist__index=Repeatquestionfaqlist__index+1
  Repeatquestionfaqlist__numRows=Repeatquestionfaqlist__numRows-1
  questionfaqlist.MoveNext()
Wend
%>
<%End If%>
<br> 
<%
faqlist.Close()
%>
<%
questionfaqlist.Close()
%>
<%
Category.Close()
Set Category = Nothing
%>
