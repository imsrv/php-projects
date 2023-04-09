<?php
###############################################################################
# 452 Productions Internet Group (http://452productions.com)
# 452 Multi-MAIL  v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001  452 Productions
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
#    Or just download it http://fsf.org/
################################################################################
require("config.inc.php");
if($dump_addys){
$result_print = mysql_query("SELECT * FROM mail_list",$db);

if($result_print) {
	while ($myrow = mysql_fetch_array($result_print)) {
		 $lists = explode(" ", $myrow[lists]);
		 for($i=0;$i<sizeof($lists);$i++){
		 	$result_list = mysql_query("SELECT * FROM lists WHERE id=$lists[$i]",$db);
			$myrowList = mysql_fetch_array($result_list);
		 	$string .= $myrowList["list_name"] . ", ";
			$vals .= "'1', ";
		}
		$string = substr($string, 0, -2);
		$vals = substr($vals, 0, -2);
     printf("\"INSERT INTO mail_list (email, $string) VALUES ('%s', $vals)\"<br>", $myrow["email"]);            
 }
}
$result = mysql_query("DROP TABLE mail_list");
$result2 = mysql_query("DROP TABLE lists");
$result3 = mysql_query("DROP TABLE mail_sent");
$result4 = mysql_query("DROP TABLE muser");

if($result && $result2 && $result3 && $result4) {
	echo"Done! Upload the new files and run the install script.<br><br>";
  if($result_print) {
	echo"Paste the stuff above in here <b>after</b> running the install program<br><br>";
	echo"<form action=\"$PHP_SELF\" method=\"post\"><textarea name=\"sql\"></textarea><br><input type=\"submit\" name=\"submit\" value=\" Go!\"></form>";          
 }
} else {
    echo mysql_error();
}
} elseif($submit){
	$result = mysql_query($sql,$db) or die("Eep! I can't do that! ".mysql_error());
	if($result){
		echo"Looks like it worked. You're all set and updated.";
	}
} else {
	echo"Step one: Press the button below to dump&drop your databases. If you have a large number of people we suggest you save a manual dump before running this script. Once you hit the button below, there's no going back without a backup.<br>";
	echo"<form action=\"$PHP_SELF\" method=\"post\"><input type=\"submit\" name=\"dump_addys\" value=\"Dump\"><br><br>";
	echo"Step two: Paste what was printed out into the box below, after running install.<br><br>";
	echo"<form action=\"$PHP_SELF\" method=\"post\"><textarea name=\"sql\"></textarea><br><input type=\"submit\" name=\"submit\" value=\" Go!\"></form>";
}

?>
