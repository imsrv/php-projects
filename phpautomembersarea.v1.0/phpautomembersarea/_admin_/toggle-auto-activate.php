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
include_once("../functions.php");
include_once("../".$installed_config_file);
session_start();
if (session_is_registered('admin_md5_pass')) pama_authenticate($_SESSION['admin_username'],$_SESSION['admin_md5_pass'],'admin',0);
else
{
 js_msg("Error, please re-login.  CODE: LEa0");
 include("logoff.php");
 exit;
}
if (isset($save))
{
 $update_query = "UPDATE pama_admin SET auto_activate='$autoactivate'";
 $result = mysql_query($update_query);
 db_close();
 header("Location: get_details.php");
 exit;
}
$result=mysql_query("SELECT * FROM pama_admin");
$row = mysql_fetch_array($result);
db_close();
include("toggle-auto-activate.html");
?>
<script LANGUAGE="JavaScript"><!--
document.AF.autoactivate.value=<? echo $row['auto_activate']; ?>;
// --></script>
