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
include_once("constants.inc.php");
session_start();
if (isset($_SESSION['md5_pass'])) pama_authenticate($_SESSION['username'],$_SESSION['md5_pass'],"members",0);
else
{
 js_msg("Error, please re-login.");
 include("logoff.php");
 exit;
}
$logged_in="<small><small><font color=\"#008000\"><b>::You are logged in::</b></font>
            &nbsp; &nbsp; &nbsp;<a href=\"logoff.php\">Log off</a><br>
            <a href=\"modify.php\">Modify personal details</a></small></b></small></small>";
include("header.html");
include(MENU_TYPE);
if (!isset($HTTP_POST_VARS['the_page'])) include(SECURE_FOLDER_NAME.INITIAL_PAGE);
else include(SECURE_FOLDER_NAME.$HTTP_POST_VARS['the_page']);

include("footer.html");
?>