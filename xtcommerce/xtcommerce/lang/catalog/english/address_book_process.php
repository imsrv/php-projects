<?php
/* -----------------------------------------------------------------------------------------
   $Id: address_book_process.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_process.php,v 1.9 2003/05/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book_process.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('NAVBAR_TITLE_1', 'My Account');
define('NAVBAR_TITLE_2', 'Address Book');

define('NAVBAR_TITLE_ADD_ENTRY', 'New Entry');
define('NAVBAR_TITLE_MODIFY_ENTRY', 'Update Entry');
define('NAVBAR_TITLE_DELETE_ENTRY', 'Delete Entry');

define('HEADING_TITLE_ADD_ENTRY', 'New Address Book Entry');
define('HEADING_TITLE_MODIFY_ENTRY', 'Update Address Book Entry');
define('HEADING_TITLE_DELETE_ENTRY', 'Delete Address Book Entry');

define('DELETE_ADDRESS_TITLE', 'Delete Address');
define('DELETE_ADDRESS_DESCRIPTION', 'Are you sure you would like to delete the selected address from your address book?');

define('NEW_ADDRESS_TITLE', 'New Address Book Entry');

define('SELECTED_ADDRESS', 'Selected Address');
define('SET_AS_PRIMARY', 'Set as primary address.');

define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'The selected address has been successfully removed from your address book.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Your address book has been successfully updated.');

define('WARNING_PRIMARY_ADDRESS_DELETION', 'The primary address cannot be deleted. Please set another address as the primary address and try again.');

define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'The address book entry does not exist.');
define('ERROR_ADDRESS_BOOK_FULL', 'Your address book is full. Please delete an unneeded address to save a new one.');
?>
