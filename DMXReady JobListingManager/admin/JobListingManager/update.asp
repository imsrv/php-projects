<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/joblistingmanager.asp" -->
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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "update" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_joblistingmanager_STRING
  MM_editTable = "tblItems"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "update.asp"
  MM_fieldsStr  = "Activated|value|DateAdded|value|CategoryID|value|ItemName|value|ItemDesc|value|SendToInstructions|value|SendToEmailAddress|value|txtContent|value"
  MM_columnsStr = "Activated|',none,''|DateAdded|',none,NULL|CategoryIDkey|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|SendToInstructions|',none,''|SendToEmailAddress|',none,''|ItemMemo|',none,''"

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
' *** Update Record: construct a sql update statement and execute it

If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then

  ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
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
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(MM_i) & " = " & MM_formVal
  Next
  MM_editQuery = MM_editQuery & " where " & MM_editColumn & " = " & MM_recordId

  If (Not MM_abortEdit) Then
    ' execute the update
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
Dim rsItems
Dim rsItems_numRows

Set rsItems = Server.CreateObject("ADODB.Recordset")
rsItems.ActiveConnection = MM_joblistingmanager_STRING
rsItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.*, tblItems.*  FROM (tblItems_Category RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  WHERE tblItems.ItemID LIKE '" + Replace(rsItems__value1, "'", "''") + "'  ORDER BY tblItems.ItemID Desc"
rsItems.CursorType = 0
rsItems.CursorLocation = 2
rsItems.LockType = 1
rsItems.Open()

rsItems_numRows = 0
%>
<%
set rsCategory_list = Server.CreateObject("ADODB.Recordset")
rsCategory_list.ActiveConnection = MM_joblistingmanager_STRING
rsCategory_list.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile  FROM tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  GROUP BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile HAVING tblItems_Category.ParentCategoryID <>0  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsCategory_list.CursorType = 0
rsCategory_list.CursorLocation = 2
rsCategory_list.LockType = 3
rsCategory_list.Open()
rsCategory_list_numRows = 0
%>
<html>
<head>
<title>Job Listing Manager</title>
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
		update.txtContent.value = obj1.getContentBody() 				
				
		//STEP 8: Form submit.
		update.submit()
		}
function LoadContent()
		{
		//STEP 6: Use putContent() method to put the hidden Textarea value into the editor.
		obj1.putContent(idTextarea.value) 
		}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body onload="LoadContent()">
<!--#include file="header.asp" --><br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
	  <form ACTION="<%=MM_editAction%>" METHOD="POST" name="update" id="update">
        <table width="100%" align="center" class="tableborder">
          <tr bgcolor="#CCCCCC">
            <td colspan="5" valign="middle"><div align="right">
              <input name="save_button" type="submit" value="Save" onClick="SubmitForm()" >
            </div></td>
          </tr>
          <tr>
            <td width="16%" height="21" valign="middle" class="tableheader">Activated: </td> 
            <td colspan="3" valign="middle"><p>              
              <input <%If (CStr((rsItems.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="Activated" value="True">
| <a href="/applications/JobListingManager/inc_joblistingmanager.asp?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%>" target="_blank">live preview</a> </p>
            </td>
            <td width="4%" rowspan="8" valign="top"><br>              <br>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="tableheader">Date Added:</td>
            <td colspan="3" valign="middle"><input name="DateAdded" type="text" value="<%=(rsItems.Fields.Item("DateAdded").Value)%>"></td>
          </tr>
          <tr>
            <td width="16%" valign="middle" class="tableheader">Department: </td>
            <td colspan="3" valign="middle"><select name="CategoryID" id="CategoryID">
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
              <a href="javascript:;" onClick="MM_openBrWindow('CategoryManager/admin.asp','Category','scrollbars=yes,width=600,height=400')">[add/edit] </a> </td>
          </tr>
          <tr>
            <td valign="middle" class="tableheader">Job Title: </td>
            <td colspan="3" valign="middle"><input name="ItemName" type="text" id="ItemName" value="<%=(rsItems.Fields.Item("ItemName").Value)%>" size="70"></td>
          </tr>
          <tr>
            <td width="16%" valign="middle" class="tableheader">Job Short Description:</td>
            <td colspan="3" valign="middle"><textarea name="ItemDesc" cols="70" rows="5" id="ItemDesc"><%=(rsItems.Fields.Item("ItemDesc").Value)%></textarea></td>
          </tr>
		            <tr>
            <td valign="middle" class="tableheader">Job Details:</td>
            <td colspan="4" valign="middle">  
			<script>
			var obj1 = new ACEditor("obj1") 
			obj1.width = "100%" //editor width
			obj1.height = 300 //editor height
			obj1.useSave = true
			obj1.onSave = SubmitForm;
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
			obj1.RUN() //show
		       </script></td>
          </tr>
          <tr>
            <td valign="middle" class="tableheader">Instructions for Applicants:</td>
            <td colspan="3" valign="middle">            <textarea name="SendToInstructions" cols="70" id="SendToInstructions"><%=(rsItems.Fields.Item("SendToInstructions").Value)%></textarea></td>
          </tr>
          <tr>
            <td valign="middle" class="tableheader">Applications should be emailed
            to: </td>
            <td colspan="3" valign="middle"><input name="SendToEmailAddress" type="text" id="SendToEmailAddress" value="<%=(rsItems.Fields.Item("SendToEmailAddress").Value)%>" size="70"></td>
          </tr>
          <tr bgcolor="#CCCCCC">
            <td colspan="5" valign="middle">
       		    <div align="right">
       		          <input name="save_button" type="submit" value="Save" onClick="SubmitForm()" >
<input type="hidden" name="txtContent"  value="" ID="txtContent">
                </div></td>
          </tr>
        </table>
        
        <input type="hidden" name="MM_update" value="update">
        <input type="hidden" name="MM_recordId" value="<%= rsItems.Fields.Item("ItemID").Value %>">
      </form>
    </td>
  </tr>
</table>
<TEXTAREA rows=7 cols=40 ID="idTextarea" NAME="idTextarea" style="display:none"><%=(rsItems.Fields.Item("ItemMemo").Value)%></TEXTAREA>
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
