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
include("../functions.php");
include_once("../".$installed_config_file);
session_start();
if (session_is_registered('admin_md5_pass')) pama_authenticate($_SESSION['admin_username'],$_SESSION['admin_md5_pass'],'admin',0);
else
{
 js_msg("Error, please re-login.  CODE: LEa0");
 include("logoff.php");
 exit;
}
$logged_in="<b><small><small><font color=\"#008000\">:: You are logged in ::</font>
            <br></small><a href=\"logoff.php\">Log off</a><br><br>
            <a href=\"get_details.php\">Main Menu</a></small></b>";
$page_title="Admin area ";
include("header.html");
if (!isset($HTTP_POST_VARS['the_page'])) include("main_menu.html");
else include($HTTP_POST_VARS['the_page']);
include_once("footer.html");
?>