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
include_once("constants.inc.php");
session_start();
if (isset($_SESSION['md5_pass'])) pama_authenticate($_SESSION['username'],$_SESSION['md5_pass'],"members",0);
else
{
 js_msg("Error, please re-login.");
 include("logoff.php");
 exit;
}
$image = ImageCreateFromJPEG($image_file);
Header("Content-type: image/jpeg");
ImageJPEG($image);
ImageDestroy($image);
die();
?>