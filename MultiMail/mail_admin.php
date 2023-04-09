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
# Required files, if you move or re-name them be sure to change
require("config.inc.php");
require("default_lang.inc.php");
require("functions.php");
###############################################################################
// Login a user
$login_failure = 0;

if($current_new_mail_login){
	if(auth_user()){
		  SetCookie("current_login_mail_user_auth_info",$current_login_mail_user_auth_info_form,time()+864000);  
			SetCookie("current_login_mail_user",$current_login_mail_user_form,time()+864000);  	
			// Cookies don't go active till next page, so this tides over for this page load
			$current_login_mail_user_auth_info = $current_login_mail_user_auth_info_form;	
			$current_login_mail_user = $current_login_mail_user_form;			  
	} elseif(($current_login_mail_user_form == $admin_user) && ($current_login_mail_user_auth_info_form == $admin_pass)){
		  SetCookie("current_login_mail_user_auth_info",$current_login_mail_user_auth_info_form,time()+864000);  
			SetCookie("current_login_mail_user",$current_login_mail_user_form,time()+864000);
			// Cookies don't go active till next page, so this tides over for this page load
			$current_login_mail_user_auth_info = $current_login_mail_user_auth_info_form;	
			$current_login_mail_user = $current_login_mail_user_form;	
	} else {
		 	$login_failure = 1;
	}
}
// Log out a user
if($logout_user){
			SetCookie("current_login_mail_user_auth_info",$current_login_mail_user_auth_info_form,time()-864000);  
			SetCookie("current_login_mail_user",$current_login_mail_user,time()-864000);
}

if($header_path != "") {
			include($header_path);
}

if(isset($current_login_mail_user)  && isset($current_login_mail_user_auth_info) && !$logout_user){
		 if(user_is_admin()){
			echo"<h3>$msg_mail_admin</h3>";
			# See if we have any special actions to do
			if ($update_privs) {
				set_list_privs();
			}elseif($submit_mail){
				popCheckAndRemove($pop_server, $pop_user, $pop_pass);
				archive_mail();
			}elseif($add_new_list) {
				add_new_list();
			}elseif($reml) {
				remove_list();
			}elseif($submit_config){
				write_config();
			}elseif ($delete) {
				delete_item();
			}elseif($remu) {
				delete_user();
			}elseif($submit_user) {
				add_user();
			}elseif($delete_email) {
				if(delete_email($id)) { echo"$delete_query_success<br><br>"; } else { echo "$delete_query_failure<br><br>"; }
			}elseif($update_list){
				write_new_list_info($id);
			}
			# if we have an action print that section
			switch($action) {
				case("new_mail"): 
					fill_mail();
					break;
				case("user"):
					user_pan();
					break;
				case("mail_sub"):
					print_mail_list();
					break;
				case("archive_browse"):
					browse_archive();
					break;
				case("edit_privs"):
					print_privs();
					break;
				case("config"):
					configure_script();
					break;
				case("list_man"):
					print_current_lists();
					echo"<b>$msg_add</b><br><br><br>";
					echo"<form action=\"$PHP_SELF\" method=\"post\"><table><tr><td>Name:</td><td><input type=\"text\" name=\"list_name\"></td></tr><tr><td>Brief Description (<255 chars):</td><td><input type=\"text\" name=\"description\"></td></tr><tr><td>Welcome message</td><td><textarea name=\"welcome\" cols=\"40\" rows=\"7\"></textarea></td></tr><tr><td>Footer message</td><td><textarea name=\"newFooter\" cols=\"40\" rows=\"7\"></textarea></td></tr><tr><td colspan=\"2\"><input type=\"submit\" value=\"Add!\" name=\"add_new_list\"></td></tr></td></table><br></form>";
					echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
					break;
				case("edit_list_info"):
					edit_list_info($id);
					break;
				case("pop_removals"):
					popCheckAndRemove($pop_server, $pop_user, $pop_pass);
					break;
				default:
					# Otherwise, print the main list
					echo"<table align=\"left\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">";
					echo"<tr><td>$msg_welcome</td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=new_mail\">$msg_send</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=user\">$msg_user_edit</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=archive_browse\">$msg_browse</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=list_man\">$msg_delete</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=config\">$msg_configure</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=mail_sub\">$msg_view</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?logout_user=1\">$msg_logout</a></td></tr>";
					echo"<tr><td><a href=\"$PHP_SELF?action=pop_removals&return_link=true\">$msg_pop</a> May take up to 40 seconds for page to load.</td></tr>";
					echo"<tr><td>";
					print_total_email();
					echo"</td></tr><tr><td>";
					print_total_sends();
					echo"</td></tr></table>";
			}
			# If not the admin, see if it's some one we want to allow 
		}elseif(user_is_sub($current_login_mail_user, $current_login_mail_user_auth_info)){
			echo"<h3>$msg_mail_admin</h3>";
			# Non-admins can only send mail
			if($submit_mail) {
				popCheckAndRemove($pop_server, $pop_user, $pop_pass);
				archive_mail();
			}
			if($action == "new_mail"){
				fill_mail();
			}else{
				# Print the mail memnu
				echo"<table align=\"left\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">";
				echo"<tr><td>$msg_welcome_non</td></tr>";
				echo"<tr><td><a href=\"$PHP_SELF?action=new_mail\">$msg_send</a></td></tr>";
				echo"<tr><td><a href=\"$PHP_SELF?logout_user=1\">$msg_logout</a></td></tr></table>";
			}
		}else{
			echo"This message should not be displayed. An error has occured.";
		}

} else {
 ?>
 <center>
<table corder="0" cellspacing="0" cellpadding="10">
	<tr>
			 <td width="20" bgcolor="#ffffff"><br></td>
			 <td width="550" align="left" valign="bottom">
			 		 <br><br><blockquote><b>Mail List Administration</b>
					 <center>
					 <br>
					 <?php
					 if($logout_user) { 
					 					echo"<b>$msg_logout_complete</b><br>"; 
					 } elseif($login_failure) {  
					 	 				echo"<center><b><font color=\"#ff0000\">$msg_bad_login</font><br>$msg_bad_login_info</center>";
					 } else {?>
					 <font color="#ff0000"><b><?php echo $msg_no_access; ?><b></font><br>
					 <?php } ?>
					 <form action="<?php echo $PHP_SELF; ?>" method="post">
					 <table border="0">
					 		<tr>
									<td align="right" valign="bottom">
			 								<b><?php echo $u_name;  ?>: </b><input type="text" name="current_login_mail_user_form" size="20"><br>
			 								<b><?php echo $p_word;  ?>: </b><input type="password" name="current_login_mail_user_auth_info_form" size="20">
									</td>
									<td align="center" valign="bottom">
			 								<table border="0" cellspacing="0" cellpadding="1" bgcolor="#ffffff">
			 	 									<tr>
			 	 											<td><input type="submit" name="current_new_mail_login" value="Login"></td>
				 									</tr>
			 								</table>
									</td>
							</tr>
					</table>
					</from>
					</center>
					</blockquote>
			</td>
	</tr>
</table>
<font size="1"><b>452 Productions Multi-Mail Version <?php echo $scriptVersion; ?></b><br><a href="http://www.452productions.com">452productions.com</a></font>
</center>
<?php
}
if($footer_path != "" ) {
	include($footer_path);
}
?>
