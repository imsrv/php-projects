<?php
/* --------------------------------------------------------------
   $Id: languages.php,v 1.1 2003/09/06 22:05:29 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.5 2002/11/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (languages.php,v 1.6 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  function xtc_get_languages_directory($code) {
    $language_query = xtc_db_query("select languages_id, directory from " . TABLE_LANGUAGES . " where code = '" . $code . "'");
    if (xtc_db_num_rows($language_query)) {
      $lang = xtc_db_fetch_array($language_query);
      $_SESSION['languages_id'] = $lang['languages_id'];
      return $lang['directory'];
    } else {
      return false;
    }
  }
?>