<?php
###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
# 452 Multi-MAIL v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000-2002 452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://www.fsf.org/
###############################################################################
# This is _not_ a complete config file. Once installed, you should click
# the configure script option on the admin page and fill in the correct
# values and hit save to generate a complete config file.

$dbName = "website";
$dbPass = "pass";
$dbUserName = "r00t";
$host = "localhost";
$base = "yoursite.com";
$smtp_server = "mail.yoursite.com";
$pop_server = "mail.yoursite.com";
$pop_user = "you";
$pop_pass = "pass";
$use_pop = "";
$db = mysql_connect($host, $dbUserName, $dbPass) or die ("Could not connect");
mysql_select_db($dbName,$db);
$today = gmdate ( "M d Y H:i:s" ); #This affecs how your date is displayed www.php.net/date for more info
 #User vars
$admin_user = "r00t";
$admin_pass = "password";
$mail_admin = "you@you.com";
$mail_admin_alias = "Mailing List";
$auto_cutting = "30";
$header_path = "header.php";
$footer_path = "footer.php";

?>
