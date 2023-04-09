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
if (isset($save))
{
 $update_query = "
  UPDATE pama_members
    SET companyname='$companyname',
        name='$name',
        address='$address',
        email='$email',
        tel='$tel',
        postcode='$postcode'
 WHERE their_username='".$_SESSION['username']."' AND their_password='".$_SESSION['md5_pass']."'";
 $result = mysql_query($update_query);
 db_close();
 header("Location: get_details.php");
 exit;
}
$result=mysql_query("SELECT * FROM pama_members WHERE their_username='".$_SESSION['username']."' AND their_password='".$_SESSION['md5_pass']."'");
$row = mysql_fetch_array($result);
db_close();
$logged_in="<small><small><font color=\"#008000\"><b>::You are logged in::</b></font>
            &nbsp; &nbsp; &nbsp;<a href=\"logoff.php\">Log off</a><br>
            <a href=\"modify.php\">Modify personal details</a></small></b></small></small>";
include("header.html");
include("modify.html"); // for quotes .... $str = str_replace("\'", "''", $str);
include("footer.html");
?>