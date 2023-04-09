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
$admin_md5_pass = clean_input($HTTP_POST_VARS['admin_password']);
pama_authenticate( clean_input($HTTP_POST_VARS['admin_username']),
                   $admin_md5_pass,
                   "admin",1);
session_start();
session_register("admin_username");
session_register("admin_md5_pass");

SetCookie("logged-in", "at", time()+600);// currently not used!
        // Included to ensure get_details.php is not called before session is set.

header("Location: get_details.php");
?>
