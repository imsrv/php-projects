<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
' Set PayPal Store Manager Variables

%>
<%
Dim rsItems__value1
rsItems__value1 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  rsItems__value1 = Request.QueryString("ItemID") 
End If
%>
<%
Dim rsItems__value3
rsItems__value3 = "%"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsItems__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsItems__value4
rsItems__value4 = "%"
If (Request.QueryString("ParentCategoryID")    <> "") Then 
  rsItems__value4 = Request.QueryString("ParentCategoryID")   
End If
%>
<%
Dim rsItems__value2
rsItems__value2 = "%"
If (Request.Form("search")      <> "") Then 
  rsItems__value2 = Request.Form("search")     
End If
%>
<%
Dim rsItems
Dim rsItems_numRows

Set rsItems = Server.CreateObject("ADODB.Recordset")
rsItems.ActiveConnection = MM_paypalstoremanager_STRING
rsItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category.*, tblItems.*, tblPPSM_PayPalPreferences.*  FROM tblItems_Category AS tblItems_Category_1 RIGHT JOIN (tblItems_Category RIGHT JOIN (tblItems LEFT JOIN tblPPSM_PayPalPreferences ON tblItems.StoreIDkey = tblPPSM_PayPalPreferences.StoreID) ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) ON tblItems_Category_1.CategoryID = tblItems_Category.ParentCategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID LIKE '" + Replace(rsItems__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsItems__value3, "'", "''") + "' AND tblItems_Category.ParentCategoryID LIKE '" + Replace(rsItems__value4, "'", "''") + "' AND (tblItems.ItemName LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' OR tblItems.ItemDesc LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' OR tblItems.ItemMemo LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' )  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsItems.CursorType = 0
rsItems.CursorLocation = 2
rsItems.LockType = 1
rsItems.Open()

rsItems_numRows = 0
%>
<%
set rsCategory = Server.CreateObject("ADODB.Recordset")
rsCategory.ActiveConnection = MM_paypalstoremanager_STRING
rsCategory.Source = "SELECT tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile, Count(tblItems.ItemID) AS ItemCount  FROM (tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID) RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey  WHERE (((tblItems.Activated)='True'))  GROUP BY tblItems_Category_1.CategoryImageFile, tblItems_Category_1.CategoryLabel, tblItems_Category_1.CategoryDesc, tblItems_Category_1.CategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile  HAVING (((tblItems_Category.ParentCategoryID)<>0))  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsCategory.CursorType = 0
rsCategory.CursorLocation = 2
rsCategory.LockType = 3
rsCategory.Open()
rsCategory_numRows = 0
%>
<%
Dim rsRelatedItems__value1
rsRelatedItems__value1 = "%"
If (Request.QueryString("ItemID") <> "") Then 
  rsRelatedItems__value1 = Request.QueryString("ItemID")
End If
%>
<%
Dim rsRelatedItems__value3
rsRelatedItems__value3 = "%"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsRelatedItems__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsRelatedItems
Dim rsRelatedItems_numRows

Set rsRelatedItems = Server.CreateObject("ADODB.Recordset")
rsRelatedItems.ActiveConnection = MM_paypalstoremanager_STRING
rsRelatedItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category.*, tblItems.*, tblPPSM_PayPalPreferences.*  FROM tblItems_Category AS tblItems_Category_1 RIGHT JOIN (tblItems_Category RIGHT JOIN (tblItems LEFT JOIN tblPPSM_PayPalPreferences ON tblItems.StoreIDkey = tblPPSM_PayPalPreferences.StoreID) ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) ON tblItems_Category_1.CategoryID = tblItems_Category.ParentCategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID NOT LIKE '" + Replace(rsRelatedItems__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsRelatedItems__value3, "'", "''") + "'  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsRelatedItems.CursorType = 0
rsRelatedItems.CursorLocation = 2
rsRelatedItems.LockType = 1
rsRelatedItems.Open()

rsRelatedItems_numRows = 0
%>
<%
Dim RepeatrsCategoryList__numRows
Dim RepeatrsCategoryList__index

RepeatrsCategoryList__numRows = -1
RepeatrsCategoryList__index = 0
rsCategory_numRows = rsCategory_numRows + RepeatrsCategoryList__numRows
%>
<%
Dim Repeat_rsItems__numRows
Dim Repeat_rsItems__index

Repeat_rsItems__numRows = 10
Repeat_rsItems__index = 0
rsItems_numRows = rsItems_numRows + Repeat_rsItems__numRows
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
rsRelatedItems_numRows = rsRelatedItems_numRows + Repeat1__numRows
%>
<%
'  *** Recordset Stats, Move To Record, and Go To Record: declare stats variables

Dim rsItems_total
Dim rsItems_first
Dim rsItems_last

' set the record count
rsItems_total = rsItems.RecordCount

' set the number of rows displayed on this page
If (rsItems_numRows < 0) Then
  rsItems_numRows = rsItems_total
Elseif (rsItems_numRows = 0) Then
  rsItems_numRows = 1
End If

' set the first and last displayed record
rsItems_first = 1
rsItems_last  = rsItems_first + rsItems_numRows - 1

' if we have the correct record count, check the other stats
If (rsItems_total <> -1) Then
  If (rsItems_first > rsItems_total) Then
    rsItems_first = rsItems_total
  End If
  If (rsItems_last > rsItems_total) Then
    rsItems_last = rsItems_total
  End If
  If (rsItems_numRows > rsItems_total) Then
    rsItems_numRows = rsItems_total
  End If
End If
%>
<%
' *** Recordset Stats: if we don't know the record count, manually count them

If (rsItems_total = -1) Then

  ' count the total records by iterating through the recordset
  rsItems_total=0
  While (Not rsItems.EOF)
    rsItems_total = rsItems_total + 1
    rsItems.MoveNext
  Wend

  ' reset the cursor to the beginning
  If (rsItems.CursorType > 0) Then
    rsItems.MoveFirst
  Else
    rsItems.Requery
  End If

  ' set the number of rows displayed on this page
  If (rsItems_numRows < 0 Or rsItems_numRows > rsItems_total) Then
    rsItems_numRows = rsItems_total
  End If

  ' set the first and last displayed record
  rsItems_first = 1
  rsItems_last = rsItems_first + rsItems_numRows - 1
  
  If (rsItems_first > rsItems_total) Then
    rsItems_first = rsItems_total
  End If
  If (rsItems_last > rsItems_total) Then
    rsItems_last = rsItems_total
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

Set MM_rs    = rsItems
MM_rsCount   = rsItems_total
MM_size      = rsItems_numRows
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
rsItems_first = MM_offset + 1
rsItems_last  = MM_offset + MM_size

If (MM_rsCount <> -1) Then
  If (rsItems_first > MM_rsCount) Then
    rsItems_first = MM_rsCount
  End If
  If (rsItems_last > MM_rsCount) Then
    rsItems_last = MM_rsCount
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../../styles.css" rel="stylesheet" type="text/css">
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="16%" valign="top">	<form name="searchForm" method="post" action="<%=request.servervariables("URL")%>
<%If Request.QueryString ("mid")<> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">
    <% If Not rsCategory.EOF Or Not rsCategory.BOF Then %>
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
      <tr>
        <td valign="top" bgcolor="#CCCCCC"><strong>search by keyword</strong><br>
            <input name="search" type="text" id="search" size="20">
            <input type="submit" value="Search" name="submit3" height="1">
        </td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFCC">
          <% 
While ((RepeatrsCategoryList__numRows <> 0) AND (NOT rsCategory.EOF)) 
%>
          <% nested_categoryvalue = rsCategory.Fields.Item("ParentCategoryValue").Value
If lastnested_categoryvalue <> nested_categoryvalue Then 
	lastnested_categoryvalue = nested_categoryvalue %>
          <br>
          <strong> <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsCategory.Fields.Item("ParentCategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategory.Fields.Item("ParentCategoryValue").Value)%></a></strong> <br>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
&nbsp;&raquo;&nbsp; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsCategory.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategory.Fields.Item("CategoryValue").Value)%></a> (<%=(rsCategory.Fields.Item("ItemCount").Value)%>)<br>
      <%
itemtotal = itemtotal + (rsCategory.Fields.Item("ItemCount").Value)
%>
      <% 
  RepeatrsCategoryList__index=RepeatrsCategoryList__index+1
  RepeatrsCategoryList__numRows=RepeatrsCategoryList__numRows-1
  rsCategory.MoveNext()
Wend
%>
          <div align="right"><a href="<%=request.servervariables("URL")%>
<%If Request.QueryString ("mid")<> "" Then %>?mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><br>
        Show All</a> (<%=ItemTotal%>) </div>
        </td>
      </tr>
    </table>
    <% End If ' end Not rsCategory.EOF Or NOT rsCategory.BOF %>

    </form>  
</td>
    <td width="84%" valign="top">
      <% 
While ((Repeat_rsItems__numRows <> 0) AND (NOT rsItems.EOF)) 
%>
      <% If Not rsItems.EOF Or Not rsItems.BOF Then %>
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row2"
Else
Response.Write "row1"
End If
%>">
<% if rsItems.Fields.Item("ImageFileThumbValue1").Value <> "" then %>           
          <td width="150" align="left" valign="top">            <% if rsItems.Fields.Item("ImageFileThumbValue1").Value <> "" then %>            <% if instr(rsItems.Fields.Item("ImageFileThumbValue1").Value,"http") Then %>
            <a href="javascript:;"><img src="<%=(rsItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="150" hspace="5" vspace="0" border="0" onClick="MM_openBrWindow('<% if instr(rsItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%else%>assets/images/<%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>            <%else%>
            <a href="javascript:;"><img src="assets/images/<%=(rsItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="150" hspace="5" vspace="0" border="0" onClick="MM_openBrWindow('<% if instr(rsItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%else%>assets/images/<%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>            <% end if %>           <% end if ' image check %>
          </td>
 <% end if %>  		  
          <td width="0" valign="top">          <p><font size="2"> <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsItems.Fields.Item("ParentCategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItems.Fields.Item("ParentCategoryValue").Value)%></a> &raquo; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItems.Fields.Item("CategoryValue").Value)%></a>&nbsp;<br>
              </font> <font size="2"><b><br>
              <%=(rsItems.Fields.Item("ItemName").Value)%></b></font>
              <%If Request.QueryString ("ItemID") <> "" Then %>
              <font size="2">&raquo;</font> <a href="javascript:history.go(-1);">Go
              Back</a>
              <% else%>
              <font size="2">&raquo;</font> <a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">More
              Detail</a>
              <%end if%>
              <br>
  <%=(rsItems.Fields.Item("ItemDesc").Value)%>          
            <div align="left"><font color="#FF0000" size="2"><strong>            <%= FormatCurrency((rsItems.Fields.Item("ItemPriceValue1").Value), -1, -2, -2, -2) %></strong></font>
			
			  <% If rsItems.Fields.Item("ItemUOM").Value <> "" Then %>
			  /<%=(rsItems.Fields.Item("ItemUOM").Value)%>
			  <%end if%>
		    </DIV>
					    <div align="right">
              <% if rsItems.Fields.Item("cmd").Value = "_xclick" Then %>
              <form name="_xclick" action="<%=(rsItems.Fields.Item("PayPalServer").Value)%>" method="post" target="_blank">
  
                      <input name="submit" type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but01.gif" alt="Make payments with PayPal - it's fast, free and secure!" align="right" border="0" >
                      <input type="hidden" name="cmd" value="<%=(rsItems.Fields.Item("cmd").Value)%>">
                      <input type="hidden" name="business" value="<%=(rsItems.Fields.Item("business").Value)%>">
                      <input type="hidden" name="currency_code" value="<%=(rsItems.Fields.Item("currency_code").Value)%>">
                      <input type="hidden" name="item_name" value="<%=(rsItems.Fields.Item("ItemName").Value)%>">
                      <input type="hidden" name="amount" value="<%=(rsItems.Fields.Item("ItemPriceValue1").Value)%>">
                      <input type="hidden" name="cancel_return" value="<%=(rsItems.Fields.Item("cancel_return").Value)%>">
                      <input type="hidden" name="return" value="<%=(rsItems.Fields.Item("return").Value)%>">
                      <input type="hidden" name="notify_url" value="<%=(rsItems.Fields.Item("notify_url").Value)%>">
                      <input type="hidden" name="item_number" value="<%=(rsItems.Fields.Item("ItemID").Value)%>">
                      <input type="hidden" name="image_url" value="<%=(rsItems.Fields.Item("image_url").Value)%>">
              </form>
              <%else%>
              <form action="<%=(rsItems.Fields.Item("PayPalServer").Value)%>" method="post" name="ShoppingCart" target="paypal" id="ShoppingCart">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but22.gif" border="0" name="submit2" alt="Make payments with PayPal - it's fast, free and secure!">
                <input type="hidden" name="cmd" value="<%=(rsItems.Fields.Item("cmd").Value)%>">
                <input type="hidden" name="business" value="<%=(rsItems.Fields.Item("business").Value)%>">
                <input type="hidden" name="currency_code" value="<%=(rsItems.Fields.Item("currency_code").Value)%>">
                <input type="hidden" name="item_name" value="<%=(rsItems.Fields.Item("ItemName").Value)%>">
                <input type="hidden" name="amount" value="<%=(rsItems.Fields.Item("ItemPriceValue1").Value)%>">
                <input type="hidden" name="return" value="<%=(rsItems.Fields.Item("return").Value)%>">
                <input type="hidden" name="cancel_return" value="<%=(rsItems.Fields.Item("cancel_return").Value)%>">
                <input type="hidden" name="notify_url" value="<%=(rsItems.Fields.Item("notify_url").Value)%>">
                <input type="hidden" name="item_number" value="<%=(rsItems.Fields.Item("ItemID").Value)%>">
                <input type="hidden" name="image_url" value="<%=(rsItems.Fields.Item("image_url").Value)%>">
                <input type="hidden" name="on0" value="Options">
                <input type="hidden" name="os0" value="Not Applicable">
                <input type="hidden" name="add" value="1">
              </form>
              <form action="<%=(rsItems.Fields.Item("PayPalServer").Value)%>" method="post" name="ViewCart" target="paypal" id="ViewCart">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="business" value="<%=(rsItems.Fields.Item("business").Value)%>">
                <input type="hidden" name="image_url" value="<%=(rsItems.Fields.Item("image_url").Value)%>">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/view_cart_02.gif" border="0" name="submit2" alt="Make payments with PayPal - it's fast, free and secure!">
                <input type="hidden" name="display" value="1">
              </form>
              <% end if%>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
<% If Request.QueryString("ItemID") <> "" AND rsItems.Fields.Item("ItemMemo").Value <> "" Then %>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="activeborder">
              <tr>
                <td bgcolor="#666666"><font color="#FFFFFF">Additional
                      Details:</font></td>
              </tr>
              <tr>
                <td><%=(rsItems.Fields.Item("ItemMemo").Value)%> </td>
              </tr>
            </table>     
            <%End If %>
          </td>
        </tr>
      </table>
      <% End If ' end Not rsItems.EOF Or NOT rsItems.BOF %>
      <% 	  dim CategoryID
CategoryID = (rsItems.Fields.Item("CategoryID").Value) 
%>
	  
	    <br>
			 <% 
  Repeat_rsItems__index=Repeat_rsItems__index+1
  Repeat_rsItems__numRows=Repeat_rsItems__numRows-1
  rsItems.MoveNext()
Wend
%>
<% If NOT Request.QueryString("ItemID") <> "" Then %>
		  <table width="95%" border="0" cellpadding="5">
  <tr>
    <td>&nbsp;
      <table border="0" width="50%" align="center">
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
      </table>
    
      <p align="center">&nbsp; Records <%=(rsItems_first)%> to <%=(rsItems_last)%> of <%=(rsItems_total)%> </p></td>
  </tr>
</table>
<% end if%>
             <% If Not rsRelatedItems.EOF Or Not rsRelatedItems.BOF Then %>
             <table width="95%" border="0" align="center" cellpadding="0" bgcolor="#FFFFCC" class="tableborder">
          <tr bgcolor="#FFFFCC">
            <td><em><strong>Also available<font size="2">:</font></strong></em></td>
          </tr>
          <% 
While ((Repeat1__numRows <> 0) AND (NOT rsRelatedItems.EOF)) 
%>
          <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row2"
Else
Response.Write "row1"
End If
%>">
            <td valign="top">             
<% IF (rsRelatedItems.Fields.Item("ImageFileThumbValue1").Value) <> "" THEN %>            
<% if instr(rsRelatedItems.Fields.Item("ImageFileThumbValue1").Value,"http") Then %>             
<a href="javascript:;"><img src="<%=(rsRelatedItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="25" border="0" align="left" onClick="MM_openBrWindow('<% if instr(rsRelatedItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsRelatedItems.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>              
<%else%>              
<a href="javascript:;"><img src="../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="25" border="0" align="left" onClick="MM_openBrWindow('<% if instr(rsRelatedItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsRelatedItems.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>  
<% end if %>
<% end if %><a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsRelatedItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsRelatedItems.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsRelatedItems.Fields.Item("ItemName").Value)%></a> - <font color="#FF0000"><%= FormatCurrency((rsRelatedItems.Fields.Item("ItemPriceValue1").Value), -1, -2, -2, -2) %></font> 

<% If rsRelatedItems.Fields.Item("ItemUOM").Value <> "" Then %>
/<%=(rsRelatedItems.Fields.Item("ItemUOM").Value)%>
<%end if%>
</td>
          </tr>
          <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  rsRelatedItems.MoveNext()
Wend
%>
             </table>
             <% End If ' end Not rsRelatedItems.EOF Or NOT rsRelatedItems.BOF %>
<br>
	<% If rsItems.EOF And rsItems.BOF AND request.Form("search") <> "" Then %>
<br>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"><font size="2">No items found containing keyword <font color="#FF0000">&quot;<strong><%= Request.Form("search") %></strong>&quot;</font> .....Please <a href="javascript:history.go(-1);">Try
        Again</a></font></div>
    </td>
  </tr>
</table>
<% End If ' end rsItems.EOF And rsItems.BOF %>
</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
<%
rsItems.Close()
Set rsItems = Nothing
%>
<%
rsCategory.Close()
Set rsCategory = Nothing
%>
<%
rsRelatedItems.Close()
Set rsRelatedItems = Nothing
%>
