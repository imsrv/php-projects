<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/newsmanager.asp"-->
<%
Dim news_list__search
news_list__search = "%"
If (Request.Form("search")    <> "") Then 
  news_list__search = Request.Form("search")   
End If
%>
<%
Dim news_list__cid
news_list__cid = "%"
If (Request.QueryString("cid") <> "") Then 
  news_list__cid = Request.QueryString("cid")
End If
%>
<%
Dim news_list__pcid
news_list__pcid = "%"
If (Request.QueryString("pcid") <> "") Then 
  news_list__pcid = Request.QueryString("pcid")
End If
%>
<%
Dim news_list__value1
news_list__value1 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  news_list__value1 = Request.QueryString("ItemID") 
End If
%>
<%
set news_list = Server.CreateObject("ADODB.Recordset")
news_list.ActiveConnection = MM_newsmanager_STRING
news_list.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_News.*  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE tblNM_News.ExpiryDate >= NOW() AND tblNM_News.Activated = 'True' AND ItemID LIKE '" + Replace(news_list__value1, "'", "''") + "' AND tblNM_NewsCategory.CategoryID Like '" + Replace(news_list__cid, "'", "''") + "'  AND tblNM_NewsCategory.ParentCategoryID Like '" + Replace(news_list__pcid, "'", "''") + "'  AND ( tblNM_News.ItemDesc Like '%" + Replace(news_list__search, "'", "''") + "%' OR tblNM_News.ItemName Like '%" + Replace(news_list__search, "'", "''") + "%' OR tblNM_NewsCategory.CategoryValue Like '%" + Replace(news_list__search, "'", "''") + "%'  OR tblNM_News.ItemDesc Like '%" + Replace(news_list__search, "'", "''") + "%' )  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_News.DateAdded DESC"
news_list.CursorType = 0
news_list.CursorLocation = 2
news_list.LockType = 3
news_list.Open()
news_list_numRows = 0
%>
<%
Dim Category__nmcatvalue
Category__nmcatvalue = "xyz"
If (Request.QueryString("pcid")  <> "") Then 
  Category__nmcatvalue = Request.QueryString("pcid") 
End If
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_newsmanager_STRING
Category.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  GROUP BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile  HAVING tblNM_NewsCategory.ParentCategoryID LIKE '" + Replace(Category__nmcatvalue, "'", "''") + "'  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
set ParentCategory = Server.CreateObject("ADODB.Recordset")
ParentCategory.ActiveConnection = MM_newsmanager_STRING
ParentCategory.Source = "SELECT tblNM_NewsCategory_1.CategoryID AS ParentCategoryID, tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory_1.CategoryDesc AS ParentCategoryDesc, tblNM_NewsCategory_1.CategoryLabel AS ParentCategoryLabel, tblNM_NewsCategory_1.CategoryImageFile AS ParentCategoryImage  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE (((tblNM_NewsCategory_1.CategoryID) Is Not Null))  GROUP BY tblNM_NewsCategory_1.CategoryID, tblNM_NewsCategory_1.ParentCategoryID, tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory_1.CategoryDesc, tblNM_NewsCategory_1.CategoryLabel, tblNM_NewsCategory_1.CategoryImageFile  ORDER BY tblNM_NewsCategory_1.CategoryValue"
ParentCategory.CursorType = 0
ParentCategory.CursorLocation = 2
ParentCategory.LockType = 3
ParentCategory.Open()
ParentCategory_numRows = 0
%>
<%
Dim news_related__rcid
news_related__rcid = "0"
If (Request.QueryString("rcid")  <> "") Then 
  news_related__rcid = Request.QueryString("rcid") 
End If
%>
<%
Dim news_related__value1
news_related__value1 = "0"
If (Request.QueryString("ItemID")   <> "") Then 
  news_related__value1 = Request.QueryString("ItemID")  
End If
%>
<%
set news_related = Server.CreateObject("ADODB.Recordset")
news_related.ActiveConnection = MM_newsmanager_STRING
news_related.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_News.*  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE tblNM_News.ExpiryDate >= NOW() AND tblNM_News.Activated = 'True' AND ItemID NOT LIKE '" + Replace(news_related__value1, "'", "''") + "' AND tblNM_NewsCategory.CategoryID Like '" + Replace(news_related__rcid, "'", "''") + "'  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_News.DateAdded DESC"
news_related.CursorType = 0
news_related.CursorLocation = 2
news_related.LockType = 3
news_related.Open()
news_related_numRows = 0
%>
<%
Dim news_archive__search
news_archive__search = "%"
If (Request.Form("search")    <> "") Then 
  news_archive__search = Request.Form("search")   
End If
%>
<%
Dim news_archive__cid
news_archive__cid = "%"
If (Request.QueryString("cid") <> "") Then 
  news_archive__cid = Request.QueryString("cid")
End If
%>
<%
Dim news_archive__pcid
news_archive__pcid = "%"
If (Request.QueryString("pcid") <> "") Then 
  news_archive__pcid = Request.QueryString("pcid")
End If
%>
<%
Dim news_archive__value1
news_archive__value1 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  news_archive__value1 = Request.QueryString("ItemID") 
End If
%>
<%
set news_archive = Server.CreateObject("ADODB.Recordset")
news_archive.ActiveConnection = MM_newsmanager_STRING
news_archive.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_News.*  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE tblNM_News.ExpiryDate < NOW() AND tblNM_News.Activated = 'True' AND ItemID LIKE '" + Replace(news_archive__value1, "'", "''") + "' AND tblNM_NewsCategory.CategoryID Like '" + Replace(news_archive__cid, "'", "''") + "'  AND tblNM_NewsCategory.ParentCategoryID Like '" + Replace(news_archive__pcid, "'", "''") + "'  AND ( tblNM_News.ItemDesc Like '%" + Replace(news_archive__search, "'", "''") + "%' OR tblNM_News.ItemName Like '%" + Replace(news_archive__search, "'", "''") + "%' OR tblNM_NewsCategory.CategoryValue Like '%" + Replace(news_archive__search, "'", "''") + "%'  OR tblNM_News.ItemDesc Like '%" + Replace(news_archive__search, "'", "''") + "%' )  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_News.DateAdded DESC"
news_archive.CursorType = 0
news_archive.CursorLocation = 2
news_archive.LockType = 3
news_archive.Open()
news_archive_numRows = 0
%>
<%
Dim news_detail__value1
news_detail__value1 = "x"
If (Request.QueryString("ItemID")   <> "") Then 
  news_detail__value1 = Request.QueryString("ItemID")  
End If
%>
<%
set news_detail = Server.CreateObject("ADODB.Recordset")
news_detail.ActiveConnection = MM_newsmanager_STRING
news_detail.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_News.*  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE tblNM_News.ItemID LIKE '" + Replace(news_detail__value1, "'", "''") + "'"
news_detail.CursorType = 0
news_detail.CursorLocation = 2
news_detail.LockType = 3
news_detail.Open()
news_detail_numRows = 0
%>
<%
Dim Repeat_news_archive__numRows
Dim Repeat_news_archive__index

Repeat_news_archive__numRows = -1
Repeat_news_archive__index = 0
news_archive_numRows = news_archive_numRows + Repeat_news_archive__numRows
%>
<%
Dim Reapeat_news_related__numRows
Dim Reapeat_news_related__index

Reapeat_news_related__numRows = -1
Reapeat_news_related__index = 0
news_related_numRows = news_related_numRows + Reapeat_news_related__numRows
%>
<%
Dim Reapeat_lnews_list__numRows
Dim Reapeat_lnews_list__index

Reapeat_lnews_list__numRows = -1
Reapeat_lnews_list__index = 0
news_list_numRows = news_list_numRows + Reapeat_lnews_list__numRows
%>
<% Dim nested_category, lastnested_category%>
<% Dim nested_parentcategory, lastnested_parentcategory%>
<% Dim nested_dateadded, lastnested_dateadded%>						
<html>
<head>
<title>Latest News as @ <% Response.Write FormatDateTime(Date(), vbLongDate) %></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	
function DoTrimProperly(str, nNamedFormat, properly, pointed, points)
  dim strRet
  strRet = Server.HTMLEncode(str)
  strRet = replace(strRet, vbcrlf,"")
  strRet = replace(strRet, vbtab,"")
  If (LEN(strRet) > nNamedFormat) Then
    strRet = LEFT(strRet, nNamedFormat)			
    If (properly = 1) Then					
      Dim TempArray								
      TempArray = split(strRet, " ")	
      Dim n
      strRet = ""
      for n = 0 to Ubound(TempArray) - 1
        strRet = strRet & " " & TempArray(n)
      next
    End If
    If (pointed = 1) Then
      strRet = strRet & points
    End If
  End If
  DoTrimProperly = strRet
End Function
</SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%">&nbsp;</td>
    <td><div align="right">
      <% If Request.QueryString("archive") = "yes" Then %>
	  <strong><font color="#FF0000" size="4">News Archive</font></strong>
      <%else%>
      <strong><font size="4">Latest
            News<font size="2"> </font></font><font size="2">for
            <% Response.Write FormatDateTime(Date(), vbLongDate) %>
            <%end if%>
&nbsp;</font></strong>&nbsp; </font></div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form action="<%=Request.ServerVariables("URL")%>
<%If Request.QueryString ("archive") <> "" Then %>?archive=<%=request.querystring("archive")%><%end if%>
<%If Request.QueryString ("mid") <> "" Then %>
<%If Request.QueryString ("archive") <> "" Then %>&<%else%>?<%end if%>mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
" method="post" name="form2" id="form2">  
 <table width="100%" border="0" cellspacing="0" cellpadding="5" height="24" class="tableborder">
 <tr>
 <% If Not ParentCategory.EOF Or Not ParentCategory.BOF Then %> 
   <td width="0" height="24" valign="baseline">
     Search by Category:
      <select name="ParentCategory" onChange="MM_jumpMenu('parent',this,0)">
           <option value="?pcid=%<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"<%If (Not isNull(Request.QueryString("pcid"))) Then If (CStr(ParentCategory.Fields.Item("ParentCategoryID").Value) = CStr(Request.QueryString("pcid"))) Then Response.Write("SELECTED") : Response.Write("")%> >Show
             All</option>
           <%
While (NOT ParentCategory.EOF)
%>
           <option value="?pcid=<%=(ParentCategory.Fields.Item("ParentCategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>" <%If (Not isNull(Request.QueryString("pcid"))) Then If (CStr(ParentCategory.Fields.Item("ParentCategoryID").Value) = CStr(Request.QueryString("pcid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(ParentCategory.Fields.Item("ParentCategoryValue").Value)%></option>
           <%
  ParentCategory.MoveNext()
Wend
If (ParentCategory.CursorType > 0) Then
  ParentCategory.MoveFirst
Else
  ParentCategory.Requery
End If
%>
         </select>
     </td>
   <% End If ' end Not ParentCategory.EOF Or NOT ParentCategory.BOF %>	 
 <% If Not Category.EOF Or Not Category.BOF Then %>     
  <td width="0" height="24" valign="baseline">      Search by Sub Category:
         <select name="Category" onChange="MM_jumpMenu('parent',this,0)">
           <option value="?pcid=<%=request.querystring("pcid")%>&cid=%<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"<%If (Not isNull(Request.QueryString("cid"))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%> >Show
             All</option>
           <%
While (NOT Category.EOF)
%>
           <option value="?pcid=<%=request.querystring("pcid")%>&cid=<%=(Category.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>" <%If (Not isNull(Request.QueryString("cid"))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
     </td>
<% End If ' end Not Category.EOF Or NOT Category.BOF %>
   <td width="0" valign="baseline">Search by Keyword
       <input name="search" type="text" id="search">
       <input type="submit" value="Go" name="submit">
   </td>
   <td width="0" valign="baseline">
     <div align="right">
       <% If NOT Request.QueryString("archive") = "yes" Then %>
       <a href="<%=request.servervariables("URL")%>?archive=yes
<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">Show
       Archive</a>
       <%else%>
       <a href="<%=request.servervariables("URL")%>
<%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">Show
       Current</a>
       <%end if%>
     </div>
   </td>
 </tr>
 </table>
</form></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
<% If Not news_detail.EOF Or Not news_detail.BOF Then %>
<tr>
    <td height="30" valign="top"><a href="<%=request.servervariables("URL")%>
		<%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>?archive=<%=request.querystring("archive")%><%end if%>">Show
        All</a> &raquo; <a href="<%=request.servervariables("URL")%>?pcid=<%=(news_detail.Fields.Item("ParentCategoryID").Value)%>
		<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"><%=(news_detail.Fields.Item("ParentCategoryValue").Value)%></a> &raquo; <a href="<%=request.servervariables("URL")%>?pcid=<%=(news_detail.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_detail.Fields.Item("CategoryID").Value)%>
		<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"><%=(news_detail.Fields.Item("CategoryValue").Value)%></a> &raquo; </td>
</tr>
  <tr>
    <td valign="top">  
    <b><font size="3"><%=(news_detail.Fields.Item("ItemName").Value)%></font> </b> <b>- </b><font color="#FF0000"><strong><em><%= DoDateTime((news_detail.Fields.Item("DateAdded").Value), 1, 4105) %></em></strong></font><br>
    <% if news_detail.Fields.Item("AuthorName").Value <> "" then %>
Added by:<em>
<% if news_detail.Fields.Item("AuthorEmail").Value <> "" then %>
<a href="mailto:<%=(news_detail.Fields.Item("AuthorEmail").Value)%>"><%=(news_detail.Fields.Item("AuthorName").Value)%></a>
<% else%>
<%=(news_detail.Fields.Item("AuthorName").Value)%> </em>
<% end if%>
<% end if%><p>
        <% if news_detail.Fields.Item("ItemType").Value = "text" then %>
        <%=Replace(news_detail.Fields.Item("ItemMemo").Value,Chr(13),"<BR>")%>
        <% else%>
        <%=(news_detail.Fields.Item("ItemMemo").Value)%>
        <% end if%>
        </p>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<%If news_detail.Fields.Item("DocumentFile1").Value <> "" Then %>  
<tr>
  <td colspan="2"><strong>Related Documents:</strong></td>
  </tr>
<tr>
<td width="0" bgcolor="#666666"><font color="#FFFFFF"><%=(news_detail.Fields.Item("DocumentFileLabel1").Value)%></font></td> 
<td width="0" bgcolor="#CCCCCC"><%If instr(news_detail.Fields.Item("DocumentFile1").Value,"http") Then %>
  <a href="<%=(news_detail.Fields.Item("DocumentFile1").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile1").Value)%></a><%else%> <a href="../../applications/assets/documents/<%=(news_detail.Fields.Item("DocumentFile1").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile1").Value)%></a><%end if%>
</td>
</tr>
<%end if%>
<%If news_detail.Fields.Item("DocumentFile2").Value <> "" Then %>  
<tr>
<td width="0" bgcolor="#666666"><font color="#FFFFFF"><%=(news_detail.Fields.Item("DocumentFileLabel2").Value)%></font></td> 
<td width="0" bgcolor="#CCCCCC"><%If instr(news_detail.Fields.Item("DocumentFile2").Value,"http") Then %> <a href="<%=(news_detail.Fields.Item("DocumentFile2").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile2").Value)%></a><%else%> <a href="../../applications/assets/documents/<%=(news_detail.Fields.Item("DocumentFile2").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile2").Value)%></a><%end if%>
</td>
</tr>
<%end if%>
<%If news_detail.Fields.Item("DocumentFile3").Value <> "" Then %>  
<tr>
<td width="0" bgcolor="#666666"><font color="#FFFFFF"><%=(news_detail.Fields.Item("DocumentFileLabel3").Value)%></font></td> 
<td width="0" bgcolor="#CCCCCC"><%If instr(news_detail.Fields.Item("DocumentFile3").Value,"http") Then %> <a href="<%=(news_detail.Fields.Item("DocumentFile3").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile3").Value)%></a><%else%> <a href="../../applications/assets/documents/<%=(news_detail.Fields.Item("DocumentFile3").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile3").Value)%></a><%end if%>
</td>
</tr>
<%end if%>
<%If news_detail.Fields.Item("DocumentFile4").Value <> "" Then %>  
<tr>
<td width="0" bgcolor="#666666"><font color="#FFFFFF"><%=(news_detail.Fields.Item("DocumentFileLabel4").Value)%></font></td> 
<td width="0" bgcolor="#CCCCCC"><%If instr(news_detail.Fields.Item("DocumentFile4").Value,"http") Then %> <a href="<%=(news_detail.Fields.Item("DocumentFile4").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile4").Value)%></a><%else%> <a href="../../applications/assets/documents/<%=(news_detail.Fields.Item("DocumentFile4").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile4").Value)%></a><%end if%>
</td>
</tr>
<%end if%>
<%If news_detail.Fields.Item("DocumentFile5").Value <> "" Then %>  
<tr>
<td width="0" bgcolor="#666666"><font color="#FFFFFF"><%=(news_detail.Fields.Item("DocumentFileLabel5").Value)%></font></td> 
<td width="0" bgcolor="#CCCCCC"><%If instr(news_detail.Fields.Item("DocumentFile5").Value,"http") Then %> <a href="<%=(news_detail.Fields.Item("DocumentFile5").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile5").Value)%></a><%else%> <a href="../../applications/assets/documents/<%=(news_detail.Fields.Item("DocumentFile5").Value)%>" target="_blank"><%=(news_detail.Fields.Item("DocumentFile5").Value)%></a><%end if%>
</td>
</tr>
<%end if%>
</table>
<br>
&laquo;		   
    <a href="javascript:history.go(-1);">Go Back</a>
      </p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <div align="right">
               <%
pre_url = "http://" & request.servervariables("HTTP_HOST") & request.servervariables("URL") & "?" & request.servervariables("QUERY_STRING")
url = Server.URLencode(pre_url)
%>	
              <a href="javascript:;"  onClick="MM_openBrWindow('components/inc_sendtofriendmanager.asp?emailform=yes&amp;url=<%=url%>','SendToFriend','width=500,height=350')">SEND
              TO FRIEND</a>
            </div>
          </td>
        </tr>
      </table>
	<hr size="1" class="hr1">    
  </td>
  </tr>
  <% End If ' end Not news_detail.EOF Or NOT news_detail.BOF %>
  <tr>
  <% If Not news_related.EOF Or Not news_related.BOF Then %>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
      <p align="center"><strong><font size="4">OTHER <%=(news_related.Fields.Item("ParentCategoryValue").Value)%>&nbsp;<%=(news_related.Fields.Item("CategoryValue").Value)%> NEWS
	  </font></strong><font size="4">
      </font> </p>      
      <% 
While ((Reapeat_news_related__numRows <> 0) AND (NOT news_related.EOF)) 
%>
      <b><font size="3">
        <% nested_parentcategory = news_related.Fields.Item("ParentCategoryValue").Value
If lastnested_parentcategory <> nested_parentcategory Then 
	lastnested_parentcategory = nested_parentcategory %>
        <font size="2"><%=(news_related.Fields.Item("ParentCategoryValue").Value)%></font></font></font>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
          </font></b>      <b><font size="2">
          <% nested_category = news_related.Fields.Item("ParentCategoryValue").Value & news_related.Fields.Item("CategoryValue").Value
If lastnested_category <> nested_category Then 
	lastnested_category = nested_category %>
      <hr align="left" width="200" size="1" class="hr2">
            </font><%=(news_related.Fields.Item("CategoryValue").Value)%><font size="2">
                     <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
            </font></b>
	  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <% if news_related.Fields.Item("ImageThumbFile1").Value <> "" Then %>
    <td width="10" valign="top">
      <% if instr(news_related.Fields.Item("ImageThumbFile1").Value,"http") Then %>
      <img src="<%=(news_related.Fields.Item("ImageThumbFile1").Value)%>" width="20" height="20">
      <%else%>
      <a href="javascript:;"><img src="../assets/images/<%=(news_related.Fields.Item("ImageThumbFile1").Value)%>" alt="<%=(news_related.Fields.Item("ImageFileLabel1").Value)%>" width="20" height="20" hspace="10" vspace="5" border="0" onClick="MM_openBrWindow('../assets/images/<%=(news_related.Fields.Item("ImageThumbFile1").Value)%>','images','scrollbars=yes,width=600,height=400')"></a>
      <% end if%>
    </td>
    <% end if%>
    <td valign="top"><b>&raquo; </b><font color="#FF0000"><em><%= DoDateTime((news_related.Fields.Item("DateAdded").Value), 1, 4105) %></em></font><b> - </b><a href="<%=request.servervariables("URL")%>?ItemID=<%=(news_related.Fields.Item("ItemID").Value)%>&rcid=<%=(news_related.Fields.Item("CategoryID").Value)%>&pcid=<%=(news_related.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_related.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"><%=(news_related.Fields.Item("ItemName").Value)%></a> &raquo;
        <% If news_related.Fields.Item("ItemDesc").Value <> "" Then %>
        <%=(DoTrimProperly((news_related.Fields.Item("ItemDesc").Value), 150, 1, 1, " ")) %>&nbsp;...&nbsp;<a href="<%=request.servervariables("URL")%>?ItemID=<%=(news_related.Fields.Item("ItemID").Value)%>&rcid=<%=(news_related.Fields.Item("CategoryID").Value)%>&pcid=<%=(news_related.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_related.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><font size="1">[view]</font></a>
        <% end if%>
    </td>
  </tr>
</table>
      <% 
  Reapeat_news_related__index=Reapeat_news_related__index+1
  Reapeat_news_related__numRows=Reapeat_news_related__numRows-1
  news_related.MoveNext()
Wend
%>
    </td>
  </tr>
</table>
</td><% End If ' end Not news_related.EOF Or NOT news_related.BOF %>
  </tr>
</table>
<% If NOT Request.QueryString("ItemID") <> "" Then %>
<% If Not Request.QueryString("archive") = "yes" Then %> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><strong><font size="4">LATEST NEWS</font></strong><font size="4">&nbsp; </font>
      <% 
While ((Reapeat_lnews_list__numRows <> 0) AND (NOT news_list.EOF)) 
%>
      <b><font size="3">
        <% nested_parentcategory = news_list.Fields.Item("ParentCategoryValue").Value
If lastnested_parentcategory <> nested_parentcategory Then 
	lastnested_parentcategory = nested_parentcategory %>
      <hr size="1" class="hr1">
      <font size="2"><%=(news_list.Fields.Item("ParentCategoryValue").Value)%></font></font></font>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
          </font></b>
      <b><font size="2">
          <% nested_category = news_list.Fields.Item("ParentCategoryValue").Value & news_list.Fields.Item("CategoryValue").Value
If lastnested_category <> nested_category Then 
	lastnested_category = nested_category %>
          <hr align="left" width="200" size="1" class="hr2">
      </font><%=(news_list.Fields.Item("CategoryValue").Value)%><font size="2">
                     <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
      </font></b>
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <% if news_list.Fields.Item("ImageThumbFile1").Value <> "" Then %>
          <td width="10" valign="top">
            <% if instr(news_list.Fields.Item("ImageThumbFile1").Value,"http") Then %>
            <img src="<%=(news_list.Fields.Item("ImageThumbFile1").Value)%>" width="20" height="20">
            <%else%>
            <a href="javascript:;"><img src="../assets/images/<%=(news_list.Fields.Item("ImageThumbFile1").Value)%>" alt="<%=(news_list.Fields.Item("ImageFileLabel1").Value)%>" width="20" height="20" hspace="10" vspace="5" border="0" onClick="MM_openBrWindow('../assets/images/<%=(news_list.Fields.Item("ImageThumbFile1").Value)%>','images','scrollbars=yes,width=600,height=400')"></a>
            <% end if%>
          </td>
          <% end if%>
          <td valign="top"><b>&nbsp;&nbsp;&raquo; </b><a href="<%=request.servervariables("URL")%>?ItemID=<%=(news_list.Fields.Item("ItemID").Value)%>&rcid=<%=(news_list.Fields.Item("CategoryID").Value)%>&pcid=<%=(news_list.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_list.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"><%=(news_list.Fields.Item("ItemName").Value)%></a><b> - </b><font color="#FF0000"><em><%= DoDateTime((news_list.Fields.Item("DateAdded").Value), 1, 4105) %></em></font> &raquo;
            <% If news_list.Fields.Item("ItemDesc").Value <> "" Then %>
            <%=(DoTrimProperly((news_list.Fields.Item("ItemDesc").Value), 125, 1, 1, " ")) %>&nbsp;...&nbsp;<a href="<%=request.servervariables("URL")%>?ItemID=<%=(news_list.Fields.Item("ItemID").Value)%>&rcid=<%=(news_list.Fields.Item("CategoryID").Value)%>&pcid=<%=(news_list.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_list.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><font size="1">[view]</font></a>
            <% end if%>
          </td>
        </tr>
      </table>
      <% 
  Reapeat_lnews_list__index=Reapeat_lnews_list__index+1
  Reapeat_lnews_list__numRows=Reapeat_lnews_list__numRows-1
  news_list.MoveNext()
Wend
%>
            <hr size="1" class="hr1"> 
      <% If news_list.EOF And news_list.BOF Then %>
      <div align="center">No Records Found...Please try again. </div>
      <% End If ' end news_list.EOF And news_list.BOF %>
    </td>
  </tr>
</table>
<%else%>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><p align="center"><strong><font color="#FF0000" size="4">NEWS ARCHIVE</font></strong><font color="#FF0000" size="4">
    </font><font size="4">    </font> </p>
      <% 
While ((Repeat_news_archive__numRows <> 0) AND (NOT news_archive.EOF)) 
%>
<b><font size="3">
          <% nested_parentcategory = news_archive.Fields.Item("ParentCategoryValue").Value
If lastnested_parentcategory <> nested_parentcategory Then 
	lastnested_parentcategory = nested_parentcategory %>
<hr size="1" class="hr1">
<font color="#FF0000" size="2"><%=(news_archive.Fields.Item("ParentCategoryValue").Value)%></font></font></font>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
          </font></b>
<b><font size="2">
        <% nested_category = news_archive.Fields.Item("ParentCategoryValue").Value & news_archive.Fields.Item("CategoryValue").Value
If lastnested_category <> nested_category Then 
	lastnested_category = nested_category %>
          <hr align="left" width="200" size="1" class="hr2">      
          </font><font color="#FF0000"><%=(news_archive.Fields.Item("CategoryValue").Value)%></font><font size="2">
                     <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
                     <br>
          </font></b>
<b>&raquo; </b><%=(news_archive.Fields.Item("DateAdded").Value)%> - <a href="<%=request.servervariables("URL")%>?ItemID=<%=(news_archive.Fields.Item("ItemID").Value)%>&pcid=<%=(news_archive.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_archive.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>
<%If Request.QueryString ("archive")<> "" Then %>&archive=<%=request.querystring("archive")%><%end if%>"><%=(news_archive.Fields.Item("ItemName").Value)%></a>
      <% 
  Repeat_news_archive__index=Repeat_news_archive__index+1
  Repeat_news_archive__numRows=Repeat_news_archive__numRows-1
  news_archive.MoveNext()
Wend
%>
<hr size="1" class="hr1">
<% If news_archive.EOF And news_archive.BOF Then %>
      <div align="center">No Records Found...Please try again. </div>
      <% End If ' end news_archive.EOF And news_larchive.BOF %>
 </td>
  </tr>
</table>
<%end if%>
<%end if%>
<%
news_list.Close()
Set news_list = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
ParentCategory.Close()
Set news_list = Nothing
%>
<%
news_related.Close()
Set news_related = Nothing
%>
<%
news_archive.Close()
Set news_archive = Nothing
%>
<%
news_detail.Close()
Set news_detail = Nothing
%>