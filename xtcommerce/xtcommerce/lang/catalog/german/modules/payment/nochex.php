<?php
/* -----------------------------------------------------------------------------------------
   $Id: nochex.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(nochex.php,v 1.3 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (nochex.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_NOCHEX_TEXT_TITLE', 'NOCHEX');
  define('MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION', 'NOCHEX<br>Erfordert die W&auml;hrung GBP.');
  
  define('MODULE_PAYMENT_NOCHEX_STATUS_TITLE' , 'Enable NOCHEX Module');
define('MODULE_PAYMENT_NOCHEX_STATUS_DESC' , 'Do you want to accept NOCHEX payments?');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_TITLE' , 'Einzelne Zonen');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche dieses Modul ben�tzen d�rfen. zb AT,DE (wenn leer, werden alle Zonen erlaubt)');
define('MODULE_PAYMENT_NOCHEX_ID_TITLE' , 'E-Mail Address');
define('MODULE_PAYMENT_NOCHEX_ID_DESC' , 'The e-mail address to use for the NOCHEX service');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_NOCHEX_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_NOCHEX_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>