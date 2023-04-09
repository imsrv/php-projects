<?php
###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
# 452 Multi-MAIL  v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001 452 Productions
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
require("config.inc.php");
require("functions.php");
include($header_path);

if ($id) {
# If we have an id display te archived item
   		$sql = "SELECT * FROM mail_sent WHERE id=$id";
	    $result = mysql_query($sql, $db);
		  $myrow = mysql_fetch_array($result);
    	$subject = $myrow["subject"];
    	$date = $myrow["date"];
    	$mail = $myrow["mail"];
		echo"<h3>Mail Archive</h3>";
		echo"<p>$subject<br>$date<br><br>$mail</p>";
}elseif ($show_list) {
		 $result_count = mysql_query( "SELECT Count(*) as total_items FROM mail_sent") or die(mysql_error()); 
     $how_many=mysql_fetch_Array($result_count); 
     $total_items=$how_many[total_items];
		 echo"<h3>Mailing list archives</h3><p>Archived mailings for list $show_list</p>";
		 echo"<table>";
		 print_archived_mail();
		 echo"</table>";
		 echo"<br><a href=\"$PHP_SELF\">Return to main</a>";
}else {
# other wise let them select it
echo"<h3>Mailing list archives</h3>";
$result = mysql_query("SELECT * FROM lists",$db);
while ($myrow = mysql_fetch_array($result)) {
		 	   printf("<a href=\"%s?show_list=%s\">%s</a><br> \n", $PHP_SELF, $myrow["list_name"], $myrow["list_name"]);
		 }
}
include($footer_path);
#fin
?>