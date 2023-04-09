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
include_once("functions.php");
include_once($installed_config_file);
db_connect();
$query="delete from phpAutoMembersArea where id=$id";
$result = mysql_query($query);
if (!$result) js_msg("There has been an error: ".mysql_error());
else js_msg("Job deleted");
db_close();

include("index.php");
?>