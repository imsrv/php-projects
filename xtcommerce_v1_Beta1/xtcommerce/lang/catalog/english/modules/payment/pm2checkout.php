<?php
/* -----------------------------------------------------------------------------------------
   $Id: pm2checkout.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pm2checkout.php,v 1.3 2002/11/18); www.oscommerce.com 
   (c) 2003	 nextcommerce (pm2checkout.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_2CHECKOUT_TEXT_TITLE', '2CheckOut');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_DESCRIPTION', 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_TYPE', 'Type:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER', 'Credit Card Owner:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', 'Credit Card Owner First Name:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', 'Credit Card Owner Last Name:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', 'Credit Card Number:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', 'Credit Card Expiry Date:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Credit Card Checknumber:');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(located at the back of the credit card)');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_JS_CC_NUMBER', '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE', 'There has been an error processing your credit card. Please try again.');
  define('MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR', 'Credit Card Error!');
  
  define('MODULE_PAYMENT_2CHECKOUT_STATUS_TITLE' , 'Enable 2CheckOut Module');
define('MODULE_PAYMENT_2CHECKOUT_STATUS_DESC' , 'Do you want to accept 2CheckOut payments?');
define('MODULE_PAYMENT_2CHECKOUT_ALLOWED_TITLE' , 'Einzelne Zonen');
define('MODULE_PAYMENT_2CHECKOUT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche dieses Modul ben�tzen d�rfen. zb AT,DE (wenn leer, werden alle Zonen erlaubt)');
define('MODULE_PAYMENT_2CHECKOUT_LOGIN_TITLE' , 'Login/Store Number');
define('MODULE_PAYMENT_2CHECKOUT_LOGIN_DESC' , 'Login/Store Number used for the 2CheckOut service');
define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_DESC' , 'Transaction mode used for the 2Checkout service');
define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_TITLE' , 'Merchant Notifications');
define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_DESC' , 'Should 2CheckOut e-mail a receipt to the store owner?');
define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_2CHECKOUT_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_2CHECKOUT_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>