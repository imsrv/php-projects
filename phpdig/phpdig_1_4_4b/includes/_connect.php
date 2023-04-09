<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/
//connection to the MySql server
$id_connect = @mysql_connect ("<host>","<user>","<pass>");
//here the name of your database where are phpdig tables
$database = "<database>";
@mysql_select_db($database,$id_connect);
?>