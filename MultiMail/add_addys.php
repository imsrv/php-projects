<?php
###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
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
#    Or just download it http://www.fsf.org/
###############################################################################
# Add users to list
require("config.inc.php");
require("functions.php");
$i=0;
if ($add_folks) {
	 $sql = "SELECT * FROM lists";
		    $result = mysql_query($sql, $db);
				while ($myrow = mysql_fetch_array($result)) {
					$id = $myrow["id"];
					$var = ereg_replace( " ", '_', $myrow["list_name"]);
					reset ($HTTP_POST_VARS);
					if($HTTP_POST_VARS[$var] == "send"){
						$lists .= $id . " ";
					}
				}
	 $new_addys = "\n" . $new_addys;
	 $email_array = explode("\n",$new_addys);
	 reset($email_array);
	  while (next($email_array)) {
					$addy = trim($email_array[key($email_array)]);
					if (check_email_addy($addy)) {
					  if (check_user($addy)) {
						 if(add_user_email($addy, $lists)) {
						 			$i++;
							}
						}else{
									echo"$addy is already on the list<br>";
						}
					} else {
						 echo"$addy is in invalid e-mail<br>";
					}
		}
		echo"<p>$i addresses added.</p>";
		echo"<br><a href=\"$PHP_SELF\">Return to main</a>"; 

} else {
	?>
<html>
<head>
<title>452 Productions Multi-MAIL Add address script</title>
</head>
<body>
<h3>Add addresses</h3>
<p>This companion script allows you to transfer an older list of emails to the 452 Multi-MAIL system. Simply take your old mailing list and paste it into the box below. <b>One email adress per line</b>. This is provided as a convience feature. <b>You may not use this script to place the names of people who do not wish to recive mailings from you onto your list</b>. If you do:<ol>
<li>You're stupid, mail sent with Multi-MAIL is very eaisly traced back to <i>your</i> web server</li>
<li>You're stupid, no one actually reads those spam messages</li>
<li>You're stupid, your violating the 452 user agreement (Which will be written at some indefinte point in the future) because we say you can't use this script for spam purposes. Any attempt to do so constitutes a violation of the end user lisence aggreement. By doing so you risk us finding out and sending a large army of purple wombats armed with nerf guns to pummel you as you walk out side to get your newspaper.</li>
<li>If still do it, well, lets just not go there, and you thought purple wombats were scary, hope you know a good astrophysist.</li>
</ol>
Have fun!</p>
<form action="<?php echo $PHP_SELF; ?>" method="post">
<textarea name="new_addys" cols="40" rows="5"></textarea>
<table>
<?php
		$result = mysql_query("SELECT * FROM lists",$db);
		$num = mysql_num_rows($result); 
		if ($num == "1") {
			 $myrow = mysql_fetch_array($result);
			 printf("<input type=\"hidden\" name=\"%s\" value=\"send\">", $myrow["list_name"]);
		}elseif($num == "0") {
					echo"<p><b>No lists have been created</b> You need to create a list before you add people</p>";
		}else{
					echo"<tr>";
	   			echo"<td colspan=\"2\">Which list(s) should these people get?</td>";
					echo"</tr>";
					echo"<tr><td>";
					while ($myrow = mysql_fetch_array($result)) {
								printf("%s <input type=\"checkbox\" name=\"%s\" value=\"send\"><br>", $myrow["list_name"], $myrow["list_name"]);
					}
					echo"</td></tr>";
		}
?>
</table>
<input type="submit" name="add_folks" value="Add 'em">
</form>
<?php
}
?>
	 