<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_count_payment_modules.inc.php,v 1.1 2003/09/06 21:47:50 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_count_payment_modules.inc.php,v 1.5 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  // include needed functions
  require_once(DIR_FS_INC . 'xtc_count_modules.inc.php');
  function xtc_count_payment_modules() {
    return xtc_count_modules(MODULE_PAYMENT_INSTALLED);
  }
 ?>
