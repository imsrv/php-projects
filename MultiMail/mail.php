<?php
###############################################################################
# 452 Productions Internet Group (http://452productions.com)
# 452 Multi-MAIL v1.6 BETA
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
#    Or just download it http://fsf.org/
###############################################################################
require("config.inc.php");
require("functions.php");
require("default_lang.inc.php");
################################################################################
# Or die()'s have replaced the if($result)' checkers for this section
################################################################################
# This can be bit confusing. Adding removing or changing have two steps
# The first the information is gathered and sent to the user for verificaion
# the second the user verifies and the changes are commited.
#This is the first step of the delting process
if($header_path != ""){
	include($header_path);
}
if($submit) {
	if (check_email_addy($Email) == "0") { # its not a valid address
      echo "<p> $msg_realemail $call_admin</a></p>";
	} else {
 		switch($action){
 			case ("remove"):
			$sql = "SELECT * FROM mail_list WHERE email='$Email'";
			$result = mysql_query($sql, $db);
			$myrow = mysql_fetch_array($result);
			$email_id = $myrow["id"];
			$exist = $myrow["email"];
			if($exist == $Email) { 
				# how was that for some craped up code? :) 
				$remove = "http://" . $base .  $PHP_SELF . "?a=d&v=" . $email_id . "&e=" . $Email; 
				$Subject = $msg_goodbye;
				$Body = stripslashes($msg_byebody . " " . $Email . " " . $msg_byebody2 . "\n" . $remove);
									  
				mail("$Email","$Subject","$Body","From:$nice_mail\nReply-To: $mail_admin");
				echo"<p>$msg_checkfurther</p>";
			}else {
				echo"<p>$Email $msg_notinlist $call_admin"; #Email's not in the list, can't delete it
			}
		break;
# This is the first step of the adding process
		case("add"): 
		 	$sql = "SELECT * FROM lists ORDER BY id DESC";
		  $result = mysql_query($sql, $db);
			while ($myrow = mysql_fetch_array($result)) {
				$id = $myrow["id"];
		 		$var = $myrow["list_name"];
		 		$var2 = ereg_replace( " ", '_', $var);
				reset ($HTTP_POST_VARS);
				if($HTTP_POST_VARS[$var2] == "send"){
					$list_to_post .= $id . "+";
					$new_list_names .= $var . ", ";
					# Only one welcome can be sent, so this doesn't matter.
					# This reasons that the first list you create will be your most 
					# popular, so the list with the smallest ID (Created first) will be
					# the one that gets it's footer sent with mailings that go to multiple
					# lists.
					$welcome = mysql_query("SELECT welcome FROM lists WHERE id='$id'");
					$welcome = mysql_fetch_array($welcome);
					$welcome = $welcome["welcome"];
				}
			}
			if($list_to_post == "") {
				echo"$msg_need_list";
				exit;
			} else {
				$list_to_post = substr($list_to_post, "0", "-1");
				$url = "http://" . $base . $PHP_SELF . "?a=w&e=" . $Email . "&l=" . $list_to_post; 
				$Body = stripslashes($welcome . "\r\n" . $msg_to_confirm . "\r\n" . $url);
				if(check_user($Email)){
				   	echo"<p>$msg_checkfurther</p>";
						mail("$Email","$msg_subjConf","$Body","From:$nice_mail\nReply-To: $mail_admin");
				}
				else {
						echo"<p>$msg_oops $call_admin</p>";	
				}
			}
		break;
# First step of the change process
		case("change"):
			$sql = "SELECT * FROM mail_list WHERE email='$Email'";
			$result = mysql_query($sql, $db);
			$myrow = mysql_fetch_array($result);
			$email_id = $myrow["id"];
			if ($result) {
				$old_list_name = $myrow["list_name"];
				$sql1 = "SELECT * FROM lists";
				$result1 = mysql_query($sql1, $db);
				while ($myrow1 = mysql_fetch_array($result1)) {
					$var = $myrow1["list_name"];
					$id = $myrow1["id"];
					reset ($HTTP_POST_VARS);
					if($HTTP_POST_VARS[$var] == "send"){
						$list_to_post .= $id . "+";
						$new_list_names .= $var . ", ";
					}
				}
				if($list_to_post == "") {
				echo"$msg_need_list";
				exit;
			} else {
				$new_list_names = substr($new_list_names, "0", "-2");
				$new_list_names = ereg_replace("_", " ", $new_list_names);
				$list_to_post = substr($list_to_post, "0", "-1");
				$url = "http://" . $base . $PHP_SELF . "?a=u&v=" . $email_id . "&l=" . $list_to_post . "&e=" . $Email;
				$message = $msg_changebody1 . $new_list_names . $msg_changebody2 . $url . $msg_changebody3 .  $REMOTE_ADDR  . "(" . $REMOTE_HOST . " - " . $HTTP_USER_AGENT . ")" . $msg_changebody4;
				mail("$Email","$msg_subjChanges","$message","From:$nice_mail\nReply-To: $mail_admin");
				echo"<p>$msg_checkfurther</p>";
			}
			}
			break;
		}
	}
} else {
	switch($a) {
# This is the second step of the delting process
	case("d" ):
				$sql = "SELECT * FROM mail_list WHERE id=$v";
				$result = mysql_query($sql, $db);
				if ($result) {
					$myrow = mysql_fetch_array($result);
					$addy = $myrow["email"];
					 if ($addy == $e) {
								$sql = "DELETE FROM mail_list WHERE id=$v";
		   					$result = mysql_query($sql, $db);
		   					if($result) {
		   			   				   			 echo"<p>$msg_emailremoved</p>";
		  					}else {
		  		 								  echo"<p>$msg_emailnotfound $call_admin";
						    }
						} else {
							echo"<p>$msg_nomatch $call_admin</p>";
					} 
				} else {
						echo"<p>$msg_notfound $call_admin</p>";
				}
		break;
#Second step of add process
	case("w"): 
		if(add_user_email($e, $l)) {
			echo"<p>$msg_emailadded </p>";
		}else {
			echo"<p>$msg_emailexists </p>";
		}
		break;
# Second step of change process
case("u"): 
	# zero's out the list subscriptoins then adds only the ones that were in the change subscription
				$result = mysql_query("SELECT * FROM mail_list WHERE id='$v'", $db);
				if (mysql_num_rows($result) == 1) {
				$myrow = mysql_fetch_array($result);
				$addy = $myrow["email"];
					 if ($addy == $e) {
					 		$lists = explode(" ", $l);
							$result = mysql_query("SELECT * FROM lists") or die("I need more power capt'n! " . mysql_error());
							$num = sizeof($lists);
							while($temprow1 = mysql_fetch_array($result)){
								$string .= $temprow1[list_name] . "='0', ";
							}
							$string = substr($string, 0, -2);
							$result = mysql_query("UPDATE mail_list SET $string WHERE id='$v'", $db) or die("Dulce et decorum est. " . mysql_error());
							$string = "";
							/*
							$fields = mysql_list_fields($dbName, "lists");
							$columns = mysql_num_fields($fields);
							for ($i = 0; $i < $columns; $i++) {
  							echo mysql_field_name($fields, $i) . "<br>\n";;
							}
      				*/
							$result = mysql_query("SELECT * FROM lists") or die("Noooo! Not the purple turkey, anything but the purple turkey! " . mysql_error());
							while($temprow = mysql_fetch_array($result)){
								for($i=0;$i<$num;$i++){
									if($lists[$i] == $temprow[id]){
										$string .= $temprow[list_name] . "='1', ";
									}
								}
							}
							$string = substr($string, 0, -2);
							$result = mysql_query("UPDATE mail_list SET $string WHERE id='$v'", $db) or die("My only regret is that I have but one process to give for my webserver. " . mysql_error());
							echo"<p>$msg_updated</p>";
						}else {
							echo"<p>$msg_nomatch $call_admin</p>";
						}
					}else{
								echo"<p>$msg_notfound $call_admin</p>";
				  }		
		break;
default:
# if we wern't asked to do anything then we need to get somthing to do
?> 
<h3><?php  echo $msg_header; ?></h3>
<form method="post" action="<?php echo "$PHP_SELF"; ?>">
<table>
<tr>
       <td><?php  echo $msg_emailaddress; ?></td>
	   <td><input type="text" name="Email"></td>
</tr>
<tr>
	   <td><?php  echo $msg_addme; ?></td>
	   <td><input type="radio" checked name="action" value="add"></td>
</tr>
<tr>
	   <td><?php  echo $msg_removeme; ?></td>
	   <td><input type="radio" name="action" value="remove"></td>
<tr>
<?php
		# Print current lists
		$result = mysql_query("SELECT * FROM lists",$db);
		$num = mysql_num_rows($result); 
		if ($num == "1") {
			 $myrow = mysql_fetch_array($result);
			 printf("<input type=\"hidden\" name=\"%s\" value=\"send\">", $default_list);
		}elseif($num == "0") {
					echo"<p><b>$msg_no_lists_exist</b></p>";
		}else{
?>
			<tr>
				<td><?php print $msg_change; ?></td>
				<td><input type="radio" name="action" value="change">
			</tr>
			<tr>
				<td colspan="2"><?php echo $msg_instruct; ?></td>
			</tr>
			<tr>
				<td colspan="2">
<?php
					while ($myrow = mysql_fetch_array($result)) {
								$list_name = ereg_replace("_"," ",$myrow["list_name"]);
								$description = ereg_replace("\\\\","",$myrow["description"]);
								printf("%s <input type=\"checkbox\" name=\"%s\" value=\"send\"><br>%s<br><br>", $list_name, $list_name, $description);
					}
					echo"</td></tr>";
		}
		?><tr>
	   <td colspan="2"><input type="submit" value="Go!" name="submit"></td>
		</tr>
</table>
</form>
<?php
}
#fin
}
if($footer_path != ""){
	include($footer_path);
}
?>