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

If (CStr(Request("MM_insert")) = "ParentCategory") Then

  MM_editConnection = MM_paypalstoremanager_STRING
  MM_editTable = "tblItems_Category"
  MM_editRedirectUrl = "list.asp#step2"
  MM_fieldsStr  = "CategoryValue|value|ParentCategoryID|value"
  MM_columnsStr = "CategoryValue|',none,''|ParentCategoryID|none,none,NULL"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
  If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If

End If
%>
<%
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "Category") Then

  MM_editConnection = MM_paypalstoremanager_STRING
  MM_editTable = "tblItems_Category"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "ParentCategoryID|value|CategoryValue|value"
  MM_columnsStr = "ParentCategoryID|none,none,NULL|CategoryValue|',none,''"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
  If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If

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
set allcategories = Server.CreateObject("ADODB.Recordset")
allcategories.ActiveConnection = MM_paypalstoremanager_STRING
allcategories.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category.*  FROM tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  WHERE tblItems_Category.ParentCategoryID <>0  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
allcategories.CursorType = 0
allcategories.CursorLocation = 2
allcategories.LockType = 3
allcategories.Open()
allcategories_numRows = 0
%>
<%
set parentcategorymenu = Server.CreateObject("ADODB.Recordset")
parentcategorymenu.ActiveConnection = MM_paypalstoremanager_STRING
parentcategorymenu.Source = "SELECT tblItems_Category.*  FROM tblItems_Category  WHERE tblItems_Category.ParentCategoryID = 0  ORDER BY tblItems_Category.CategoryID DESC"
parentcategorymenu.CursorType = 0
parentcategorymenu.CursorLocation = 2
parentcategorymenu.LockType = 3
parentcategorymenu.Open()
parentcategorymenu_numRows = 0
%>
<%
Dim rsParentCategory
Dim rsParentCategory_numRows

Set rsParentCategory = Server.CreateObject("ADODB.Recordset")
rsParentCategory.ActiveConnection = MM_paypalstoremanager_STRING
rsParentCategory.Source = "SELECT *  FROM tblItems_Category  WHERE ParentCategoryID = 0  ORDER BY CategoryValue"
rsParentCategory.CursorType = 0
rsParentCategory.CursorLocation = 2
rsParentCategory.LockType = 1
rsParentCategory.Open()

rsParentCategory_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
allcategories_numRows = allcategories_numRows + Repeat1__numRows
%>
<%
Dim Repeat2__numRows
Dim Repeat2__index

Repeat2__numRows = -1
Repeat2__index = 0
rsParentCategory_numRows = rsParentCategory_numRows + Repeat2__numRows
%>
<%
' UltraDeviant - Row Number written by Owen Palmer (http://ultradeviant.co.uk)
Dim OP_RowNum
If MM_offset <> "" Then
	OP_RowNum = MM_offset + 1
Else
	OP_RowNum = 1
End If
%>
<html>
<head>
<title>Catalog Category Administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

function openPictureWindow_Fever(imageName,imageWidth,imageHeight,alt,posLeft,posTop) {
	newWindow = window.open("","newWindow","width="+imageWidth+",height="+imageHeight+",left="+posLeft+",top="+posTop);
	newWindow.document.open();
	newWindow.document.write('<html><title>'+alt+'</title><body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" onBlur="self.close()">'); 
	newWindow.document.write('<img src='+imageName+' width='+imageWidth+' height='+imageHeight+' alt='+alt+'>'); 
	newWindow.document.write('</body></html>');
	newWindow.document.close();
	newWindow.focus();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<!--#include file="header.asp" -->
<br>
<table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="tableborder"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
      <tr>
        <td><strong><font color="#FF0000" size="2">STEP 1</font></strong><font color="#FF0000" size="2">&nbsp; </font>-
          <font color="#FF0000"><strong>Create Category </strong></font>: Enter
          the name of the Category and press the create button.</td>
      </tr>
      <tr>
        <td><form ACTION="<%=MM_editAction%>" METHOD="POST" name="ParentCategory" id="ParentCategory">
              <strong>Create Category:</strong>              
              <input name="CategoryValue" type="text" id="CategoryValue" size="25">
          <input type="submit" value="Next" name="submit">
          <input type="hidden" name="MM_insert" value="ParentCategory">
          <input type="hidden" name="ParentCategoryID" value="0">
        </form></td>
      </tr>
    </table>
      <% 
While ((Repeat2__numRows <> 0) AND (NOT rsParentCategory.EOF)) 
%>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
          <td width="50%" height="28"><strong>&nbsp;
          <%Response.Write(RecordCounter)%>
          . </strong>      <%=(rsParentCategory.Fields.Item("CategoryValue").Value)%></td>
          <td width="5%"><div align="center"><a href="update_category.asp?cid=<%=(rsParentCategory.Fields.Item("CategoryID").Value)%>">Edit</a></div>
          </td>
          <td width="30%">              <% if rsParentCategory.Fields.Item("CategoryImageFile").Value <> "" then %>
                <a href="javascript:;"><img src="../../../applications/PayPalStoreManager/assets/images/<%=(rsParentCategory.Fields.Item("CategoryImageFile").Value)%>" width="25" border="0" onClick="openPictureWindow_Fever('../../../applications/PayPalStoreManager/assets/images/<%=(rsParentCategory.Fields.Item("CategoryImageFile").Value)%>','400','400','<%=(rsParentCategory.Fields.Item("CategoryValue").Value)%>',')',')')"></a>
                <% else%>
                <a href="javascript:;" onClick="MM_openBrWindow('update_image_category.asp?cid=<%=(rsParentCategory.Fields.Item("CategoryID").Value)%>','image','width=300,height=150')">Add
                Image</a>
                <% end if ' image check %>
          </td><td><a href="delete_category.asp?cid=<%=(rsParentCategory.Fields.Item("CategoryID").Value)%>">Delete</a> </td>
        </tr>
      </table>
      <% 
  Repeat2__index=Repeat2__index+1
  Repeat2__numRows=Repeat2__numRows-1
  rsParentCategory.MoveNext()
Wend
%>
</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr valign>
    <td height="81" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
      <tr>
        <td><strong><font color="#FF0000" size="2"><a name="step2"></a>STEP 2</font></strong><font color="#FF0000" size="2">&nbsp; </font>- <font color="#FF0000"><strong>Create
              SubCategory </strong></font>: Select the Category, enter the name
              of the Sub Category and press the create button. </td>
      </tr>
      <tr>
        <td>
          <form action="<%=MM_editAction%>" method="POST" name="Category" id="Category">
            <strong>Create Sub Category:</strong>
            <select name="ParentCategoryID" id="ParentCategoryID">
            <%
While (NOT parentcategorymenu.EOF)
%>
            <option value="<%=(parentcategorymenu.Fields.Item("CategoryID").Value)%>"><%=(parentcategorymenu.Fields.Item("CategoryValue").Value)%></option>
              <%
  parentcategorymenu.MoveNext()
Wend
If (parentcategorymenu.CursorType > 0) Then
  parentcategorymenu.MoveFirst
Else
  parentcategorymenu.Requery
End If
%>
            </select>
            <input name="CategoryValue" type="text" id="CategoryValue" size="25">
            <input name="submit" type="submit" id="submit" value="Create">
            <input type="hidden" name="MM_insert" value="Category">
          </form>
        </td>
      </tr>
    </table>
<% 
While ((Repeat1__numRows <> 0) AND (NOT allcategories.EOF)) 
%>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td width="50%"><strong>				  			  
                  <% TFM_nest = allcategories.Fields.Item("ParentCategoryValue").Value
If lastTFM_nest <> TFM_nest Then 
	lastTFM_nest = TFM_nest %>
&nbsp;&nbsp;&#8250;&nbsp;&nbsp;                  <%=(allcategories.Fields.Item("ParentCategoryValue").Value)%>
<%End If 'End Basic-UltraDev Simulated Nested Repeat %>
          </strong></td>
        </tr>
      </table>


	  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F8F8">
        <tr>
          <td width="50%" height="28"> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;&nbsp;&nbsp;&nbsp;<%=(allcategories.Fields.Item("CategoryValue").Value)%></td>
          <td width="5%"><div align="center"><a href="update_category.asp?cid=<%=(allcategories.Fields.Item("CategoryID").Value)%>">Edit</a></div></td>
          <td width="30%">            <% if allcategories.Fields.Item("CategoryImageFile").Value <> "" then %>
              <a href="javascript:;"><img src="../../../applications/PayPalStoreManager/assets/images/<%=(allcategories.Fields.Item("CategoryImageFile").Value)%>" width="25" border="0" onClick="openPictureWindow_Fever('../../../applications/PayPalStoreManager/assets/images/<%=(allcategories.Fields.Item("CategoryImageFile").Value)%>','400','400','<%=(allcategories.Fields.Item("CategoryValue").Value)%>',')',')')"></a>
             <% else%>
              <a href="javascript:;" onClick="MM_openBrWindow('update_image_category.asp?cid=<%=(allcategories.Fields.Item("CategoryID").Value)%>','image','width=300,height=150')">Add
              Image</a>
              <% end if ' image check %>
</td><td><a href="delete_category.asp?cid=<%=(allcategories.Fields.Item("CategoryID").Value)%>">Delete</a>
</td>
        </tr>
      </table>
      <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  allcategories.MoveNext()
Wend
%>
</td>
  </tr>
</table>
<div align="center"><br>
  <a href="closewindow_redirect.asp">Close Window
</a></div>
</body>
</html>
<%
allcategories.Close()
Set allcategories = Nothing
%>
<%
parentcategorymenu.Close()
%>
<%
rsParentCategory.Close()
Set rsParentCategory = Nothing
%>
