<?php
$fields[1]["comment"][]=" Option to use or not Credit Card Payment on the site.";
$fields[1]["name"]="(radio on,off)Credit Card Payment";
$fields[1]["define"]="CC_PAYMENT";
$fields[1]["default"]="on'";
$fields[2]["comment"][]=" Option to use or not Normal Invoice Payment (Wire Transfer, Money Order etc.).";
$fields[2]["name"]="(radio on,off)Invoice Payment";
$fields[2]["define"]="INVOICE_PAYMENT";
$fields[2]["default"]="on'";
$fields[3]["comment"][]="Select the payment method from the list above";
$fields[3]["name"]="(select manual,paypal,authorize,echo-inc,2checkout,verysign,worldpay) Credit Card Processor Gateway";
$fields[3]["define"]="CC_PROCESSOR_TYPE";
$fields[3]["default"]="authorize'";
$fields[4]["comment"][]="Enable/Disable Address Verification Service";
$fields[4]["name"]="(radio yes,no) Enable AVS";
$fields[4]["define"]="CC_AVS";
$fields[4]["default"]="yes'";
$fields[5]["comment"][]="Some Payment Gateway need SSL to process payment(authorize, echo-inc). Click <a href=\"javascript: ;\" onclick=\"newwin=window.open('testssl.php?todo=testssl','_blank','width=300,height=150,scrollbars=yes,menubar=no,resizable=yes,location=no');\">here</a> to see if you can enable this option.";
$fields[5]["name"]="(radio yes,no) Enable SSL";
$fields[5]["define"]="ENABLE_SSL";
$fields[5]["default"]="yes'";
$fields[6]["name"]="(radio yes,no) Notify admin in email when the payment is made";
$fields[6]["define"]="CC_NOTIFY_ADMIN";
$fields[6]["default"]="yes'";
$fields[7]["name"]="(radio yes,no) Send a confirmation email to buyer with payment details";
$fields[7]["define"]="CC_NOTIFY_BUYER";
$fields[7]["default"]="yes'";
$fields[8]["comment"][]="_________________________________________________________________";
$fields[8]["comment"][]="Manual Processing settings";
$fields[8]["name"]="(radio email,db) Send sensitive data in email, or store in database";
$fields[8]["define"]="MANUAL_STORE";
$fields[8]["default"]="db'";
$fields[9]["comment"][]="_________________________________________________________________";
$fields[9]["comment"][]="PayPal Processing settings";
$fields[9]["name"]="PayPal URL";
$fields[9]["define"]="PAYPAL_URL";
$fields[9]["default"]="https://www.paypal.com/cgi-bin/webscr'";
$fields[10]["name"]="PayPal bussiness (email address)";
$fields[10]["define"]="PAYPAL_BUSINESS";
$fields[10]["default"]="test@paypal.com'";
$fields[11]["name"]="(select USD,CAD,GBP,EUR,JPY) PayPal Currency";
$fields[11]["define"]="PAYPAL_CURRENCY";
$fields[11]["default"]="USD'";
$fields[12]["comment"][]="You can select manual validation and all the Paypal payments will be manually validated by the admin, you can select automatic validation without waiting for the admin validation, or automatic with Paypal IPN - only if IPN is activated in your account";
$fields[12]["name"]="(radio manual,automatic,IPN) Paypal payment validation method";
$fields[12]["define"]="PAYPAL_VALIDATION";
$fields[12]["default"]="manual";
$fields[13]["comment"][]="_________________________________________________________________";
$fields[13]["comment"][]="To use Authorize.net you need curl module installed (enabled). Click <a href=\"javascript: ;\" onclick=\"newwin=window.open('testcurl.php?desc=Authorize.net','_blank','width=300,height=150,scrollbars=yes,menubar=no,resizable=yes,location=no');\">here</a> to see if you have this module.";
$fields[13]["comment"][]="Authorize.net Processing settings";
$fields[13]["name"]="Authorize.net Login";
$fields[13]["define"]="AUTHORIZE_NET_LOGIN";
$fields[13]["default"]="testing'";
$fields[14]["name"]="Authorize.net Password";
$fields[14]["define"]="AUTHORIZE_NET_PASSWORD";
$fields[14]["default"]="'";
$fields[15]["comment"][]="Enter the Transaction Key obtained from the Merchant Interface";
$fields[15]["name"]="Authorize.net Transaction Key";
$fields[15]["define"]="AUTHORIZE_NET_TRANKEY";
$fields[15]["default"]="1233444-222'";
$fields[16]["name"]="Authorize.net URL";
$fields[16]["define"]="AUTHORIZE_NET_URL";
$fields[16]["default"]="https://secure.authorize.net/gateway/transact.dll'";
$fields[17]["comment"][]="Don't forgott to set the Demo Mode to \"no\" when you feel the system works as expected";
$fields[17]["name"]="(radio yes,no) Authorize.net Demo Mode";
$fields[17]["define"]="AUTHORIZE_NET_DEMO";
$fields[17]["default"]="yes'";
$fields[18]["comment"][]="_________________________________________________________________";
$fields[18]["comment"][]="To use echo-inc.com you need curl module installed (enabled). Click <a href=\"javascript: ;\" onclick=\"newwin=window.open('testcurl.php?desc=echoinc.net','_blank','width=300,height=150,scrollbars=yes,menubar=no,resizable=yes,location=no');\">here</a> to see if you have this module.";
$fields[18]["comment"][]="Echoinc.com Processing settings";
$fields[18]["name"]="Echo-inc.com Account";
$fields[18]["define"]="ECHO_INC_COM_LOGIN";
$fields[18]["default"]="123>12345'";
$fields[19]["name"]="Echo-inc.com PIN";
$fields[19]["define"]="ECHO_INC_COM_PASSWORD";
$fields[19]["default"]="123456'";
$fields[20]["name"]="Echo-inc.com URL";
$fields[20]["define"]="ECHO_INC_COM_URL";
$fields[20]["default"]="https://wwws.echo-inc.com/scripts/INR200.EXE'";
$fields[21]["comment"][]="Don't forgott to set the Demo Mode to \"no\" when you feel the system works as expected";
$fields[21]["name"]="(radio yes,no) Echo-inc.com Demo Mode";
$fields[21]["define"]="ECHO_INC_COM_DEMO";
$fields[21]["default"]="yes'";
$fields[22]["comment"][]="_________________________________________________________________";
$fields[22]["comment"][]="2checkout.com Processing settings";
$fields[22]["name"]="2checkout.com account";
$fields[22]["define"]="CHECKOUT_COM_ACCOUNT";
$fields[22]["default"]="12345'";
$fields[23]["name"]="2checkout.com URL";
$fields[23]["define"]="CHECKOUT_COM_URL";
$fields[23]["default"]="https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c'";
$fields[24]["comment"][]="Don't forgott to set the Demo Mode to \"no\" when you feel the system works as expected";
$fields[24]["name"]="(radio yes,no) 2CheckOut Demo Mode";
$fields[24]["define"]="CHECKOUT_COM_DEMO";
$fields[24]["default"]="yes'";
$fields[25]["comment"][]="_________________________________________________________________";
$fields[25]["comment"][]="Verisign Processing settings";
$fields[25]["name"]="Verisign login";
$fields[25]["define"]="VERISIGN_COM_ACCOUNT";
$fields[25]["default"]="testdrive'";
$fields[26]["name"]="VeriSign URL";
$fields[26]["define"]="VERISIGN_COM_URL";
$fields[26]["default"]="https://payflowlink.verisign.com/payflowlink.cfm'";
$fields[27]["name"]="VeriSign Partner";
$fields[27]["define"]="VERISIGN_COM_PARTNER";
$fields[27]["default"]="VeriSign'";
$fields[28]["comment"][]="_________________________________________________________________";
$fields[28]["comment"][]="WorldPay Processing settings";
$fields[28]["name"]="WorldPay URL";
$fields[28]["define"]="WORLDPAY_URL";
$fields[28]["default"]="https://select.worldpay.com/wcc/purchase/'";
$fields[29]["name"]="WorldPay ID";
$fields[29]["define"]="WORLDPAY_ID";
$fields[29]["default"]="45887'";
$fields[30]["name"]="WorldPay CartID";
$fields[30]["define"]="WORLDPAY_CARTID";
$fields[30]["default"]="homesale123'";
$fields[31]["name"]="WorldPay Curency";
$fields[31]["define"]="WORLDPAY_CURRENCY";
$fields[31]["default"]="USD'";
$fields[32]["name"]="(radio yes,no) WorldPay Test Mode";
$fields[32]["define"]="WORLDPAY_TEST";
$fields[32]["default"]="no'";
?>