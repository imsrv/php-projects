<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_currencies_values.inc.php,v 1.1 2003/09/06 21:47:50 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (xtc_get_currencies_values.inc.php,v 1.1 2003/08/213); www.nextcommerce.org
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function xtc_get_currencies_values($code) {
    $currency_values = xtc_db_query("select * from " . TABLE_CURRENCIES . " where code = '" . $code . "'");
    $currencie_data=xtc_db_fetch_array($currency_values);
    return $currencie_data;
  }

 ?>