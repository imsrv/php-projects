<?php
/* --------------------------------------------------------------
   $Id: header.php,v 1.1 2003/09/06 22:05:29 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.19 2002/04/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><?php echo xtc_image(DIR_WS_IMAGES . 'logo.gif', 'nextcommerce', '185', '95'); ?></td>
    <td valign="bottom" align="right" background="images/bg_top.jpg"><?php echo xtc_image(DIR_WS_IMAGES . 'img_spacer.jpg', '', '', ''); ?><?php echo '<a href="start.php"  class="headerLink">'. xtc_image(DIR_WS_IMAGES . 'top_index.gif', '', '', '').'</a>'; ?><?php echo xtc_image(DIR_WS_IMAGES . 'img_spacer.jpg', '', '', ''); ?><?php echo '<a href="http://www.xt-commerce.com" target="_new" class="headerLink">'. xtc_image(DIR_WS_IMAGES . 'top_support.gif', '', '', '').'</a>'; ?><?php echo xtc_image(DIR_WS_IMAGES . 'img_spacer.jpg', '', '', ''); ?><?php echo '<a href="../index.php" class="headerLink">'. xtc_image(DIR_WS_IMAGES . 'top_shop.gif', '', '', '').'</a>'; ?><?php echo xtc_image(DIR_WS_IMAGES . 'img_spacer.jpg', '', '', ''); ?><?php echo '<a href="' . xtc_href_link(FILENAME_LOGOUT, '', 'NONSSL') . '" class="headerLink">'. xtc_image(DIR_WS_IMAGES . 'top_logout.gif', '', '', '').'</a>'; ?><?php echo xtc_image(DIR_WS_IMAGES . 'img_spacer.jpg', '', '', ''); ?><?php echo '<a href="' . xtc_href_link(FILENAME_CREDITS, '', 'NONSSL') . '" class="headerLink">'. xtc_image(DIR_WS_IMAGES . 'top_credits.gif', '', '', '').'</a>'; ?><?php echo xtc_image(DIR_WS_IMAGES . 'img_line.jpg', '', '', ''); ?></td>
</td>
  </tr>
</table>
