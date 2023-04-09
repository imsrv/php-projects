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
if (!isset($loginerror)) $loginerror="";
session_start();
unset($_SESSION['md5_pass']);
unset($username);
unset($md5_pass);
session_destroy();
?>
<script language="JavaScript"><!--
url2open="index.php?loginerror=<? echo urlencode($loginerror); ?>";
document.location=url2open;
// --></script>

<p><a href="index.php?loginerror=<? echo urlencode($loginerror); ?>">Click here if not auto forwarding.</a></p>