<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
define('INITIAL_PAGE', 'home.html');//the first page displayed on successful login
define('SECURE_FOLDER_NAME', 'content/');//the name of the secure folder, include slash on end

//define('MENU_TYPE', 'menu-type-standard.php');//links appear as standard links accross top of page
define('MENU_TYPE', 'menu-type-dropdown.php');//links appear in drop down box in center top of page

define('MAIN_MENU_TEXT', '<small><b>Main Menu:</b></small>');//text that appears next to dropdown menu box


?>
