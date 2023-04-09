<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/paypalstoremanager.asp" -->
<%
Dim rsPreferences
Dim rsPreferences_numRows

Set rsPreferences = Server.CreateObject("ADODB.Recordset")
rsPreferences.ActiveConnection = MM_paypalstoremanager_STRING
rsPreferences.Source = "SELECT *  FROM tblPPSM_PayPalPreferences"
rsPreferences.CursorType = 0
rsPreferences.CursorLocation = 2
rsPreferences.LockType = 1
rsPreferences.Open()

rsPreferences_numRows = 0
%>
<%
'Declare our variables we will be receiving
Dim str, business, receiver_email, receiver_id, item_name, item_number, quantity, item_name1, item_number1, invoice, custom, option_name1, option_selection1, option_name2, option_selection2, num_cart_items, payment_status, payment_type, pending_reason, reason_code, payment_date, txn_id, parent_txn_id, txn_type, mc_gross, mc_fee, mc_currency, settle_amount, payment_gross, payment_fee, exchange_rate, first_name, last_name, payer_business_name, address_street, address_city, address_state, address_zip, address_country, address_status, payer_email, payer_status, notify_version, verify_sign
Dim objHttp

'Request the variables we declare above from PayPal
str = Request.Form
payment_processor = "PayPal"
business = Request.Form("business")
receiver_email = Request.Form("receiver_email")
receiver_id = Request.Form("receiver_id")
item_name = Request.Form("item_name")
item_number = Request.Form("item_number")
quantity = Request.Form("quantity")
item_name1 = Request.Form("item_name")
item_number1 = Request.Form("item_number")
invoice = Request.Form("invoice")
custom = Request.Form("custom")
memo = Request.Form("memo")
tax = Request.Form("tax")
option_name1 = Request.Form("option_name1")
option_selection1 = Request.Form("option_selection1")
option_name2 = Request.Form("option_name2")
option_selection2 = Request.Form("option_selection2")
num_cart_items = Request.Form("num_cart_items")
payment_status = Request.Form("payment_status")
payment_type = Request.Form("payment_type")
pending_reason = Request.Form("pending_reason")
reason_code = Request.Form("reason_code")
payment_date = Request.Form("payment_date")
txn_id = Request.Form("txn_id")
parent_txn_id = Request.Form("parent_txn_id")
txn_type = Request.Form("txn_type")
mc_gross = Request.Form("mc_gross")
mc_fee = Request.Form("mc_fee")
mc_currency = Request.Form("mc_currency")
settle_amount = Request.Form("settle_amount")
payment_gross = Request.Form("payment_gross")
payment_fee = Request.Form("payment_fee")
exchange_rate = Request.Form("exchange_rate")
first_name = Request.Form("first_name")
last_name = Request.Form("last_name")
payer_business_name = Request.Form("payer_business_name")
address_street = Request.Form("address_street")
address_city = Request.Form("address_city")
address_state = Request.Form("address_state")
address_zip = Request.Form("address_zip")
address_country = Request.Form("address_country")
address_status = Request.Form("address_status")
payer_email = Request.Form("payer_email")
payer_status = Request.Form("payer_status")
payer_id = Request.Form("payer_id")
notify_version = Request.Form("notify_version")
verify_sign = Request.Form("verify_sign")


' Post back to PayPal system to validate
str = str & "&cmd=_notify-validate"
set objHttp = Server.CreateObject("Msxml2.ServerXMLHTTP")
objHttp.open "POST", "https://www.paypal.com/cgi-bin/webscr", false
objHttp.setRequestHeader "Content-type", "application/x-www-form-urlencoded"
objHttp.Send str

' Check notification validation
if (objHttp.status <> 200 ) then
' HTTP error handling
'Now we see if the payment is pending, verified, or denied 
elseif (objHttp.responseText = "VERIFIED" OR objHttp.responseText = "PENDING" OR txn_type <> "reversal" OR payment_status <> "Refunded") then
'elseif (objHttp.responseText = "INVALID" OR objHttp.responseText = "FAILED") then

'It is verified or pending so we process the payment with the code below

'Send SMS Message notification
Dim objCDOsms
Set objCDOsms = Server.CreateObject("CDONTS.NewMail")
objCDOsms.From = payer_email
objCDOsms.To = (rsPreferences.Fields.Item("SMSConfirmationEmailAddressTO").Value)
objCDOsms.CC = ""
objCDOsms.Subject = "Sale- " & payment_gross
objCDOsms.Body = item_name
objCDOsms.Send()
Set objCDOsms = Nothing
'End Send SMS Message notification
end if

'elseif (objHttp.responseText = "INVALID" OR objHttp.responseText = "FAILED") then
'elseif (objHttp.responseText = "VERIFIED" OR objHttp.responseText = "PENDING") then
' If we get an Invalid response from PayPal, then the payment is messed up and we notify the customer
'Here we insert the values we got from PayPal above into our tblPayPalPayments- We get the email and item number
'end if
set objHttp = nothing
%>
<%
rsPreferences.Close()
Set rsPreferences = Nothing
%>
