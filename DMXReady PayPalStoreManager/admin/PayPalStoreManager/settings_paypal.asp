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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "form1" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_paypalstoremanager_STRING
  MM_editTable = "tblPPSM_PayPalPreferences"
  MM_editColumn = "StoreID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "StoreName|value|currency_code|value|business|value|image_url|value|notify_url|value|cancel_return|value|return|value|cmd|value|PayPalServer|value|SMSConfirmationEmailAddressTO|value"
  MM_columnsStr = "StoreName|',none,''|currency_code|',none,''|business|',none,''|image_url|',none,''|notify_url|',none,''|cancel_return|',none,''|return|',none,''|cmd|',none,''|PayPalServer|',none,''|SMSConfirmationEmailAddressTO|',none,''"

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
Dim rsPayPalPreferences__value1
rsPayPalPreferences__value1 = "1"
If (Request.QueryString("StoreID")   <> "") Then 
  rsPayPalPreferences__value1 = Request.QueryString("StoreID")  
End If
%>
<%
Dim rsPayPalPreferences
Dim rsPayPalPreferences_numRows

Set rsPayPalPreferences = Server.CreateObject("ADODB.Recordset")
rsPayPalPreferences.ActiveConnection = MM_paypalstoremanager_STRING
rsPayPalPreferences.Source = "SELECT *  FROM tblPPSM_PayPalPreferences  WHERE StoreID = " + Replace(rsPayPalPreferences__value1, "'", "''") + ""
rsPayPalPreferences.CursorType = 0
rsPayPalPreferences.CursorLocation = 2
rsPayPalPreferences.LockType = 1
rsPayPalPreferences.Open()

rsPayPalPreferences_numRows = 0
%>
<%
Dim rsStore
Dim rsStore_numRows

Set rsStore = Server.CreateObject("ADODB.Recordset")
rsStore.ActiveConnection = MM_paypalstoremanager_STRING
rsStore.Source = "SELECT *  FROM tblPPSM_PayPalPreferences"
rsStore.CursorType = 0
rsStore.CursorLocation = 2
rsStore.LockType = 1
rsStore.Open()

rsStore_numRows = 0
%>
<html>
<head>
<title>PayPal Store Manager Settings</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--#include file="header.asp" -->
<% If Not rsPayPalPreferences.EOF Or Not rsPayPalPreferences.BOF Then %>
<form method="POST" action="<%=MM_editAction%>" name="form1">
  <table width="100%" align="center" class="tableborder">
    <tr valign="baseline">
      <td colspan="3" align="right" nowrap class="tableheader"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" nowrap class="tableheader"><strong></strong><strong><font color="#FF0000" size="3"><%=(rsPayPalPreferences.Fields.Item("StoreName").Value)%></font></strong></td>
      <td nowrap class="tableheader"><div align="right"><strong> Set PayPal Preferences</strong></div>
      </td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Store Name:</td>
      <td width="34%" bgcolor="#EAEAEA"><input type="text" name="StoreName" value="<%=(rsPayPalPreferences.Fields.Item("StoreName").Value)%>" size="50">
      </td>
      <td width="53%" bgcolor="#EAEAEA">Name of your Store. (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)<br>
      i.e.<font color="#FF0000"> <strong><%= Request.ServerVariables("SERVER_NAME")%></strong></font></td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Currency:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <select name="currency_code" id="currency_code">
          <option value="" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Select
          Currency</option>
          <option value="USD" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("USD" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>USD
          | U.S. Dollars</option>
          <option value="EUR" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("EUR" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>EUR
          | Euros</option>
          <option value="GBP" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("GBP" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>GBP
          | Pounds Sterling</option>
          <option value="CAD" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("CAD" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>CAD
          | Canadian Dollars</option>
          <option value="JPY" <%If (Not isNull((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then If ("JPY" = CStr((rsPayPalPreferences.Fields.Item("currency_code").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>JPY
          | Yen</option>
        </select>
      </td>
      <td width="53%" bgcolor="#EAEAEA">Defines the currency in which the monetary variables (amount,
          shipping, shipping2, handling, tax) are denoted. Possible values are &quot;USD&quot;, &quot;EUR&quot;, &quot;GBP&quot;, &quot;CAD&quot;, &quot;JPY&quot;.
          If omitted, all monetary fields will be interpreted as U.S. Dollars.
        (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)</td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">PayPal Email Address:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <input name="business" type="text" id="business" value="<%=(rsPayPalPreferences.Fields.Item("business").Value)%>" size="50">
      </td>
      <td width="53%" bgcolor="#EAEAEA"> Email address on your PayPal account. (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)
        <br>
      i.e.<font color="#FF0000">        <strong>paypal@<%= Request.ServerVariables("SERVER_NAME")%></strong></font></td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Location of Payment Page Logo:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <input name="image_url" type="text" id="image_url2" value="<%=(rsPayPalPreferences.Fields.Item("image_url").Value)%>" size="100">
        <br>
        <br>
		<% if rsPayPalPreferences.Fields.Item("image_url").Value <> "" Then %>
        <% if instr(rsPayPalPreferences.Fields.Item("image_url").Value,"http") Then %>
              <img src="<%=(rsPayPalPreferences.Fields.Item("image_url").Value)%>">
              <%else%>
              <img src="images/<%=(rsPayPalPreferences.Fields.Item("image_url").Value)%>">
              <% end if ' image check %>
			  <% end if ' image check %>
      </td>
      <td width="53%" bgcolor="#EAEAEA">The internet URL of the 150 X 50 pixel image you would like to use
        as your logo (should start with <strong>https</strong>://...) (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)<br>
      i.e. <strong><font color="#FF0000">https://<%= Request.ServerVariables("Server_Name")%>/images/secure_logo.gif</font></strong></td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Location of IPN Page:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <input type="text" name="notify_url" value="<%=(rsPayPalPreferences.Fields.Item("notify_url").Value)%>" size="100">
      </td>
      <td width="53%" bgcolor="#EAEAEA">Only used with IPN. An internet URL where IPN form posts will be
            sent. (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)<br>
      i.e. <strong><font color="#FF0000">http://<%= Request.ServerVariables("Server_Name")%>/applications/PayPalStoreManager/components/ipn_paypal.asp </font></strong></td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Cancel Page:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <input name="cancel_return" type="text" id="cancel_return" value="<%=(rsPayPalPreferences.Fields.Item("cancel_return").Value)%>" size="100">
      </td>
      <td width="53%" bgcolor="#EAEAEA">An internet URL where your customer will be returned after
        canceling payment. (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)<br>
      i.e.<strong><font color="#FF0000"> http://<%= Request.ServerVariables("Server_Name")%>/applications/PayPalStoreManager/components/failed.asp</font></strong></td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">Success Page:</td>
      <td width="34%" bgcolor="#EAEAEA">
        <input name="return" type="text" id="return" value="<%=(rsPayPalPreferences.Fields.Item("return").Value)%>" size="100">
      </td>
      <td width="53%" bgcolor="#EAEAEA"><p>An internet URL where your customer will be returned after completing
        payment. (<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_help-ext&source_page=_home" target="_blank">help?</a>)<br>
        i.e. <strong><font color="#FF0000">http://<%= Request.ServerVariables("Server_Name")%>/applications/PayPalStoreManager/components/success.asp</font></strong></p>
      </td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">PayPal Button Type</td>
      <td width="34%" bgcolor="#EAEAEA"><p>
          <label>
          <input <%If (CStr((rsPayPalPreferences.Fields.Item("cmd").Value)) = CStr("_xclick")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="cmd" value="_xclick">
          Single Item</label>
          <label>
          <input <%If (CStr((rsPayPalPreferences.Fields.Item("cmd").Value)) = CStr("_cart")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="cmd" value="_cart">
          Shopping Cart</label>
          <br>
          </p>
      </td>
      <td width="53%" bgcolor="#EAEAEA">Select &quot;Shopping Cart&quot; if you wish to use a shopping
        cart for your store OR &quot;Single Item&quot; if you wish to accept single item
        purchases only.</td>
    </tr>
    <tr valign="baseline">
      <td width="13%" align="right" nowrap class="tableheader">PayPal Server: </td>
      <td width="34%" bgcolor="#EAEAEA"><select name="PayPalServer" id="PayPalServer">
        <option value="https://www.paypal.com/cgi-bin/webscr" <%If (Not isNull((rsPayPalPreferences.Fields.Item("PayPalServer").Value))) Then If ("https://www.sandbox.paypal.com/cgi-bin/webscr" = CStr((rsPayPalPreferences.Fields.Item("PayPalServer").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Live Server</option>
        <option value="https://www.sandbox.paypal.com/cgi-bin/webscr" <%If (Not isNull((rsPayPalPreferences.Fields.Item("PayPalServer").Value))) Then If ("https://www.sandbox.paypal.com/cgi-bin/webscr" = CStr((rsPayPalPreferences.Fields.Item("PayPalServer").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Test Server</option>
      </select>        
</td>
      <td width="53%" bgcolor="#EAEAEA">Select Test or Live server (To utilize the Test server
        you will need to create a test account (<a href="https://developer.paypal.com/" target="_blank">help?</a>)</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="tableheader">SMS/Cell phone Email Address</td>
      <td bgcolor="#EAEAEA"><input name="SMSConfirmationEmailAddressTO" type="text" value="<%=(rsPayPalPreferences.Fields.Item("SMSConfirmationEmailAddressTO").Value)%>" size="50">
</td>
      <td bgcolor="#EAEAEA"> This feature is available if you wish to send a text/SMS message
        notifying you of a sale. This  does
not affect the &quot;Receipt of Payment&quot; OR &quot;Purchase Confirmation&quot; notification
that is automatically sent to buyer and  seller from PayPal.<br>
i.e. <strong><font color="#FF0000">3238982252@msg.telus.com</font></strong></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="tableheader">&nbsp;</td>
      <td><input name="submit4" type="submit" value="Save PayPal settings">
        <input type="hidden" name="MM_recordId" value="<%= rsPayPalPreferences.Fields.Item("StoreID").Value %>">
        <input type="hidden" name="MM_update" value="form1">
</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<% End If ' end Not rsPayPalPreferences.EOF Or NOT rsPayPalPreferences.BOF %>

</body>
</html>
<%
rsPayPalPreferences.Close()
Set rsPayPalPreferences = Nothing
%>
<%
rsStore.Close()
Set rsStore = Nothing
%>
