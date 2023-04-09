<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/contactusmanager.asp" -->
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

If (CStr(Request("MM_update")) = "contact_details" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_contactusmanager_STRING
  MM_editTable = "tblContactUs"
  MM_editColumn = "ContactID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Activated|value|Salutation|value|FirstName|value|LastName|value|CategoryID|value|EmailAddress|value|Profile|value|ImageFile|value|OrgName1|value|OrgName12|value|JobTitle|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|State|value|Country|value|Map|value|MessageSubjectAdmin|value|MessageBCAdmin|value|MessageCCAdmin|value|MessageHeaderAdmin|value|MessageFooterAdmin|value|MessageSubjectVisitor|value|MessageBodyVisitor|value|MessageHeaderVisitor|value|MessageFooterVisitorLine1|value|MessageFooterVisitorLine2|value|MessageFooterVisitorLine3|value"
  MM_columnsStr = "Activated|',none,''|Salutation|',none,''|FirstName|',none,''|LastName|',none,''|CategoryID|none,none,NULL|EmailAddress|',none,''|Profile|',none,''|ImageFile|',none,''|OrgName1|',none,''|OrgName2|',none,''|JobTitle|',none,''|WebsiteURL|',none,''|Address1|',none,''|Phone|',none,''|Address2|',none,''|CellPhone|',none,''|City|',none,''|Fax|',none,''|PostalCode|',none,''|State|',none,''|Country|',none,''|Map|',none,''|MessageSubjectAdmin|',none,''|MessageBCAdmin|',none,''|MessageCCAdmin|',none,''|MessageHeaderAdmin|',none,''|MessageFooterAdmin|',none,''|MessageSubjectVisitor|',none,''|MessageBodyVisitor|',none,''|MessageHeaderVisitor|',none,''|MessageFooterVisitorLine1|',none,''|MessageFooterVisitorLine2|',none,''|MessageFooterVisitorLine3|',none,''"

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
Dim contact_details__value1
contact_details__value1 = "0"
If (Request.QueryString("ContactID") <> "") Then 
  contact_details__value1 = Request.QueryString("ContactID")
End If
%>
<%
set contact_details = Server.CreateObject("ADODB.Recordset")
contact_details.ActiveConnection = MM_contactusmanager_STRING
contact_details.Source = "SELECT *  FROM tblContactUs  WHERE ContactID = " + Replace(contact_details__value1, "'", "''") + ""
contact_details.CursorType = 0
contact_details.CursorLocation = 2
contact_details.LockType = 3
contact_details.Open()
contact_details_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_contactusmanager_STRING
Category.Source = "SELECT *  FROM tblContactUsCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Lookup_State
Dim Lookup_State_numRows

Set Lookup_State = Server.CreateObject("ADODB.Recordset")
Lookup_State.ActiveConnection = MM_contactusmanager_STRING
Lookup_State.Source = "SELECT *  FROM LookupState"
Lookup_State.CursorType = 0
Lookup_State.CursorLocation = 2
Lookup_State.LockType = 1
Lookup_State.Open()

Lookup_State_numRows = 0
%>
<%
Dim Lookup_Country
Dim Lookup_Country_numRows

Set Lookup_Country = Server.CreateObject("ADODB.Recordset")
Lookup_Country.ActiveConnection = MM_contactusmanager_STRING
Lookup_Country.Source = "SELECT *  FROM LookupCountry"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
%>
<html>
<head>
<title>Contact Us Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
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
<body>
<!--#include file="header.asp" -->
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="contact_details" id="contact_details">
  <table width="100%" height="272" align="center" cellpadding="5" cellspacing="0" class="tableborder">
    <tr>
      <td width="49%" height="270" valign="top">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="3">Contact Details:</td>
            <td>Activated
            <input <%If (CStr((contact_details.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True"></td>
          </tr>
          <tr class="row2">
            <td width="15%">First Name:</td>
            <td width="39%"><select name="Salutation" id="select6">
              <option value="Mr." <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Mr." = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Mr.
              <option value="Mrs." <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Mrs." = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Mrs.
              <option value="Miss" <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Miss" = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Miss
              <option value="Dr." <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Dr." = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Dr.
              <option value="Fr." <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Fr." = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Fr.</option>
              <option value="Sr." <%If (Not isNull((contact_details.Fields.Item("Salutation").Value))) Then If ("Sr." = CStr((contact_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Sr.</option>
            </select>
              <input name="FirstName" type="text" id="FirstName3" value="<%=(contact_details.Fields.Item("FirstName").Value)%>" size="15"></td>
            <td width="19%">Last Name:</td>
            <td width="27%"><input name="LastName" type="text" id="LastName2" value="<%=(contact_details.Fields.Item("LastName").Value)%>"></td>
          </tr>
          <tr class="row2">
            <td>Department: </td>
            <td><select name="CategoryID">
              <%
While (NOT Category.EOF)
%>
              <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((contact_details.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((contact_details.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
        | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Edit
        Dept</a></td>
            <td>Email Address:</td>
            <td><input name="EmailAddress" type="text" id="EmailAddress3" value="<%=(contact_details.Fields.Item("EmailAddress").Value)%>"></td>
          </tr>
        </table>
        <br>        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr>
            <td colspan="2" class="tableheader">Personal Details:</td>
          </tr>
          <tr class="row2">
            <td width="16%">Profile/Bio:</td>
            <td width="84%"><textarea name="Profile" cols="40" rows="6" id="Profile"><%=(contact_details.Fields.Item("Profile").Value)%></textarea>
            </td>
          </tr>
          <tr class="row2">
            <td height="47">Photo:</td>
            <td>              <% if contact_details.Fields.Item("ImageFile").Value <> "" then %>
                    <a href="javascript:;"><img src="../../applications/ContactUsManager/images/<%=(contact_details.Fields.Item("ImageFile").Value)%>" alt="Click to Zoom" border="0" onClick="openPictureWindow_Fever('../../applications/ContactUsManager/images/<%=(contact_details.Fields.Item("ImageFile").Value)%>','400','400','<%=(contact_details.Fields.Item("ImageFile").Value)%>','','')"></a>
                    |
                    <input name="ImageFile" type="text" id="ImageFile" value="<%=(contact_details.Fields.Item("ImageFile").Value)%>">
                    <% end if%>
    | 
                    <a href="javascript:;" onClick="MM_openBrWindow('upload_image.asp?ContactID=<%=(contact_details.Fields.Item("ContactID").Value)%>','Image','scrollbars=yes,width=300,height=150')">ADD
                    New 
              Picture</a> </td></tr>
        </table>        
        <br>                <br>        
        <input name="submit" type="submit" value="Update Record">
        <br>
      </td>
      <td width="49%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="tableheader">
          <td colspan="4">Company Details:</td>
        </tr>
        <tr class="row2">
          <td width="22%">Company Name:</td>
          <td width="26%"><input name="OrgName1" type="text" id="OrgName1" value="<%=(contact_details.Fields.Item("OrgName1").Value)%>">
          </td>
          <td width="15%">Division:</td>
          <td width="37%"><input name="OrgName12" type="text" id="OrgName13" value="<%=(contact_details.Fields.Item("OrgName2").Value)%>"></td>
        </tr>
        <tr class="row2">
          <td>Job Title:</td>
          <td><input name="JobTitle" type="text" id="JobTitle" value="<%=(contact_details.Fields.Item("JobTitle").Value)%>">
          </td>
          <td>Web Site:</td>
          <td>http://
            <input name="WebsiteURL" type="text" id="WebsiteURL" value="<%=(contact_details.Fields.Item("WebsiteURL").Value)%>">
          </td>
        </tr>
      </table>                
        <br>        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details:</td>
          </tr>
          <tr class="row2">
            <td width="21%">Address 1: </td>
            <td width="32%"><input name="Address1" type="text" id="Address12" value="<%=(contact_details.Fields.Item("Address1").Value)%>">
            </td>
            <td width="16%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone2" value="<%=(contact_details.Fields.Item("Phone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address22" value="<%=(contact_details.Fields.Item("Address2").Value)%>" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone2" value="<%=(contact_details.Fields.Item("CellPhone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>City:</td>
            <td><input name="City" type="text" id="City2" value="<%=(contact_details.Fields.Item("City").Value)%>">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax2" value="<%=(contact_details.Fields.Item("Fax").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode2" value="<%=(contact_details.Fields.Item("PostalCode").Value)%>">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="row2">
            <td>Province/State:</td>
            <td><select name="State" id="select">
                <%
While (NOT Lookup_State.EOF)
%>
                <option value="<%=(Lookup_State.Fields.Item("StateName").Value)%>" <%If (Not isNull((contact_details.Fields.Item("State").Value))) Then If (CStr(Lookup_State.Fields.Item("StateName").Value) = CStr((contact_details.Fields.Item("State").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_State.Fields.Item("StateName").Value)%></option>
                <%
  Lookup_State.MoveNext()
Wend
If (Lookup_State.CursorType > 0) Then
  Lookup_State.MoveFirst
Else
  Lookup_State.Requery
End If
%>
              </select>
            </td>
            <td>Country:</td>
            <td><select name="Country" id="select7">
              <%
While (NOT Lookup_Country.EOF)
%>
              <option value="<%=(Lookup_Country.Fields.Item("CountryName").Value)%>" <%If (Not isNull((contact_details.Fields.Item("Country").Value))) Then If (CStr(Lookup_Country.Fields.Item("CountryName").Value) = CStr((contact_details.Fields.Item("Country").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_Country.Fields.Item("CountryName").Value)%></option>
              <%
  Lookup_Country.MoveNext()
Wend
If (Lookup_Country.CursorType > 0) Then
  Lookup_Country.MoveFirst
Else
  Lookup_Country.Requery
End If
%>
            </select>
</td>
          </tr>
          <tr class="row2">
            <td height="25">Map:</td>
            <td colspan="3"><input name="Map" type="text" id="Map3" value="<%=(contact_details.Fields.Item("Map").Value)%>" size="30"> 
              |  <a href="http://ca.maps.yahoo.com" target="_blank">Visit
              Yahoo Maps</a></td>
          </tr>
        </table>
      <br></td>
    </tr>
  </table>
  

  <br>
  <table width="100%" align="center" class="tableborder">
    <tr class="tableheader">
      <td colspan="3" valign="top">This section allows you
        to configure the confirmation email that is automatically sent to the
        Contact and Visitor</td>
    </tr>
    <tr class="row2">
      <td width="32%" height="22" align="right" valign="top">Configure
          Email message Preferences for </td>
      <td width="68%" colspan="2">          <strong><%=(contact_details.Fields.Item("FirstName").Value)%>&nbsp;<%=(contact_details.Fields.Item("LastName").Value)%> | <%=(contact_details.Fields.Item("EmailAddress").Value)%></strong> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Subject Line
        of Confirmation Email sent to <%=(contact_details.Fields.Item("FirstName").Value)%><strong>&nbsp;</strong><%=(contact_details.Fields.Item("LastName").Value)%>:</td>
      <td colspan="2" valign="top">
        <textarea name="MessageSubjectAdmin" cols="60" rows="2"><%=(contact_details.Fields.Item("MessageSubjectAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of confirmation email sent to Contact" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="22" align="right" valign="top">Set the
        BCC of Confirmation Email sent to <%=(contact_details.Fields.Item("FirstName").Value)%><strong>&nbsp;</strong><%=(contact_details.Fields.Item("LastName").Value)%>:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageBCAdmin" value="<%=(contact_details.Fields.Item("MessageBCAdmin").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter an additional email address you wish to BCC" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the CC of Confirmation
        Email sent to <%=(contact_details.Fields.Item("FirstName").Value)%><strong>&nbsp;</strong><%=(contact_details.Fields.Item("LastName").Value)%>:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageCCAdmin" value="<%=(contact_details.Fields.Item("MessageCCAdmin").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter an additional email address you wish CC" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="56" align="right" valign="top">Set the
        Message Header of Confirmation Email sent to <%=(contact_details.Fields.Item("FirstName").Value)%><strong>&nbsp;</strong><%=(contact_details.Fields.Item("LastName").Value)%></td>
      <td colspan="2" valign="top">
        <textarea name="MessageHeaderAdmin" cols="60" rows="3"><%=(contact_details.Fields.Item("MessageHeaderAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        of Confirmation Email sent to <%=(contact_details.Fields.Item("FirstName").Value)%><strong>&nbsp;</strong><%=(contact_details.Fields.Item("LastName").Value)%>:</td>
      <td colspan="2" valign="top">
        <textarea name="MessageFooterAdmin" cols="60" rows="3" id="MessageFooterAdmin"><%=(contact_details.Fields.Item("MessageFooterAdmin").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the footer text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="24" align="right" valign="top">Set the
        Subject Line of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <input name="MessageSubjectVisitor" type="text" value="<%=(contact_details.Fields.Item("MessageSubjectVisitor").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Body
        of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <textarea name="MessageBodyVisitor" cols="60" rows="5"><%=(contact_details.Fields.Item("MessageBodyVisitor").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the text you wish displayed in the body of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Header
        of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <textarea name="MessageHeaderVisitor" cols="60" rows="3"><%=(contact_details.Fields.Item("MessageHeaderVisitor").Value)%></textarea>
      <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line1 of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine1" value="<%=(contact_details.Fields.Item("MessageFooterVisitorLine1").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 1st line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line2 of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine2" value="<%=(contact_details.Fields.Item("MessageFooterVisitorLine2").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 2nd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top">Set the Message Footer
        Line3 of Confirmation Email sent to Visitor:</td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageFooterVisitorLine3" value="<%=(contact_details.Fields.Item("MessageFooterVisitorLine3").Value)%>" size="60">
      <img src="questionmark.gif" alt="Enter the 3rd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td colspan="2" valign="top">
        <input name="submit2" type="submit" value="Update Record">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="contact_details">
  <input type="hidden" name="MM_recordId" value="<%= contact_details.Fields.Item("ContactID").Value %>">
</form>
</body>
</html>
<%
contact_details.Close()
Set contact_details = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
Lookup_Country.Close()
Set Lookup_Country = Nothing
%>
<%
Lookup_State.Close()
Set Lookup_State = Nothing
%>

