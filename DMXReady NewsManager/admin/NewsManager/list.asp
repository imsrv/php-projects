<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/newsmanager.asp"-->
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

  MM_editConnection = MM_newsmanager_STRING
  MM_editTable = "tblNM_News"
  MM_editRedirectUrl = "list.asp"
  MM_fieldsStr  = "CategoryID|value|ItemName|value|ItemDesc|value|DateAdded|value|ExpiryDate|value|Activated|value|txtContent|value"
  MM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|DateAdded|',none,NULL|ExpiryDate|',none,NULL|Activated|',none,''|ItemMemo|',none,''"

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
set ParentCategory = Server.CreateObject("ADODB.Recordset")
ParentCategory.ActiveConnection = MM_newsmanager_STRING
ParentCategory.Source = "SELECT tblNM_NewsCategory_1.CategoryID AS ParentCategoryID, tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory_1.CategoryDesc AS ParentCategoryDesc, tblNM_NewsCategory_1.CategoryLabel AS ParentCategoryLabel, tblNM_NewsCategory_1.CategoryImageFile AS ParentCategoryImage  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID   WHERE (((tblNM_NewsCategory_1.CategoryID) Is Not Null)) GROUP BY tblNM_NewsCategory_1.CategoryID, tblNM_NewsCategory_1.ParentCategoryID, tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory_1.CategoryDesc, tblNM_NewsCategory_1.CategoryLabel, tblNM_NewsCategory_1.CategoryImageFile  ORDER BY tblNM_NewsCategory_1.CategoryValue"
ParentCategory.CursorType = 0
ParentCategory.CursorLocation = 2
ParentCategory.LockType = 3
ParentCategory.Open()
ParentCategory_numRows = 0
%>
<%
Dim Category__value1
Category__value1 = "xyz"
If (Request.QueryString("pcid") <> "") Then 
  Category__value1 = Request.QueryString("pcid")
End If
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_newsmanager_STRING
Category.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile  FROM tblNM_NewsCategory LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  GROUP BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile HAVING tblNM_NewsCategory.ParentCategoryID LIKE '" + Replace(Category__value1, "'", "''") + "' AND tblNM_NewsCategory.ParentCategoryID <>0  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
set Category_list = Server.CreateObject("ADODB.Recordset")
Category_list.ActiveConnection = MM_newsmanager_STRING
Category_list.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile  FROM tblNM_NewsCategory LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  GROUP BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryID, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile HAVING tblNM_NewsCategory.ParentCategoryID <>0  ORDER BY tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue"
Category_list.CursorType = 0
Category_list.CursorLocation = 2
Category_list.LockType = 3
Category_list.Open()
Category_list_numRows = 0
%>
<%
Dim settings
Dim settings_numRows

Set settings = Server.CreateObject("ADODB.Recordset")
settings.ActiveConnection = MM_newsmanager_STRING
settings.Source = "SELECT *  FROM tblNM_Settings"
settings.CursorType = 0
settings.CursorLocation = 2
settings.LockType = 1
settings.Open()

settings_numRows = 0
%>
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
set news_list = Server.CreateObject("ADODB.Recordset")
news_list.ActiveConnection = MM_newsmanager_STRING
news_list.Source = "SELECT tblNM_NewsCategory_1.CategoryValue AS ParentCategoryValue, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_News.*  FROM (tblNM_NewsCategory RIGHT JOIN tblNM_News ON tblNM_NewsCategory.CategoryID = tblNM_News.CategoryID) LEFT JOIN tblNM_NewsCategory AS tblNM_NewsCategory_1 ON tblNM_NewsCategory.ParentCategoryID = tblNM_NewsCategory_1.CategoryID  WHERE tblNM_NewsCategory.CategoryID Like '" + Replace(news_list__cid, "'", "''") + "'  AND tblNM_NewsCategory.ParentCategoryID Like '" + Replace(news_list__pcid, "'", "''") + "'  AND ( tblNM_News.ItemDesc Like '%" + Replace(news_list__search, "'", "''") + "%' OR tblNM_News.ItemName Like '%" + Replace(news_list__search, "'", "''") + "%' OR tblNM_NewsCategory.CategoryValue Like '%" + Replace(news_list__search, "'", "''") + "%'  OR tblNM_News.ItemDesc Like '%" + Replace(news_list__search, "'", "''") + "%' )  ORDER BY tblNM_News.ExpiryDate DESC, tblNM_NewsCategory_1.CategoryValue, tblNM_NewsCategory.CategoryValue"
news_list.CursorType = 0
news_list.CursorLocation = 2
news_list.LockType = 1
news_list.Open()
news_list_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = 20
Repeat1__index = 0
news_list_numRows = news_list_numRows + Repeat1__numRows
%>

<%
'  *** Recordset Stats, Move To Record, and Go To Record: declare stats variables

Dim news_list_total
Dim news_list_first
Dim news_list_last

' set the record count
news_list_total = news_list.RecordCount

' set the number of rows displayed on this page
If (news_list_numRows < 0) Then
  news_list_numRows = news_list_total
Elseif (news_list_numRows = 0) Then
  news_list_numRows = 1
End If

' set the first and last displayed record
news_list_first = 1
news_list_last  = news_list_first + news_list_numRows - 1

' if we have the correct record count, check the other stats
If (news_list_total <> -1) Then
  If (news_list_first > news_list_total) Then
    news_list_first = news_list_total
  End If
  If (news_list_last > news_list_total) Then
    news_list_last = news_list_total
  End If
  If (news_list_numRows > news_list_total) Then
    news_list_numRows = news_list_total
  End If
End If
%>

<%
' *** Recordset Stats: if we don't know the record count, manually count them

If (news_list_total = -1) Then

  ' count the total records by iterating through the recordset
  news_list_total=0
  While (Not news_list.EOF)
    news_list_total = news_list_total + 1
    news_list.MoveNext
  Wend

  ' reset the cursor to the beginning
  If (news_list.CursorType > 0) Then
    news_list.MoveFirst
  Else
    news_list.Requery
  End If

  ' set the number of rows displayed on this page
  If (news_list_numRows < 0 Or news_list_numRows > news_list_total) Then
    news_list_numRows = news_list_total
  End If

  ' set the first and last displayed record
  news_list_first = 1
  news_list_last = news_list_first + news_list_numRows - 1
  
  If (news_list_first > news_list_total) Then
    news_list_first = news_list_total
  End If
  If (news_list_last > news_list_total) Then
    news_list_last = news_list_total
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

Set MM_rs    = news_list
MM_rsCount   = news_list_total
MM_size      = news_list_numRows
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
news_list_first = MM_offset + 1
news_list_last  = MM_offset + MM_size

If (MM_rsCount <> -1) Then
  If (news_list_first > MM_rsCount) Then
    news_list_first = MM_rsCount
  End If
  If (news_list_last > MM_rsCount) Then
    news_list_last = MM_rsCount
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
<%
Dim news_listRepeat__numRows
news_listRepeat__numRows = -1
Dim news_listRepeat__index
news_listRepeat__index = 0
news_list_numRows = news_list_numRows + news_listRepeat__numRows
%>
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
<html>
<head>
<title>News Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
<!--


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<!-- STEP 1: include js files -->
	<script language="JavaScript" src="ACE_CoreFiles/include/yusasp_ace.js"></script>
	<script language="JavaScript" src="ACE_CoreFiles/include/yusasp_color.js"></script>
	<script>
<!--


//STEP 5: prepare submit FORM function
	function SubmitForm()
		{
		//STEP 6: Before getting the edited content, the display mode of the editor 
		//must not in HTML view.
		if(obj1.displayMode == "HTML")
			{
			alert("Please uncheck HTML view")
			return ;
			}
				
		//STEP 7: Here we move the edited content into a form field.
		insert.txtContent.value = obj1.getContentBody() 				
				
		//STEP 8: Form submit.
		//insert.submit()
		}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
<h3> <% IF Request.QueryString("action") = "insert" Then%><a href="?action=update"> EDIT <%=(settings.Fields.Item("ApplicationItem").Value)%> ITEM</a>&nbsp;|&nbsp; ADD <%=(settings.Fields.Item("ApplicationItem").Value)%> ITEM<%else%>EDIT <%=(settings.Fields.Item("ApplicationItem").Value)%>&nbsp;ITEM|&nbsp; <a href="?action=insert"> ADD <%=(settings.Fields.Item("ApplicationItem").Value)%> ITEM</a>
</h3><%end if%>
<% IF Request.QueryString("action") = "insert" Then%>
<br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
	  <form ACTION="<%=MM_editAction%>" METHOD="POST" name="insert" id="insert">
        <table width="100%" align="center" class="tableborder">
          <tr valign="middle">
            <td width="0" class="tableheader"><%=(settings.Fields.Item("ApplicationItem").Value)%> Item Category:</td> 
            <td colspan="2" class="tableheader"><p>
              <% If Not Category_list.EOF Or Not Category_list.BOF Then %>
              <select name="CategoryID" id="CategoryID">
                <%
While (NOT Category_list.EOF)
%>
                <option value="<%=(Category_list.Fields.Item("CategoryID").Value)%>"><%=(Category_list.Fields.Item("ParentCategoryValue").Value)%> - <%=(Category_list.Fields.Item("CategoryValue").Value)%></option>
                <%
  Category_list.MoveNext()
Wend
If (Category_list.CursorType > 0) Then
  Category_list.MoveFirst
Else
  Category_list.Requery
End If
%>
              </select>
              <% End If ' end Not Category_list.EOF Or NOT Category_list.BOF %>
| <a href="javascript:;" onClick="MM_openBrWindow('CategoryManager/admin.asp','Category','scrollbars=yes,width=600,height=400')">add/edit</a> <br>
            </p>
            </td>
            <td colspan="3" rowspan="4" class="tableheader">
			               <script>
			var obj1 = new ACEditor("obj1") 
			obj1.width = "100%" //editor width
			obj1.height = 300 //editor height
			obj1.useAsset = true
			obj1.useImage = true
			obj1.AssetPageURL = "ACE_CoreFiles/default_Asset.asp" //specify Asset library management page
			obj1.ImagePageURL = "ACE_CoreFiles/default_Image.asp" //specify Image library management page
			obj1.base = "" //where the users see the content (where we publish the content)
			obj1.baseEditor = "" //location of the editor
			obj1.StyleSelection = "styles.css"; //use style selection
			obj1.StyleSelectionPath_RelativeTo_EditorPath = "../"; //location of style selection css file (relative to the editor)
			obj1.PageStyle = "styles.css"; //apply external css to the document
			obj1.PageStylePath_RelativeTo_EditorPath = "../"; //location of the external css (relative to the editor)
			obj1.isFullHTML = false //edit full HTML (not just BODY)
			obj1.usePageProperties = false
			obj1.usePrint = false
			obj1.RUN() //show
		       </script>          
            </td>
          </tr>
          <tr valign="middle">
            <td width="0" class="tableheader"><%=(settings.Fields.Item("ApplicationItem").Value)%> Item Name:</td>
            <td colspan="2" class="tableheader"><input name="ItemName" type="text" id="ItemName" value="Enter Name" size="40"></td>
          </tr>
          <tr valign="middle">
            <td width="0" class="tableheader"><%=(settings.Fields.Item("ApplicationItem").Value)%> Item Description:</td>
            <td colspan="2" class="tableheader"><textarea name="ItemDesc" cols="21" rows="8" id="ItemDesc">Enter Description</textarea></td>
          </tr>
          <tr valign="middle">
            <td colspan="3" class="tableheader"><p align="center">
                <input name="save_button" type="submit" value="Save" onClick="SubmitForm()" >
                <input name="DateAdded" type="hidden" id="DateAdded" value="<%= DoDateTime(Date(), 2, 7177) %>">
				<input name="ExpiryDate" type="hidden" id="ExpiryDate" value="<%= DoDateTime(Date() + (settings.Fields.Item("ExpiryDays").Value), 2, 7177) %>">
                <input name="Activated" type="hidden" id="Activated" value="True">
                <input type="hidden" name="txtContent"  value="Enter Details" id="txtContent">
              </p></td>
          </tr>
        </table>

<input type="hidden" name="MM_insert" value="insert">
      </form>
    </td>
  </tr>
</table>
<%else%>
<form method="post" name="search" id="search" action="<%=Request.ServerVariables("URL")%>
<%If Request.QueryString("archive") <> "" Then %>?archive=<%=request.querystring("archive")%><%end if%>
<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>" >  
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
<tr class="tableheader">
<% If Not ParentCategory.EOF Or Not ParentCategory.BOF Then %>   
 <td height="24" width="0" valign="baseline">
     <div align="left">Search by <%=(settings.Fields.Item("ApplicationItem").Value)%> Category:
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
     </div></td>
<% End If ' end Not ParentCategory.EOF Or NOT ParentCategory.BOF %>
<% If Not Category.EOF Or Not Category.BOF Then %>
   <td height="24" width="0" valign="baseline">      <div align="left"> Search
       by <%=(settings.Fields.Item("ApplicationItem").Value)%> Sub Category:
       <select name="Category" onChange="MM_jumpMenu('parent',this,0)">
             <option value="?pcid=<%=request.querystring("pcid")%>&cid=%<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"<%If (Not isNull(Request.QueryString("cid"))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%> >Show
               All</option>
             <%
While (NOT Category.EOF)
%>
             <option value="?pcid=<%=request.querystring("pcid")%>&cid=<%=(Category.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>
<%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>" <%If (Not isNull(Request.QueryString("cid"))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
      </div></td>
<% End If ' end Not Category.EOF Or NOT Category.BOF %>   
   <td width="0" valign="baseline"><div align="right">Search by Keyword
         <input name="search" type="text" id="search">
         <input type="submit" value="Go" name="submit">
       </div>
     <div align="right">            </div>
   </td>
   </tr>
 </table>
</form>
<form action="update_list.asp" method="post" name="update" id="update">
<% If Not news_list.EOF Or Not news_list.BOF Then %>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td>
      <div align="right">
        <input name="Submit2" type="submit" id="Submit23" value="Save Changes">
      </div>
    </td>
  </tr>
</table>
<% End If ' end Not news_list.EOF Or NOT news_list.BOF %>
<table width="100%" height="32" border="0" cellpadding="2" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="0">&nbsp; </td>
      <td width="0">Item Name</td>
      <td width="0">Activated</td>
      <td width="0">Category 
    | <a href="javascript:;" onClick="MM_openBrWindow('CategoryManager/admin.asp','Category','scrollbars=yes,width=600,height=400')">add/edit</a></td>
      <td width="0"><div align="center">Date Added</div></td>
      <td width="0"><div align="right"></div></td>
      <td width="0">Archive Date</td>
      <td width="0"><div align="center">Edit</div></td>
      <td width="0"><div align="center">Delete</div></td>
      <td width="0"><div align="center">Preview</div></td>
    </tr>
    <% Dim iCount
  iCount = 0
%>
    <% 
While ((Repeat1__numRows <> 0) AND (NOT news_list.EOF)) 
%>
    <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
      <td width="0" height="13"> <strong>
        <%Response.Write(iCount + 1 + MM_offset)%>
    . </strong>
          <div align="center"></div>
      </td>
      <td width="0" height="13">
        <input name="<%= (iCount & ".ItemName") %>" type="text" value="<%=(news_list.Fields.Item("ItemName").Value)%>" size="50">
      </td>
            <td width="0" height="13"><div align="center">
              <input <%If (CStr((news_list.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="<%= (iCount & ".Activated") %>" value="True">
            </div></td>
            <td width="0" height="13"><input name="<%= (iCount & ".ItemID") %>" type="hidden" value="<%=(news_list.Fields.Item("ItemID").Value)%>">
          <select name="<%= (iCount & ".CategoryID") %>" id="<%= (iCount & ".CategoryID") %>">
            <%
While (NOT Category_list.EOF)
%>
            <option value="<%=(Category_list.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((news_list.Fields.Item("CategoryID").Value))) Then If (CStr(Category_list.Fields.Item("CategoryID").Value) = CStr((news_list.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category_list.Fields.Item("ParentCategoryValue").Value)%> - <%=(Category_list.Fields.Item("CategoryValue").Value)%></option>
            <%
  Category_list.MoveNext()
Wend
If (Category_list.CursorType > 0) Then
  Category_list.MoveFirst
Else
  Category_list.Requery
End If
%>
          </select>
      </td>
      <td width="0" height="13"><%= DoDateTime((news_list.Fields.Item("DateAdded").Value), 2, 7177) %></td>
      <td width="0" height="13">
	    <div align="right">
	      <% if (news_list.Fields.Item("ExpiryDate").Value) >= NOW() THEN %>
 Archive in 
 <% = datediff("D", DATE(), news_list.Fields.Item("ExpiryDate").Value) %> 
 days 
 <%else%>
 <font color="#FF0000">Archived 
 <% = datediff("D", (news_list.Fields.Item("ExpiryDate").Value), DATE()) %> 
 days ago 
 <%end if%>
  on:</font></div></td>
      <td width="0" height="13"><input name="<%= (iCount & ".ExpiryDate") %>" type="text" value="<%= DoDateTime((news_list.Fields.Item("ExpiryDate").Value), 2, 7177) %>" size="10"></td>

      <td width="0" height="13" align="center"> <a href="update.asp?ItemID=<%=(news_list.Fields.Item("ItemID").Value)%>"> Edit</a>
      </td>
      <td width="0" height="13" align="center"><a href="delete.asp?ItemID=<%=(news_list.Fields.Item("ItemID").Value)%>">Delete</a> </td>
      <td width="0" height="13">
        <div align="center"><a href="../../applications/NewsManager/inc_newsmanager.asp?pcid=<%=(news_list.Fields.Item("ParentCategoryID").Value)%>&cid=<%=(news_list.Fields.Item("CategoryID").Value)%>&rcid=<%=(news_list.Fields.Item("CategoryID").Value)%>&ItemID=<%=(news_list.Fields.Item("ItemID").Value)%>" target="_blank">Live
        Preview</a> </div>
      </td>
    </tr>
<% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  news_list.MoveNext()
  iCount = iCount + 1
Wend
%>
</table>

    
<% If Not news_list.EOF Or Not news_list.BOF Then %>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td>      <div align="right">
        <input name="Submit2" type="submit" id="Submit23" value="Save Changes">
        <input type="hidden" name="Count" value="<%= iCount - 1 %>">
      </div>
    </td>
  </tr>
</table>
<% End If ' end Not news_list.EOF Or NOT news_list.BOF %>
</form>
    <table border="0" width="40%" align="center">
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
      <tr>
        <td colspan="4" align="center">&nbsp; Records <strong><%=(news_list_first)%></strong> to <strong><%=(news_list_last)%></strong> of <strong><%=(news_list_total)%></strong> </td>
      </tr>
    </table>
<% If news_list.EOF And news_list.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end news_list.EOF And news_list.BOF %>
<%end if%>
</body>
</html>
<%
ParentCategory.Close()
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
Category_list.Close()
Set Category_list = Nothing
%>
<%
settings.Close()
Set settings = Nothing
%>
<%
news_list.Close()
Set news_list = Nothing
%>
