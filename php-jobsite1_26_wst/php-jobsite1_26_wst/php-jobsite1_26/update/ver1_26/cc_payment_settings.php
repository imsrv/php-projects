<?php
define('CC_PAYMENT','on');
define('INVOICE_PAYMENT','on');
define('CC_PROCESSOR_TYPE','paypal');
define('CC_AVS','yes');
define('ENABLE_SSL','yes');
define('CC_NOTIFY_ADMIN','yes');
define('CC_NOTIFY_BUYER','yes');
define('MANUAL_STORE','db');
define('PAYPAL_URL','https://www.paypal.com/cgi-bin/webscr');
define('PAYPAL_BUSINESS','test@paypal.com');
define('PAYPAL_CURRENCY','USD');
define('PAYPAL_VALIDATION','manual');
define('AUTHORIZE_NET_LOGIN','testing');
define('AUTHORIZE_NET_PASSWORD','');
define('AUTHORIZE_NET_TRANKEY','1233444-222');
define('AUTHORIZE_NET_URL','https://secure.authorize.net/gateway/transact.dll');
define('AUTHORIZE_NET_DEMO','yes');
define('ECHO_INC_COM_LOGIN','123>12345');
define('ECHO_INC_COM_PASSWORD','123456');
define('ECHO_INC_COM_URL','https://wwws.echo-inc.com/scripts/INR200.EXE');
define('ECHO_INC_COM_DEMO','yes');
define('CHECKOUT_COM_ACCOUNT','12345');
define('CHECKOUT_COM_URL','https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c');
define('CHECKOUT_COM_DEMO','yes');
define('VERISIGN_COM_ACCOUNT','testdrive');
define('VERISIGN_COM_URL','https://payflowlink.verisign.com/payflowlink.cfm');
define('VERISIGN_COM_PARTNER','VeriSign');
define('WORLDPAY_URL','https://select.worldpay.com/wcc/purchase/');
define('WORLDPAY_ID','45887');
define('WORLDPAY_CARTID','homesale123');
define('WORLDPAY_CURRENCY','USD');
define('WORLDPAY_TEST','no');
?>