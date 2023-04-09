<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/accountlistmanager.asp"-->
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

If (CStr(Request("MM_update")) = "account_details" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_Accounts"
  MM_editColumn = "AccountID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Activated|value|OrgName1|value|OrgName12|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|AccountEmailAddress|value|State|value|Country|value|Map|value|Profile|value|AccountImageFile|value|CategoryID|value|AccountLookuptxt1|value|AccountLookuptxt2|value|AccountLookuptxt3|value|AccountLookuptxt4|value|AccountLookuptxt5|value"
  MM_columnsStr = "AccountActivated|',none,''|AccountName1|',none,''|AccountName2|',none,''|AccountWebsiteURL|',none,''|AccountAddress1|',none,''|AccountPhone|',none,''|AccountAddress2|',none,''|AccountCellPhone|',none,''|AccountCity|',none,''|AccountFax|',none,''|AccountPostalCode|',none,''|AccountEmailAddress|',none,''|AccountState|',none,''|AccountCountry|',none,''|AccountMap|',none,''|AccountProfile|',none,''|AccountImageFile|',none,''|AccountCategoryID|none,none,NULL|AccountLookuptxt1|',none,''|AccountLookuptxt2|',none,''|AccountLookuptxt3|',none,''|AccountLookuptxt4|',none,''|AccountLookuptxt5|',none,''"

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
Dim account_details__value1
account_details__value1 = "0"
If (Request.QueryString("AccountID") <> "") Then 
  account_details__value1 = Request.QueryString("AccountID")
End If
%>
<%
set account_details = Server.CreateObject("ADODB.Recordset")
account_details.ActiveConnection = MM_accountlistmanager_STRING
account_details.Source = "SELECT *  FROM tblAM_Accounts  WHERE AccountID = " + Replace(account_details__value1, "'", "''") + ""
account_details.CursorType = 0
account_details.CursorLocation = 2
account_details.LockType = 3
account_details.Open()
account_details_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_accountlistmanager_STRING
Category.Source = "SELECT *  FROM tblAM_AccountsCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim AccountLookuptxt1
Dim AccountLookuptxt1_numRows

Set AccountLookuptxt1 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt1.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt1.Source = "SELECT *  FROM tblAM_AccountLookuptxt1"
AccountLookuptxt1.CursorType = 0
AccountLookuptxt1.CursorLocation = 2
AccountLookuptxt1.LockType = 1
AccountLookuptxt1.Open()

AccountLookuptxt1_numRows = 0
%>
<%
Dim AccountLookuptxt2
Dim AccountLookuptxt2_numRows

Set AccountLookuptxt2 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt2.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt2.Source = "SELECT *  FROM tblAM_AccountLookuptxt2"
AccountLookuptxt2.CursorType = 0
AccountLookuptxt2.CursorLocation = 2
AccountLookuptxt2.LockType = 1
AccountLookuptxt2.Open()

AccountLookuptxt2_numRows = 0
%>
<%
Dim AccountLookuptxt3
Dim AccountLookuptxt3_numRows

Set AccountLookuptxt3 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt3.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt3.Source = "SELECT *  FROM tblAM_AccountLookuptxt3"
AccountLookuptxt3.CursorType = 0
AccountLookuptxt3.CursorLocation = 2
AccountLookuptxt3.LockType = 1
AccountLookuptxt3.Open()

AccountLookuptxt3_numRows = 0
%>
<%
Dim AccountLookuptxt4
Dim AccountLookuptxt4_numRows

Set AccountLookuptxt4 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt4.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt4.Source = "SELECT *  FROM tblAM_AccountLookuptxt4"
AccountLookuptxt4.CursorType = 0
AccountLookuptxt4.CursorLocation = 2
AccountLookuptxt4.LockType = 1
AccountLookuptxt4.Open()

AccountLookuptxt4_numRows = 0
%>
<%
Dim AccountLookuptxt5
Dim AccountLookuptxt5_numRows

Set AccountLookuptxt5 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt5.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt5.Source = "SELECT *  FROM tblAM_AccountLookuptxt5"
AccountLookuptxt5.CursorType = 0
AccountLookuptxt5.CursorLocation = 2
AccountLookuptxt5.LockType = 1
AccountLookuptxt5.Open()

AccountLookuptxt5_numRows = 0
%>
<%
Dim Lookup_State
Dim Lookup_State_numRows

Set Lookup_State = Server.CreateObject("ADODB.Recordset")
Lookup_State.ActiveConnection = MM_accountlistmanager_STRING
Lookup_State.Source = "SELECT *  FROM tblLookupState"
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
Lookup_Country.ActiveConnection = MM_accountlistmanager_STRING
Lookup_Country.Source = "SELECT *  FROM tblLookupCountry"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
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
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="account_details" id="account_details">
  <table width="100%" height="272" align="center" cellpadding="5" cellspacing="0" class="tableborder">
    <tr>
      <td width="49%" height="270" valign="top">     
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="3">Company Details:</td>
            <td>Activated: 
            <input <%If (CStr((account_details.Fields.Item("AccountActivated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True"></td>
          </tr>
          <tr class="row2">
            <td width="19%">Name 1:</td>
            <td width="28%"><input name="OrgName1" type="text" id="OrgName12" value="<%=(account_details.Fields.Item("AccountName1").Value)%>">
            </td>
            <td width="16%">Name 2:</td>
            <td width="37%"><input name="OrgName12" type="text" id="OrgName122" value="<%=(account_details.Fields.Item("AccountName2").Value)%>">
            </td>
          </tr>
          <tr class="row2">
            <td colspan="4"> Web Site URL: http://
              <input name="WebsiteURL" type="text" id="WebsiteURL2" value="<%=(account_details.Fields.Item("AccountWebsiteURL").Value)%>">
            </td>
          </tr>
        </table>
        <div align="right">
          <input name="submit3" type="submit" value="Save Record">        
        </div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details</td>
          </tr>
          <tr class="row2">
            <td width="21%">Address 1: </td>
            <td width="32%"><input name="Address1" type="text" id="Address1" value="<%=(account_details.Fields.Item("AccountAddress1").Value)%>">
            </td>
            <td width="16%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone" value="<%=(account_details.Fields.Item("AccountPhone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address2" value="<%=(account_details.Fields.Item("AccountAddress2").Value)%>" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone" value="<%=(account_details.Fields.Item("AccountCellPhone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>City:</td>
            <td><input name="City" type="text" id="City" value="<%=(account_details.Fields.Item("AccountCity").Value)%>">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax" value="<%=(account_details.Fields.Item("AccountFax").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode" value="<%=(account_details.Fields.Item("AccountPostalCode").Value)%>">
            </td>
            <td>Email:</td>
            <td><input name="AccountEmailAddress" type="text" id="JobTitle3" value="<%=(account_details.Fields.Item("AccountEmailAddress").Value)%>"></td>
          </tr>
          <tr class="row2">
            <td>Province/State:</td>
            <td><select name="State" id="select5" title="<%=(account_details.Fields.Item("AccountState").Value)%>">
            <%
While (NOT Lookup_State.EOF)
%>
            <option value="<%=(Lookup_State.Fields.Item("StateName").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountState").Value))) Then If (CStr(Lookup_State.Fields.Item("StateName").Value) = CStr((account_details.Fields.Item("AccountState").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_State.Fields.Item("StateName").Value)%></option>
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
            <td><select name="Country" id="select6" title="<%=(account_details.Fields.Item("AccountCountry").Value)%>">
            <%
While (NOT Lookup_Country.EOF)
%>
            <option value="<%=(Lookup_Country.Fields.Item("CountryName").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountCountry").Value))) Then If (CStr(Lookup_Country.Fields.Item("CountryName").Value) = CStr((account_details.Fields.Item("AccountCountry").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_Country.Fields.Item("CountryName").Value)%></option>
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
            <td colspan="3"><input name="Map" type="text" id="Map" value="<%=(account_details.Fields.Item("AccountMap").Value)%>" size="30">
      | <a href="http://ca.maps.yahoo.com" target="_blank">Get URL from Yahoo
      Maps</a></td>
          </tr>
        </table>
        <div align="right">
          <input name="submit32" type="submit" value="Save Record">
          <br>
        </div></td>
      <td width="49%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr>
          <td colspan="2" class="tableheader">Profile Details:</td>
        </tr>
        <tr class="row2">
          <td width="24%">Profile:</td>
          <td width="76%"><textarea name="Profile" cols="40" rows="6" id="textarea"><%=(account_details.Fields.Item("AccountProfile").Value)%></textarea>
          </td>
        </tr>
        <tr class="row2">
          <td height="27">Image/Logo:</td>
          <td>              <% if account_details.Fields.Item("AccountImageFile").Value <> "" then %>
              <img src="../../applications/AccountListManager/images/<%=(account_details.Fields.Item("AccountImageFile").Value)%>" height="30">
              <% end if %>
  |
  <input name="AccountImageFile" type="text" id="AccountImageFile" value="<%=(account_details.Fields.Item("AccountImageFile").Value)%>">
  | <a href="javascript:;" onClick="MM_openBrWindow('upload_image.asp?AccountID=<%=(account_details.Fields.Item("AccountID").Value)%>','Image','scrollbars=yes,width=300,height=150')"> Add
  Picture</a> </td></tr>
      </table>        
        <div align="right">
          <input name="submit33" type="submit" value="Save Record">
        </div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="2">Additional Details</td>
          </tr>
          <tr class="row2">
            <td width="25%"><%=(Category.Fields.Item("CategoryLabel").Value)%></td>
            <td width="75%"><select name="CategoryID" id="CategoryID">
                <%
While (NOT Category.EOF)
%>
                <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountCategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((account_details.Fields.Item("AccountCategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      Category</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt1.EOF Or Not AccountLookuptxt1.BOF Then %>
              <%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt1.EOF Or NOT AccountLookuptxt1.BOF %>
            </td>
            <td><select name="AccountLookuptxt1" id="AccountLookuptxt1">
                <%
While (NOT AccountLookuptxt1.EOF)
%>
                <option value="<%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemValue").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountLookuptxt1").Value))) Then If (CStr(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemValue").Value) = CStr((account_details.Fields.Item("AccountLookuptxt1").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemValue").Value)%></option>
                <%
  AccountLookuptxt1.MoveNext()
Wend
If (AccountLookuptxt1.CursorType > 0) Then
  AccountLookuptxt1.MoveFirst
Else
  AccountLookuptxt1.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt1.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt2.EOF Or Not AccountLookuptxt2.BOF Then %>
              <%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt2.EOF Or NOT AccountLookuptxt2.BOF %>
            </td>
            <td><select name="AccountLookuptxt2" id="AccountLookuptxt2">
                <%
While (NOT AccountLookuptxt2.EOF)
%>
                <option value="<%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemValue").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountLookuptxt2").Value))) Then If (CStr(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemValue").Value) = CStr((account_details.Fields.Item("AccountLookuptxt2").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemValue").Value)%></option>
                <%
  AccountLookuptxt2.MoveNext()
Wend
If (AccountLookuptxt2.CursorType > 0) Then
  AccountLookuptxt2.MoveFirst
Else
  AccountLookuptxt2.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt2.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt3.EOF Or Not AccountLookuptxt3.BOF Then %>
              <%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt3.EOF Or NOT AccountLookuptxt3.BOF %>
            </td>
            <td><select name="AccountLookuptxt3" id="AccountLookuptxt3">
            <%
While (NOT AccountLookuptxt3.EOF)
%>
            <option value="<%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemValue").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountLookuptxt3").Value))) Then If (CStr(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemValue").Value) = CStr((account_details.Fields.Item("AccountLookuptxt3").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemValue").Value)%></option>
                <%
  AccountLookuptxt3.MoveNext()
Wend
If (AccountLookuptxt3.CursorType > 0) Then
  AccountLookuptxt3.MoveFirst
Else
  AccountLookuptxt3.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt3.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt4.EOF Or Not AccountLookuptxt4.BOF Then %>
              <%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt4.EOF Or NOT AccountLookuptxt4.BOF %>
            </td>
            <td><select name="AccountLookuptxt4" id="AccountLookuptxt4">
                <%
While (NOT AccountLookuptxt4.EOF)
%>
                <option value="<%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemValue").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountLookuptxt4").Value))) Then If (CStr(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemValue").Value) = CStr((account_details.Fields.Item("AccountLookuptxt4").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemValue").Value)%></option>
                <%
  AccountLookuptxt4.MoveNext()
Wend
If (AccountLookuptxt4.CursorType > 0) Then
  AccountLookuptxt4.MoveFirst
Else
  AccountLookuptxt4.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt4.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt5.EOF Or Not AccountLookuptxt5.BOF Then %>
              <%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt5.EOF Or NOT AccountLookuptxt5.BOF %>
            </td>
            <td><select name="AccountLookuptxt5" id="AccountLookuptxt5">
                <%
While (NOT AccountLookuptxt5.EOF)
%>
                <option value="<%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemValue").Value)%>" <%If (Not isNull((account_details.Fields.Item("AccountLookuptxt5").Value))) Then If (CStr(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemValue").Value) = CStr((account_details.Fields.Item("AccountLookuptxt5").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemValue").Value)%></option>
                <%
  AccountLookuptxt5.MoveNext()
Wend
If (AccountLookuptxt5.CursorType > 0) Then
  AccountLookuptxt5.MoveFirst
Else
  AccountLookuptxt5.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt5.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
        </table>
        <div align="right">
          <input name="submit34" type="submit" value="Save Record">
        </div></td>
    </tr>
  </table>
<br>
<input type="hidden" name="MM_update" value="account_details">
<input type="hidden" name="MM_recordId" value="<%= account_details.Fields.Item("AccountID").Value %>">
</form>
</body>
</html>
<%
account_details.Close()
Set account_details = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
AccountLookuptxt1.Close()
Set AccountLookuptxt1 = Nothing
%>
<%
AccountLookuptxt2.Close()
Set AccountLookuptxt2 = Nothing
%>
<%
AccountLookuptxt3.Close()
Set AccountLookuptxt3 = Nothing
%>
<%
AccountLookuptxt4.Close()
Set AccountLookuptxt4 = Nothing
%>
<%
AccountLookuptxt5.Close()
Set AccountLookuptxt5 = Nothing
%>
<%
Lookup_State.Close()
Set Lookup_State = Nothing
%>
<%
Lookup_Country.Close()
Set Lookup_Country = Nothing
%>

