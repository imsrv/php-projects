<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_products_stock.inc.php,v 1.1 2003/09/06 21:47:50 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_products_stock.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function xtc_get_products_stock($products_id) {
    $products_id = xtc_get_prid($products_id);
    $stock_query = xtc_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "'");
    $stock_values = xtc_db_fetch_array($stock_query);

    return $stock_values['products_quantity'];
  }

 ?>