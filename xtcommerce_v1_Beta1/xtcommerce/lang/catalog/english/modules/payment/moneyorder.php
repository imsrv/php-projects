<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneyorder.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.6 2003/01/24); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Check/Money Order');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Make Payable To:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br><br>Send To:<br>' . nl2br(STORE_NAME_ADDRESS) . '<br><br>' . 'Your order will not ship until we receive payment.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Make Payable To: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nSend To:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment.');
  
  define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Enable Check/Money Order Module');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'Do you want to accept Check/Money Order payments?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Einzelne Zonen');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche dieses Modul ben�tzen d�rfen. zb AT,DE (wenn leer, werden alle Zonen erlaubt)');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Make Payable to:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'Who should payments be made payable to?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>
