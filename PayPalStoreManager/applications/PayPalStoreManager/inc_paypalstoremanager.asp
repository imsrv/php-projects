<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
' Set PayPal Store Manager Variables

%>
<%
Dim rsItemsPPSM__value1
rsItemsPPSM__value1 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  rsItemsPPSM__value1 = Request.QueryString("ItemID") 
End If
%>
<%
Dim rsItemsPPSM__value3
rsItemsPPSM__value3 = "%"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsItemsPPSM__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsItemsPPSM__value4
rsItemsPPSM__value4 = "%"
If (Request.QueryString("ParentCategoryID")    <> "") Then 
  rsItemsPPSM__value4 = Request.QueryString("ParentCategoryID")   
End If
%>
<%
Dim rsItemsPPSM__value2
rsItemsPPSM__value2 = "%"
If (Request.Form("search")      <> "") Then 
  rsItemsPPSM__value2 = Request.Form("search")     
End If
%>
<%
Dim rsItemsPPSM
Dim rsItemsPPSM_numRows

Set rsItemsPPSM = Server.CreateObject("ADODB.Recordset")
rsItemsPPSM.ActiveConnection = MM_paypalstoremanager_STRING
rsItemsPPSM.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category.*, tblItems.*, tblPPSM_PayPalPreferences.*  FROM tblItems_Category AS tblItems_Category_1 RIGHT JOIN (tblItems_Category RIGHT JOIN (tblItems LEFT JOIN tblPPSM_PayPalPreferences ON tblItems.StoreIDkey = tblPPSM_PayPalPreferences.StoreID) ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) ON tblItems_Category_1.CategoryID = tblItems_Category.ParentCategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID LIKE '" + Replace(rsItemsPPSM__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsItemsPPSM__value3, "'", "''") + "' AND tblItems_Category.ParentCategoryID LIKE '" + Replace(rsItemsPPSM__value4, "'", "''") + "' AND (tblItems.ItemName LIKE '%" + Replace(rsItemsPPSM__value2, "'", "''") + "%' OR tblItems.ItemDesc LIKE '%" + Replace(rsItemsPPSM__value2, "'", "''") + "%' OR tblItems.ItemMemo LIKE '%" + Replace(rsItemsPPSM__value2, "'", "''") + "%' )  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsItemsPPSM.CursorType = 0
rsItemsPPSM.CursorLocation = 2
rsItemsPPSM.LockType = 1
rsItemsPPSM.Open()

rsItemsPPSM_numRows = 0
%>
<%
set rsCategoryPPSM = Server.CreateObject("ADODB.Recordset")
rsCategoryPPSM.ActiveConnection = MM_paypalstoremanager_STRING
rsCategoryPPSM.Source = "SELECT tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile, Count(tblItems.ItemID) AS ItemCount  FROM (tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID) RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey  WHERE (((tblItems.Activated)='True'))  GROUP BY tblItems_Category_1.CategoryImageFile, tblItems_Category_1.CategoryLabel, tblItems_Category_1.CategoryDesc, tblItems_Category_1.CategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile  HAVING (((tblItems_Category.ParentCategoryID)<>0))  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsCategoryPPSM.CursorType = 0
rsCategoryPPSM.CursorLocation = 2
rsCategoryPPSM.LockType = 3
rsCategoryPPSM.Open()
rsCategoryPPSM_numRows = 0
%>
<%
Dim rsRelatedItemsPPSM__value1
rsRelatedItemsPPSM__value1 = "%"
If (Request.QueryString("ItemID") <> "") Then 
  rsRelatedItemsPPSM__value1 = Request.QueryString("ItemID")
End If
%>
<%
Dim rsRelatedItemsPPSM__value3
rsRelatedItemsPPSM__value3 = "%"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsRelatedItemsPPSM__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsRelatedItemsPPSM
Dim rsRelatedItemsPPSM_numRows

Set rsRelatedItemsPPSM = Server.CreateObject("ADODB.Recordset")
rsRelatedItemsPPSM.ActiveConnection = MM_paypalstoremanager_STRING
rsRelatedItemsPPSM.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category.*, tblItems.*, tblPPSM_PayPalPreferences.*  FROM tblItems_Category AS tblItems_Category_1 RIGHT JOIN (tblItems_Category RIGHT JOIN (tblItems LEFT JOIN tblPPSM_PayPalPreferences ON tblItems.StoreIDkey = tblPPSM_PayPalPreferences.StoreID) ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) ON tblItems_Category_1.CategoryID = tblItems_Category.ParentCategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID NOT LIKE '" + Replace(rsRelatedItemsPPSM__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsRelatedItemsPPSM__value3, "'", "''") + "'  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsRelatedItemsPPSM.CursorType = 0
rsRelatedItemsPPSM.CursorLocation = 2
rsRelatedItemsPPSM.LockType = 1
rsRelatedItemsPPSM.Open()

rsRelatedItemsPPSM_numRows = 0
%>
<%
Dim RepeatrsCategoryPPSMList__numRows
Dim RepeatrsCategoryPPSMList__index

RepeatrsCategoryPPSMList__numRows = -1
RepeatrsCategoryPPSMList__index = 0
rsCategoryPPSM_numRows = rsCategoryPPSM_numRows + RepeatrsCategoryPPSMList__numRows
%>
<%
Dim Repeat_rsItemsPPSM__numRows
Dim Repeat_rsItemsPPSM__index

Repeat_rsItemsPPSM__numRows = -1
Repeat_rsItemsPPSM__index = 0
rsItemsPPSM_numRows = rsItemsPPSM_numRows + Repeat_rsItemsPPSM__numRows
%>
<%
Dim Repeat_rsRelatedItemsPPSM__numRows
Dim Repeat_rsRelatedItemsPPSM__index

Repeat_rsRelatedItemsPPSM__numRows = -1
Repeat_rsRelatedItemsPPSM__index = 0
rsRelatedItemsPPSM_numRows = rsRelatedItemsPPSM_numRows + Repeat_rsRelatedItemsPPSM__numRows
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
    <% If Not rsCategoryPPSM.EOF Or Not rsCategoryPPSM.BOF Then %>
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
While ((RepeatrsCategoryPPSMList__numRows <> 0) AND (NOT rsCategoryPPSM.EOF)) 
%>
          <% nested_categoryvalue = rsCategoryPPSM.Fields.Item("ParentCategoryValue").Value
If lastnested_categoryvalue <> nested_categoryvalue Then 
	lastnested_categoryvalue = nested_categoryvalue %>
          <br>
          <strong> <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsCategoryPPSM.Fields.Item("ParentCategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategoryPPSM.Fields.Item("ParentCategoryValue").Value)%></a></strong> <br>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
&nbsp;&raquo;&nbsp; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsCategoryPPSM.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategoryPPSM.Fields.Item("CategoryValue").Value)%></a> (<%=(rsCategoryPPSM.Fields.Item("ItemCount").Value)%>)<br>
      <%
itemtotal = itemtotal + (rsCategoryPPSM.Fields.Item("ItemCount").Value)
%>
      <% 
  RepeatrsCategoryPPSMList__index=RepeatrsCategoryPPSMList__index+1
  RepeatrsCategoryPPSMList__numRows=RepeatrsCategoryPPSMList__numRows-1
  rsCategoryPPSM.MoveNext()
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
    <% End If ' end Not rsCategoryPPSM.EOF Or NOT rsCategoryPPSM.BOF %>

    </form>  
</td>
    <td width="84%" valign="top">
      <% 
While ((Repeat_rsItemsPPSM__numRows <> 0) AND (NOT rsItemsPPSM.EOF)) 
%>
      <% If Not rsItemsPPSM.EOF Or Not rsItemsPPSM.BOF Then %>
      <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row2"
Else
Response.Write "row1"
End If
%>">
<% if rsItemsPPSM.Fields.Item("ImageFileThumbValue1").Value <> "" then %>           
          <td width="150" align="left" valign="top">            <% if rsItemsPPSM.Fields.Item("ImageFileThumbValue1").Value <> "" then %>            <% if instr(rsItemsPPSM.Fields.Item("ImageFileThumbValue1").Value,"http") Then %>
            <a href="javascript:;"><img src="<%=(rsItemsPPSM.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="150" hspace="5" vspace="0" border="0" onClick="MM_openBrWindow('<% if instr(rsItemsPPSM.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>            <%else%>
            <a href="javascript:;"><img src="../../applications/PayPalStoreManager/assets/images/<%=(rsItemsPPSM.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="150" hspace="5" vspace="0" border="0" onClick="MM_openBrWindow('<% if instr(rsItemsPPSM.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>            <% end if %>           <% end if ' image check %>
          </td>
 <% end if %>  		  
          <td width="0" valign="top">          <p><font size="2"> <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsItemsPPSM.Fields.Item("ParentCategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItemsPPSM.Fields.Item("ParentCategoryValue").Value)%></a> &raquo; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsItemsPPSM.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItemsPPSM.Fields.Item("CategoryValue").Value)%></a>&nbsp;<br>
              </font> <font size="2"><b><br>
              <%=(rsItemsPPSM.Fields.Item("ItemName").Value)%></b></font>
              <%If Request.QueryString ("ItemID") <> "" Then %>
              <font size="2">&raquo;</font> <a href="javascript:history.go(-1);">Go
              Back</a>
              <% else%>
              <font size="2">&raquo;</font> <a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsItemsPPSM.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItemsPPSM.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">More
              Detail</a>
              <%end if%>
              <br>
  <%=(rsItemsPPSM.Fields.Item("ItemDesc").Value)%>          
            <div align="left"><font color="#FF0000" size="2"><strong>            <%= FormatCurrency((rsItemsPPSM.Fields.Item("ItemPriceValue1").Value), -1, -2, -2, -2) %></strong></font>
			
			  <% If rsItemsPPSM.Fields.Item("ItemUOM").Value <> "" Then %>
			  /<%=(rsItemsPPSM.Fields.Item("ItemUOM").Value)%>
			  <%end if%>
		    </DIV>
					    <div align="right">
              <% if rsItemsPPSM.Fields.Item("cmd").Value = "_xclick" Then %>
              <form name="_xclick" action="<%=(rsItemsPPSM.Fields.Item("PayPalServer").Value)%>" method="post" target="_blank">
  
                      <input name="submit" type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but01.gif" alt="Make payments with PayPal - it's fast, free and secure!" align="right" border="0" >
                      <input type="hidden" name="cmd" value="<%=(rsItemsPPSM.Fields.Item("cmd").Value)%>">
                      <input type="hidden" name="business" value="<%=(rsItemsPPSM.Fields.Item("business").Value)%>">
                      <input type="hidden" name="currency_code" value="<%=(rsItemsPPSM.Fields.Item("currency_code").Value)%>">
                      <input type="hidden" name="item_name" value="<%=(rsItemsPPSM.Fields.Item("ItemName").Value)%>">
                      <input type="hidden" name="amount" value="<%=(rsItemsPPSM.Fields.Item("ItemPriceValue1").Value)%>">
                      <input type="hidden" name="cancel_return" value="<%=(rsItemsPPSM.Fields.Item("cancel_return").Value)%>">
                      <input type="hidden" name="return" value="<%=(rsItemsPPSM.Fields.Item("return").Value)%>">
                      <input type="hidden" name="notify_url" value="<%=(rsItemsPPSM.Fields.Item("notify_url").Value)%>">
                      <input type="hidden" name="item_number" value="<%=(rsItemsPPSM.Fields.Item("ItemID").Value)%>">
                      <input type="hidden" name="image_url" value="<%=(rsItemsPPSM.Fields.Item("image_url").Value)%>">
              </form>
              <%else%>
              <form action="<%=(rsItemsPPSM.Fields.Item("PayPalServer").Value)%>" method="post" name="ShoppingCart" target="paypal" id="ShoppingCart">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but22.gif" border="0" name="submit2" alt="Make payments with PayPal - it's fast, free and secure!">
                <input type="hidden" name="cmd" value="<%=(rsItemsPPSM.Fields.Item("cmd").Value)%>">
                <input type="hidden" name="business" value="<%=(rsItemsPPSM.Fields.Item("business").Value)%>">
                <input type="hidden" name="currency_code" value="<%=(rsItemsPPSM.Fields.Item("currency_code").Value)%>">
                <input type="hidden" name="item_name" value="<%=(rsItemsPPSM.Fields.Item("ItemName").Value)%>">
                <input type="hidden" name="amount" value="<%=(rsItemsPPSM.Fields.Item("ItemPriceValue1").Value)%>">
                <input type="hidden" name="return" value="<%=(rsItemsPPSM.Fields.Item("return").Value)%>">
                <input type="hidden" name="cancel_return" value="<%=(rsItemsPPSM.Fields.Item("cancel_return").Value)%>">
                <input type="hidden" name="notify_url" value="<%=(rsItemsPPSM.Fields.Item("notify_url").Value)%>">
                <input type="hidden" name="item_number" value="<%=(rsItemsPPSM.Fields.Item("ItemID").Value)%>">
                <input type="hidden" name="image_url" value="<%=(rsItemsPPSM.Fields.Item("image_url").Value)%>">
                <input type="hidden" name="on0" value="Options">
                <input type="hidden" name="os0" value="Not Applicable">
                <input type="hidden" name="add" value="1">
              </form>
              <form action="<%=(rsItemsPPSM.Fields.Item("PayPalServer").Value)%>" method="post" name="ViewCart" target="paypal" id="ViewCart">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="business" value="<%=(rsItemsPPSM.Fields.Item("business").Value)%>">
                <input type="hidden" name="image_url" value="<%=(rsItemsPPSM.Fields.Item("image_url").Value)%>">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/view_cart_02.gif" border="0" name="submit2" alt="Make payments with PayPal - it's fast, free and secure!">
                <input type="hidden" name="display" value="1">
              </form>
              <% end if%>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><% If Request.QueryString("ItemID") <> "" AND rsItemsPPSM.Fields.Item("ItemMemo").Value <> "" Then %>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="activeborder">
              <tr>
                <td bgcolor="#666666"><font color="#FFFFFF">Additional
                      Details:</font></td>
              </tr>
              <tr>
                <td><%=(rsItemsPPSM.Fields.Item("ItemMemo").Value)%> </td>
              </tr>
            </table>     
            <%End If %>
          </td>
        </tr>
      </table>
      <% End If ' end Not rsItemsPPSM.EOF Or NOT rsItemsPPSM.BOF %>
      <% 	
CategoryID = (rsItemsPPSM.Fields.Item("CategoryID").Value) 
%>
	  
	    <br>
			 <% 
  Repeat_rsItemsPPSM__index=Repeat_rsItemsPPSM__index+1
  Repeat_rsItemsPPSM__numRows=Repeat_rsItemsPPSM__numRows-1
  rsItemsPPSM.MoveNext()
Wend
%>
             <% If Not rsRelatedItemsPPSM.EOF Or Not rsRelatedItemsPPSM.BOF Then %>
             <table width="95%" border="0" align="center" cellpadding="0" bgcolor="#FFFFCC" class="tableborder">
          <tr bgcolor="#FFFFCC">
            <td><em><strong>Also available<font size="2">:</font></strong></em></td>
          </tr>
          <% 
While ((Repeat_rsRelatedItemsPPSM__numRows <> 0) AND (NOT rsRelatedItemsPPSM.EOF)) 
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
<% IF (rsRelatedItemsPPSM.Fields.Item("ImageFileThumbValue1").Value) <> "" THEN %>            
<% if instr(rsRelatedItemsPPSM.Fields.Item("ImageFileThumbValue1").Value,"http") Then %>             
<a href="javascript:;"><img src="<%=(rsRelatedItemsPPSM.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="25" border="0" align="left" onClick="MM_openBrWindow('<% if instr(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>              
<%else%>              
<a href="javascript:;"><img src="../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItemsPPSM.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="25" border="0" align="left" onClick="MM_openBrWindow('<% if instr(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsRelatedItemsPPSM.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>  
<% end if %>
<% end if %><a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsRelatedItemsPPSM.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsRelatedItemsPPSM.Fields.Item("CategoryID").Value)%>
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsRelatedItemsPPSM.Fields.Item("ItemName").Value)%></a> - <font color="#FF0000"><%= FormatCurrency((rsRelatedItemsPPSM.Fields.Item("ItemPriceValue1").Value), -1, -2, -2, -2) %></font> 

<% If rsRelatedItemsPPSM.Fields.Item("ItemUOM").Value <> "" Then %>
/<%=(rsRelatedItemsPPSM.Fields.Item("ItemUOM").Value)%>
<%end if%>
</td>
          </tr>
          <% 
  Repeat_rsRelatedItemsPPSM__index=Repeat_rsRelatedItemsPPSM__index+1
  Repeat_rsRelatedItemsPPSM__numRows=Repeat_rsRelatedItemsPPSM__numRows-1
  rsRelatedItemsPPSM.MoveNext()
Wend
%>
             </table>
             <% End If ' end Not rsRelatedItemsPPSM.EOF Or NOT rsRelatedItemsPPSM.BOF %>
<br>
	<% If rsItemsPPSM.EOF And rsItemsPPSM.BOF AND request.Form("search") <> "" Then %>
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
<% End If ' end rsItemsPPSM.EOF And rsItemsPPSM.BOF %>
</td>
  </tr>
</table>
</body>
<%
rsItemsPPSM.Close()
Set rsItemsPPSM = Nothing
%>
<%
rsCategoryPPSM.Close()
Set rsCategoryPPSM = Nothing
%>
<%
rsRelatedItemsPPSM.Close()
Set rsRelatedItemsPPSM = Nothing
%>
