<?php
/* -----------------------------------------------------------------------------------------
   $Id: psigate.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(psigate.php,v 1.3 2002/11/18); www.oscommerce.com 
   (c) 2003	 nextcommerce (psigate.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PSIGATE_TEXT_TITLE', 'PSiGate');
  define('MODULE_PAYMENT_PSIGATE_TEXT_DESCRIPTION', 'Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_OWNER', 'Credit Card Owner:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_NUMBER', 'Credit Card Number:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_EXPIRES', 'Credit Card Expiry Date:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_TYPE', 'Type:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_JS_CC_NUMBER', '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR_MESSAGE', 'There has been an error processing your credit card. Please try again.');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR', 'Credit Card Error!');
  
  define('MODULE_PAYMENT_PSIGATE_STATUS_TITLE' , 'Enable PSiGate Module');
define('MODULE_PAYMENT_PSIGATE_STATUS_DESC' , 'Do you want to accept PSiGate payments?');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_TITLE' , 'Einzelne Zonen');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche dieses Modul ben�tzen d�rfen. zb AT,DE (wenn leer, werden alle Zonen erlaubt)');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_TITLE' , 'Merchant ID');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_DESC' , 'Merchant ID used for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_DESC' , 'Transaction mode to use for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_TITLE' , 'Transaction Type');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_DESC' , 'Transaction type to use for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_TITLE' , 'Credit Card Collection');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_DESC' , 'Should the credit card details be collected locally or remotely at PSiGate?');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_PSIGATE_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_PSIGATE_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>