<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/newsmanager.asp"-->
<%
' *** Cancel A Session Variable
' *** MagicBeat Server Behavior - 2008 - by Jag S. Sidhu - www.magicbeat.com
If (Request.QueryString ("ItemID") <> "") Then
Session("ItemID") = ""
End If
%>
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
If (CStr(Request("MM_update")) = "fHtmlEditor" And CStr(Request("MM_recordId")) <> "") Then
  MM_editConnection = MM_newsmanager_STRING
  MM_editTable = "tblNM_News"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "Activated|value|DateAdded|value|ExpiryDate|value|AuthorName|value|AuthorEmail|value|CategoryID|value|ItemName|value|ItemDesc|value|ImageThumbFile1|value|DocumentFileLabel1|value|DocumentFile1|value|DocumentFileLabel2|value|DocumentFile2|value|DocumentFileLabel3|value|DocumentFile3|value|DocumentFileLabel4|value|DocumentFile4|value|DocumentFileLabel5|value|DocumentFile5|value|txtContent|value"
  MM_columnsStr = "Activated|',none,''|DateAdded|',none,NULL|ExpiryDate|',none,NULL|AuthorName|',none,''|AuthorEmail|',none,''|CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|ImageThumbFile1|',none,''|DocumentFileLabel1|',none,''|DocumentFile1|',none,''|DocumentFileLabel2|',none,''|DocumentFile2|',none,''|DocumentFileLabel3|',none,''|DocumentFile3|',none,''|DocumentFileLabel4|',none,''|DocumentFile4|',none,''|DocumentFileLabel5|',none,''|DocumentFile5|',none,''|ItemMemo|',none,''"
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
Dim list__MMColItemID
list__MMColItemID = "0"
If (Request.QueryString("ItemID") <> "") Then 
  list__MMColItemID = Request.QueryString("ItemID")
End If
%>
<%
Dim list__MMColItemID2
list__MMColItemID2 = "0"
If (Session("ItemID") <> "") Then 
  list__MMColItemID2 = Session("ItemID")
End If
%>
<%
set list = Server.CreateObject("ADODB.Recordset")
list.ActiveConnection = MM_newsmanager_STRING
list.Source = "SELECT tblNM_News.*, tblNM_NewsCategory.CategoryValue, tblNM_NewsCategory.ParentCategoryID, tblNM_NewsCategory.CategoryDesc, tblNM_NewsCategory.CategoryLabel, tblNM_NewsCategory.CategoryImageFile  FROM tblNM_News INNER JOIN tblNM_NewsCategory ON tblNM_News.CategoryID = tblNM_NewsCategory.CategoryID  WHERE ItemID = " + Replace(list__MMColItemID, "'", "''") + " OR ItemID = " + Replace(list__MMColItemID2, "'", "''") + ""
list.CursorType = 0
list.CursorLocation = 2
list.LockType = 3
list.Open()
list_numRows = 0
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
<title>Update</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
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
	//STEP 10: prepare submit FORM function
	function SubmitForm()
		{
		//STEP 11: Before getting the edited content, the display mode of the editor 
		//must not in HTML view.
		if(obj1.displayMode == "HTML")
			{
			alert("Please uncheck HTML view")
			return ;
			}

		//STEP 12: Here we move the edited content into the input form we've prepared before.
		fHtmlEditor.txtContent.value = obj1.getContentBody()
				
		//STEP 13: Form submit.
		fHtmlEditor.submit()
		}
	function LoadContent()
		{
		//STEP 6: Use putContent() method to put the hidden Textarea value into the editor.
		obj1.putContent(idTextarea.value) 
		}
	</script>
<body onload="LoadContent()" style="font:10pt verdana,arial,sans-serif">
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
      <form ACTION="<%=MM_editAction%>" METHOD="POST" name="fHtmlEditor">
        <table width="100%" align="center" class="tableborder">
          <tr> 
            <td colspan="4" nowrap class="tableheader"><div align="left">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><a href="../../applications/NewsManager/inc_newsmanager.asp?ItemID=<%=(list.Fields.Item("ItemID").Value)%>" target="_blank">Click
                    for Live Preview</a> </td>
                    <td><div align="right"><strong>Update</strong></div></td>
                  </tr>
                </table>
            </div>
            </td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Activated:</td>
            <td colspan="3" valign="baseline" class="tablebody"><input <%If (CStr(list.Fields.Item("Activated").Value) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="Activated" value=True >
              <img src="questionmark.gif" alt="(Check if you want this News Message to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15"></td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Date
            Details: </td>
            <td colspan="3" valign="baseline" class="tablebody"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="0">Date Added:
<input name="DateAdded" type="text" id="DateAdded" value="<%= DoDateTime((list.Fields.Item("DateAdded").Value), 2, 7177) %>" size="10">
                </td>
                <td width="0">Todays Date:<strong> <%= DoDateTime(DATE(), 2, 7177) %></strong></td>
                <td width="0">Expiry Date:
<input name="ExpiryDate" type="text" id="ExpiryDate" value="<%= DoDateTime((list.Fields.Item("ExpiryDate").Value), 2, 7177) %>" size="10"></td>
                <td width="0"><% if (list.Fields.Item("ExpiryDate").Value) >= NOW() THEN %>
                  <% daystoexpiry = datediff("D", DATE(), list.Fields.Item("ExpiryDate").Value) %>
  News Item will be moved to archive in <strong><font color="#FF0000"><%=daystoexpiry%> days</font></strong> from today on <strong><%=DoDateTime((list.Fields.Item("ExpiryDate").Value), 2, 7177)%></strong><%else%>
  <strong>  <font color="#FF0000">Archived 
  <% = datediff("D", (list.Fields.Item("ExpiryDate").Value), DATE()) %> 
 days ago </font></strong>  <%end if%>
  </td></tr>
            </table></td>
          </tr>
          <tr>
            <td align="right" valign="baseline" nowrap class="tableheader">Author
              Details:</td>
            <td colspan="3" valign="baseline" class="tablebody"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="0">Author Name: 
                  <input name="AuthorName" type="text" id="AuthorName" value="<%=(list.Fields.Item("AuthorName").Value)%>"></td>
                <td width="0">&nbsp;</td>
                <td width="0">Author Email: 
                  <input name="AuthorEmail" type="text" id="AuthorEmail" value="<%=(list.Fields.Item("AuthorEmail").Value)%>">
                </td>
                </tr>
            </table></td>
          </tr>
          <tr> 
            <td width="11%" align="right" valign="baseline" nowrap class="tableheader">Category:</td>
            <td colspan="3" valign="baseline" class="tablebody"> 
          <select name="CategoryID" id="CategoryID">
            <%
While (NOT Category_list.EOF)
%>
            <option value="<%=(Category_list.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((list.Fields.Item("CategoryID").Value))) Then If (CStr(Category_list.Fields.Item("CategoryID").Value) = CStr((list.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category_list.Fields.Item("ParentCategoryValue").Value)%> - <%=(Category_list.Fields.Item("CategoryValue").Value)%></option>
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
              | <a href="javascript:;" onClick="MM_openBrWindow('CategoryManager/admin.asp','Category','scrollbars=yes,width=500,height=400')">add/edit category</a> <img src="questionmark.gif" alt="Select a category that best describes the News Message" width="15" height="15"></td>
          </tr>
          <tr> 
            <td width="11%" align="right" valign="baseline" nowrap class="tableheader"> Name:</td>
            <td colspan="3" class="tablebody"> 
              <input name="ItemName" type="text" value="<%=(list.Fields.Item("ItemName").Value)%>" size="60">
            <img src="questionmark.gif" alt="Enter Name that best describes the News Message" width="15" height="15">            </td>
          </tr>
          <tr> 
            <td nowrap align="right" class="tableheader" valign="middle" width="11%">Desc:</td>
            <td colspan="3" valign="middle" class="tablebody"> 
              <textarea name="ItemDesc" cols="50" rows="2"><%=(list.Fields.Item("ItemDesc").Value)%></textarea>
              <img src="questionmark.gif" alt="Enter description of the News Message" width="15" height="15"> | This text is displayed in the news summary window</td>
          </tr>
		 <tr>
            <td nowrap align="right" class="tableheader" valign="top">            Thumbnail
                Image: </td>
            <td colspan="3" valign="top" class="tablebody"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
			 <% IF Request.QueryString("show") = "images" OR list.Fields.Item("ImageThumbFile1").Value <> "" THEN %>
              <tr>
                <td width="71%" height="36" valign="top"><%If instr(list.Fields.Item("ImageThumbFile1").Value,"http") Then %>
Using External Link:
  <%else%>
Using Uploaded File:
<%end if%>
<input name="ImageThumbFile1" type="text" id="ImageThumbFile1" value="<%=(list.Fields.Item("ImageThumbFile1").Value)%>" size="30">
<br> 
To Edit, enter URL address to external image:http://www.website.com/images/image.gif
OR <a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=1&amp;filetype=Image&amp;fileattribute=Thumb&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','Image','width=300,height=150')">Upload
Image to Server</a></td>
                <td width="29%"><% if instr(list.Fields.Item("ImageThumbFile1").Value,"http") Then %>
                  <img src="<%=(list.Fields.Item("ImageThumbFile1").Value)%>" width="50" height="50">
                  <%else%>
                  <img src="../../applications/assets/images/<%=(list.Fields.Item("ImageThumbFile1").Value)%>" width="50" height="50">
                  <% end if %>
</td>
              </tr>
			  <%else%>
              <tr>
                <td height="20" colspan="2">Add
                    Thumbnail Image to News Headline using:<a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=1&amp;filetype=Image&amp;fileattribute=Thumb&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','Image','width=300,height=150')"> Image
                    Uploaded to Server </a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=1&filetype=Image&fileattribute=Thumb&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Image Source</a></td>
                </tr>
				<%end if%>
            </table></td>
          </tr>
          <tr>
            <td nowrap align="right" valign="top" class="tableheader">            Related
              Document: </td>
            <td colspan="3" valign="top" class="tablebody">
			  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
			<% IF Request.QueryString("show") = "file1" OR list.Fields.Item("DocumentFile1").Value <> "" THEN %>
              <tr valign="top">
                <td height="25">                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="row1">
                  <tr valign="middle">
                    <td width="135" rowspan="3"><strong>Related Document  1:</strong></td>
                    <td width="141"> Label/Description of File:                      </td>
                    <td width="619"><input name="DocumentFileLabel1" type="text" id="DocumentFileLabel1" value="<%=(list.Fields.Item("DocumentFileLabel1").Value)%>" size="60"></td>
                  </tr>
                  <tr valign="middle">
                    <td>
					<%If instr(list.Fields.Item("DocumentFile1").Value,"http") Then %>					
					Using External Link: 
					<%else%>
					Using Uploaded File:
					<%end if%></td>
                    <td>
                      <input name="DocumentFile1" type="text" id="DocumentFile1" value="<%=(list.Fields.Item("DocumentFile1").Value)%>" size="60">
					  <%If instr(list.Fields.Item("DocumentFile1").Value,"http") Then %>
					  [ <a href="<%=(list.Fields.Item("DocumentFile1").Value)%>" target="_blank">Test
                      Link</a>
]                      
<%else%> 
[
<a href="../../applications/assets/documents/<%=(list.Fields.Item("DocumentFile1").Value)%>" target="_blank">Test
Link</a>
                      ]
                      <%end if%></td>
                  </tr>
                  <tr valign="middle">
                    <td colspan="2"><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Upload
                        File to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                        to  Web Page or </a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">External</a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')"> File</a></td>
                  </tr>
                </table>                  
                </td>
                </tr>
				<%else%>
              <tr>
                <td height="20"><strong>Add Related Document 1 using:</strong><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">                    File
                    Uploaded to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=1&amp;filetype=document&amp;ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Web Page or File</a></td>
                </tr>			  <%end if%>
			  <% IF Request.QueryString("show") = "file2" OR list.Fields.Item("DocumentFile2").Value <> "" THEN %>
              <tr>
                <td height="25" nowrap><table width="100%" border="0" cellpadding="2" cellspacing="0" class="row1">
                  <tr valign="middle">
                    <td width="135" rowspan="3"><strong>Related Document 2:</strong></td>
                    <td width="141"> Label/Description of File: </td>
                    <td width="619"><input name="DocumentFileLabel2" type="text" id="DocumentFileLabel2" value="<%=(list.Fields.Item("DocumentFileLabel2").Value)%>" size="60">
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td>
                      <%If instr(list.Fields.Item("DocumentFile2").Value,"http") Then %>
      Using External Link:
      <%else%>
      Using Uploaded File:
      <%end if%>
                    </td>
                    <td>
                      <input name="DocumentFile2" type="text" id="DocumentFile2" value="<%=(list.Fields.Item("DocumentFile2").Value)%>" size="60">
                      <%If instr(list.Fields.Item("DocumentFile2").Value,"http") Then %>
      [ <a href="<%=(list.Fields.Item("DocumentFile2").Value)%>" target="_blank">Test
      Link</a> ]
                            <%else%>
      [ <a href="../../applications/assets/documents/<%=(list.Fields.Item("DocumentFile2").Value)%>" target="_blank">Test
      Link</a> ]
      <%end if%>
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td colspan="2"><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Upload
                        File to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                        to Web Page or </a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">External</a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')"> File</a></td>
                  </tr>
                </table></td>
                </tr>
				<%else%>
              <tr>
                <td height="20"><strong>Add Related Document 2 using:</strong> <a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">                    File
                    Uploaded to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=2&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Web Page or File</a></td>
                </tr>			  <%end if%>
			  <% IF Request.QueryString("show") = "file3" OR list.Fields.Item("DocumentFile3").Value <> "" THEN %>
 <tr>
                <td height="25" nowrap><table width="100%" border="0" cellpadding="2" cellspacing="0" class="row1">
                  <tr valign="middle">
                    <td width="135" rowspan="3"><strong>Related Document 3:</strong></td>
                    <td width="141"> Label/Description of File: </td>
                    <td width="619"><input name="DocumentFileLabel3" type="text" id="DocumentFileLabel3" value="<%=(list.Fields.Item("DocumentFileLabel3").Value)%>" size="60">
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td>
                      <%If instr(list.Fields.Item("DocumentFile3").Value,"http") Then %>
      Using External Link:
      <%else%>
      Using Uploaded File:
      <%end if%>
                    </td>
                    <td>
                      <input name="DocumentFile3" type="text" id="DocumentFile3" value="<%=(list.Fields.Item("DocumentFile3").Value)%>" size="60">
                      <%If instr(list.Fields.Item("DocumentFile3").Value,"http") Then %>
      [ <a href="<%=(list.Fields.Item("DocumentFile3").Value)%>" target="_blank">Test
      Link</a> ]
            <%else%>
      [ <a href="../../applications/assets/documents/<%=(list.Fields.Item("DocumentFile3").Value)%>" target="_blank">Test
      Link</a> ]
            <%end if%>
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td colspan="2"><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Upload
                        File to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                        to Web Page or </a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">External</a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')"> File</a></td>
                  </tr>
                </table></td>
                </tr>
				<%else%>
              <tr>
                <td height="25"><strong>Add Related Document 3 using:</strong> <a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">                    File
                    Uploaded  to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=3&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Web Page or File</a></td>
                </tr>			  <%end if%>
			  <% IF Request.QueryString("show") = "file4" OR list.Fields.Item("DocumentFile4").Value <> "" THEN %>
              <tr>
                <td height="25" nowrap><table width="100%" border="0" cellpadding="2" cellspacing="0" class="row1">
                  <tr valign="middle">
                    <td width="135" rowspan="3"><strong>Related Document 4:</strong></td>
                    <td width="141"> Label/Description of File: </td>
                    <td width="619"><input name="DocumentFileLabel4" type="text" id="DocumentFileLabel4" value="<%=(list.Fields.Item("DocumentFileLabel4").Value)%>" size="60">
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td>
                      <%If instr(list.Fields.Item("DocumentFile4").Value,"http") Then %>
      Using External Link:
      <%else%>
      Using Uploaded File:
      <%end if%>
                    </td>
                    <td>
                      <input name="DocumentFile4" type="text" id="DocumentFile4" value="<%=(list.Fields.Item("DocumentFile4").Value)%>" size="60">
                      <%If instr(list.Fields.Item("DocumentFile4").Value,"http") Then %>
      [ <a href="<%=(list.Fields.Item("DocumentFile4").Value)%>" target="_blank">Test
      Link</a> ]
            <%else%>
      [ <a href="../../applications/assets/documents/<%=(list.Fields.Item("DocumentFile4").Value)%>" target="_blank">Test
      Link</a> ]
            <%end if%>
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td colspan="2"><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Upload
                        File to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                        to Web Page or </a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">External</a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')"> File</a></td>
                  </tr>
                </table></td>
                </tr>
				<% else%>
              <tr>
                <td height="20"><strong>Add Related Document 4 using:</strong> <a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">                    File
                    Uploaded to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=4&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Web Page or File</a></td>
                </tr>			  <% end if%>
			  <% IF Request.QueryString("show") = "file5" OR list.Fields.Item("DocumentFile5").Value <> "" THEN %>
              <tr>
                <td height="25" nowrap><table width="100%" border="0" cellpadding="2" cellspacing="0" class="row1">
                  <tr valign="middle">
                    <td width="135" rowspan="3"><strong>Related Document 5:</strong></td>
                    <td width="141"> Label/Description of File: </td>
                    <td width="619"><input name="DocumentFileLabel5" type="text" id="DocumentFileLabel5" value="<%=(list.Fields.Item("DocumentFileLabel5").Value)%>" size="60">
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td>
                      <%If instr(list.Fields.Item("DocumentFile5").Value,"http") Then %>
      Using External Link:
      <%else%>
      Using Uploaded File:
      <%end if%>
                    </td>
                    <td>
                      <input name="DocumentFile5" type="text" id="DocumentFile5" value="<%=(list.Fields.Item("DocumentFile5").Value)%>" size="60">
                      <%If instr(list.Fields.Item("DocumentFile5").Value,"http") Then %>
      [ <a href="<%=(list.Fields.Item("DocumentFile5").Value)%>" target="_blank">Test
      Link</a> ]
            <%else%>
      [ <a href="../../applications/assets/documents/<%=(list.Fields.Item("DocumentFile5").Value)%>" target="_blank">Test
      Link</a> ]
            <%end if%>
                    </td>
                  </tr>
                  <tr valign="middle">
                    <td colspan="2"><a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Upload
                        File to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                        to Web Page or </a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">External</a><a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')"> File</a></td>
                  </tr>
                </table></td>
                </tr>
				<%else%>
              <tr>
                <td height="25"><strong>Add Related Document 5 using:</strong> <a href="javascript:;" onClick="MM_openBrWindow('file_upload.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">                    File
                    Uploaded to Server</a>&nbsp; OR &nbsp;<a href="javascript:;" onClick="MM_openBrWindow('file_link.asp?filenum=5&filetype=document&ItemID=<%=(list.Fields.Item("ItemID").Value)%>','File','width=300,height=150')">Link
                    to External Web Page or File</a></td>
                </tr>			  <%end if%>
            </table></td>
          </tr>
		   <tr>
		     <td height="14" align="right" valign="top" nowrap class="tableheader">	       Details:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </td>
	         <td colspan="3" class="tablebody"><input type="button" value="Save Record" onClick="SubmitForm()" id="Button12" name="Button12">
               <script>
			var obj1 = new ACEditor("obj1") 
			obj1.width = "100%" //editor width
			obj1.height = 500 //editor height
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
		       </script>
</td>
	      </tr>
         <tr> 
            <td width="11%" align="right" valign="baseline" nowrap class="tableheader">&nbsp;</td>
            <td colspan="3" valign="baseline" class="tablebody"> 
<INPUT type="button" value="Save Record" onclick="SubmitForm()" ID="Button1" NAME="Button1">

            </td>
          </tr>
        </table>        
		<input type="hidden" name="txtContent"  value="" ID="txtContent">
        <input type="hidden" name="MM_update" value="fHtmlEditor">
<input type="hidden" name="MM_recordId" value="<%= list.Fields.Item("ItemID").Value %>">
      </form>
	  <TEXTAREA rows=7 cols=40 ID="idTextarea" NAME="idTextarea" style="display:none"><%=(list.Fields.Item("ItemMemo").Value)%></TEXTAREA>

      <p>&nbsp;</p>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body></html>
<%
list.Close()
%>
<%
Category_list.Close()
Set Category_list = Nothing
%>
