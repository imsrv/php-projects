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
################################################################################
require("config.inc.php");

#don't translate these first two lines
$call_admin = $msg_emailadmin  . " <a href=\"mailto:" . $mail_admin . "?subject=" . $msg_subjHelp . "\">" .$msg_emailadmin2;
$nice_mail = $mail_admin_alias . " <" . $mail_admin . ">";

#mail admin strings
$return_to_main = "Return to main";
$delete_query_success = "Your delete query was successful.";
$delete_query_failure = "Your delete query was not successful. It is likely that you have tried to delete an item that does not exist. If this error persists, contact the admin.";
$delete_email_warning = "To remove a user from your list, click on 'DELETE'. There is NO undo, and NO confirmation is sent to the user. They just disapear.";
$show_which_addys1 = "You have";
$show_which_addys2 = "people on your list. Please select which ones you would like to view, or show all to see them all";
$explain_which_addys = "You have chosen to display users";
$explain_which_addys2 = "thru";
$explain_which_addys3 = "out of"; 
$explain_which_addys4 = "total users";
$need_list = "You have not created any lists. You need to create a list before people can join";
$msgist_with_none = "You have";
$msgist_with_none2 = "lists with no one on any of them";
$msgist_with_some = "You have";
$msgist_with_some2 = "lists with";
$msgist_with_some3 = "people signed up.";
$msgist_with_some4 = "View breakdown";
$no_archives = "You have no mailings in your archive";
$some_archives = "You have"; 
$some_archives2 =  "sent mailings in your archive. (All users combined)";
$mail_archive_header = "Mailing list archives";
$delete_lang = "DELETE";
$which_list = "Working with list";
$select_your_list = "There are";
$select_your_list2 = "archived mailing for this list. Please select which ones you would like to view, or show all to see them all";
$disply_out_of = "You have chosen to display items";
$disply_out_of2 = "thru"; 
$disply_out_of3 = "out of";
$disply_out_of4 = "total items.";
$fill_fields = "You must fill in all the fields!";
$send_failure = "Your mesage was not sent";
$no_list_selcted = "You did not select a list(s) to send this message to!";
$archive_done = "Mail archived!";
$sending_mail = "Sending mail...This may take a minute if you have a large number of people on your list.";
$send_sucess = "Your message has been sent!";
$socket_crash = "Big problem, I couldn't connect to the socket. No mail was sent. $errstr ($errno)";
$go_away = "Only authorized users may visit. Bye.";
$user_added = "User";
$user_added2 = "has been added";
$user_exists = "A user by that name already exists. I can't create this new user.";
$who_allowed = "The following users have access to your mail system.";
$edit_user_privs = "Edit privliges";
$no_users = "No users have been added";
$user_adding = "Add user";
$u_name = "Username";
$p_word = "Password";
$msg_new_mail = "New mail";
$msg_subject = "Subject";
$msg_no_lists_exist = "No lists have been created yet";
$msg_send_to = "This message will be sent to list ";
$msg_which_list_send = "Which lists would you like to send this message to?";
$msg_user_gone = "User"; 
$msg_user_gone2 = "is gone.";
$msg_user_not_exist = "User";  
$msg_user_not_exist2 = "does not exist, I can't get rid of him/her!";
$msg_new_list = "List added";
$msg_list_exists = "List already exists!";
$msg_list_gone = "List removed";
$msg_list_exists_no = "List does not exist!";
$msg_user_changed = "User access changed";
$msg_user_privs = "User priviliges";
$msg_user_working = "Working with user";
$msg_config_updated = "Configuration data saved";
$msg_mail_admin = "Mail admin";
$msg_welcome = "Welcome to your mailing list admin. You are logged in as admin.";
$msg_send = "Send mail";
$msg_user_edit = "Add/remove/edit user";
$msg_browse = "Broswe/delete past mailings";
$msg_delete = "Add/delete lists";
$msg_configure = "Configure script";
$msg_view = "View adresses on list";
$msg_welcome_non = "Welcome to the mailing list admin.";
$msg_add = "Add list";
$msg_pop = "Check received removal replies";
$msg_remove = "To remove yourself or change your subscription, please visit ";
$msg_remove2 =" or reply to this message with the subject of 'unsubscribe' (No Re:)";
$msg_logout = "Log out";
$msg_logout_complete = "You have been logged out";
$msg_bad_login = "Bad Login";
$msg_bad_login_info = "Please ensure you have access to this system. Make sure you have cookies enabled. If you are having difficulty you may contact $mail_admin.";
$msg_no_access = "Unauthorized access prohibited";

#archive strings
$msg_archive_explain = "There are";
$msg_archive_explain2 = "archived mailing for this list. Please select which ones you would like to view, or show all to see them all";

#mail strings
$msg_realemail = "Could we try a real email address? You know, one of those ones that work and all.";
$msg_emailadmin = "If you keep having problems,";
$msg_emailadmin2 = "contact the admin";
$msg_subjHelp = "Help!";
$msg_goodbye = "Goodbye!";
$msg_byebody = "We received a request to remove";
$msg_byebody2 = "from our mailing list. We're sad to see you go, and hope that you enjoyed your stay with us. To complete the process you just need to visit the link below and you will be removed! This helps us to make sure that no one tampers with your account without your knowledge.\n\nOnce again, sorry to see you go, we hope you'll think of us again in the future.";
$msg_checkfurther = "Your request has been sent.\n\nPlease check your mail box for further instructions on how to complete the process.";
$msg_notinlist = "does not appear to be in our mailing list. Therefore It can't be removed from the list.";
$msg_toconfirm = "To confirm click below.";
$msg_subjConf = "Mailing List confirmation";
$msg_subjChanges = "Mailing List Changes";
$msg_oops = "Oops! Looks like someone else has already signed up that e-mail adress. Did you want to change your subscriptions? If so click that option. ";
$msg_changebody1 = "We received a request to modify your subscription to our mailing lists.\n\nWe have received a request to send you mail for the following lists:\n";
$msg_changebody2 = "\n\nIf you want to make these changes click on the link below, or paste it into your adress bar.\n";
$msg_changebody3 = "\n\nIf you didn't request changes to be made to your subscription then don't click and no changes will be made. In that case some trickster at ";
$msg_changebody4 = "made this request.\n\n";
$msg_emailremoved = "Your e-mail adress has been removed from the mailing list.";
$msg_emailnotfound = "Sorry, but your confirmation code  wasn't found in our database. Try re-submitting your request, and make sure that the url that was sent to you is complete and unchanged. Maybe you had already confirmed the removal and you are not suscribed.";
$msg_emailadded = "Thank you for confirming your subscription(s). You've been succesfully added!";
$msg_emailexists = "Your email address is already registered.<br>To change your subscriptions use the option change subscription option";
$msg_updated = "Subscription updated";
$msg_nomatch = "Sorry, but your codes did not match. Try re-submitting your request, and not messing with the url that is sent to you.";
$msg_notfound = "Sorry, but I've never heard of you before. You need to sign up before you may edit lists.";
$msg_header = "Mailing List";
$msg_emailaddress = "Enter your email address";
$msg_addme = "Subscribe Me";
$msg_removeme = "Cancel my subscription(s)";
$msg_change = "Change my subscription(s)";
$msg_instruct = "If you've selected remove me you can just hit Go now.<br><br>Select the mailings you'd wish to receive (keep receiving).";
$msg_need_list = "You did not select any lists. If you wish to remove yourself please use the remove option.";

#front strigns
$msg_signup = "Add yourself to our mailing list and we'll keep you informed about changes to our sites and other news you may be interested in.";
?>
