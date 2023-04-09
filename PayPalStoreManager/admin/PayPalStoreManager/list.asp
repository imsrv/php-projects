<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
' *** Edit Operations: declare variables

Dim MM_editAction
Dim MM_abortEdit
Dim MM_editQuery
Dim MM_editCmd

Dim MM_editConnection
Dim MM_editTable
Dim MM_editRedirectUrl
Dim MM_editColumn
Dim MM_recordId

Dim MM_fieldsStr
Dim MM_columnsStr
Dim MM_fields
Dim MM_columns
Dim MM_typeArray
Dim MM_formVal
Dim MM_delim
Dim MM_altVal
Dim MM_emptyVal
Dim MM_i

MM_editAction = CStr(Request.ServerVariables("SCRIPT_NAME"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Request.QueryString
End If

' boolean to abort record edit
MM_abortEdit = false

' query string to execute
MM_editQuery = ""
%>
<%
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "insert") Then

  MM_editConnection = MM_paypalstoremanager_STRING
  MM_editTable = "tblItems"
  MM_editRedirectUrl = "update.asp?action=insert"
  MM_fieldsStr  = "CategoryID|value|ItemName|value|DateAdded|value|Activated|value|StoreID|value|ItemPriceValue1|value"
  MM_columnsStr = "CategoryIDkey|none,none,NULL|ItemName|',none,''|DateAdded|',none,NULL|Activated|',none,''|StoreIDkey|none,none,NULL|ItemPriceValue1|none,none,NULL"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
  'If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
 'If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      'MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    'Else
      'MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    'End If
  'End If

End If
%>
<%
' *** Insert Record: construct a sql insert statement and execute it

Dim MM_tableValues
Dim MM_dbValues

If (CStr(Request("MM_insert")) <> "") Then

  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_formVal = MM_fields(MM_i+1)
    MM_typeArray = Split(MM_columns(MM_i+1),",")
    MM_delim = MM_typeArray(0)
    If (MM_delim = "none") Then MM_delim = ""
    MM_altVal = MM_typeArray(1)
    If (MM_altVal = "none") Then MM_altVal = ""
    MM_emptyVal = MM_typeArray(2)
    If (MM_emptyVal = "none") Then MM_emptyVal = ""
    If (MM_formVal = "") Then
      MM_formVal = MM_emptyVal
    Else
      If (MM_altVal <> "") Then
        MM_formVal = MM_altVal
      ElseIf (MM_delim = "'") Then  ' escape quotes
        MM_formVal = "'" & Replace(MM_formVal,"'","''") & "'"
      Else
        MM_formVal = MM_delim + MM_formVal + MM_delim
      End If
    End If
    If (MM_i <> LBound(MM_fields)) Then
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End If
    MM_tableValues = MM_tableValues & MM_columns(MM_i)
    MM_dbValues = MM_dbValues & MM_formVal
  Next
  MM_editQuery = "insert into " & MM_editTable & " (" & MM_tableValues & ") values (" & MM_dbValues & ")"

  If (Not MM_abortEdit) Then
    ' execute the insert
    Set MM_editCmd = Server.CreateObject("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_editConnection
    MM_editCmd.CommandText = MM_editQuery
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close

    If (MM_editRedirectUrl <> "") Then
      Response.Redirect(MM_editRedirectUrl)
    End If
  End If

End If
%>
<%
Dim rsItems__value1
rsItems__value1 = "%"
If (Request.QueryString("ItemID") <> "") Then 
  rsItems__value1 = Request.QueryString("ItemID")
End If
%>
<%
Dim rsItems__MMColParam1
rsItems__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  rsItems__MMColParam1 = Request.Form("search")  
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
Dim rsItems
Dim rsItems_numRows

Set rsItems = Server.CreateObject("ADODB.Recordset")
rsItems.ActiveConnection = MM_paypalstoremanager_STRING
rsItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.*, tblItems.*, tbl_Lookup.LookupLabel, tbl_Lookup.LookupDescription, tbl_Lookup_1.LookupLabel, tbl_Lookup_1.LookupDescription, tbl_Lookup_2.LookupLabel, tbl_Lookup_2.LookupDescription, tbl_Lookup_4.LookupLabel, tblPPSM_PayPalPreferences.StoreName, tblPPSM_PayPalPreferences.StoreID, tblPPSM_PayPalPreferences.business, tblPPSM_PayPalPreferences.image_url, tblPPSM_PayPalPreferences.return, tblPPSM_PayPalPreferences.cancel_return, tblPPSM_PayPalPreferences.notify_url, tblPPSM_PayPalPreferences.cmd, tblPPSM_PayPalPreferences.currency_code, tblPPSM_PayPalPreferences.PayPalServer, tblItems_Templates.*  FROM (tblItems_Category RIGHT JOIN ((((((((tblItems LEFT JOIN (tbl_Lookup RIGHT JOIN tbl_LookupDetails ON tbl_Lookup.LookupID = tbl_LookupDetails.LookupIDKey) ON tblItems.LookupItemID1 = tbl_LookupDetails.LookupItemID) LEFT JOIN (tbl_LookupDetails AS tbl_LookupDetails_1 LEFT JOIN tbl_Lookup AS tbl_Lookup_1 ON tbl_LookupDetails_1.LookupIDKey = tbl_Lookup_1.LookupID) ON tblItems.LookupItemID2 = tbl_LookupDetails_1.LookupItemID) LEFT JOIN (tbl_LookupDetails AS tbl_LookupDetails_4 LEFT JOIN tbl_Lookup AS tbl_Lookup_4 ON tbl_LookupDetails_4.LookupIDKey = tbl_Lookup_4.LookupID) ON tblItems.LookupItemID3 = tbl_LookupDetails_4.LookupItemID) LEFT JOIN tbl_LookupDetails AS tbl_LookupDetails_2 ON tblItems.LookupItemID4 = tbl_LookupDetails_2.LookupItemID) LEFT JOIN tbl_LookupDetails AS tbl_LookupDetails_3 ON tblItems.LookupItemID5 = tbl_LookupDetails_3.LookupItemID) LEFT JOIN tbl_Lookup AS tbl_Lookup_2 ON tbl_LookupDetails_2.LookupIDKey = tbl_Lookup_2.LookupID) LEFT JOIN tblPPSM_PayPalPreferences ON tblItems.StoreIDkey = tblPPSM_PayPalPreferences.StoreID) LEFT JOIN tblItems_Templates ON tblItems.TemplateIDkey = tblItems_Templates.tblItemsTemplateID) ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  WHERE tblItems.ItemID LIKE '" + Replace(rsItems__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE  '" + Replace(rsItems__value3, "'", "''") + "' AND (tblItems.ItemDesc Like '%" + Replace(rsItems__MMColParam1, "'", "''") + "%' OR tblItems.ItemName Like '%" + Replace(rsItems__MMColParam1, "'", "''") + "%' OR tblItems.ItemMemo Like '%" + Replace(rsItems__MMColParam1, "'", "''") + "%')  ORDER BY tblItems.DateAdded"
rsItems.CursorType = 0
rsItems.CursorLocation = 2
rsItems.LockType = 1
rsItems.Open()

rsItems_numRows = 0
%>
<%
set rsCategory_list = Server.CreateObject("ADODB.Recordset")
rsCategory_list.ActiveConnection = MM_paypalstoremanager_STRING
rsCategory_list.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile  FROM tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  GROUP BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile HAVING tblItems_Category.ParentCategoryID <>0  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsCategory_list.CursorType = 0
rsCategory_list.CursorLocation = 2
rsCategory_list.LockType = 3
rsCategory_list.Open()
rsCategory_list_numRows = 0
%>
<%
Dim Repeat_rsItems__numRows
Dim Repeat_rsItems__index

Repeat_rsItems__numRows = -1
Repeat_rsItems__index = 0
rsItems_numRows = rsItems_numRows + Repeat_rsItems__numRows
%>
<html>
<head>
<title>PayPal Catalog Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>	
</head>
<body>
<!--#include file="header.asp" -->
<% IF Request.QueryString("action") = "insert" Then%>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
	  <form ACTION="<%=MM_editAction%>" METHOD="POST" name="insert" id="insert">
	  <table width="100%" align="center" class="tableborder">
            <tr valign="middle">
  
          </tr>
          <tr valign="middle">
            <td width="0" class="tableheader"> Select  category</td>
            <td colspan="2" class="tableheader">
              <% If Not rsCategory_list.EOF Or Not rsCategory_list.BOF Then %>
              <select name="CategoryID" id="CategoryID">
                <%
While (NOT rsCategory_list.EOF)
%>
                <option value="<%=(rsCategory_list.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((rsItems.Fields.Item("CategoryIDkey").Value))) Then If (CStr(rsCategory_list.Fields.Item("CategoryID").Value) = CStr((rsItems.Fields.Item("CategoryIDkey").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(rsCategory_list.Fields.Item("ParentCategoryValue").Value)%> - <%=(rsCategory_list.Fields.Item("CategoryValue").Value)%></option>
                <%
  rsCategory_list.MoveNext()
Wend
If (rsCategory_list.CursorType > 0) Then
  rsCategory_list.MoveFirst
Else
  rsCategory_list.Requery
End If
%>
              </select>
              <% End If ' end Not rsCategory_list.EOF Or NOT rsCategory_list.BOF %>
              <a href="javascript:;" onClick="MM_openBrWindow('CategoryManager/admin.asp','Category','scrollbars=yes,width=600,height=400')">[add/edit]</a> </td>
          </tr>
          <tr valign="middle">
            <td class="tableheader">Enter product name</td>
            <td colspan="2" class="tableheader">
            <input name="ItemName" type="text" id="ItemName" value="Enter Name" size="70">
            <input name="save_button" type="submit" value="Next ---&raquo;">
            <input name="DateAdded" type="hidden" id="DateAdded" value="<%= DoDateTime(Date(), 2, 7177) %>">
            <input name="Activated" type="hidden" id="Activated" value="True">
			<input name="StoreID" type="hidden" id="StoreID" value="1">
            <input name="ItemPriceValue1" type="hidden" id="ItemPriceValue1" value="1">
</td>
          </tr>
        </table>

<input type="hidden" name="MM_insert" value="insert">
      </form>
    </td>
  </tr>
</table>
  <%else%>
<form method="post" name="search" id="search" action="<%If Request.QueryString ("action")<> "" Then %>?action=<%=request.querystring("action")%><%end if%>" >
<% If Not rsCategory_list.EOF Or Not rsCategory_list.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr class="tableheader">
    <td height="24" width="33%" valign="baseline">
      <div align="left"> Search by Category:
        <select name="CategoryID" onChange="MM_jumpMenu('parent',this,0)">
    <option value="?action=<%=request.querystring("action")%>" <%If (Not isNull(request.querystring("CategoryID"))) Then If (CStr(rsCategory_list.Fields.Item("CategoryID").Value) = CStr(request.querystring("CategoryID"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
          <%
While (NOT rsCategory_list.EOF)
%>
          <option value="?CategoryID=<%=(rsCategory_list.Fields.Item("CategoryID").Value)%>&action=<%=request.querystring("action")%>" <%If (Not isNull(request.querystring("CategoryID"))) Then If (CStr(rsCategory_list.Fields.Item("CategoryID").Value) = CStr(request.querystring("CategoryID"))) Then Response.Write("SELECTED") : Response.Write("")%>>
		  <%=(rsCategory_list.Fields.Item("ParentCategoryValue").Value)%> &#8212; <%=(rsCategory_list.Fields.Item("CategoryValue").Value)%></option>
          <%
  rsCategory_list.MoveNext()
Wend
If (rsCategory_list.CursorType > 0) Then
  rsCategory_list.MoveFirst
Else
  rsCategory_list.Requery
End If
%>
        </select>
    </div>
    </td>
    <td width="37%" valign="baseline"><div align="right">Search by Keyword
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
          </div>
      </td>
    </tr>
 </table>
<% End If ' end Not rsCategory_list.EOF Or NOT rsCategory_list.BOF %>
</form>
<form action="update_list.asp" method="post" name="update" id="update">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td>
      <div align="right">
        <input name="Submit2" type="submit" id="Submit23" value="Save Changes">
      </div>
    </td>
  </tr>
</table>
<table width="100%" height="32" border="0" cellpadding="2" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="0">&nbsp; </td>
      <td width="0">Category</td>
      <td width="0">Sub Category</td>
      <td width="0">Item ID</td>
      <td width="0">Item Name</td>
      <td width="0">Item Price</td>
      <td width="0"> Unit of Measure</td>
      <td width="0">Activated</td>
      <td width="0"><div align="right"></div></td>
      <td width="0"><div align="center">Edit</div></td>
      <td width="0"><div align="center">Delete</div></td>
      <td width="0"><div align="center">Preview</div></td>
    </tr>
<% Dim iCount
  iCount = 0
%>
<% 
While ((Repeat_rsItems__numRows <> 0) AND (NOT rsItems.EOF)) 
%>
    <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
      <td width="0" height="13"> <strong>&nbsp;
        <%Response.Write(RecordCounter)%>
        . </strong>      </td>
      <td width="0"><%=(rsItems.Fields.Item("ParentCategoryValue").Value)%></td>
      <td width="0"><%=(rsItems.Fields.Item("CategoryValue").Value)%></td>
      <td width="0" height="13"><%=(rsItems.Fields.Item("ItemID").Value)%>
        <input name="<%= (iCount & ".ItemID") %>" type="hidden" value="<%=(rsItems.Fields.Item("ItemID").Value)%>"></td>
      <td width="0" height="13"><input name="<%=(iCount & ".ItemName")%>" type="text" value="<%=(rsItems.Fields.Item("ItemName").Value)%>" size="60"></td>
      <td width="0" height="13"><input name="<%=(iCount & ".ItemPriceValue1")%>" type="text" value="<%=(rsItems.Fields.Item("ItemPriceValue1").Value)%>" size="10">
      </td>
      <td width="0" height="13"><select name="<%=(iCount & ".ItemUOM")%>">
        <option value="Unit" selected <%If (Not isNull((rsItems.Fields.Item("ItemUOM").Value))) Then If ("Unit" = CStr((rsItems.Fields.Item("ItemUOM").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Unit</option>
        <option value="Hour" <%If (Not isNull((rsItems.Fields.Item("ItemUOM").Value))) Then If ("Hour" = CStr((rsItems.Fields.Item("ItemUOM").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Hour</option>
		 <option value="" <%If (Not isNull((rsItems.Fields.Item("ItemUOM").Value))) Then If ("" = CStr((rsItems.Fields.Item("ItemUOM").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>blank</option>
      </select></td>
      <td width="0" height="13"><div align="center">
          <input <%If (CStr((rsItems.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="<%= (iCount & ".Activated") %>" value="True">
                      </div>
      </td>
      <td width="0" height="13"><div align="right">
	  <% if rsItems.Fields.Item("ImageFileThumbValue1").Value <> "" then %>
		  		  <% if instr(rsItems.Fields.Item("ImageFileThumbValue1").Value,"http") Then %>
                  <a href="javascript:;"><img src="<%=(rsItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="MM_openBrWindow('<% if instr(rsItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>
                      <%else%>
                      <a href="javascript:;"><img src="../../applications/PayPalStoreManager/assets/images/<%=(rsItems.Fields.Item("ImageFileThumbValue1").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="MM_openBrWindow('<% if instr(rsItems.Fields.Item("ImageFileValue1").Value,"http") Then %><%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%else%>../../applications/PayPalStoreManager/assets/images/<%=(rsItems.Fields.Item("ImageFileValue1").Value)%><%end if%>','image','scrollbars=yes,width=500,height=500')"></a>
                      <% end if %>
					   <% end if %>
                      </div>
      </td>
      <td width="0" height="13" align="center"> <a href="update.asp?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%>&action=detail"> Edit Details</a> </td>
      <td width="0" height="13" align="center"><a href="delete.asp?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>">Delete</a> </td>
      <td width="0" height="13">
        <div align="center"><a href="/applications/PayPalStoreManager/inc_paypalstoremanager.asp?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%>" target="_blank">Live
            Preview</a> </div>
      </td>
    </tr>
    <% 
  Repeat_rsItems__index=Repeat_rsItems__index+1
  Repeat_rsItems__numRows=Repeat_rsItems__numRows-1
  rsItems.MoveNext()
  iCount = iCount + 1
Wend
%>

</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td>      <div align="right">
        <input name="Submit2" type="submit" id="Submit23" value="Save Changes">
        <input type="hidden" name="Count" value="<%= iCount - 1 %>">
      </div>
    </td>
  </tr>
</table>
</form>
<%end if%>
<% If rsItems.EOF And rsItems.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end rsItems.EOF And rsItems.BOF %>
</body>
</html>
<%
rsItems.Close()
Set rsItems = Nothing
%>
<%
rsCategory_list.Close()
Set rsCategory_list = Nothing
%>
