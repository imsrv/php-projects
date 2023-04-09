<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/billboardmanager.asp" -->
<%
Dim billboard_detail__value1
billboard_detail__value1 = "%"
If (Request.querystring("ItemID")  <> "") Then 
  billboard_detail__value1 = Request.querystring("ItemID") 
End If
%>
<%
Dim billboard_detail__value2
billboard_detail__value2 = "%"
If (Request.Form("searchcat")   <> "") Then 
  billboard_detail__value2 = Request.Form("searchcat")  
End If
%>
<%
Dim billboard_detail__value3
billboard_detail__value3 = "%"
If (Request.Form("search")   <> "") Then 
  billboard_detail__value3 = Request.Form("search")  
End If
%>
<%
set billboard_detail = Server.CreateObject("ADODB.Recordset")
billboard_detail.ActiveConnection = MM_billboardmanager_STRING
billboard_detail.Source = "SELECT Billboard.*, BillboardCategory.CategoryName  FROM Billboard INNER JOIN BillboardCategory ON Billboard.CategoryID = BillboardCategory.CategoryID  WHERE Activated = 'True' AND ItemID LIKE '" + Replace(billboard_detail__value1, "'", "''") + "' AND  BillboardCategory.CategoryName Like '" + Replace(billboard_detail__value2, "'", "''") + "'  AND ( Billboard.ItemDesc Like '%" + Replace(billboard_detail__value3, "'", "''") + "%' OR Billboard.ItemName Like '%" + Replace(billboard_detail__value3, "'", "''") + "%' OR Billboard.ItemMemo Like '%" + Replace(billboard_detail__value3, "'", "''") + "%')  ORDER BY BillboardCategory.CategoryID, DateAdded DESC"
billboard_detail.CursorType = 0
billboard_detail.CursorLocation = 2
billboard_detail.LockType = 3
billboard_detail.Open()
billboard_detail_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_billboardmanager_STRING
Category.Source = "SELECT BillboardCategory.CategoryID, BillboardCategory.CategoryName  FROM BillboardCategory INNER JOIN Billboard ON BillboardCategory.CategoryID = Billboard.CategoryID  GROUP BY BillboardCategory.CategoryID, BillboardCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat1_billboard__numRows
Dim Repeat1_billboard__index

Repeat1_billboard__numRows = -1
Repeat1_billboard__index = 0
billboard_detail_numRows = billboard_detail_numRows + Repeat1_billboard__numRows
%>
<% Dim TFM_nest, lastTFM_nest%>
<html>
<head>
<title>Billboard Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
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
</head>
<body>
<% If NOT Request.QueryString("ItemID") <> "" Then %> 
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
<%end if%>
<div align="center">
  <% 
While ((Repeat1_billboard__numRows <> 0) AND (NOT billboard_detail.EOF)) 
%>
  <table width="100%" cellpadding="0" cellspacing="0">
    <td valign="top" >
            <% TFM_nest = billboard_detail.Fields.Item("CategoryName").Value
If lastTFM_nest <> TFM_nest Then 
	lastTFM_nest = TFM_nest %>
        <table width="100%" height="12" border="0" cellpadding="0" cellspacing="2" class="row2">
          <tr>
            <td height="17" width="50%" class="tablehead1">
              <div align="left"><b><%=(billboard_detail.Fields.Item("CategoryName").Value)%></b></div>
            </td>
            <td width="50%" class="tablehead1"><div align="right">
                <% If Request.QueryString("ItemID")<> "" Then %> 
                    |
                   <a href="<%=request.servervariables("URL")%>
		<%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">Show List</a><%end if%>
           </div></td>
          </tr>
        </table>
	    <%End If 'End Basic-UltraDev Simulated Nested Repeat %>  
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="24" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3" >
                <tr>
                  <td width="7%">Title:</td>
                  <td width="81%"><b><%=(billboard_detail.Fields.Item("ItemName").Value)%>                  </b>                  <% If Not Request.QueryString("ItemID")<> "" Then %> 
                    |
                    <a href="<%=request.servervariables("URL")%>?ItemID=<%=(billboard_detail.Fields.Item("ItemID").Value)%>
		<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">Read
                    More</a>                  <%else%>
                    |                   <a href="<%=request.servervariables("URL")%>
		<%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">Show
                    All</a>                  <%end if%>
  </td>
  <% if billboard_detail.Fields.Item("ImageFile").Value <> "" then %>
                  <td width="12%" rowspan="3" align="right">                    <% if billboard_detail.Fields.Item("ImageFile").Value <> "" then %>
                      <img src="images/<%=(billboard_detail.Fields.Item("ImageFile").Value)%>" alt="Click to Zoom" height="75">
                      <% end if%>
  </td><% end if%>
                </tr>
                <tr>
                  <td>Date Posted:</td>
                  <td><%= DoDateTime((billboard_detail.Fields.Item("DateAdded").Value), 1, 4105) %></td>
                </tr>
                <tr>
                  <td>Description:</td>
                  <td><%=Replace(billboard_detail.Fields.Item("ItemDesc").Value,Chr(13),"<BR>")%></td>
                </tr>
                <tr>
                  <td colspan="3"><hr size="1" noshade></td>
                </tr>
                </table>
            </td>
		    <% if billboard_detail.Fields.Item("ImageFile").Value <> "" then %>
            <% end if%>
          </tr>
  <% if Request.QueryString("ItemID") <> "" then %>		
          <tr>
            <td valign="top"><p><br>
                <%=(billboard_detail.Fields.Item("ItemMemo").Value)%></p>
              <p>
                <% If billboard_detail.Fields.Item("RelatedLink").Value <> "" Then %>
              Related Information: <a href="<%=(billboard_detail.Fields.Item("RelatedLink").Value)%>" target="_blank"><%=(billboard_detail.Fields.Item("RelatedLink").Value)%></a>
              <% end if%>
              </p>
              <p><% If billboard_detail.Fields.Item("DownloadFile").Value <> "" Then %>
              Download File: 
  <a href="<%If instr(billboard_detail.Fields.Item("DownloadFile").Value,"http") Then %><%=(billboard_detail.Fields.Item("DownloadFile").Value)%><%else%>upload/<%=(billboard_detail.Fields.Item("DownloadFile").Value)%><%end if%>" target="_blank"><%=(billboard_detail.Fields.Item("DownloadFile").Value)%></a>
  <% end if%></p></td>
          </tr>
		  <% end if%>
        </table>
      </td>
    </tr>
  </table>
  <% 
  Repeat1_billboard__index=Repeat1_billboard__index+1
  Repeat1_billboard__numRows=Repeat1_billboard__numRows-1
  billboard_detail.MoveNext()
Wend
%>
  <br>
  <input name="button" type=button onClick="javascript:self.close();" value="Close Window">
</div>
</body>
</html>
<%
billboard_detail.Close()
Set billboard_detail = Nothing
%>
<%
Category.Close()
%>
