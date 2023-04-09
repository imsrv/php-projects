<?php
###############################################################################
# 452 Productions Internet Group (http://452productions.com)
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
#    Or just download it http://fsf.org/
################################################################################
# By popular request, all functions, for all portions of the script have been 
# centrilized here. If somthing is not working, this is where you want to be. 
# Functions are grouped by the files which call them. Within each file block 
# the functions are grouped in the order they were added to the script, rouhgly 
# implying order of importance.
################################################################################
require("default_lang.inc.php");
require("config.inc.php");
################################################################################
$scriptVersion = "1.6.3b";
# Just cause it's a v1.x dosen't imply anything.
################################################################################
# Things to do:
# bounced e-mails - need a stronger check at sign up, like check mx records
# along with making sure the e-mail is sytaticly correct. Also, some sort
# of bounced or dead address recevier and cleaner upper. Could do at send,
# or let the message bounce.
# Still acts fuggly on some systems, especialy the delete, no clue why
# Added in some memory managment, sockets seem to be leaking mem, need to play
# with sockets set to non-blocking mode.
# POP functions are reallllly messed.
################################################################################
# Functions for use in mail.php and front.php
# popcheckandremove() also has a tendancy to play with these.
################################################################################
# add an e-mail address with approrate lists
function get_list_name($id){
	$result = mysql_query("SELECT list_name FROM lists WHERE id='$id'") or die(mysql_error());
	if(mysql_num_rows($result) == 1){
		$myrow = mysql_fetch_array($result);
		return $myrow[list_name];
	}
	@mysql_free_result($result);
}
function add_user_email($Email, $lists) {
	global $dbPass, $dbUserName, $host, $dbname, $today, $db, $PHP_SELF, $user_exists, $default_list;
	if($lists == "") {
		$lists = $default_list;
	}
	$result = mysql_query("SELECT * FROM mail_list WHERE email='$Email'", $db) or die(mysql_error());
	$num = sizeof($lists);
	if(mysql_num_rows($result) != 1){
		for($i=0;$i<$num;$i++){
			$listFieldDescription .= get_list_name($lists[$i]) . ",";
			$listFieldValues .= "'1', ";
		}
		@mysql_free_result($result);
		$listFieldDescription = substr($listFieldDescription, 0, -1);
		$listFieldValues = substr($listFieldValues, 0, -2);
		$result1 = mysql_query("INSERT INTO mail_list (email, $listFieldDescription) VALUES ('$Email', $listFieldValues)", $db) or die(mysql_error());
		if($result1){
			return 1;
		}else {
			echo "$user_exists";
			return 0;
		}
	} else {
		echo "$user_exists";
		return 0;
	}
	@mysql_free_result($result1);
}
# returns false if the user exists, true if they don't exist
# don't ask why it's not the other way arround, legacy system support
function check_user($new_user_id) {
	global $dbPass, $dbUserName, $host, $dbname, $today, $db, $PHP_SELF;	  
	$sql = "SELECT * FROM mail_list WHERE email='$new_user_id'" or die("From the heart of hell I stabeth thee Moby Dick! " . mysql_error());
	$result = mysql_query($sql, $db);	   					   			   
	if(mysql_num_rows($result) == 1) {
		//echo"user exists<br>";
		return 0;							
	}else {
		//echo"user does not exist";
		return 1;																			
	}
	@mysql_free_result($result);
}
# regex that works pretty darn good.
# It might be smart to implement some mx record checking
# Can't decided if it'd be better to do mx checking or have smtp look for 
# invalids at sendmail time. Might end up being both, but for the moment, this
# is the security gaurd
function check_email_addy($Email) {
	#From the php mailing list
	if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $Email)) {
		return 1;
	}else{
		return 0;
	}
}
################################################################################
# Fuctions for use in archive.php
################################################################################
# Due to some pathetic logic and failure to think, these functions are
# duplicated almost line for line in the admin section. blah, fix it later.
# Non admin
function print_archived_mail(){
	global $db, $id, $PHP_SELF, $view_items, $disp_start, $disp_end, $auto_cutting;
	global $msg_archive_explain, $msg_archive_explain2, $disply_out_of;
	$result = mysql_query( "SELECT Count(*) as total_items FROM mail_sent") or die("Mundus vult decipi, ergo decipiatur. " . mysql_error()); 
	$how_many=mysql_fetch_Array($result); 
	$total_items=$how_many[total_items];
	@mysql_free_result($result);
	if($id){
		$result = mysql_query("SELECT * FROM mail_sent WHERE id=$id");
		$myrow =mysql_fetch_array($result);
		printf("%s<br>Sent on %s By %s<br><br>%s", $myrow["subject"],$myrow["date"],$myrow["user_id"],$myrow["mail"]);
		@mysql_free_result($result);
	}else {
		if(!$view_items) {
		if($total_items <= $auto_cutting) {
			$sql = "SELECT * FROM mail_sent ORDER BY date DESC";
			print_subject($sql);		 
		}else {
			echo"<p>$msg_archive_explain $total_items $msg_archive_explain2</p>";
			echo"<form method=\"post\" action=\"$PHP_SELF?action=archive_browse\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
		}
	}else{
		echo"<p>$disply_out_of</p>";
		$sql = "SELECT * FROM mail_sent LIMIT $disp_start, $disp_end ORDER BY date DESC";
		print_subject($sql);
		echo"<form method=\"post\" action=\"$PHP_SELF\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
	}
	}
}
function print_subject($sql) {
	global $db, $show_list, $PHP_SELF;
	$result = mysql_query($sql, $db);
	while ($myrow = mysql_fetch_array($result)) {
		$list_names = $myrow["list_names"];
		if (eregi($show_list, $list_names)) {
			printf("<tr><td><a href=\"%s?action=archive_browse&id=%s\">%s</a></td><td>%s</td><td>Sent by %s</td></td></tr>\n", $PHP_SELF, $myrow["id"], $myrow["subject"], $myrow["date"], $myrow["user_id"], $PHP_SELF, $myrow["id"]);
		}
	}
	@mysql_free_result($result);
}
################################################################################
# Mail admin functions
################################################################################
# Delete an e-mail adress from your database
function delete_email($id) {
	global $db;
		# delete a record
		$result1 = mysql_query("DELETE FROM mail_list WHERE id='$id'", $db) or die("I'm sorry Dave, I'm afraid I can't do that. " . mysql_error());
		if (mysql_affected_rows($result1) == 1)
		{
		 @mysql_free_result($result1);
  		 return 1;
		}
		@mysql_free_result($result1);
		return 0;
}
# Delete a past mailing
function delete_item() {
	global $delete, $id, $db, $delete_query_success, $delete_query_failure;
	if($delete){
		# delete a record
		$result1 = mysql_query("DELETE FROM mail_sent WHERE id='$id'", $db) or die($delete_query_failure . " Unable to delete! One of those bad things, namely: " . mysql_error());
		if (mysql_affected_rows($result1) == 1)
		{
		  echo"$delete_query_success";
		} else {
			echo"$delete_query_failure";
		}
		@mysql_free_result($result1);
	}
}
# Print e-mail addresses on your database
function print_mail_list() {
	global $view_email, $db, $PHP_SELF, $disp_start, $disp_end, $view_items, $auto_cutting;
	global $delete_email_warning, $delete_lang, $show_which_addys1, $show_which_addys2, $explain_which_addys, $explain_which_addys2, $explain_which_addys3, $explain_which_addys4, $return_to_main;
	$result = mysql_query( "SELECT Count(*) as total_items FROM mail_list") or die(mysql_error()); 
  $how_many=mysql_fetch_Array($result); 
  $total_items=$how_many[total_items];
  @mysql_free_result($result);
	if(!$view_items){
		if($total_items <= $auto_cutting) {
			$result_print = mysql_query("SELECT * FROM mail_list",$db);
		 	echo"$delete_email_warning<br><br> ";
		 	while ($myrow = mysql_fetch_array($result_print)) {
		 		printf("%s<a href=\"%s?id=%s&delete_email=yes\">($delete_lang)</a><br>", $myrow["email"], $PHP_SELF, $myrow["id"]);            
		  }
			@mysql_free_result($result_print);
			echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
		}else {
			echo"$show_which_addys1 $total_items $show_which_addys2<br><br>";
			echo"<form method=\"post\" action=\"$PHP_SELF?action=mail_sub\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
		 	echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";}
	}else{
		$result_print = mysql_query("SELECT * FROM mail_list LIMIT $disp_start, $disp_end",$db);
		echo"$explain_which_addys $disp_start $explain_which_addys2 $disp_end $explain_which_addys3 $total_items $explain_which_addys4<br><br>";
		echo"$delete_email_warning<br><br> ";
		while ($myrow = mysql_fetch_array($result_print)) {
			printf("%s<a href=\"%s?id=%s&delete_email=yes\">($delete_lang)</a><br>", $myrow["email"], $PHP_SELF, $myrow["id"]);
		}
		@mysql_free_result($result_print);
		echo"<form method=\"post\" action=\"$PHP_SELF?action=mail_sub\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
		echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
	}	 					
}    
# Print total number of e-mails in your database                    					 
function print_total_email() {
	global  $db, $PHP_SELF, $need_list, $msgist_with_none, $msgist_with_none2, $msgist_with_some, $msgist_with_some2, $msgist_with_some3, $msgist_with_some4;
	# Total items in data base
	$result = mysql_query( "SELECT Count(*) as total_items FROM mail_list") or die(mysql_error()); 
	$how_many=mysql_fetch_Array($result); 
	$total_items=$how_many[total_items];
	@mysql_free_result($result);
	$result_list = mysql_query( "SELECT Count(*) as total_lists FROM lists") or die(mysql_error()); 
	$how_many_lists=mysql_fetch_Array($result_list); 
	$total_lists=$how_many_lists[total_lists];
	@mysql_free_result($result_list);
	if($total_lists == "0"){
		echo"$need_list<br><br>";
	} elseif($total_items == "0"){
		echo"$msgist_with_none $total_lists $msgist_with_none2<br><br>";
	}else{
		echo"$msgist_with_some $total_lists $msgist_with_some2 $total_items $msgist_with_some3<br><a href=\"$PHP_SELF?action=list_man\">$msgist_with_some4</a><br><br>";
	}
}
# count the number of people on a given list
function count_people_on_list($id) {
	global $db;
	$i=0;
	$result = mysql_query("SELECT * FROM mail_list");
	while($myrow = mysql_fetch_array($result)) {
		if($myrow[$id] == 1){
			$i++;
		}
	}
	@mysql_free_result($result);
	return $i;
}
# Print total number of mailings sent
function print_total_sends() {
	global  $db, $no_archives, $some_archives, $some_archives2;
	# Total items in data base
	$result = mysql_query( "SELECT Count(*) as total_items FROM mail_sent") or die(mysql_error()); 
	$how_many=mysql_fetch_Array($result); 
	$total_items=$how_many[total_items];
	@mysql_free_result($result);
	if($total_items == "0"){
		echo"$no_archives<br><br>";
	}else{
		echo"$some_archives $total_items $some_archives2<br><br>";
	}
}
################################################################################
# Send mail via smtp
################################################################################
/* word_wrap($string, $cols, $prefix)
 *
 * Takes $string, and wraps it on a per-word boundary (does not clip
 * words UNLESS the word is more than $cols long), no more than $cols per
 * line. Allows for optional prefix string for each line. (Was written to
 * easily format replies to e-mails, prefixing each line with "> ".
 *
 * Copyright 1999 Dominic J. Eidson, use as you wish, but give credit
 * where credit due.
 */
function word_wrap ($string, $cols = 900, $prefix = "") {

	$t_lines = split( "\n", $string);
        $outlines = "";

	while(list(, $thisline) = each($t_lines)) {
	    if(strlen($thisline) > $cols) {

		$newline = "";
		$t_l_lines = split(" ", $thisline);

		while(list(, $thisword) = each($t_l_lines)) {
		    while((strlen($thisword) + strlen($prefix)) > $cols) {
			$cur_pos = 0;
			$outlines .= $prefix;

			for($num=0; $num < $cols-1; $num++) {
			    $outlines .= $thisword[$num];
			    $cur_pos++;
			}

			$outlines .= "\n";
			$thisword = substr($thisword, $cur_pos, (strlen($thisword)-$cur_pos));
		    }

		    if((strlen($newline) + strlen($thisword)) > $cols) {
			$outlines .= $prefix.$newline."\n";
			$newline = $thisword." ";
		    } else {
			$newline .= $thisword." ";
		    }
		}

		$outlines .= $prefix.$newline."\n";
	    } else {
		$outlines .= $prefix.$thisline."\n";
	    }
	}
	return $outlines;
}
# These three functions are adapted from the mail RFC's
# If you want them to behave differently look at RFC 821
# for the other SMTP commands you can use.
# Open the SMTP socket, only called once
function open_socket($socket, $from) {
	global $smtp_id;
	fputs($socket,"EHLO $smtp_id\r\n");
	fputs($socket,"mail from: $from\r\n"); 
}
# Write the message to the socket, called for each addy
function write_current_mail($socket, $email) {
	fputs($socket,"rcpt to: $email\r\n"); 
}
# Close the socket, ie send the message, only called once
# If the script pukes out before this point the email is _NOT_ sent
function close_socket($socket, $header, $subject, $body) {
	$body = word_wrap($body, 900); 
	fputs($socket,"data\r\n"); 
	fputs($socket,"Subject: $subject\r\n"); 
	fputs($socket,"To: $email\r\n"); 
	# html mail, done in header, just here for ref
	#fputs($socket,"MIME-Version: 1.0\r\n"); 
	#fputs($socket,"Content-Type: text/html\r\n"); 
	fputs($socket,"$header\r\n"); 
	fputs($socket,"\r\n"); 
	fputs($socket,"$body\r\n"); 
	fputs($socket,".\r\n");  
	fputs($socket, "RSET\r\n"); 
	fputs($socket, "QUIT\r\n"); 
	while(!feof($socket)){
		fgets($socket, "1024");
	}
	fclose($socket);
}
# Archive mail to database and call mail function
function archive_mail(){
	global $db, $today, $new_mail, $new_subject, $current_login_mail_user, $list_name, $HTTP_POST_VARS;
	global $fill_fields, $send_failure, $no_list_selcted, $archive_done;
	# validate fields
	if (!$new_mail || !$new_subject) {
		echo"<b>$fill_fields</b><br>$send_failure<br><br>";
	} else {
		# NO preventive mesaures
		# You better trust your admins
		# Or uncomment the below
		#$new_mail = strip_tags($new_mail, "<a>, <br>, <b>,<i>");
		#$new_subject = strip_tags($new_subject, "<a>,<b>,<i>");
		# if everything checked out go on and process
		$result = mysql_query("SELECT * FROM lists") or die(mysql_error()); 
		while ($myrow = mysql_fetch_array($result)) {
			$var = $myrow["list_name"];
			$var2 = ereg_replace(" ", "_", $var);
			reset ($HTTP_POST_VARS);
			if($HTTP_POST_VARS[$var2]){
				$list_names .= $var . ",";
			}
		}
		@mysql_free_result($result);
		if($list_name == " ") {
			echo"<b>$no_list_selcted</b><br>$send_failure<br><br>";
		}else{
		$list_name = substr($list_name, "0", "-1");
		#Uncomment if slash problems
		#$new_subject = addslashes($new_subject);
		#$new_mail = addslashes($new_mail);
		$sql = "INSERT INTO mail_sent (subject, mail, user_id, list_names, date) VALUES ('$new_subject', '$new_mail', '$current_login_mail_user', '$list_names', '$today')";
		$result = mysql_query($sql, $db);
		if (!$result) {
			echo"Error! ", mysql_error();
			@mysql_free_result($result);
			exit;
		} else {
			echo"$archive_done<br><br>";
			@mysql_free_result($result);
			flush();
			send_mail();
		}
	}
 }
}	
# Send the message to the correct people
function send_mail(){
	global $db, $new_subject, $new_mail, $HTTP_POST_VARS, $footer, $mail_admin, $smtp_server, $mail_admin_alias, $base;
	global $sending_mail, $send_sucess, $socket_crash, $mail_loc, $send_html_mail, $msg_remove;
	global $use_stmp, $use_std;
		echo"$sending_mail<br><br>";
		flush();
		$result_list = mysql_query("SELECT * FROM lists ORDER BY id DESC") or die(mysql_error());
		# This could be a for loop but convention in this script is to 
		# do this with a while
		$i = 0;
		while ($myrow = mysql_fetch_array($result_list)) {
			$var = $myrow["list_name"];
			$id = $myrow["id"];
			reset ($HTTP_POST_VARS);
			if($HTTP_POST_VARS[$var]){
				# Only one footer can be sent, so this doesn't matter.
				# This reasons that the first list you create will be your most 
				# popular, so the list with the smallest ID (Created first) will be
				# the one that gets it's footer sent with mailings that go to multiple
				# lists.
				$footer = mysql_query("SELECT footer FROM lists WHERE id='$id'");
				$lists_to_send[$i] =  get_list_name($id);
				$i++;
			}
		}
		@mysql_free_result($result_list);
		
		$myfooter = mysql_fetch_array($footer);
		@mysql_free_result($footer);
		//$result_list = mysql_query("SELECT * FROM lists") or die(mysql_error());
		$result_user = mysql_query("SELECT * FROM mail_list");
		#$new_mail .= "\r\n\r\n" . stripslashes($myfooter[footer]) . "\r\n\r\n" . stripslashes($msg_remove) . " http://" . $base . $mail_loc;
		$new_mail = stripslashes($new_mail) . "\r\n\r\n" . stripslashes($myfooter[footer]) . "\r\n\r\n" . stripslashes($msg_remove) . " http://" . $base . $mail_loc;
		if($use_pop) {
			$new_mail .= $msg_remove2;
		}
		$nice_mail = $mail_admin_alias . " <" . $mail_admin . ">";
		$header = "From: " . $nice_mail ."\r\nX-Sender: " . $mail_admin ."\r\n Reply-To: " . $mail_admin . "\r\nX-Mailer: 452-PHP 452productions.com";
		if($send_html_mail){
			$header .= "\r\nMIME-Version: 1.0\r\nContent-Type: text/html\r\n";
		}
		# Hey, it finnaly works the way it should, unlimited number of lists
		# and no regex's w00t w00t
		# Try each e-mail address
		if($use_std){
			# sissy not using sockets
			while(($myrow_send = mysql_fetch_array($result_user))) { 
			# for each address, try each list
			while (list($index, $subarray) = each($lists_to_send) ) { 
				# if the list matchs one they want to recevie send
				if($myrow_send[$subarray] == 1){
					$email = stripslashes($myrow_send["email"]);
					//echo"send $email<br>";
					mail($email, $new_subject, $new_mail, $header);
					# and we've sent one copy so we don't care about the rest, move
					# on to a different address.
					break 1;
				}
			}
		reset($lists_to_send);
		}
	} else {
		# now here's a real man (or woman, or 'it' if you live in san fransico)
		$socket = fsockopen($smtp_server, 25, $errno, $errstr);
		if ($socket) {
			open_socket($socket, $mail_admin);
			while(($myrow_send = mysql_fetch_array($result_user))) { 
				# for each address, try each list
				while (list($index, $subarray) = each($lists_to_send) ) { 
					# if the list matchs one they want to recevie send
					if($myrow_send[$subarray] == 1){
						$email = stripslashes($myrow_send["email"]);
						//echo"send $email<br>";
						write_current_mail($socket, $email);
						# and we've sent one copy so we don't care about the rest, move
						# on to a different address.
						break 1;
					}
				}
				reset($lists_to_send);
			}
			close_socket($socket, $header, $new_subject, $new_mail);
			echo"$send_sucess<br><br>";
		} else {
			echo"$socket_crash";
		}
	}	
	@mysql_free_result($result_user);
	//@mysql_free_result($result_list);
} 
################################################################################
# That's all folks, 460ish lines, and you have the functions to add, and remove
# users, send and archive mail. We've got a few thousand more lines, but
# the core is all the stuff above. Everything else is jsut details.
################################################################################
# Authorize a non-admin user
# It's important that we differntante between 'users' and 'e-mails'
# Within the context of the admin section, and especialy the next few functions
# users mean subu-admins, or even the super admin. 'e-mails' are the people on
# your list. In functions that deal mainly with e-mails, we reffer to them as 
# users, but that's mostly in mail.php. When in doubt, check wich table is being
# accessed - muser == admin - mail_list == e-mail
function auth_user() {
	global $REMOTE_HOST, $REMOTE_ADDR, $HTTP_USER_AGENT, $current_login_mail_user_form, $current_login_mail_user_auth_info_form, $today, $db, $PHP_SELF;
	//global $go_away;
	mysql_select_db($dbName,$db);
	if($current_login_mail_user_form == "" || $current_login_mail_user_auth_info_form == ""){
		return 0;
	}
	$sql = "SELECT * FROM muser WHERE user_id='$current_login_mail_user_form'";
	$result = mysql_query($sql, $db) or die(mysql_error());
	if($result) {
		$myrow = mysql_fetch_array($result);
		$pass = $myrow["user_pass"];
		if($current_login_mail_user_auth_info_form == $pass) {
		  //echo"Form: $current_login_mail_user_auth_info_form pass: $pass";
			@mysql_free_result($result);
			return 1;
		} else {
			$fp = fopen("login_failure.txt", "a+");
			fwrite($fp, "Mail admin|$REMOTE_HOST|$REMOTE_ADDR|$HTTP_USER_AGENT|$current_login_mail_user_form|$current_login_mail_user_auth_info_form|$today");
			fclose($fp);
			//echo"$go_away<br><br>";
			@mysql_free_result($result);
			return 0;
		}
	} else { 
		$fp = fopen("login_failure.txt", "a+");
		fwrite($fp, "Mail admin|$REMOTE_HOST|$REMOTE_ADDR|$HTTP_USER_AGENT|$current_login_mail_user_form|$current_login_mail_user_auth_info_form|$today");
		fclose($fp);
		//echo"$go_away<br><br>";
		@mysql_free_result($result);
		return 0;
	}
}	
function user_is_admin()
{
  global $current_login_mail_user, $admin_user, $current_login_mail_user_auth_info, $admin_pass;
  if(($current_login_mail_user == $admin_user) && ($current_login_mail_user_auth_info == $admin_pass)){
		  return 1;
  } else {
  		  return 0;
  }
}
function user_is_sub()
{
  global $current_login_mail_user, $current_login_mail_user_auth_info;
  if(auth_user()){
  				return 1;
  } else {
        return 0;
  }
}
/*
eh, done easier in mail_admin.php
function logout_user()
{
 			SetCookie("current_login_mail_user_auth_info",$current_login_mail_user_auth_info_form,time()-864000);  
			SetCookie("current_login_mail_user",$current_login_mail_user,time()-864000);
}
*/

# Add a user
function add_user() {
	global $admin_user, $user_id, $QUERY_STRING, $submit_user, $new_user_id, $new_user_pass, $db;
	global $user_added, $user_added2, $user_exists;
	if ($submit_user) {	
		if ($new_user_id != $admin){
			$sql = "SELECT * FROM muser WHERE user_id=$new_user_id";
			$result = mysql_query($sql, $db);
			if(!$result) {
				$sql = "INSERT INTO muser (user_id, user_pass) VALUES ('$new_user_id', '$new_user_pass')" or die(mysql_error());
				$result1 = mysql_query($sql, $db);
				if($result1){
					echo"<b>$user_added $new_user_id $user_added2</b><br><br>";
				}else {
					echo"<b>$user_exists</b><br><br>";
				}
			}else {
				echo"<b>$user_exists</b><br><br>";
			}
		}else {
			echo"<b>$user_exists</b><br><br>";
		}					 
	}	
	@mysql_free_result($result);
	@mysql_free_result($result1);
}
# Edit/remove users
function user_pan() {
	global $new_user_id, $new_user_pass, $db, $delete_lang, $edit_user_privs;
	global $who_allowed, $no_users, $user_adding, $u_name, $p_word, $return_to_main, $PHP_SELF;
	$result = mysql_query("SELECT * FROM muser",$db);
	echo"$who_allowed<br><br>";
	if ($result) {
		while ($myrow = mysql_fetch_array($result)) {
			printf("%s \n", $myrow["user_id"]);
			printf("<a href=\"%s?action=edit_privs&unum=%s\">$edit_user_privs</a> ", $PHP_SELF, $myrow["id"]);
			printf("<a href=\"%s?remu=yes&unum=%s\">($delete_lang)</a><br>", $PHP_SELF, $myrow["id"]);
		}
	}else {
		echo" $no_users<br><br>";
	}
	@mysql_free_result($result);
	echo"<b>$user_adding</b><br><br>\n";
	echo"<form method=\"post\" action=\"$PHP_SELF\">\n";
	echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n";
	echo"<tr>\n";
	echo"<td>$u_name</td>\n";
	echo"<td><input type=\"Text\" name=\"new_user_id\" value=\"$u_name\"></td>\n";
	echo"</tr>\n";
	echo"<tr>\n";
	echo"<td>$p_word</td>\n";
	echo"<td><input type=\"Text\" name=\"new_user_pass\" value=\"$p_word\"></td>\n";
	echo"</tr>\n";
	echo"</table>\n";
	echo"<input type=\"Submit\" name=\"submit_user\" value=\"Enter information\">\n";
	echo"</form>\n";
	echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
}
# fill_mail() contains almost idnetical code to
# print_current_lists(), but, print lists does not 
# select on usernames
# admin e-amil fill form
function fill_mail(){
	global $db, $PHP_SELF, $current_login_mail_user, $admin_user;
	global $msg_new_mail, $msg_subject, $msg_no_lists_exist, $msg_which_list_send, $return_to_main;
	echo"<b>$msg_new_mail</b><br><br>\n";
	echo"<form method=\"post\" action=\"$PHP_SELF\">\n";
	echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n";
	echo"<tr>\n";
	echo"<td colspan=\"2\">$msg_subject\n";
	echo"<input type=\"Text\" name=\"new_subject\" value=\"Subject\"></td>\n";
	echo"</tr>\n";
	echo"<tr>\n";
	echo"<td colspan=\"2\"><textarea name=\"new_mail\" cols=\"50\" rows=\"10\"></textarea></td>\n";
	echo"</tr>\n";
	echo"<tr>\n";
	echo"<td>\n";
	echo"HTML mail <input type=\"checkbox\" name=\"send_html_mail\">";
	echo"</td>";
	echo"</tr>";
	echo"<td>";
	$result = mysql_query( "SELECT Count(*) as total_items FROM lists") or die(mysql_error()); 
	$how_many=mysql_fetch_array($result); 
	$total_items=$how_many[total_items];
	@mysql_free_result($result);
	if ($total_items == "0") {
		echo"<b>$msg_no_lists_exist</b><br><br>";
	}elseif ($total_items == "1") {
		if ($current_login_mail_user == $admin_user){
			$result = mysql_query("SELECT * FROM lists") or die(mysql_error()); 
			while ($myrow = mysql_fetch_array($result)) {
				$list_name = ereg_replace("_", " ", $myrow["list_name"]);
				printf("%s %s <input type=\"hidden\" name=\"%s\" value=\"send\">  \n", $msg_send_to, $list_name, $myrow["list_name"]);
			}
			@mysql_free_result($result);
		}else{
			$result_user = mysql_query("SELECT * FROM muser WHERE user_id='$current_login_mail_user'") or die(mysql_error());
			$myrow_user = mysql_fetch_array($result_user);
			$result = mysql_query("SELECT * FROM lists") or die(mysql_error());
			while ($myrow = mysql_fetch_array($result)) {
				$list_name = ereg_replace("_", " ", $myrow["list_name"]);
				if ($myrow_user[$list_name] == "1"){
					printf("<input type=\"hidden\" name=\"%s\" value=\"send\">  \n", $msg_send_to, $list_name, $myrow["list_name"]);
				}
			}
			@mysql_free_result($result);
			@mysql_free_result($result_user);
		}
	}elseif ($total_items > "1") {
		echo"$msg_which_list_send<br><br>";
		if ($current_login_mail_user == $admin_user){
			$result = mysql_query("SELECT * FROM lists") or die(mysql_error()); 
			while ($myrow = mysql_fetch_array($result)) {
				$list_name = ereg_replace("_", " ", $myrow["list_name"]);
				printf("%s <input type=\"checkbox\" name=\"%s\">  \n", $list_name, $myrow["list_name"]);
			}
			@mysql_free_result($result);
		}else{
			$result_user = mysql_query("SELECT * FROM muser WHERE user_id='$current_login_mail_user'") or die(mysql_error());
			$myrow_user = mysql_fetch_array($result_user);
			$result = mysql_query("SELECT * FROM lists") or die(mysql_error());
			while ($myrow = mysql_fetch_array($result)) {
				$list_name = $myrow["list_name"];
				if ($myrow_user[$list_name] == "1"){
					$list_name = ereg_replace("_", " ", $list_name);
					printf("%s <input type=\"checkbox\" name=\"%s\">  \n", $list_name, $myrow["list_name"]);
				}
			}
			@mysql_free_result($result);
			@mysql_free_result($result_user);
		}
	}
	echo"</td>\n";
	echo"</tr>\n";
	echo"</table>\n";
	echo"<input type=\"Submit\" name=\"submit_mail\" value=\"Enter information\">\n";
	echo"</form>\n";
	echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
}
# revoke a users access to the mail system
function delete_user(){
	global $remu, $unum, $db, $msg_user_gone, $msg_user_gone2, $msg_delete_query_failure, $msg_user_not_exist2, $msg_user_not_exist;
	if ($remu) {
		$sql = "DELETE FROM muser WHERE id='$unum'";
		$result = mysql_query($sql, $db) or die(mysql_error());
		if(mysql_affected_rows($result) == 1){
		  @mysql_free_result($result);
			echo"<b>$msg_user_gone $user_id $msg_user_gone2</b><br><br>";
		}elseif (mysql_affected_rows($result) != 1) {
			echo "$delete_query_failure", mysql_error();
			echo"<br><br>";
			@mysql_free_result($result);
			exit;
		}else{
		  @mysql_free_result($result);
			echo"$msg_user_not_exist $user_id $msg_user_not_exist2<br><br>";
		}
	}
	
}
################################################################################
# Thus ends the multiple admin section
# Starting with the multi list capablities
################################################################################
# Create a mail list
function add_new_list() {
	global $db, $list_name, $description, $welcome, $newFooter, $msg_new_list, $msg_list_exists;
	$list_name = ereg_replace(" ","_",$list_name);
	$result = mysql_query("SELECT * FROM lists WHERE list_name='$list_name'", $db) or die("The goal of all inanimate objects is to resist man and ultimately defeat him. " . mysql_error());
	if (mysql_num_rows($result) == 1) { 
		echo"$msg_list_exists<br><br>";
	}else {
		$result1 = mysql_query("ALTER TABLE muser ADD $list_name TINYINT not null", $db) or die("Whenever I'm caught between two evils, I take the one I've never tried " . mysql_error());
		$result2 = mysql_query("INSERT INTO lists (list_name, description, welcome, footer) VALUES ('$list_name', '$description', '$welcome', '$newFooter')", $db) or die("Ambition is a poor excuse for not having sense enough to be lazy. - McCarthy" . mysql_error());
		$result3 = mysql_query("ALTER TABLE mail_list ADD $list_name TINYINT not null", $db) or die("Just because something doesn't do what you planned it to do doesn't mean it's useless. - Edision " . mysql_error());
		echo"$msg_new_list<br><br>";
		@mysql_free_result($result1);
		@mysql_free_result($result2);
		@mysql_free_result($result3);
	}
	@mysql_free_result($result);
}
# Remove a mail list
function remove_list() {
	global $db, $list_name, $reml, $msg_list_gone, $msg_list_exists_no;
	$list_name = ereg_replace(" ","_",$list_name);
	$result = mysql_query("SELECT * FROM lists WHERE list_name='$list_name'", $db) or die("O villain, villain, smiling, damned villain! " . mysql_error());
	if (mysql_num_rows($result) == 1) {
		$result1 = mysql_query("ALTER TABLE muser DROP $list_name", $db) or die("There are more things in heaven and earth, Horatio, than are dreamt of in your philosophy. " . mysql_error());
		$result2 = mysql_query("ALTER TABLE mail_list DROP $list_name", $db) or die("Somthing wicked this way comes. " . mysql_error());
		$result3 = mysql_query("DELETE FROM lists WHERE list_name='$list_name'", $db) or die("Et tu, Brutus? " . mysql_error());
		echo"$msg_list_gone<br><br>";
		@mysql_free_result($result1);
		@mysql_free_result($result2);
		@mysql_free_result($result3);
	}else {
		echo"$msg_list_exists_no<br><br>";
	}
	@mysql_free_result($result);
}
################################################################################
# Dealing with multi admins in conjunction with multi lists
################################################################################
# Write the priveliges for a user
function set_list_privs() {
	global $db, $HTTP_POST_VARS, $unum, $msg_user_changed;
	reset ($HTTP_POST_VARS);
	while ((list ($key, $val) = each ($HTTP_POST_VARS)) && (!$error)) {
		if($key != "unum" && $key != "update_privs"){
			$string .= "$key='$val', ";
		}
	}
	$string = substr($string, 0, -2);
	$sql = "UPDATE muser SET $string WHERE id='$unum'";
	$result = mysql_query($sql, $db) or die("I am dying, Egypt, dying: Give me some wine, and let me speak a little " . mysql_error());
	echo"$msg_user_changed";
	@mysql_free_result($result);
}
################################################################################
# back to super admin stuff
################################################################################
# Print the lists with option to delete
function print_current_lists() {
	global $db, $PHP_SELF, $delete_lang;
	$result = mysql_query("SELECT * FROM lists") or die("Dog of a Saxon! Take thy lance, and prepare for the death thou hast drawn upon thee. " . mysql_error()); 
	while($myrow= mysql_fetch_array($result)) {
		$id = $myrow["id"];
		$num = count_people_on_list($myrow["list_name"]);
		$list_name = ereg_replace("_", " ", $myrow["list_name"]);
		echo"$list_name";
		printf("<a href=\"%s?reml=yes&list_name=%s\">($delete_lang)</a> <a href=\"$PHP_SELF?action=edit_list_info&id=$id\">(EDIT)</a> %s members<br>%s<br><br>", $PHP_SELF, $list_name, $num, $myrow["description"]);  
	}
	@mysql_free_result($result);
}

# Print the info on a current list with option to change
function edit_list_info($id){
	global $db, $PHP_SELF;
	$result = mysql_query("SELECT * FROM lists WHERE id='$id'") or die(mysql_error());
	if($result){
		$myrow = mysql_fetch_Array($result);
		$list_name = stripslashes($myrow["list_name"]);
		$description = stripslashes($myrow["description"]);
		$welcome = stripslashes($myrow["welcome"]);
		$footer = stripslashes($myrow["footer"]);
		echo"$list_name<br><form action=\"$PHP_SELF\" method=\"post\">Description (<255 Chars) <input tpye=\"text\" name=\"nDescription\" maxlength=\"255\" value=\"$description\"><br>Welcome message:<br><textarea cols=\"40\" rows=\"7\" name=\"nWelcome\">$welcome</textarea><br>Footer message:<br><textarea cols=\"40\" rows=\"7\" name=\"nFooter\">$footer</textarea><br><input type=\"hidden\" name=\"id\" value=\"$id\"><input type=\"submit\" name=\"update_list\" value=\"Update\"></form>";
	} else {
		echo mysql_error();
	}
	@mysql_free_result($result);
}
function write_new_list_info($id){
	global $db, $nDescription, $nWelcome, $nFooter;
	$nDescription = addslashes($nDescription);
	$nWelcome = addslashes($nWelcome);
	$nFooter = addslashes($nFooter);
	$result = mysql_query("UPDATE lists SET description='$nDescription', welcome='$nWelcome', footer='$nFooter' WHERE id=$id");
	if($result) {
		echo"List data saved.<br>";
	} else {
		echo"List not updated! Failure! ", mysql_error();
	}
	@mysql_free_result($result);
}
# Print the current privliges of a user with option to cahnge
function print_privs() {
	global $db, $unum, $PHP_SELF, $msg_user_privs, $msg_user_working, $msg_no_list_exists, $return_to_main;
	$sql = "SELECT * FROM muser WHERE id='$unum'";
	$result_name = mysql_query($sql, $db) or die("I told you never press the big red button! " . mysql_error());
	$myrow_name = mysql_fetch_array($result_name);
	@mysql_free_result($result_name);
	printf("<b>%s</b><br><br>%s %s<br><br>", $msg_user_privs, $msg_user_working, $myrow_name["user_id"]);
	echo"<form action=\"$PHP_SELF\" method=\"post\">";
	$result = mysql_query("SELECT * FROM lists",$db) or die("This is new, hey, wait, that's not supposed to happen. " . mysql_error());
	if($result) {
		$i="0";
		while ($myrow = mysql_fetch_array($result)) {
			$list_name = $myrow["list_name"];
			if ($myrow_name["$list_name"] == "1") {
				$value_1 = "checked";
				$value_2 = "";
			}else{
				$value_1 = "";
				$value_2 = "checked";
			}
			$form_list_name = $myrow["list_name"];
			$pretty = ereg_replace("_", " ", $myrow["list_name"]);
			echo"$pretty:  Allow<input type=\"radio\" $value_1 name=\"$form_list_name\" value=\"1\">";
			echo" Don't allow<input type=\"radio\" $value_2 name=\"$form_list_name\" value=\"0\"><br>";
		}
		echo"<br><br><input type=\"hidden\" name=\"unum\" value=\"$unum\"> <input type=\"submit\" name=\"update_privs\" value=\"Save\"></form>";
	}else{ 
		echo"$msg_no_lists_exist";
	}
	@mysql_free_result($result);
	echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
}
################################################################################
# Starting the utlity and grunt work functions
################################################################################
# For php3 folks count_array_values is not defined
# and really sizeof() is used more often
function count_array_elements($array){
	$i="0";
	do { 
		$i++;
	} while (next($array));
		return $i;
}
# Grab an ID for POP
function get_id($email){
	global $db;
	$sql = "SELECT * FROM mail_list WHERE email='$email'" or die("Somebody f'd up. " . mysql_error());
	$result = mysql_query($sql, $db);	   					   			   
	if($result) {
		$myrow = mysql_fetch_array($result);
		@mysql_free_result($result);
		return $myrow[id];						
	}		
	@mysql_free_result($result);																	
}
# Play with all your little pretty script variables
function configure_script() {
	global $db, $msg_configure, $PHP_SELF, $use_std;
	global $dbName, $dbPass, $dbUserName, $host, $base, $default_list, $mail_loc, $smtp_id, $smtp_server, $pop_server, $pop_user, $pop_pass, $use_pop, $admin_user, $admin_pass, $mail_admin, $mail_admin_alias, $auto_cutting, $m, $footer, $header_path, $footer_path;
	echo"<b>$msg_configure</b><br><br>";
	echo"<form method=\"post\" action=\"$PHP_SELF\">";
	echo"<table>";
	echo"<tr><td colspan=\"2\">Database info</td></tr>";
	echo"<tr><td>Database</td><td><input type=\"text\" name=\"t_dbName\" value=\"$dbName\"></td></tr>";
	echo"<tr><td>Database username</td><td><input type=\"text\" name=\"t_dbUserName\" value=\"$dbUserName\"></td></tr>";
	echo"<tr><td>Database password</td><td><input type=\"text\" name=\"t_dbPass\" value=\"$dbPass\"></td></tr>";
	echo"<tr><td>Database host</td><td><input type=\"text\" name=\"t_host\" value=\"$host\"></td></tr>";
	echo"<tr><td colspan=\"2\">Site and email info</td></tr>";
	echo"<tr><td>Base address</td><td><input type=\"text\" name=\"t_base\" value=\"$base\"></td></tr>";
	echo"<tr><td>mail.php address</td><td><input type=\"text\" name=\"t_mail_loc\" value=\"$mail_loc\"></td></tr>";
	echo"<tr><td>SMTP ID (Usualy mydomain.com)</td><td><input type=\"text\" name=\"t_smtp_id\" value=\"$smtp_id\"></td></tr>";
	echo"<tr><td>SMTP server (Usualy mail.mydomain.com)</td><td><input type=\"text\" name=\"t_smtp_server\" value=\"$smtp_server\"></td></tr>";
	echo"<tr><td>POP server (Usualy mail.mydomain.com)</td><td><input type=\"text\" name=\"t_pop_server\" value=\"$pop_server\"></td></tr>";
	echo"<tr><td>POP account</td><td><input type=\"text\" name=\"t_pop_user\" value=\"$pop_user\"></td></tr>";
	echo"<tr><td>POP password</td><td><input type=\"text\" name=\"t_pop_pass\" value=\"$pop_pass\"></td></tr>";
	if($use_pop) { 
		echo"<tr><td>Use POP (Check for yes)</td><td><input type=\"checkbox\" checked name=\"t_use_pop\"></td></tr>"; 
	} else { 
		echo"<tr><td>Use POP (Check for yes)</td><td><input type=\"checkbox\" name=\"t_use_pop\"></td></tr>"; 
	}
	if($use_std) { 
		echo"<tr><td>Use standard mail command (Check for yes)</td><td><input type=\"checkbox\" checked name=\"t_use_std\"></td></tr>"; 
	} else { 
		echo"<tr><td>Use standard mail command (Check for yes)</td><td><input type=\"checkbox\" name=\"t_use_std\"></td></tr>"; 
	}
	if($db){
		echo"<tr><td>Default List: (Currently ";
		if($default_list){
			echo"$default_list)";
		} else {
			echo"Not Selected)";
		}
		echo"</td><td><select name=\"t_default_list\">";
		$result = mysql_query("SELECT * FROM lists") or die(mysql_error()); 
		while($myrow = mysql_fetch_array($result)) {
			$id = $myrow["list_name"];
			$list_name = ereg_replace("_", " ", $myrow["list_name"]);
			echo"<option>$list_name</option>";
		}
		@mysql_free_result($result);
		echo"</select><td></tr>";
	}
	echo"<tr><td>Admin username</td><td><input type=\"text\" name=\"t_admin_user\" value=\"$admin_user\"></td></tr>";
	echo"<tr><td>Admin password</td><td><input type=\"text\" name=\"t_admin_pass\" value=\"$admin_pass\"></td></tr>";
	echo"<tr><td>Mail Admin (E-mail address)</td><td><input type=\"text\" name=\"t_mail_admin\" value=\"$mail_admin\"></td></tr>";
	echo"<tr><td>Mail admin alias</td><td><input type=\"text\" name=\"t_mail_admin_alias\" value=\"$mail_admin_alias\"></td></tr>";
	echo"<tr><td>Emails per page (Auto-cutoff number)</td><td><input type=\"text\" name=\"t_auto_cutting\" value=\"$auto_cutting\"></td></tr>";
	echo"<tr><td>HTML Header path</td><td><input type=\"text\" name=\"t_html_header\" value=\"$header_path\"></td></tr>";
	echo"<tr><td>HTML Footer path</td><td><input type=\"text\" name=\"t_html_footer\" value=\"$footer_path\"></td></tr>";
	echo"</table>";
	echo"<input type=\"submit\" name=\"submit_config\" value=\"Save\"></form><br>";
}
function write_config(){
	global $msg_config_updated;
	global $t_dbName, $t_default_list, $t_use_std, $t_dbPass, $t_dbUserName;
	global $t_host, $t_base, $t_mail_loc, $t_smtp_id, $t_smtp_server, $t_pop_server;
	global $t_pop_user, $t_use_pop, $t_pop_pass, $t_admin_user, $t_admin_pass; 
	global $t_mail_admin, $t_mail_admin_alias, $t_auto_cutting, $t_html_header; 
	global $t_html_footer, $t_footer, $t_m, $scriptVersion;
	if($t_default_list){
		$t_default_list = ereg_replace(" ", "_", $t_default_list);
	}
	$fp = fopen("config.inc.php", "w");
	fwrite ($fp , "<?php\n
###############################################################################
# 452 Productions Internet Group (http://452productions.com)
# 452 Multi-MAIL v1.5 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2001  452 Productions
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
###############################################################################\n\n\n");
	fwrite ($fp , "\$dbName = \"$t_dbName\";\n");
	fwrite ($fp , "\$dbPass = \"$t_dbPass\";\n");
	fwrite ($fp , "\$dbUserName = \"$t_dbUserName\";\n");
	fwrite ($fp , "\$host = \"$t_host\";\n");
	fwrite ($fp , "\$base = \"$t_base\";\n");
	fwrite ($fp , "\$mail_loc = \"$t_mail_loc\";\n");
	fwrite ($fp , "\$smtp_id = \"$t_smtp_id\";\n");
	fwrite ($fp , "\$smtp_server = \"$t_smtp_server\";\n");
	fwrite ($fp , "\$pop_server = \"$t_pop_server\";\n");
	fwrite ($fp , "\$pop_user = \"$t_pop_user\";\n");
	fwrite ($fp , "\$pop_pass = \"$t_pop_pass\";\n");
	fwrite ($fp , "\$use_pop = \"$t_use_pop\";\n");
	fwrite ($fp , "\$use_std = \"$t_use_std\";\n");
	fwrite ($fp , "\$db = mysql_connect(\$host, \$dbUserName, \$dbPass) or die (\"Could not connect\");\n");
	fwrite ($fp , "mysql_select_db(\$dbName,\$db);\n");
	fwrite ($fp , "\$today = gmdate ( \"M d Y H:i:s\" ); #This affecs how your date is displayed www.php.net/date for more info\n");
	fwrite ($fp , " ");
	fwrite ($fp , "#User vars\n");
	fwrite ($fp , "\n");
	fwrite ($fp , "\$default_list = \"$t_default_list\";\n");
	fwrite ($fp , "\$admin_user = \"$t_admin_user\";\n");
	fwrite ($fp , "\$admin_pass = \"$t_admin_pass\";\n");
	fwrite ($fp , "\$mail_admin = \"$t_mail_admin\";\n");
	fwrite ($fp , "\$mail_admin_alias = \"$t_mail_admin_alias\";\n");
	fwrite ($fp , "\$auto_cutting = \"$t_auto_cutting\";\n");
	fwrite ($fp , "\$header_path = \"$t_html_header\";\n");
	fwrite ($fp , "\$footer_path = \"$t_html_footer\";\n");
	fwrite ($fp , "\$footer = \"$t_footer\";\n");
	fwrite ($fp , "\$m = \"$t_m\";\n");
	fwrite ($fp , "\$version = \"$scriptVersion\";\n");
	fwrite ($fp , "?>");
	fclose($fp);
	echo"$msg_config_updated<br>";
}
################################################################################
# admin archive browse
################################################################################
# These functions are a quick cover up for a serious logic mistake made in
# the design of the archive section - prints the subject of te mail with 
# option to delete.
# need to roll these into the functionso in the archive section
function print_archived_mail_admin(){
	global $db, $id, $PHP_SELF, $view_items, $disp_start, $disp_end, $auto_cutting;
	global $msg_archive_explain, $msg_archive_explain2, $disply_out_of;
	$result = mysql_query( "SELECT Count(*) as total_items FROM mail_sent") or die("Pinky, you've left the lens cap to your brain on again. " . mysql_error()); 
	$how_many=mysql_fetch_Array($result); 
	$total_items=$how_many[total_items];
	@mysql_free_result($result);
	if($id){
		$result = mysql_query("SELECT * FROM mail_sent WHERE id=$id") or die("We have incomming boggies at twelve o'clock! " . mysql_error());
		$myrow =mysql_fetch_array($result);
		printf("%s<br>Sent on %s By %s<br><br>%s", $myrow["subject"],$myrow["date"],$myrow["user_id"],$myrow["mail"]);
	}else {
	if(!$view_items) {
		if($total_items <= $auto_cutting) {
			$sql = "SELECT * FROM mail_sent ORDER BY date DESC";
			print_subject_admin($sql);		 
		}else {
			echo"<p>$msg_archive_explain $total_items $msg_archive_explain2</p>";
			echo"<form method=\"post\" action=\"$PHP_SELF?action=archive_browse\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
		}
	}else{
		echo"<p>$disply_out_of</p>";
		$sql = "SELECT * FROM mail_sent LIMIT $disp_start, $disp_end ORDER BY date DESC";
		print_subject_admin($sql);
		echo"<form method=\"post\" action=\"$PHP_SELF\">\nFrom <input type=\"text\" name=\"disp_start\" value=\"1\" size=\"5\"> to <input type=\"text\" name=\"disp_end\" value=\"20\" size=\"5\"> <input type=\"submit\" name=\"view_items\" value=\"Go!\">\n</form>";
	}
	}
}
function print_lists() {
	global $db;
	$result = mysql_query("SELECT * FROM lists",$db);
	while ($myrow = mysql_fetch_array($result)) {
		 	   printf("<a href=\"%s?action=archive_browse&show_list=%s\">%s</a><br> \n", $PHP_SELF, $myrow["list_name"], $myrow["list_name"]);
   }
	@mysql_free_result($result);
}
function browse_archive() {
	global $show_list, $id, $db, $PHP_SELF;
	if ($id) {
# If we have an id display te archived item
   		$sql = "SELECT * FROM mail_sent WHERE id=$id";
	   $result = mysql_query($sql, $db);
		  $myrow = mysql_fetch_array($result);
    	$subject = $myrow["subject"];
    	$date = $myrow["date"];
    	$mail = $myrow["mail"];
			@mysql_free_result($result);
		echo"<h3>Mail Archive</h3>";
		echo"<p>$subject <a href=\"$PHP_SELF?delete=yes&id=$id\">(DELETE)</a><br>$date<br><br>$mail</p>";
}elseif ($show_list) {
		 $result_count = mysql_query( "SELECT Count(*) as total_items FROM mail_sent") or die(mysql_error()); 
     $how_many=mysql_fetch_Array($result_count); 
     $total_items=$how_many[total_items];
		 echo"<h3>Mailing list archives</h3><p>Archived mailings for list $show_list</p>";
		 echo"<table>";
		 #print_sent_mail();
		 print_archived_mail_admin();
		 echo"</table>";
		 echo"<br><a href=\"$PHP_SELF\">Return to main</a>";
		 @mysql_free_result($result_count);
   }else {
			# other wise let them select it
			echo"<h3>Mailing list archives</h3>";
			$result = mysql_query("SELECT * FROM lists",$db);
			while ($myrow = mysql_fetch_array($result)) {
		 	   printf("<a href=\"%s?action=archive_browse&show_list=%s\">%s</a><br> \n", $PHP_SELF, $myrow["list_name"], $myrow["list_name"]);
		 }
		 @mysql_free_result($result);
	}
}
function print_subject_admin($sql) {
	global $db, $show_list, $PHP_SELF;
	$result = mysql_query($sql, $db);
	while ($myrow = mysql_fetch_array($result)) {
		$list_names = $myrow["list_names"];
		if (eregi($show_list, $list_names)) {
			printf("<tr><td><a href=\"%s?action=archive_browse&id=%s\">%s</a> <a href=\"%s?delete=yes&id=%s\">(DELETE)</td><td>%s</td><td>Sent by %s</td></td></tr>\n", $PHP_SELF, $myrow["id"], $myrow["subject"], $PHP_SELF, $myrow["id"], $myrow["date"], $myrow["user_id"]);
		}
	}
	@mysql_free_result($result);
}
################################################################################
# Start with the pop functions, a lot of string parseing in here
################################################################################
# Pulls the e-mail address out of a big ugly mass of data
function findEmail($data){
	# This is where it gets fun
	# Parsing strings sucks, so we'll just blow some junk up
	# We assume that the letter follows conventions and that the first occurance 
	# of the letters 'From: ' is followed by the address.
	$pre = explode("From: ", $data);
	$email = explode("\r\n", $pre[1]);
	if(check_email_addy($email[0])) {
		return $email[0];
	} else {
		# Fancy mailer, gotta parse out the ugly stuff
		$plain = explode("<", $email[0]);
		$email = ereg_replace(">", "", $plain[1]);
		return $email;
	}
}
# gets the subject - it's all we care about, the rest of the stuff gets
# knocked off
function getSubject($data){
	$pre = explode("Subject: ", $data);
	$subject = explode("\r\n", $pre[1]);
	$sub = strtolower($subject[0]);
	return $sub;
}
# Rips the command outta the e-mail subject
function getCommand($sub){
	if(eregi("drop", $sub)){
		$command = "drop";
	} elseif(eregi("add", $sub)) {
		$command = "add";
	} elseif((eregi("unsubscribe", $sub)) || (eregi("remove", $sub))){
		$command = "remove";
	} elseif(eregi("subscribe", $sub)) {
		$command = "subscribe";
	}
		return $command;
}
# For some reason, the thing hangs if you try and fgets in real time
# cause of that it's simpler to do two connects if needed
# No clue why, if any one has a better idea, all ears
# Returns the number of messages in the mail box.
function newMail($pop_server, $pop_user, $pop_pass) {
	$socket = fsockopen($pop_server, 110, $errno, $errstr);
	if($socket){
		fputs($socket, "USER $pop_user\r\n");
		fputs($socket, "PASS $pop_pass\r\n");
		fputs($socket, "STAT\r\n");
		fputs($socket, "QUIT \r\n");
		while(!feof($socket)){
			$data .= fgets($socket, 1024);
		}
		fclose ($socket);
		$oks = explode("+OK ", $data);
		$num = explode(" ", $oks[4]);
		if($num[0] == 0) {
			return 0;
		} else {
			return $num[0];
		}
	} else {
		die("Bury my heart at wounded knee. Could not connect to POP.");
	}
}
# Through methods we are not at liberty to discuss, this function returns
# the lists present in the subject of an e-mail.
/*
function findLists($subject, $command){
	switch($command){
		case("add"):
			$subject = substr($subject, 4);
			$lists = explode(",", $subject);
			break;
		case("drop"):
			$subject = substr($subject, 5);
			$lists = explode(",", $subject);
			break;
		case("subscribe"):
			$subject = substr($subject, 10);
			$lists = explode(",", $subject);
			break;
	}
	$num = sizeof($lists);
	$result = mysql_query("SELECT * FROM lists") or die("This could be a small problem. " . mysql_error());
	if($result){
		while($myrow = mysql_fetch_array($result)){
			$temp = strtolower($myrow[list_name]);
			for($i=0;$i<$num;$i++){
				if(trim($temp) == trim($lists[$i])) {
					$id = $myrow[id];
 					$newLists .= $id . " ";
				}
			}
		}
	}
	if($newLists == ""){
		# no lists matched
		return -1;
	} else {
		return $newLists;
	}
}
*/
# New version comes thanks to Micheal F (mike@adam.org http://adam.org) 
# and will at some point  usurp the more egregious version above.
function findLists($subject, $command){
	$find = array('/.*(add|drop|unsubscribe|subscribe)/i','/\W/','/\b/');
	$replace = array('','','');
	$lists = explode(',',preg_replace($find,$replace,strtolower($subject)));
	$where = "LCASE(TRIM(list_name)) = '" . join ("' OR LCASE(TRIM(list_name)) = '",$lists) . "'";
	$result = mysql_query("SELECT id FROM lists WHERE $where") or die("This could be a small problem. " . mysql_error());
	if($result){
		while($myrow = mysql_fetch_array($result)){
			$newLists[] = $myrow[id];
		}
	}
	@mysql_free_result($result);
	if($newLists == ""){
	# no lists matched
	return -1;
	} else {
	return join(' ',$newLists);
	}
}
# handles adding lists to a users subscription
function changeAdd($lists, $id){
	$num = sizeof($lists);
	for($i=0;$i<$num;$i++){
		$string .= $lists[$i] . "='1', ";
	}
	$string = substr($string, 0, -2);
	$result = mysql_query("UPDATE mail_list SET $string WHERE id='$id'", $db);
	if($result){
	 @mysql_free_result($result);
		return 1;
	} else {
	 @mysql_free_result($result);
		return 0;
	}
}
# takes list of a users subscription
function changeDrop($lists, $id){
	$num = sizeof($lists);
	for($i=0;$i<$num;$i++){
		$string .= $lists[$i] . "='0', ";
	}
	$string = substr($string, 0, -2);
	$result = mysql_query("UPDATE mail_list SET $string WHERE id='$id'", $db);
	if($result){
	 @mysql_free_result($result);
		return 1;
	} else {
	 @mysql_free_result($result);
		return 0;
	}
}
# This logs into the pop server parses the messages, deals with
# what it can, leaves the rest.
# This is quite possible the most misleading function on earth, it is
# itself a mini script, calling or accessing almost a forth of the
# other functions in this script. A lot of the comlpexity comes from
# not wanting to do the strings with regex's.
function popCheckAndRemove($pop_server, $pop_user, $pop_pass){
	global $db, $PHP_SELF, $use_pop, $mail_admin, $mail_admin_alias, $base, $return_link, $return_to_main;
	# First see if were even supposed to do this
	if($use_pop){
		#if so see if new messages
		$mail = newMail($pop_server, $pop_user, $pop_pass);
		if($mail != 0) {
			# if so login
			$socket = fsockopen($pop_server, "110", $errno, $errstr);
			if($socket) {
				fputs($socket, "USER $pop_user\r\n");
				fputs($socket, "PASS $pop_pass\r\n");
				# grab each message
				for($i = 0; $i <= $mail; $i++) {
					fputs($socket, "RETR $i\r\n");
				}
				fputs($socket, "QUIT \r\n");
				# pack it in
				while(!feof($socket)){
					$data .= fgets($socket, 1024);
				}
				fclose($socket);
				# Split em up into individaul messages
				$messages = explode("\r\n.\r\n", $data);
				#no need to carry that around
				$data = "";
				$work = 0;
				for($i = 0; $i <= $mail; $i++) {
					#figure out which command
					$subject = getSubject($messages[$i]);
					$command[$i] = getCommand($subject);
					switch($command[$i]){
						case("drop"):
							$change[$i] = findEmail($messages[$i]);
							# array of array
							$dropLists[$i] = findLists($subject, $command[$i]);
							$work++;
							
							break;
						case("add"):
							$change[$i] = findEmail($messages[$i]);
							# array of array
							$addLists[$i] = findLists($subject, $command[$i]);
							$work++;
							break;
						case("remove"):
							$bye[$i] = findEmail($messages[$i]);
							$work++;
							break;
						case("subscribe"):
							$add[$i] = findEmail($messages[$i]);
							$subLists[$i] = findLists($subject, $command[$i]);
							echo"$subLists[$i]<br>";
							$work++;
							break;
					}
				}
				$numChange = sizeof($change);
				$numBye = sizeof($bye);
				$numNew = sizeof($add);
			} else {
					echo"Could not connect! ($errno) $errstr<br>";
			}
			$successful_off = 0;
			$failure_off = 0;
			$successful_on = 0;
			$failure_on = 0;
			$successful_change = 0;
			$failure_change = 0;
			# If we have work, do it
			if($work > 0) {
				$nice_mail = $mail_admin_alias . " <" . $mail_admin . ">";
				$header = "From: " . $nice_mail ."\nX-Sender: " . $mail_admin ."\n Reply-To: " . $mail_admin . "\nX-Mailer: 452-PHP 452productions.com\n To: $email";
				#connect and login
				$socket = fsockopen($pop_server, "110", $errno, $errstr);
				if($socket) {
					fputs($socket, "USER $pop_user\r\n");
					fputs($socket, "PASS $pop_pass\r\n");
					# Removing people
					if(gettype($bye)=="array") { 
						while (list($index, $subarray) = each($bye) ) { 
							if(!check_user($subarray)) {
								$id = get_id($subarray);
								# Get off my list
								if(delete_email($id)){
									$letter = $index + 1;
									fputs($socket, "DELE $letter\r\n");
									$successful_off++;
								} else {
									$failure_off++;
									echo"Could not find/remove $subarray from database. If you have removed them, please delete the message from the mail box.<br><br>";
								}
							} else {
								$failure_off++;
								echo"$subarray not in list but wants to be removed. That's bad. Suggested course of action: contact $subarray to see if they subscribed under a different e-mail address.<br><br>";
							}
						}
					} 
					# Done removing
					# Change subscriptions
					if(gettype($change)=="array") { 	
					
						echo"first if<br>";
						while (list($index, $subarray) = each($change) ) { 
							$changedDone = 0;
							$letter = $index + 1;
							echo"&nbsp; &nbsp;while $subarray<br>";
							if(($addLists[$index] == -1) || ($dropLists[$index] == -1)) {
								mail($subarray, "List Change Failure", "You have requested to be change your status on a list that doees not exist. Check that you spelled the list name correctly and that the admin has not removed this list. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
								fputs($socket, "DELE $letter\r\n");
								$failure_change++;
							} else {
									if(!check_user($subarray)) {
										echo"&nbsp; &nbsp; &nbsp; &nbsp; second if <br>";
										$id = get_id($subarray);
										if($addLists[$index]){
											$lists = explode(" ", $addLists[$index]);
											if(changeAdd($lists, $id)){
												$changedDone = 1;
											}
									} elseif($dropLists[$index]){
										$lists = explode(" ", $dropLists[$index]);
										if(changeDrop($lists, $id)){
											$changedDone = 1;
										}
									}	
									if ($changedDone) {
										fputs($socket, "DELE $letter\r\n");
										$successful_change++;
										mail($subarray, "List Change Success", "You list change has been completed!\r\n\r\n $mail_admin.\r\n\r\nhttp://$base\r\n\r\n", $header);
									} else {
										$failure_change++;
										echo"change failure<br>";
										mail($subarray, "List Change Failure", "You have requested to be added to a list, but you are already on that list, or some other monstrosity has occured. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
										fputs($socket, "DELE $letter\r\n");
									}
								} else {
									Echo"not on lists<br>";
									if($addLists[$index] != -1){
										echo"inside add<br>";
										$lists = explode(" ", $addLists[$index]);
										if(add_user_email($subarray, $lists)) {
											$id = explode(" ", $lists);
											$id = $id[0];
											$welcome = mysql_query("SELECT welcome FROM lists WHERE id='$id'") or die("Ahhh, crap. " . mysql_error());
											$welcome = mysql_fetch_array($welcome);
											$welcome_m = $welcome["welcome"];
											@mysql_free_result($welcome);
											mail($subarray, "You have been added", $welcome_m . "\r\n\r\n", $header);
											fputs($socket, "DELE $letter\r\n");
										} else {
											echo"inside add2<br>";
											mail($subarray, "List Change Failure", "You have requested to be added to a list, but you are already on that list, or some other monstrosity has occured. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
											fputs($socket, "DELE $letter\r\n");
											$failure_change++;
										}
									} else {
										echo"inside add3 $addLists<br>";
										mail($subarray, "List Change Failure", "You have requested to drop a list, but, you are not even on the mailing list, for any list, let alone the one you want to drop. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
										fputs($socket, "DELE $letter\r\n");
										$failure_change++;
									}
								}
							} 
						}
					}  
					# Pretty much the smae as above, just calls the add_user_email function
					# addin folks
					if(gettype($add)=="array") { 
						while (list($index, $subarray) = each($add) ) { 
							$letter = $index + 1;
							if(check_user($subarray)) {
								$lists = explode(" ", $subLists[$index]);
								if(add_user_email($subarray, $lists)){
									fputs($socket, "DELE $letter\r\n");
									# in this case, the user specified the list order
									# we'll assume they know what they want, and put the list
									# they care most about first, so we'll send the welcome
									# for the first list they listed
									$id = $lists[0];
									$welcome = mysql_query("SELECT welcome FROM lists WHERE id='$id'") or die("It's all over. SQL died on the operating table. We did everything we could. " . mysql_error());
									$welcome = mysql_fetch_array($welcome);
									$welcome_m = $welcome["welcome"];
									@mysql_free_result(welcome);
									mail($subarray, "You have been added" . $welcome_m . "\r\n\r\n", $header);
									$successful_on++;
								} else {
									fputs($socket, "DELE $letter\r\n");
									$failure_on++;
									echo"already on list at add<br>";
									mail($subarray, "Subscription Failure", "Your address, $subarray, appears to already be in this mailservers database. Please use the 'add' command to change your mailings. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
								}
							} else {
								fputs($socket, "DELE $letter\r\n");
								echo"already on list at check<br>";
								$failure_on++;
								mail($subarray, "Subscription Failure", "Your address, $subarray, appears to already be in this mailservers database. Please use the 'add' command to change your mailings. If you are having problems, please contact $mail_admin.\r\n\r\n", $header);
							}
						}
					} 
					fputs($socket, "QUIT \r\n");
					# pack it in
					while(!feof($socket)){
						$data .= fgets($socket, 1024);
					}
					fclose($socket);
					//echo"$data";
					$data = "";
				} else {
					echo"Could not connect! ($errno) $errstr<br>";
				}
			}
			$left = $mail - ($successful_off + $successful_on + failure_on + $successful_change + failure_change);
			echo"$mail total messages in box at start:<br>\n";
			if($numBye) {
			echo"$numBye people wanting to be removed. I got rid of $successful_off, with $failure_off failures.<br>";
			}
			if($numNew){
				echo"$numNew people wanting to be added. I added $successful_on, with $failure_on failures.";
				if($failure_on){
					echo" (They were already on the list)<br>";
				}
			}
			if($numChange){
				echo"$numChange people wanting to change things. I added $successful_change, with $failure_change failures.<br>";
			}
			echo"There are now $left messages in the box that I can't deal with.<br>";
		} else {
			echo"No messages to work with.<br>";
		}
	} else {
		echo"POP not enabled.<br>";
	}
	if($return_link){
		echo"<br><a href=\"$PHP_SELF\">$return_to_main</a>";
	}
	
}
# World domination on a global scale (TM)
# less insidious than it sounds, really....
function world_domination(){
	global $version, $mail_admin;
	echo"This is the <a href=\"452productions.com\">452 Multi-Mail v$scriptVersion script</a><br><br>Questions regarding the operation of this script should be addressed to $mail_admin.<br><br>Questions regarding this script's design should be addressed to services@452productions.com<br><br>";
}
# fin - dues ex machina
?>