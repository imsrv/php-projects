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

Repeat_rsItems__numRows = -1
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
          <div align="right"><a href="<%=request.servervariables("URL")%>?show=all
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
<% If Request.QueryString <> "" OR Request.Form <> "" Then ' Remove if you want to display all records as default %>
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
          <td colspan="2" valign="top"><% If Request.QueryString("ItemID") <> "" AND rsItems.Fields.Item("ItemMemo").Value <> "" Then %>
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
<%end if%>
  </tr>
</table>
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
