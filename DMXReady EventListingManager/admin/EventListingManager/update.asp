<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/eventlistingmanager.asp" -->
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

If (CStr(Request("MM_update")) = "form1" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_eventlistingmanager_STRING
  MM_editTable = "tblEventListings"
  MM_editColumn = "ItemID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "CategoryID|value|ItemName|value|ItemDesc|value|ItemDescShort|value|EventLocation|value|LocationMap|value|EventStartDate|value|EventEndDate|value|EventStartTime|value|EventEndTime|value|EventPresenter|value|ItemPrice|value|UnitOfMeasure|value|ImageFileA|value|ImageFileB|value|Feature1|value|Feature2|value|Feature3|value|Feature4|value|Feature5|value|Activated|value"
  MM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|ItemDescShort|',none,''|EventLocation|',none,''|LocationMap|',none,''|EventStartDate|',none,NULL|EventEndDate|',none,NULL|EventStartTime|',none,NULL|EventEndTime|',none,NULL|EventPresenter|',none,''|ItemPrice|none,none,NULL|UnitOfMeasure|',none,''|ImageFileA|',none,''|ImageFileB|',none,''|Feature1|',none,''|Feature2|',none,''|Feature3|',none,''|Feature4|',none,''|Feature5|',none,''|Activated|',none,''"

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
Dim List_Events__value1
List_Events__value1 = "%"
If (Request.queryString("ItemID")  <> "") Then 
  List_Events__value1 = Request.queryString("ItemID") 
End If
%>
<%
set List_Events = Server.CreateObject("ADODB.Recordset")
List_Events.ActiveConnection = MM_eventlistingmanager_STRING
List_Events.Source = "SELECT *  FROM tblEventListings  WHERE ItemID LIKE '" + Replace(List_Events__value1, "'", "''") + "'  ORDER BY ItemID DESC"
List_Events.CursorType = 0
List_Events.CursorLocation = 2
List_Events.LockType = 3
List_Events.Open()
List_Events_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_eventlistingmanager_STRING
Category.Source = "SELECT *  FROM tblEventCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
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
</head>
<body>
<!--#include file="header.asp" -->
      <form ACTION="<%=MM_editAction%>" METHOD="POST" name="form1">
        <table width="100%" align="center" class="tableborder">
          <tr align="right" valign="top">
            <td colspan="2" class="tableheader">Update</td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Category:</td>
            <td align="left">
              <select name="CategoryID">
              <%
While (NOT Category.EOF)
%>
              <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((List_Events.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((List_Events.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
      category</a> <img src="questionmark.gif" alt="Select a category that best describes the Event i.e. Sporting Event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event name:</td>
            <td align="left">
              <input name="ItemName" type="text" id="ItemName" value="<%=(List_Events.Fields.Item("ItemName").Value)%>" size="50">
              <img src="questionmark.gif" alt="Enter the name of the event" width="15" height="15"> </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Description:</td>
            <td align="left">
              <textarea name="ItemDesc" cols="50" rows="5" id="ItemDesc"><%=(List_Events.Fields.Item("ItemDesc").Value)%></textarea>
              <img src="questionmark.gif" alt="Enter a description of the event" width="15" height="15"> </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Short Description:</td>
            <td align="left">
            <textarea name="ItemDescShort" cols="50" rows="5" id="ItemDescShort"><%=(List_Events.Fields.Item("ItemDescShort").Value)%></textarea>
            <img src="questionmark.gif" alt="Enter a short description of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Location:</td>
            <td align="left"><textarea name="EventLocation" cols="30" rows="5" id="EventLocation"><%=(List_Events.Fields.Item("EventLocation").Value)%></textarea>
            <img src="questionmark.gif" alt="Enter the location of the event including Address Details" width="15" height="15"></td>
          </tr>
		   <tr align="right" valign="top">
            <td class="tableheader">Link to Map:</td>
            <td align="left">            <input name="LocationMap" type="text" id="LocationMap" value="<%=(List_Events.Fields.Item("LocationMap").Value)%>" size="50">              
              <img src="questionmark.gif" alt="Enter the URL to yahoo Maps" width="15" height="15"> <a href="http://ca.maps.yahoo.com" target="_blank">Visit
             Yahoo Maps</a></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Date:</td>
            <td align="left"> Start Date 
            <input name="EventStartDate" type="text" id="EventStartDate" value="<%=(List_Events.Fields.Item("EventStartDate").Value)%>"> 
            End date
            <input name="EventEndDate" type="text" id="EventEndDate" value="<%=(List_Events.Fields.Item("EventEndDate").Value)%>">
            <img src="questionmark.gif" alt="Enter the start/end date of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Time:</td>
            <td align="left">Start Time 
              <input name="EventStartTime" type="text" id="EventStartTime" value="<%=(List_Events.Fields.Item("EventStartTime").Value)%>">
End Time
<input name="EventEndTime" type="text" id="EventEndTime" value="<%=(List_Events.Fields.Item("EventEndTime").Value)%>">
<img src="questionmark.gif" alt="Enter the start/end time of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Presented By:</td>
            <td align="left"><input name="EventPresenter" type="text" id="EventPresenter" value="<%=(List_Events.Fields.Item("EventPresenter").Value)%>">
            <img src="questionmark.gif" alt="Enter the presenter/sponsor of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Price:</td>
            <td align="left"><input name="ItemPrice" type="text" id="EventStartDate3" value="<%=(List_Events.Fields.Item("ItemPrice").Value)%>"> 
              /              
                <select name="UnitOfMeasure" id="UnitOfMeasure">
                <option value="Person" <%If (Not isNull((List_Events.Fields.Item("UnitOfMeasure").Value))) Then If ("Person" = CStr((List_Events.Fields.Item("UnitOfMeasure").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Person</option>
                <option value="Hour" <%If (Not isNull((List_Events.Fields.Item("UnitOfMeasure").Value))) Then If ("Hour" = CStr((List_Events.Fields.Item("UnitOfMeasure").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Hour</option>
                <option value="Day" <%If (Not isNull((List_Events.Fields.Item("UnitOfMeasure").Value))) Then If ("Day" = CStr((List_Events.Fields.Item("UnitOfMeasure").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Day</option>
              </select>
              <img src="questionmark.gif" alt="Enter a price associated with the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image A:</td>
            <td align="left"> 
              <% if List_Events.Fields.Item("ImageFileA").Value <> "" then %>
              <img src="../../applications/EventListingManager/images/<%=(List_Events.Fields.Item("ImageFileA").Value)%>" width="50">
              <% end if %> 
              | 
              <input name="ImageFileA" type="text" id="ImageFileA" value="<%=(List_Events.Fields.Item("ImageFileA").Value)%>"> 
              | <a href="javascript:;" onClick="MM_openBrWindow('upload_imageA.asp?ItemID=<%=(List_Events.Fields.Item("ItemID").Value)%>','Image','scrollbars=yes,width=300,height=150')">Update
Image</a> <img src="questionmark.gif" alt="Upload image associated with the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image B:</td>
            <td align="left">              <% if List_Events.Fields.Item("ImageFileB").Value <> "" then %>
                <img src="../../applications/EventListingManager/images/<%=(List_Events.Fields.Item("ImageFileB").Value)%>" width="50">
                <% end if %>
  |              
  <input name="ImageFileB" type="text" id="ImageFileB" value="<%=(List_Events.Fields.Item("ImageFileB").Value)%>">
  | <a href="javascript:;" onClick="MM_openBrWindow('upload_imageB.asp?ItemID=<%=(List_Events.Fields.Item("ItemID").Value)%>','Image','scrollbars=yes,width=300,height=150')">Update
  Image</a> <img src="questionmark.gif" alt="Upload image associated with the event" width="15" height="15"></td></tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 1: </td>
            <td align="left"><input name="Feature1" type="text" id="EventStartDate23" value="<%=(List_Events.Fields.Item("Feature1").Value)%>">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 2: </td>
            <td align="left"><input name="Feature2" type="text" id="EventStartDate24" value="<%=(List_Events.Fields.Item("Feature2").Value)%>">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 3: </td>
            <td align="left"><input name="Feature3" type="text" id="EventStartDate25" value="<%=(List_Events.Fields.Item("Feature3").Value)%>">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 4: </td>
            <td align="left"><input name="Feature4" type="text" id="Feature3" value="<%=(List_Events.Fields.Item("Feature4").Value)%>">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 5: </td>
            <td align="left"><input name="Feature5" type="text" id="Feature32" value="<%=(List_Events.Fields.Item("Feature5").Value)%>">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Activated:</td>
            <td align="left"><input name="Activated" type="checkbox" value="True" <%If (CStr((List_Events.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%>>
              <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15"> </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">&nbsp;</td>
            <td align="left"><input name="submit" type="submit" value="Publish to Event Listings page">
</td>
          </tr>
        </table>
        

        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="MM_recordId" value="<%= List_Events.Fields.Item("ItemID").Value %>">
      </form>
</body>
</html>
<%
List_Events.Close()
%>
<%
Category.Close()
%>



