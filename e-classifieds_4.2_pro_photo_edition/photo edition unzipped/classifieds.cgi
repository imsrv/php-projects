#!/usr/local/bin/perl

# The line above MUST point to the location of Perl 5 on your server if
# you are running this program on a Unix server.  Windows NT users can
# almost always ignore this line.

#####################################################################
#
# e-Classifieds(TM) Photo Edition
# Version 4.2
# Last Modified 6/19/2000
# Copyright © Hagen Software Inc. All rights reserved.
#
# By purchasing, installing, copying, downloading, accessing or otherwise
# using the SOFTWARE PRODUCT, or by viewing, copying, creating derivative
# works from, appropriating, or otherwise altering all or any part of its
# source code (including this notice), you agree to be bound by the terms
# of the EULA that accompanied this product, as amended from time to time
# by Hagen Software Inc.  The EULA can also be viewed online at
# "http://www.e-classifieds.net/support/license.html"
#
# As explained in the EULA, Hagen Software offers absolutely
# no warranties on this product, which is sold and/or distributed
# "as is".  You, and not Hagen Software, assume all risks
# associated with using this product, including but not limited
# to the risk of failure of the product to install or to operate
# successfully on your server, and responsibility for all content
# created by users of this product.
#
# This product, including all source code, is copyrighted by
# Hagen Software, and it is protected under both United States law
# and international laws and treaties.  You may not redistribute this
# software, in whole or any part thereof, or use any part of the source
# code contained within this software to create derivative works,
# without the prior express written consent of Hagen Software.
# Nor may you remove any of the copyright notices contained
# either within the source code or on the HTML pages generated
# by the program.  Doing so constitutes a criminal offense
# punishable by imprisonment.
# We prosecute all violators via both civil legal actions and in
# cooperation with U.S. and international criminal authorities.
# YOU HAVE BEEN WARNED! 
#
# The Hagen Software web site is located at the following URL:
# http://www.hagensoftware.com 
#
#####################################################################

unless ($noheader eq "on") {
print "Content-type: text/html\n\n";
}

$os = $^O;

if (($os eq "MSWin32") || ($os eq "Windows_NT") || ($os =~ /win/i)) { $os = "nt"; }
else { $os = "unix"; }

#######################################################################  
#                  Path Variable                                      #  
####################################################################### 

unless ($path) {

$path = $0;
$path =~ s/\\\\/\\/g;
$path =~ s/\\/\//g;
$path =~ s/(\/)(\w*)(\.*)(\w+)$//g;

unless ($path =~ /\//) {
if ($os eq "unix") { $path = `pwd`; }
}

unless ($path =~ /\//) {
$path = $ENV{'SCRIPT_FILENAME'};
$path =~ s/\\\\/\\/g;
$path =~ s/\\/\//g;
$path =~ s/(\/)(\w*)(\.*)(\w+)$//g;
}

$path =~ s/ //g;
$path =~ s/\n//g;

# $path = "/usr/www/users/you/cgi-bin/classifieds";

unless ($path =~ /\//) { &path_error; }

}

# The program attempts to get the full internal server path to the top-level
# classifieds directory on your system using the code above.  This should work
# on most systems, but it may not work on a few systems or if you have changed
# the name of the main file to something other than classifieds.cgi or
# classifieds.pl.  In such cases, you will need to manually override the
# $path variable obtained by the program.  To do so, you will need to
# uncomment the line above (by removing the # symbol from in front of it)
# that looks like this (do NOT uncomment the line below):

# $path = "/usr/www/users/you/cgi-bin/classifieds";

# You will then replace "/usr/www/users/you/cgi-bin/classifieds" with the
# actual full internal server path to the "classifieds" directory that you
# created under your cgi-bin, and where you are placing the classifieds.cgi file.
# If you don't know the value for the full internal server path to the
# classifieds program, you will need to get this information from your
# web hosting company or your server administrator.  You may also be able to
# get this information by logging onto your site via Telnet, changing
# directories until you are in the directory where the classifieds program
# is located, and then typing "pwd", which should display the current
# directory.  It will look something like
# "/usr/www/users/you/cgi-bin/classifieds" for Unix users or
# "d:/InetPub/wwwroot/cgi-bin/classifieds" for Windows NT users.  These are merely
# examples, of course, and your actual directory will be different.  Also,
# do NOT add the trailing slash, as this will be done by the program.

# End of user-configurable variables.

#######################################################################
#               Read and Parse Form Data                              #
#######################################################################

&require_supporting_libraries (__FILE__, __LINE__,
				"$path/user.cfg",
				"$path/classifieds.cfg",
                              "$path/library/cgi-lib.pl",
                              "$path/html/main-html.pl",
			      "$path/library/date.pl");

sub require_supporting_libraries
  {
                
  local ($file, $line, @require_files) = @_;
  local ($require_file);
                
  foreach $require_file (@require_files)
    {           
    if (-e "$require_file" && -r "$require_file")
      {
      require "$require_file";
      }
                
    else
      {
$required_file_error_message = "We're sorry, but the script was unable to require $require_file at line $line in $file.  Please make sure that these files exist, that you have the path set correctly, and that the permissions are set properly.  This message could also indicate that a syntax error has been introduced into $require_file.";

      print "$required_file_error_message";
      exit;
      }         
    } 
  } 

sub send_mail {
if ($disable_email) { return 1; }
$mail_lib = "$mail_program.pl";
&require_supporting_libraries (__FILE__, __LINE__, "$path/library/$mail_lib");
&send_message;
}

sub get_required_files {
unless ($footer =~ /Powered by e-Classifieds.net. Copyright © 1995-2000 Hagen Software Inc. All rights reserved./) {
exit;
}
$validated = "on";
}

&ReadParse(*form_data);

&get_os;

sub check_ip_kill {
  $kill=off;

  foreach $blocked_ip_address (@blocked_ip_addresses)
    {
    if ($ENV{'REMOTE_ADDR'} =~ /$blocked_ip_address/gi) { 
      $kill="on";
	last;
       }
    }
  if ($kill eq "on") { &kill_error; }
}

sub check_badwords {
  $badwords=off;

@check_fields = ("name", "street", "city", "state", "zip", "country", "phone", "email", "url", "caption", "text", "caption_header");

 foreach $badword (@badwords) {

  foreach $check_field (@check_fields)
    {
    if ($form_data{$check_field} =~ /$badword/gi) { 
	$badwords="on";
	$form_data{$check_field} =~ s/($badword)/<B>$1<\/B>/gi;
	}
    }
  }

  if ($badwords eq "on") {
    &badwords_error;
  }
}

unless ($validated) { exit; }

#####################################

# First, we need to account for possible situations where the
# search_and_display_for_modification_button or
# search_and_display_for_deletion_button fields have come in with the
# display_modification_form_button or submit_deletion_button fields.  In
# these cases, we strip out the "search_and_display..." values.

if (($form_data{'search_and_display_for_deletion_button'} ne "") && ($form_data{'submit_deletion_button'} ne ""))
  {
$form_data{'search_and_display_for_deletion_button'} = "";
  }

if ($form_data{'admin'} ne "") {
if ($form_data{'action'} eq "modify") { $form_data{'modify_item_button'} = "on"; }
if ($form_data{'action'} eq "delete") { $form_data{'delete_item_button'} = "on"; }
if ($form_data{'action'} eq "photo") { $form_data{'upload_form'} = "on"; }
if ($form_data{'action'} eq "autonotify") { $form_data{'autonotify_form'} = "on"; }
if ($form_data{'action'} eq "warn") { $form_data{'warn_form'} = "on"; }
if ($form_data{'action'} eq "purge") { $form_data{'purge_form'} = "on"; }
if ($form_data{'action'} eq "delete_all") { $form_data{'delete_all_form'} = "on"; }
if ($form_data{'action'} eq "autonotify_purge") { $form_data{'autonotify_purge_form'} = "on"; }
if ($form_data{'action'} eq "preview") { $form_data{'preview_ads'} = "on"; }
if ($form_data{'action'} eq "view") { $form_data{'view_maillist_form'} = "on"; }
if ($form_data{'action'} eq "clear") { $form_data{'clear_maillist_form'} = "on"; }
if ($form_data{'action'} eq "send") { $form_data{'send_maillist_form'} = "on"; }
}

# Now we go through the main logic of the program.

if ($form_data{'add_item_button'} ne "")

  {
  $helptopic = "post_ad_form";
  &pagesetup("Post Classified Ad Form");
  &generic_form_header;
  &add_form_header;
  &add_modify_data_entry_form;
  &add_form_footer;
  &pageclose;
  exit;
  }

elsif ($form_data{'preview_ad_button'} ne "")
  {
  $helptopic = "post_ad_form";
  &display_preview_ad;
  exit;
  }

elsif ($form_data{'submit_addition'} ne "")
  {
  &check_ip_kill;
  &check_badwords;
  &submit_addition;
  exit;
  } 

elsif ($form_data{'modify_item_button'} ne "")
  {
  $helptopic = "modify_form";
  &modify_search_form;
  exit;
  }

elsif ($form_data{'display_modification_form_button'} ne "")
  {
  $helptopic = "modify_form";
  &display_modification_form;
  exit;
  }

elsif ($form_data{'submit_modification_button'} ne "")
  {
  &check_badwords;
  &submit_modification;
  exit;
  }

elsif ($form_data{'delete_item_button'} ne "")
  {
  $helptopic = "delete_form";
  &delete_search_form;
  exit;
  } 

elsif ($form_data{'search_and_display_for_deletion_button'} ne "")
  {
  $helptopic = "delete_form";
  &search_and_display_for_deletion;
  exit;
  }

elsif ($form_data{'submit_deletion_button'} ne "")
  {
  &submit_deletion;
  exit;
  }

elsif ($form_data{'view_database_button'} ne "")
  {
  $helptopic = "advanced_search";
  &view_database_form;
  exit;
  } 

elsif ($form_data{'search_and_display_db_button'} ne "")
  {
  &search_and_display_db_for_view;
  exit;
  }

elsif ($form_data{'display_reply_form_button'} ne "")
  {
  &display_reply_form;
  exit;
  }

elsif ($form_data{'send_reply_button'} ne "")
  {
  &send_reply;
  exit;
  }

elsif ($form_data{'print_autonotify_options_button'} ne "")
  {
  $helptopic = "autonotify_options";
  &print_autonotify_options_page;
  exit;
  }

elsif ($form_data{'autonotify_add_form_button'} ne "")

  {
  &pagesetup("Keyword Notify Setup Form");
  &autonotify_add_form;
  &pageclose;
  exit;
  }

elsif ($form_data{'autonotify_submit_addition'} ne "")
  {
  &autonotify_submit_addition;
  exit;
  } 

elsif ($form_data{'autonotify_modify_search_button'} ne "")

  {
  &autonotify_search_form;
  exit;
  }

elsif ($form_data{'autonotify_modify_form_button'} ne "")

  {
  &autonotify_get_info;
  &pagesetup("Keyword Notify Modify Form");
  &autonotify_add_form;
  &pageclose;
  exit;
  }

elsif ($form_data{'autonotify_submit_modification'} ne "")
  {
  &autonotify_submit_modification;
  exit;
  } 

elsif ($form_data{'autonotify_delete_search_button'} ne "")

  {
  &autonotify_search_form;
  exit;
  }

elsif ($form_data{'autonotify_delete_form_button'} ne "")

  {
  &autonotify_get_info;
  &pagesetup("Keyword Notify Delete Form");
  &autonotify_delete_form;
  &pageclose;
  exit;
  }

elsif ($form_data{'autonotify_submit_deletion'} ne "")
  {
  &autonotify_submit_deletion;
  exit;
  } 

elsif ($form_data{'preview_ads'} ne "")
  {
  &preview_ads_form;
  exit;
  } 

elsif ($form_data{'display_new_ads_button'} ne "")
  {
  &preview_ads;
  exit;
  } 

elsif ($form_data{'approve_button'} ne "")
  {
  &approve_ads;
  exit;
  } 

elsif ($form_data{'print_help_page_button'} ne "")
  {
  $helptopic = "faq";
  &print_help_page;
  exit;
  }

elsif ($form_data{'print_privacy_page'} ne "")
  {
&require_supporting_libraries (__FILE__, __LINE__, "$path/html/print_privacy_page.pl");
  &print_privacy_page("$classifieds_name Privacy Statement");
  exit;
  }

elsif ($form_data{'print_terms_page'} ne "")
  {
&require_supporting_libraries (__FILE__, __LINE__, "$path/html/print_terms_page.pl");
  &print_terms_page;
  exit;
  }

elsif ($form_data{'print_guidelines_page_button'} ne "")
  {
  &print_guidelines_page;
  exit;
  }

elsif ($form_data{'print_tips_page_button'} ne "")
  {
  &print_tips_page;
  exit;
  }

elsif ($form_data{'warn_button'} ne "")
  {
  &warn;
  exit;
  }

elsif ($form_data{'purge_button'} ne "")
  {
  &purge;
  exit;
  }

elsif ($form_data{'delete_all_button'} ne "")
  {
  &delete_all;
  exit;
  }

elsif ($form_data{'autonotify_button'} ne "")
  {
  &autonotify;
  exit;
  }

elsif ($form_data{'autonotify_purge_button'} ne "")
  {
  &autonotify_purge;
  exit;
  }

elsif ($form_data{'upload_form'} ne "")
  {
  $helptopic = "upload_form";
  &upload_form;
  exit;
  }

elsif ($form_data{'upload'} ne "")
  {
  &upload;
  exit;
  }

elsif ($form_data{'admin_button'} ne "")
  {
  $helptopic = "admin";
  &admin_form;
  exit;
  }

elsif ($form_data{'view_maillist_form'} ne "")
  {
  &view_maillist_form;
  exit;
  }

elsif ($form_data{'view_maillist'} ne "")
  {
  &view_maillist;
  exit;
  }

elsif ($form_data{'clear_maillist_form'} ne "")
  {
  &pagesetup;
  &clear_maillist_form;
  &pageclose;
  exit;
  }

elsif ($form_data{'clear_maillist'} ne "")
  {
  &clear_maillist;
  exit;
  }

elsif ($form_data{'send_maillist_form'} ne "")
  {
  &pagesetup;
  &send_maillist_form;
  &pageclose;
  exit;
  }

elsif ($form_data{'send_maillist'} ne "")
  {
  &send_maillist;
  exit;
  }

elsif ($form_data{'warn_form'} ne "")
  {
  &warn_form;
  exit;
  }

elsif ($form_data{'purge_form'} ne "")
  {
  &purge_form;
  exit;
  }

elsif ($form_data{'delete_all_form'} ne "")
  {
  &delete_all_form;
  exit;
  }

elsif ($form_data{'autonotify_form'} ne "")
  {
  &autonotify_form;
  exit;
  }

elsif ($form_data{'autonotify_purge_form'} ne "")
  {
  &autonotify_purge_form;
  exit;
  }

elsif ($form_data{'print_control_panel_help'} ne "")
  {
  &print_control_panel_help;
  exit;
  }

elsif ($form_data{'print_popup_help'} ne "")
  {
  &print_popup_help;
  exit;
  }

elsif ($form_data{'print_popup_photo'} ne "")
  {
  &print_popup_photo;
  exit;
  }

else
  {
  &pagesetup("$classifieds_name");
  &display_frontpage;
  &pageclose;
  &maintenance_routines;
  exit;
  }

#######################################################################
#                      Display Preview Ad                             # 
#######################################################################

sub display_preview_ad
  {              

# Check for valid e-mail address

    if ($form_data{'email'} ne "")
       {
           unless ($form_data{'email'} =~ /.*\@.*\..*/) {
               &email_error;
           }
      }

# Check for valid URL

   if ($form_data{'url'} ne "")
     {
           unless ($form_data{'url'} =~ /http:\/\/.*\..*/) {
               &url_error;
           }
    }

if (($form_data{'name'} eq "") || ($form_data{'city'} eq "") || ($form_data{'state'} eq "") || ($form_data{'email'} eq "") || ($form_data{'category'} eq "") || ($form_data{'caption'} eq "") || ($form_data{'text'} eq "") || ($form_data{'password'} eq "") || ($form_data{'ad_duration'} eq "")) {  &required_error;   }

$usertext = $form_data{'text'};
$usertext =~ s/~nl~/\n/g;
$usertext =~ s/(\W+)/\|/g;
@ad_words = split (/\|/, $usertext);
$number_of_words = @ad_words;

if ($number_of_words > $maxwords) { &word_limit_error; }

@ad_categories = &SplitParam($form_data{'category'});
foreach $item (@ad_categories)
{
# chop ($item) if ($item =~ /\W$/);
$ad_categories .= "$item&&";
}

$ad_categories =~ s/\&\&$//g;

$number_of_ads = @ad_categories;

if ($number_of_ads > $max_ads) { &ad_limit_error; }

# unless ($verified eq "on") {
# exit;
#  }

if ($fee eq "on") {
$unformatted_total_cost = $first_ad_cost + (($number_of_ads - 1) * $multiple_ad_cost);
$total_cost = sprintf ("%.2f", $unformatted_total_cost);
  }

&preview_ad_form;
exit;

}

#######################################################################
#                      Submit an Addition                             # 
#######################################################################

sub submit_addition
  {              

# Check for valid e-mail address

    if ($form_data{'email'} ne "")
       {
           unless ($form_data{'email'} =~ /.*\@.*\..*/) {
               &email_error;
           }
      }

# Check for valid URL

   if ($form_data{'url'} ne "")
     {
           unless ($form_data{'url'} =~ /http:\/\/.*\..*/) {
               &url_error;
           }
    }

if (($form_data{'name'} eq "") || ($form_data{'city'} eq "") || ($form_data{'state'} eq "") || ($form_data{'email'} eq "") || ($form_data{'category'} eq "") || ($form_data{'caption'} eq "") || ($form_data{'text'} eq "") || ($form_data{'password'} eq "") || ($form_data{'ad_duration'} eq "")) {  &required_error;   }

$usertext = $form_data{'text'};
$usertext =~ s/~nl~/\n/g;
$usertext =~ s/(\W+)/\|/g;
@ad_words = split (/\|/, $usertext);
$number_of_words = @ad_words;

if ($number_of_words > $maxwords) { &word_limit_error; }

@ad_categories = &SplitParam($form_data{'category'});
foreach $item (@ad_categories)
{
# chop ($item) if ($item =~ /\W$/);
$ad_categories .= "$item&&";
}

$ad_categories =~ s/\&\&$//g;

$number_of_ads = @ad_categories;

if ($number_of_ads > $max_ads) { &ad_limit_error; }

unless ($verified eq "on") {
 exit;
  }

$duration_match = "off";
foreach $duration (@ad_duration) {
if ($form_data{'ad_duration'} eq "$duration") {
$duration_match = "on";
last;
  }
}
if ($duration_match ne "on") {
$form_data{'ad_duration'} = $ad_duration[0];
}

if ($fee eq "on") {
$unformatted_total_cost = $first_ad_cost + (($number_of_ads - 1) * $multiple_ad_cost);
$total_cost = sprintf ("%.2f", $unformatted_total_cost);
  }

if ($check_duplicates eq "on") {
&check_duplicates;
}

sub check_duplicates {

$duplicate_found = "";

  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Check Duplicates",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);
      @fields = split(/\|/, $line);
if (($fields[9] eq $ad_categories) && ($fields[10] eq $form_data{'caption'}) && ($fields[11] eq $form_data{'text'})) {
$duplicate_found = "on";
}
   } # End of while datafile has data
   close(DATAFILE);

if ($duplicate_found) {
&duplicate_error;
  }
}

if (!$flock) { &get_file_lock("$location_of_counter_lock_file"); }
  open (COUNTER_FILE, "$location_of_counter_file") || 
	&file_open_error ("$location_of_counter_file", "Submit Addition",
	__FILE__, __LINE__);
if ($flock) { flock COUNTER_FILE, 2; }
  open (NEW_COUNTER_FILE, ">$location_of_new_counter_file") || 
	&file_open_error ("$location_of_new_counter_file", "Submit Addition",
	__FILE__, __LINE__);

  while (<COUNTER_FILE>)
    {
    $line = $_; 
    chomp $line;
    $current_counter = $line;
  $current_counter++;
  $new_counter = $current_counter;

  print NEW_COUNTER_FILE "$new_counter";
  }

  close (NEW_COUNTER_FILE);
if ($flock) { rename($location_of_new_counter_file, $location_of_counter_file); }
  close (COUNTER_FILE);
if (!$flock) { 
unlink("$location_of_counter_file");
rename($location_of_new_counter_file, $location_of_counter_file); }

if ($os eq "unix") { chmod 0666, "$location_of_counter_file"; }

if (!$flock) { &release_file_lock("$location_of_counter_lock_file"); }

if (!$flock) { &get_file_lock("$location_of_lock_file"); }
  open (DATABASE, ">>$data_file_path") || 
        die "can't open data file\n";                      
if ($flock) { flock DATABASE, 2; }

if ($require_admin_approval eq "on") { $new_status = "temp"; }
else { $new_status = "ok"; }

    $new_row .= "$form_data{'name'}|$form_data{'street'}|$form_data{'city'}|$form_data{'state'}|$form_data{'zip'}|$form_data{'country'}|$form_data{'phone'}|$form_data{'email'}|$form_data{'url'}|$ad_categories|$form_data{'caption'}|$form_data{'text'}|$current_date|0|$new_status|$form_data{'password'}|$form_data{'ad_duration'}|$form_data{'caption_header'}|$form_data{'display_address'}||$new_counter\n";

  print DATABASE $new_row;
  close (DATABASE);

if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

if ($uselogs) {
  open (LOG_FILE, ">>$location_of_log_file") || die "can't open log file\n";
  print LOG_FILE "ADD\|$ENV{'REMOTE_ADDR'}\|$new_row";
  close (LOG_FILE);

if ($os eq "unix") { chmod 0666, "$location_of_log_file"; }
  }

  &release_file_lock("$location_of_lock_file");

# The following code allows you to harvest e-mail addresses from the ads by
# adding the name and e-mail address of the poster to a text file.  This should
# be done only with the user's permission, through the usage of a checkbox
# on the ad submission form.  Otherwise, it's SPAM!

if (($form_data{'add_to_mailing_list'} eq "on") && ($collect_email_addresses eq "on")) {

if (!$flock) { &get_file_lock("$location_of_mailinglist_lock_file"); }
  open (MAILINGLIST_FILE, "$location_of_email_list") ;
if ($flock) { flock MAILINGLIST_FILE, 2; }

$location_of_new_email_list = "$location_of_email_list.tmp";
  open (NEW_MAILINGLIST_FILE, ">$location_of_new_email_list") ;

  while (<MAILINGLIST_FILE>)
    {
    $line = $_; 
    chop ($line) if ($line =~ /\n$/);
    @fields = split (/\|/, $line);

	if ($form_data{'email'} eq $fields[0]) { 
	$mailmatch = "on";
	print NEW_MAILINGLIST_FILE "$line\n";
	}

	else { print NEW_MAILINGLIST_FILE "$line\n"; }
    }

if ($mailmatch ne "on") {
print NEW_MAILINGLIST_FILE "$form_data{'email'}\|$form_data{'name'}\n";
}

  close (NEW_MAILINGLIST_FILE);
if ($flock) { rename($location_of_new_email_list, $location_of_email_list); }
  close (MAILINGLIST_FILE);
if (!$flock) { 
unlink("$location_of_email_list");
rename($location_of_new_email_list, $location_of_email_list); }

if ($os eq "unix") { chmod 0666, "$location_of_email_list"; }

if (!$flock) { &release_file_lock("$location_of_mailinglist_lock_file"); }
}

# The following code causes the script to notify the admin anytime someone
# adds an entry.

$user_email = $form_data{'email'};

if ($notify_add eq "on")
	{
&add_email_message;

if ($require_admin_from_address) { $from = $master_admin_email_address; }
else { $from = $user_email; }

&send_mail($from, $master_admin_email_address, $subject, $message);
    }

# The following code causes the script to send an e-mail message to the person
# who just posted a classified ad.
# First, it checks to see whether they entered an e-mail address on the form.  If not,
# it skips this section and doesn't send them the e-mail message.

if (($form_data{'email'} ne "") && ($reply_user eq "on"))
  {
&user_response_email_message;
&send_mail($master_admin_email_address, $user_email, $subject, $message);
}

  &successful_addition_message;

if ($use_instant_autonotify eq "on") {
&instant_autonotify;
}

  }             
                
#######################################################################
#                       Submit a Modification                         # 
#######################################################################

		# The user might also be submitting a modification to the
		# database.

sub submit_modification
  {              

		# The first thing we must do is make sure that they
		# actually chose a database item to modify.  If they did
		# not, we better warn them and stop processing.

  if ($form_data{'item_to_modify'} eq "")
    {
    &no_item_submitted_for_modification;
    exit;
    }

# Check for valid e-mail address

    if ($form_data{'email'} ne "")
       {
           unless ($form_data{'email'} =~ /.*\@.*\..*/) {
               &email_error;
           }
      }

# Check for valid URL

   if ($form_data{'url'} ne "")
     {
           unless ($form_data{'url'} =~ /http:\/\/.*\..*/) {
               &url_error;
           }
    }

if (($form_data{'name'} eq "") || ($form_data{'city'} eq "") || ($form_data{'state'} eq "") || ($form_data{'email'} eq "") || ($form_data{'caption'} eq "") || ($form_data{'text'} eq "") || ($form_data{'password'} eq "")) {  &required_error;   }

$usertext = $form_data{'text'};
$usertext =~ s/~nl~/\n/g;
$usertext =~ s/(\W+)/\|/g;
@ad_words = split (/\|/, $usertext);
$number_of_words = @ad_words;

if ($number_of_words > $maxwords) { &word_limit_error; }


if (!$flock) { &get_file_lock("$location_of_lock_file"); }
  open (DATABASE, "$data_file_path") || &file_open_error
	("$data_file_path", "Modify item",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_data_file_path") || &file_open_error
	("$new_data_file_path", "Modify item",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    if ($fields[20] ne $form_data{'item_to_modify'})
      {
print NEW_DATABASE "$line\n";
      }

    else
      {
      $old_row = "$line";

if (($require_admin_approval eq "on") && ($form_data{'admin_password'} eq "$admin_password")) { $new_status = "ok"; }
else { $new_status = "$fields[14]"; }

if ($form_data{'renew_ad'} eq "on") {
if ((($limit_renewals eq "on") && ($fields[13] < $max_renewals)) || ($limit_renewals ne "on")) {
$ad_renewed = "on";
$new_renewals = $fields[13] + 1;
$new_ad_duration = $fields[16] + $fields[16];
  }
else {
$new_renewals = $fields[13];
$new_ad_duration = $fields[16];
  }
}

else {
$new_renewals = $fields[13];
$new_ad_duration = $fields[16];
  }

    $new_row = "$form_data{'name'}|$form_data{'street'}|$form_data{'city'}|$form_data{'state'}|$form_data{'zip'}|$form_data{'country'}|$form_data{'phone'}|$form_data{'email'}|$form_data{'url'}|$fields[9]|$form_data{'caption'}|$form_data{'text'}|$fields[12]|$new_renewals|$new_status|$form_data{'password'}|$new_ad_duration|$form_data{'caption_header'}|$form_data{'display_address'}|$fields[19]|$fields[20]";

	$new_row =~ s/([\0-\37\177])/ /g;
	$new_row =~ s/\r\n/ /g;

print NEW_DATABASE "$new_row\n";

# Define new variables here

      $user_modify = $fields[0];
      $email_modify = $fields[7];
      $url_modify = $fields[8];
	$status = $fields[14];
	$db_id_modify = $fields[20];

      } # End of  else
    } # End of while (<DATABASE>)

  close (NEW_DATABASE);
if ($flock) { rename($new_data_file_path, $data_file_path); }
  close (DATABASE);
if (!$flock) { 
unlink("$data_file_path");
rename($new_data_file_path, $data_file_path); }

if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

if ($uselogs) {
  open (LOG_FILE, ">>$location_of_log_file") || die "can't open log file\n";
  print LOG_FILE "MODIFY\|$ENV{'REMOTE_ADDR'}\|$new_row";
  print LOG_FILE "MODIFY_OLD\|$old_row\n";  
  close (LOG_FILE);

if ($os eq "unix") { chmod 0666, "$location_of_log_file"; }
  }

# The following code causes the script to notify the admin anytime
# someone modifies an entry.
# Again, make sure that you have properly defined the variables in the setup file.

if ($notify_modify eq "on")
	{
&modify_email_message;

if ($require_admin_from_address) { $from = $master_admin_email_address; }
else { $from = $email_modify; }

&send_mail($from, $master_admin_email_address, $subject, $message);

    }

if (($charge_for_renewals eq "on") && ($ad_renewed eq "on"))
  {
&renew_response_email_message;
&send_mail($master_admin_email_address, $email_modify, $subject, $message);
}

    &successful_modification_message;
  }             

#######################################################################
#                       Submit a Deletion                             #  
#######################################################################                 

		# Finally, the user might be asking to make an actual
		# deletion.

sub submit_deletion
  {              

		# As in the case of modification, we must make sure the
		# user actually chose an item to delete from the list.

  if ($form_data{'item_to_delete'} eq "")
    {
    &no_item_submitted_for_modification;
    exit;
    }

if (!$flock) { &get_file_lock("$location_of_lock_file"); }

    open (DATABASE, "$data_file_path") || &file_open_error
        ("$data_file_path", "Delete Item",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_data_file_path") || &file_open_error
	("$new_data_file_path", "Modify item",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_;
    chop $line;
    @fields = split (/\|/, $line);

		# Then, for each item in the delete list, we will delete it
		# if the current line's item id is equal to the id submitted.

    if ($fields[20] ne $form_data{'item_to_delete'})
      {
print NEW_DATABASE "$line\n";
      }

    else
      {
      $deleted_row = "$line";
      $user_delete = $fields[0];
      $email_delete = $fields[7];
      $url_delete = $fields[8];
	$status = $fields[14];
	$db_id_delete = $fields[20];
	}

}

  close (NEW_DATABASE);
if ($flock) { rename($new_data_file_path, $data_file_path); }
  close (DATABASE);
if (!$flock) { 
unlink("$data_file_path");
rename($new_data_file_path, $data_file_path); }

if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

if ($uselogs) {
  open (LOG_FILE, ">>$location_of_log_file") || die "can't open log file\n";
  print LOG_FILE "$deleted_row";  
  close (LOG_FILE);

if ($os eq "unix") { chmod 0666, "$location_of_log_file"; }
  }

unlink("$upload_path/$db_id_delete.gif");
unlink("$upload_path/$db_id_delete.jpg");

# The following code causes the script to notify the admin anytime someone deletes an entry.
# Again, make sure that you have properly defined the variables in the setup file.

if ($notify_delete eq "on")
	{
&delete_email_message;

if ($require_admin_from_address) { $from = $master_admin_email_address; }
else { $from = $email_delete; }

&send_mail($from, $master_admin_email_address, $subject, $message);

      }

    &successful_deletion_message;
	$successful_deletion = "on";
  }             

#######################################################################
#                       Approve Ads                         # 
#######################################################################

# The following routine updates the database for items that have been
# approved by the administrator.

sub approve_ads
  {              

if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }

  if ($form_data{'db_id'} eq "")
    {
    &no_item_submitted_for_modification;
    exit;
    }

if (!$flock) { &get_file_lock("$location_of_lock_file"); }
    open (DATABASE, "<$data_file_path") || &file_open_error 
        ("$data_file_path", "Approve Item",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_data_file_path") || &file_open_error
	("$new_data_file_path", "Modify item",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    if ($fields[20] ne $form_data{'db_id'})
      {
      print NEW_DATABASE "$line\n";
      }

    else
      {
      $old_row = "$line";

    $new_row = "$fields[0]|$fields[1]|$fields[2]|$fields[3]|$fields[4]|$fields[5]|$fields[6]|$fields[7]|$fields[8]|$fields[9]|$fields[10]|$fields[11]|$fields[12]|$fields[13]|ok|$fields[15]|$fields[16]|$fields[17]|$fields[18]|$fields[19]|$fields[20]";

	$new_row =~ s/([\0-\37\177])/ /g;
	$new_row =~ s/\r\n/ /g;

      print NEW_DATABASE "$new_row\n";

      } # End of  else
    } # End of while (<DATABASE>)

  close (NEW_DATABASE);
if ($flock) { rename($new_data_file_path, $data_file_path); }
  close (DATABASE);
if (!$flock) { 
unlink("$data_file_path");
rename($new_data_file_path, $data_file_path); }

if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

    &release_file_lock("$location_of_lock_file");

    &successful_approval_message;
  }             

#######################################################################
#                    Search and Display the Database 		      #
#######################################################################  
    
sub search_and_display_db
  {              

$form_data{'keywords'} =~ s/~p~/\|/g;
$form_data{'category'} =~ s/~p~/\|/g;
$form_data{'text'} =~ s/~p~/\|/g;
$form_data{'status'} =~ s/~p~/\|/g;
$form_data{'password'} =~ s/~p~/\|/g;
$form_data{'db_id'} =~ s/~p~/\|/g;

if (($form_data{'display_new_ads_button'} ne "") || ($form_data{'show_temp_ads'} ne "")){
$form_data{'status'} = "temp";
}

elsif (($form_data{'display_modification_form_button'} ne "") || ($form_data{'search_and_display_for_deletion_button'} ne "") || ($searchall eq "on")) {
$form_data{'status'} = "temp|ok";
}

else { $form_data{'status'} = "ok"; }

# if (($form_data{'display_modification_form_button'} ne "") || # ($form_data{'search_and_display_for_deletion_button'} ne "")) {
# if ($form_data{'password'} eq $admin_password) { $form_data{'password'} = ""; }
#   $form_data{'exact_match'} = "on"; }

if ($form_data{'boolean'} eq "any terms") {
   $form_data{'keywords'} =~ s/\s+/\|/g; }

if ($form_data{'boolean'} eq "as a phrase") {
   $form_data{'as_a_phrase'} = "on"; }

  if ($form_data{'days_ago'} ne "")
    {
($today_month,$today_day,$today_year) = split (/\//, &get_date);
$today = &jday($today_month,$today_day,$today_year);
$oldest_day = ($today - $form_data{'days_ago'});
($beginmonth, $beginday, $beginyear, $beginweekday) = &jdate($oldest_day);
$form_data{'date_begin'} = "$beginmonth/$beginday/$beginyear";
    }


  ($total_row_count) = &submit_query(*database_rows);


unless ($display_results_html eq "off") {
  if ($total_row_count < 1)
    {
    &no_hits_message;
    exit;
    }           
  }

if ($form_data{'display_modification_form_button'} ne "") { $hits_seen = 0; }

else { $hits_seen = $form_data{'new_hits_seen'}; }

  for ($i = 1;$i <= $hits_seen;$i++)
    {
    $seen_row = shift (@database_rows);
    }

  $length_of_database_rows = @database_rows;
                

  for ($i = $length_of_database_rows-1;$i >= $max_rows_returned;$i--)
    {
    $extra_row = pop (@database_rows);
    }

  $new_hits_seen = $hits_seen + $max_rows_returned;

  $old_hits_seen = $hits_seen - $max_rows_returned;

unless ($display_results_html eq "off") {
  &search_results_body;
  &search_results_footer;
	}
  }

###################

sub submit_query
  {

  local($row_count);
  $row_count = 0;

if ($form_data{'query'} eq "browse") { &browse; }
elsif ($form_data{'query'} eq "keyword") { &keyword_search; }
elsif ($form_data{'query'} eq "category") { &category_search; }
elsif ($form_data{'query'} eq "retrieval") { &retrieval; }
elsif ($form_data{'query'} eq "edit") { &edit; }
elsif ($form_data{'query'} eq "advanced_search") { &advanced_search; }
elsif ((!$form_data{'query'}) && ($disable_advanced_searching)) { &keyword_search; }
else { &advanced_search; }

sub browse {
  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);
      @fields = split(/\|/, $line);
unless ($fields[14] ne "ok") {
&presort;
      $row_count++;
	}
   } # End of while datafile has data
   close(DATAFILE);
&sort;
  return($row_count);
}

sub keyword_search {
	$form_data{'keywords'} =~ s/ampersand/&/g; 
	$form_data{'keywords'} =~ s/equalsign/=/; 

	$form_data{'keywords'} =~ s/\+/plussign/g; 
	$form_data{'keywords'} =~ s/[\+]+/\\\+/; 
	$form_data{'keywords'} =~ s/\*/starsymbol/g;
	$form_data{'keywords'} =~ s/\?/questionmark/g; 
	$form_data{'keywords'} =~ s/\[/leftbracket/g;
	$form_data{'keywords'} =~ s/\(/leftparen/g;
	$form_data{'keywords'} =~ s/\)/rightparen/g;
	$form_data{'keywords'} =~ s/\$/dollarsign/g;

@word_list = split(/\s+/,$form_data{'keywords'});
  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);

	$line =~ s/\+/plussign/g; 
	$line =~ s/[\+]+/\\\+/; 
	$line =~ s/\*/starsymbol/g;
	$line =~ s/\?/questionmark/g; 
	$line =~ s/\[/leftbracket/g;
	$line =~ s/\(/leftparen/g;
	$line =~ s/\)/rightparen/g;
	$line =~ s/\$/dollarsign/g;

       @fields = split(/\|/, $line);
 if ($fields[14] ne "ok") { next; }

if ($form_data{'keywords'} eq "") {

foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
}

&presort;
$row_count++;
next;
	}

foreach $word (@word_list) { 

if ($line =~ /$word/i) {

foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
}

 &presort;
      $row_count++;
	last;
	}
     }
   } # End of while datafile has data
   close(DATAFILE);

@database_rows = @new_rows;

 &sort;

  return($row_count);
}

sub category_search {
	$form_data{'category'} =~ s/ampersand/&/g; 
	$form_data{'category'} =~ s/equalsign/=/; 
	$form_data{'category'} =~ s/\+/plussign/g; 
	$form_data{'category'} =~ s/[\+]+/\\\+/; 
	$form_data{'category'} =~ s/\*/starsymbol/g;
	$form_data{'category'} =~ s/\?/questionmark/g; 
	$form_data{'category'} =~ s/\[/leftbracket/g;
	$form_data{'category'} =~ s/\(/leftparen/g;
	$form_data{'category'} =~ s/\)/rightparen/g;
	$form_data{'category'} =~ s/\$/dollarsign/g;

  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);
      @fields = split(/\|/, $line);


	$fields[9] =~ s/\+/plussign/g; 
	$fields[9] =~ s/[\+]+/\\\+/; 
	$fields[9] =~ s/\*/starsymbol/g;
	$fields[9] =~ s/\?/questionmark/g; 
	$fields[9] =~ s/\[/leftbracket/g;
	$fields[9] =~ s/\(/leftparen/g;
	$fields[9] =~ s/\)/rightparen/g;
	$fields[9] =~ s/\$/dollarsign/g;

if ((($fields[9] =~ /$form_data{'category'}/i) && ($fields[14] eq "ok")) || (($form_data{'category'} eq "") && ($fields[14] eq "ok"))) {

	$fields[9] =~ s/plussign/\+/g; 
	$fields[9] =~ s/\\\+/[\+]+/; 
	$fields[9] =~ s/starsymbol/\*/g;
	$fields[9] =~ s/questionmark/\?/g; 
	$fields[9] =~ s/leftbracket/\[/g;
	$fields[9] =~ s/leftparen/\(/g;
	$fields[9] =~ s/rightparen/\)/g;
	$fields[9] =~ s/dollarsign/\$/g;

&presort;

      $row_count++;
	}
   } # End of while datafile has data
   close(DATAFILE);

@database_rows = @new_rows;

# &sort;

  return($row_count);
}

sub retrieval {
  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);
      @fields = split(/\|/, $line);
if ($fields[20] == $form_data{'db_id'}) {
&presort;
      $row_count++;
	last;
	}
   } # End of while datafile has data
   close(DATAFILE);
&sort;
  return($row_count);
}

sub edit {
  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);
      @fields = split(/\|/, $line);
if (($form_data{'db_id'} == $fields[20]) && (($form_data{'password'} eq $fields[15]) ||  ($form_data{'password'} eq $admin_password))) {
&presort;
      $row_count++;
	last;
	}
   } # End of while datafile has data
   close(DATAFILE);
&sort;
  return($row_count);
}

sub advanced_search {
	$form_data{'keywords'} =~ s/ampersand/&/g; 
	$form_data{'keywords'} =~ s/equalsign/=/; 

	$form_data{'keywords'} =~ s/\+/plussign/g; 
	$form_data{'keywords'} =~ s/[\+]+/\\\+/; 
	$form_data{'keywords'} =~ s/\*/starsymbol/g;
	$form_data{'keywords'} =~ s/\?/questionmark/g; 
	$form_data{'keywords'} =~ s/\[/leftbracket/g;
	$form_data{'keywords'} =~ s/\(/leftparen/g;
	$form_data{'keywords'} =~ s/\)/rightparen/g;
	$form_data{'keywords'} =~ s/\$/dollarsign/g;

@word_list = split(/\s+/,$form_data{'keywords'});
  open(DATAFILE, "$data_file_path") ||
    &file_open_error("$data_file_path",
      "Read Database",__FILE__,__LINE__);
  while(($line = <DATAFILE>)) 
    {
      chop($line);

	$line =~ s/\+/plussign/g; 
	$line =~ s/[\+]+/\\\+/; 
	$line =~ s/\*/starsymbol/g;
	$line =~ s/\?/questionmark/g; 
	$line =~ s/\[/leftbracket/g;
	$line =~ s/\(/leftparen/g;
	$line =~ s/\)/rightparen/g;
	$line =~ s/\$/dollarsign/g;

       @fields = split(/\|/, $line);

if (($form_data{'display_new_ads_button'} ne "") || ($form_data{'show_temp_ads'} ne "")) {
if ($fields[14] ne "temp") { next; }
}

elsif (($form_data{'display_modification_form_button'} ne "") || ($form_data{'search_and_display_for_deletion_button'} ne "") || ($searchall eq "on")) {
$form_data{'status'} = "temp|ok";
}

else { 
if ($fields[14] ne "ok") { next; }
}


$number = $fields[20];

if ($form_data{'photo'} ne "") {
unless ((-e "$upload_path/$number.gif") || (-e "$upload_path/$number.jpg")) { next; }
}

if ($form_data{'category'} ne "") {
unless ($fields[9] =~ /$form_data{'category'}/) { next; }
}

if ($form_data{'caption_header'} ne "") {
unless ($fields[17] eq $form_data{'caption_header'}) { next; }
}

$date_field = $fields[12];
($mo, $da, $yr) = split(/\//, $date_field);
$ad_day = &jday($mo,$da,$yr);
if ($ad_day < $oldest_day) { next; }

if ($form_data{'keywords'} eq "") {

foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
}

&presort;
$row_count++;
next;
	}

if (!$form_data{'case_sensitive'}) {

if ($form_data{'boolean'} eq "any terms") {
foreach $word (@word_list) { 
if ($line =~ /$word/i) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	last;
	}
     }
}

if ($form_data{'boolean'} eq "all terms") {
$match = 1;
foreach $word (@word_list) { 
unless ($line =~ /$word/i) {
$match = 0;
last;
  }
}

if ($match == 1) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	}
}

if ($form_data{'boolean'} eq "as a phrase") {
if ($line =~ /$form_data{'keywords'}/i) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	}
}
} # end of case insensitive

else {

if ($form_data{'boolean'} eq "any terms") {
foreach $word (@word_list) { 
if ($line =~ /$word/) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	last;
	}
     }
}

if ($form_data{'boolean'} eq "all terms") {
$match = 1;
foreach $word (@word_list) { 
unless ($line =~ /$word/) {
$match = 0;
last;
  }
}

if ($match == 1) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	}
}

if ($form_data{'boolean'} eq "as a phrase") {
if ($line =~ /$form_data{'keywords'}/) {
foreach $field (@fields) {
	$field =~ s/plussign/\+/g; 
	$field =~ s/\\\+/[\+]+/; 
	$field =~ s/starsymbol/\*/g;
	$field =~ s/questionmark/\?/g; 
	$field =~ s/leftbracket/\[/g;
	$field =~ s/leftparen/\(/g;
	$field =~ s/rightparen/\)/g;
	$field =~ s/dollarsign/\$/g;
	}
 &presort;
      $row_count++;
	}
}
} # end of case sensitive

   } # End of while datafile has data
   close(DATAFILE);

&sort;
return($row_count);
}

  } 

sub presort {

if ($use_default_sorting) {
    $new_row = join ("\|", @fields);
    unshift (@new_rows, $new_row);
}

else {
    $sortable_field = $fields[$index_of_field_to_be_sorted_by];
	if ($numeric_sort)
		{

		$sortable_field =~ s/\$//g;
		$sortable_field =~ s/,//g;
		$sortable_field =~ s/(\d+)([kK])/${1}000/gi;
		$sortable_field =~ s/([^0-9\.]+)/ /g;
		$sortable_field =~ s/^([^0-9\.]*)(\d+\.?\d*|\.\d+)(.*)$/$2/g;

		unless ( $sortable_field =~ /^(\d+\.?\d*|\.\d+)$/ )
			{ $sortable_field = 0; }

		}

      if ($date_sort)
		{
 ($mo, $da, $yr) = split(/\//, $sortable_field);
 
        $mo = "0" . $mo
          if (length($mo) < 2);

        $da = "0" . $da
          if (length($da) < 2);

        $yr = (1900 + $yr)
          if (length($yr) < 3);

		# Then we will assign the new formatted date to $db_date.

        $sortable_field = $yr . $mo . $da;

	}

    unshift (@fields, $sortable_field);
    $new_row = join ("\|", @fields);
# $new_rows[$row_count] = $new_row;
    push (@new_rows, $new_row);
  } #end of else
} # end of sub presort

sub sort {
  @database_rows = ();

if ($use_default_sorting) {
@database_rows = @new_rows;

# @sorted_rows = @new_rows;
#  $i = 1;
#  foreach $sorted_row (@sorted_rows)
#    {
#    @row = split (/\|/, $sorted_row);
#    push (@row, $i);
#    $old_but_sorted_row = join ("\|", @row);
#    push (@database_rows, $old_but_sorted_row);
#    $i++;
#    }
}

else {

 if ($numeric_sort)
 {

  if ($use_reverse_sorting)
	{
@sorted_rows = sort {$b <=> $a} @new_rows;
	}
  else
	{
@sorted_rows = sort {$a <=> $b} @new_rows;
	}
  }

 else {
   if ($use_reverse_sorting) {
       @sorted_rows = sort { lc($b) cmp lc($a) } @new_rows;
   }
   else {
       @sorted_rows = sort { lc($a) cmp lc($b) } @new_rows;
   }
  }

@database_rows = @sorted_rows;

#  $i = 1;
#  foreach $sorted_row (@sorted_rows)
#    {
#    @row = split (/\|/, $sorted_row);
#    $sorted_field = shift (@row);
#    push (@row, $i);
#    $old_but_sorted_row = join ("\|", @row);
#    push (@database_rows, $old_but_sorted_row);
#    $i++;
#    }
  } # end of else
} # end of sub sort

sub imagesize {

local($image_file) = @_;

my(@options)=
  (
   'UseNewGifsize',   'bool',    'No',
   'UseHash',	      'bool',    'No',
   );

($image_width,$image_height) = &imgsize("$image_file");

return ($image_width,$image_height);

# Looking at the filename is somewhat crude.  A more sophisticated approach
# is to look at the first 4 bytes of the image.  The following are the numbers
# for some of the more common image formats.
#  PNG 89 50 4e 47    
#  GIF 47 49 46 38
#  JPG ff d8 ff e0
#  XBM 23 64 65 66

sub imgsize {
  my($file)= @_;
#  my($ref)=@_ ? shift @_ : "";
  my($x,$y)=(0,0);
  my($image_width,$image_height)=(0,0);
  
  # Open the file

open(STRM, "<$file");

# set binmode for Windows NT servers.  This may not work or be supported
# on all Windows NT servers.

    binmode( STRM ); 
    if ($file =~ /\.jpg$/i || $file =~ /\.jpeg$/i) {
      ($x,$y) = &jpegsize(\*STRM);
    } elsif($file =~ /\.gif$/i) {
      ($x,$y) = &gifsize(\*STRM);
    } elsif($file =~ /\.xbm$/i) {
      ($x,$y) = &xbmsize(\*STRM);
    } elsif($file =~ /\.png$/i) {
      ($x,$y) = &pngsize(\*STRM);
    } else {
      $image_file_error_message = "This file ($file) is not in either the gif, xbm, jpeg or png formats, or else it is incorrectly named.";
    }
    close(STRM);
    
#    if(&istrue($UseHash) && $x && $y){
#      $hashx{$file}=$x;
#      $hashy{$file}=$y;
#    }

  return ($x,$y);
}

sub istrue
{ 
  my( $val)=@_;  
  return (defined($val) && ($val =~ /^y(es)?/i || $val =~ /true/i ));
}

sub isfalse
{
  my( $val)=@_;  
  return (defined($val) && ($val =~ /^no?/i || $val =~ /false/i )); 
}

###########################################################################
# Subroutine gets the size of the specified GIF
###########################################################################
sub gifsize
{
  my($GIF) = @_;
  if( &istrue($UseNewGifsize) ){
    return &NEWgifsize($GIF);
  } else {
    return &OLDgifsize($GIF);
  }
}


sub OLDgifsize {
  my($GIF) = @_;
  my($type,$a,$b,$c,$d,$s)=(0,0,0,0,0,0);

  if(defined( $GIF )		&&
     read($GIF, $type, 6)	&&
     $type =~ /GIF8[7,9]a/	&&
     read($GIF, $s, 4) == 4	){
    ($a,$b,$c,$d)=unpack("C"x4,$s);
    return ($b<<8|$a,$d<<8|$c);
  }
  return (0,0);
}

# part of NEWgifsize
sub gif_blockskip {
  my ($GIF, $skip, $type) = @_;
  my ($s)=0;
  my ($dummy)='';
  
  read ($GIF, $dummy, $skip);	# Skip header (if any)
  while (1) {
    if (eof ($GIF)) {
      warn "Invalid/Corrupted GIF (at EOF in GIF $type)\n";
      return "";
    }
    read($GIF, $s, 1);		# Block size
    last if ord($s) == 0;	# Block terminator
    read ($GIF, $dummy, ord($s));	# Skip data    
  }
}

sub NEWgifsize {
  my($GIF) = @_;
  my($cmapsize, $a, $b, $c, $d, $e)=0;
  my($type,$s)=(0,0);
  my($x,$y)=(0,0);
  my($dummy)='';
  
  return($x,$y) if(!defined $GIF);
  
  read($GIF, $type, 6); 
  if($type !~ /GIF8[7,9]a/ || read($GIF, $s, 7) != 7 ){
    warn "Invalid/Corrupted GIF (bad header)\n"; 
    return($x,$y);
  }
  ($e)=unpack("x4 C",$s);
  if ($e & 0x80) {
    $cmapsize = 3 * 2**(($e & 0x07) + 1);
    if (!read($GIF, $dummy, $cmapsize)) {
      warn "Invalid/Corrupted GIF (global color map too small?)\n";
      return($x,$y);
    }
  }
 FINDIMAGE:
  while (1) {
    if (eof ($GIF)) {
      warn "Invalid/Corrupted GIF (at EOF w/o Image Descriptors)\n";
      return($x,$y);
    }
    read($GIF, $s, 1);
    ($e) = unpack("C", $s);
    if ($e == 0x2c) {		# Image Descriptor (GIF87a, GIF89a 20.c.i)
      if (read($GIF, $s, 8) != 8) {
	warn "Invalid/Corrupted GIF (missing image header?)\n";
	return($x,$y);
      }
      ($a,$b,$c,$d)=unpack("x4 C4",$s);
      $x=$b<<8|$a;
      $y=$d<<8|$c;
      return($x,$y);
    }
    if ($type eq "GIF89a") {
      if ($e == 0x21) {		# Extension Introducer (GIF89a 23.c.i)
	read($GIF, $s, 1);
	($e) = unpack("C", $s);
	if ($e == 0xF9) {	# Graphic Control Extension (GIF89a 23.c.ii)
	  read($GIF, $dummy, 6);	# Skip it
	  next FINDIMAGE;	# Look again for Image Descriptor
	} elsif ($e == 0xFE) {	# Comment Extension (GIF89a 24.c.ii)
	  &gif_blockskip ($GIF, 0, "Comment");
	  next FINDIMAGE;	# Look again for Image Descriptor
	} elsif ($e == 0x01) {	# Plain Text Label (GIF89a 25.c.ii)
	  &gif_blockskip ($GIF, 12, "text data");
	  next FINDIMAGE;	# Look again for Image Descriptor
	} elsif ($e == 0xFF) {	# Application Extension Label (GIF89a 26.c.ii)
	  &gif_blockskip ($GIF, 11, "application data");
	  next FINDIMAGE;	# Look again for Image Descriptor
	} else {
	  printf STDERR "Invalid/Corrupted GIF (Unknown extension %#x)\n", $e;
	  return($x,$y);
	}
      }
      else {
	printf STDERR "Invalid/Corrupted GIF (Unknown code %#x)\n", $e;
	return($x,$y);
      }
    }
    else {
      warn "Invalid/Corrupted GIF (missing GIF87a Image Descriptor)\n";
      return($x,$y);
    }
  }
}

# jpegsize : gets the width and height (in pixels) of a jpeg file
sub jpegsize {
  my($JPEG) = @_;
  my($done)=0;
  my($c1,$c2,$ch,$s,$length, $dummy)=(0,0,0,0,0,0);
  my($a,$b,$c,$d);
  
  if(defined($JPEG)		&&
     read($JPEG, $c1, 1)	&&
     read($JPEG, $c2, 1)	&&
     ord($c1) == 0xFF		&& 
     ord($c2) == 0xD8		){
    while (ord($ch) != 0xDA && !$done) {
      # Find next marker (JPEG markers begin with 0xFF)
      # This can hang the program!!
      while (ord($ch) != 0xFF) { return(0,0) unless read($JPEG, $ch, 1); }
      # JPEG markers can be padded with unlimited 0xFF's
      while (ord($ch) == 0xFF) { return(0,0) unless read($JPEG, $ch, 1); }
      # Now, $ch contains the value of the marker.
      if ((ord($ch) >= 0xC0) && (ord($ch) <= 0xC3)) {
	return(0,0) unless read ($JPEG, $dummy, 3); 
	return(0,0) unless read($JPEG, $s, 4);
	($a,$b,$c,$d)=unpack("C"x4,$s);
	return ($c<<8|$d, $a<<8|$b );
      } else {
	# We **MUST** skip variables, since FF's within variable names are
	# NOT valid JPEG markers
	return(0,0) unless read ($JPEG, $s, 2); 
	($c1, $c2) = unpack("C"x2,$s); 
	$length = $c1<<8|$c2;
	last if (!defined($length) || $length < 2);
	read($JPEG, $dummy, $length-2);
      }
    }
  }
  return (0,0);
}

} # end of sub imagesize

#################################################################
#                      get_date Subroutine                      #
#################################################################
 
sub get_date
  {

  local ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst,$date);   
  local (@days, @months);

  @days = ('Sunday','Monday','Tuesday','Wednesday','Thursday',
           'Friday','Saturday');
  @months = ('January','February','March','April','May','June','July', 
             'August','September','October','November','December');

$time = time;
$hourdiff = 0;
$localtime = $time + ($hourdiff * 3600);
    
  ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($localtime);
  
  $year = (1900 + $year);

  if ($mon < 10)
    {
    $mon = "0$mon";
    }
  if ($mday < 10)
    {
    $mday = "0$mday";
    }
  $mon++;
$date = "$mon/$mday/$year";
  return $date;
  }                 

#######################################################################
#                            get_file_lock                            #
#######################################################################

sub get_file_lock
  {
  local ($lock_file) = @_;
  local ($timeout);
$timeout=90;	# in seconds

if ($flock eq "on") {
  open(LOCK_FILE, ">$lock_file") || &file_open_error ("$lock_file",
                                                      "Lock File Routine",
                                                      __FILE__, __LINE__);
flock(LOCK_FILE, 2); # 2 exclusively locks the file
  }

else {

  while (-e $lock_file && (stat($lock_file))[9]+$timeout>time)
  {
    sleep(1);
  }
                
  open(LOCK_FILE, ">$lock_file") || &file_open_error ("$lock_file",
                                                      "Lock File Routine",
                                                      __FILE__, __LINE__);
  }
}

#######################################################################
#                            release_file_lock                        #
#######################################################################

sub release_file_lock
  {
  local ($lock_file) = @_;

if ($flock eq "on") {
  close(LOCK_FILE);
flock(LOCK_FILE, 8); # 8 unlocks the file
  unlink($lock_file);
  }

else {
  close(LOCK_FILE);
  unlink($lock_file);
    }
  }

sub get_os {
&load_libraries;
unless ($disable_email) {
  unless (-e "$path/data/system.dat") {
  open (DATA_FILE, ">$path/data/system.dat") || 
        &file_open_error ("$path/data/system.dat", "Get System Data",   
        __FILE__, __LINE__);
  print DATA_FILE "$current_date";
  close (DATA_FILE);
if ($os eq "unix") { chmod 0666, "$path/data/system.dat"; }
&send_mail($from, $to, $subject, $message);
   }

($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
  if (($mday == 15) && (($mon == 0) || ($mon == 3) || ($mon == 6) || ($mon == 9)))  {
  if ((-e "$path/data/system.dat") && (-M "$path/data/system.dat" > 1)) {
  open (DATA_FILE, ">$path/data/system.dat") || 
        &file_open_error ("$path/data/system.dat", "Get System Data",   
        __FILE__, __LINE__);                      
  print DATA_FILE "$current_date";
  close (DATA_FILE);
if ($os eq "unix") { chmod 0666, "$path/data/system.dat"; }
&send_mail($from, $to, $subject, $message);
     }
   }
  }
}

#######################################################################
#                       warn subroutine 			         #
#######################################################################

sub warn
  {
if (($form_data{'print_html_response'} ne "") && ($noheader ne "on")) {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }
	}

    if ((-e "$location_of_warn_file") && (-M "$location_of_warn_file" < ($warn_runtime_interval-.01))) {
if ($form_data{'print_html_response'} eq "on") {
&warn_error_message;
	}
}
else { &warn_engine; }

sub warn_engine {

    $maximum_warning_days = (($minimum_warning_days + $warn_runtime_interval) - 1);

    &get_file_lock("$location_of_lock_file");

  open (DATABASE, "$data_file_path") || die "can't open data file\n";

  while (<DATABASE>)
    {
    $line = $_;
    chop $line;
    @fields = split (/\|/, $line);

($dbmonth,$dbday,$dbyear) = split (/\//, $fields[12]);
$julian_day = &jday($dbmonth,$dbday,$dbyear);
($today_month,$today_day,$today_year) = split (/\//, &get_date);
$today = &jday($today_month,$today_day,$today_year);
$posted_days_ago = ($today - $julian_day);

$expiration_days = $fields[16];
$daysleft = ($expiration_days - $posted_days_ago);

# Then, for each item in the database, if the ad falls within the
# date range that we have specified for sending out the warning notices,
# we will send an e-mail message to the poster notifying them that their
# ad is about to be deleted unless they renew it

  if (($daysleft >= $minimum_warning_days) && ($daysleft <= $maximum_warning_days)) {
      $user_row = "$line";
      $email_user = $fields[7];

&warn_email_message;

&send_mail($master_admin_email_address, $email_user, $subject, $message);
      }
    }
  close (DATABASE);

    &release_file_lock("$location_of_lock_file");

    open (FILE, ">$location_of_warn_file") || die "can't open data file\n";
    print FILE "1";
    close (FILE);

if ($os eq "unix") { chmod 0666, "$location_of_warn_file"; }

if ($form_data{'print_html_response'} eq "on") {
&warn_success_message;
  }

	}
  }

#######################################################################
#                       purge subroutine 			         #
#######################################################################

sub purge
  {
if (($form_data{'print_html_response'} ne "") && ($noheader ne "on")) {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }
	}

if ((-e "$location_of_purge_file") && (-M "$location_of_purge_file" < ($purge_runtime_interval-.01))) {
if ($form_data{'print_html_response'} eq "on") {
&purge_error_message;
	}
}
else { &purge_engine; }

sub purge_engine {

if (!$flock) { &get_file_lock("$location_of_lock_file"); }

  open (DATABASE, "$data_file_path") || &file_open_error
        ("$data_file_path", "Purge Database",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_data_file_path") || &file_open_error
	("$new_data_file_path", "Purge Database",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_;
    chop $line;
    @fields = split (/\|/, $line);

($dbmonth,$dbday,$dbyear) = split (/\//, $fields[12]);

$julian_day = &jday($dbmonth,$dbday,$dbyear);
($today_month,$today_day,$today_year) = split (/\//, &get_date);
$today = &jday($today_month,$today_day,$today_year);
$posted_days_ago = ($today - $julian_day);

$expiration_days = $fields[16];

		# Then, foreach item in the delete list, we will delete it
		# if the age of the datestamp id file is greater than the
		# amount specified in the setup file.

    if ($posted_days_ago <= $expiration_days)
      {
    print NEW_DATABASE "$line\n";
      }

    else
      {
#      $purged_rows .= "$line\n\n";
$db_id_purge = $fields[20];
unlink("$upload_path/$db_id_purge.gif");
unlink("$upload_path/$db_id_purge.jpg");
      }
    }

  close (NEW_DATABASE);
if ($flock) { rename($new_data_file_path, $data_file_path); }
  close (DATABASE);
if (!$flock) { 
unlink("$data_file_path");
rename($new_data_file_path, $data_file_path); }

if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

    open (FILE, ">$location_of_purge_file") || die "can't open purge file\n";
    print FILE "1";
    close (FILE);

if ($os eq "unix") { chmod 0666, "$location_of_purge_file"; }

if ($form_data{'print_html_response'} eq "on") {
&purge_success_message;
  }

	} # end of sub purge_engine
  }

#######################################################################
#                       delete_all subroutine 			         #
#######################################################################

sub delete_all
  {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }

if (!$flock) { &get_file_lock("$location_of_lock_file"); }
   open(FILE,">$data_file_path");
if ($flock) { flock FILE, 2; }
	print FILE "";
  close (FILE);
if ($os eq "unix") { chmod 0666, "$data_file_path"; }

if (!$flock) { &release_file_lock("$location_of_lock_file"); }

  &delete_all_success_message;
  }

#######################################################################
#                       autonotify subroutine 			         #
#######################################################################

sub autonotify
  {
if (($form_data{'print_html_response'} ne "") && ($noheader ne "on")) {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }
	}

if ($use_instant_autonotify eq "on") {
if ($form_data{'print_html_response'} eq "on") {
&instant_autonotify_error_message;
	}
}

    elsif ((-e "$location_of_autonotify_file") && (-M "$location_of_autonotify_file" < ($autonotify_days_interval-.01))) {
if ($form_data{'print_html_response'} eq "on") {
&autonotify_error_message;
	}
}
else { &autonotify_engine; }

sub autonotify_engine {

$display_results_html = "off";

  open (DATABASE, "$autonotify_data_file") || die "can't open keyword file\n";

	@lines = <DATABASE>;
	foreach $line (@lines) {
		chop ($line) if ($line =~ /\n$/);
	@notifyfields = split(/\|/,$line);

  @database_rows = ();
  @sorted_rows = ();
  @new_rows = ();
  $ad_message = "";

$form_data{'keywords'} = $notifyfields[0];
$form_data{'boolean'} = $notifyfields[1];
$form_data{'case_sensitive'} = $notifyfields[2];
$form_data{'category'} = $notifyfields[3];
$form_data{'caption_header'} = $notifyfields[4];
$form_data{'photo'} = $notifyfields[5];

$email_user = $notifyfields[6];
$form_data{'days_ago'} = $autonotify_days_interval;
$form_data{'max_hits'} = 200;

&search_and_display_db;

  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);
    $fields[9] =~ s/\&\&/, /g;
    foreach $index (@db_index_for_display)
      {
      $fields[$index] =~ s/~p~/\|/g;
      $fields[$index] =~ s/~nl~/\n/g;
      }
	&autonotify_message;
     }

&autonotify_email_message;

&send_mail($master_admin_email_address, $email_user, $subject, $message);

} # end foreach $line
  close (DATABASE);

     open (FILE, ">$location_of_autonotify_file") || die "can't open keyword file\n";
     print FILE "1";
     close (FILE);

if ($os eq "unix") { chmod 0666, "$location_of_autonotify_file"; }

if ($form_data{'print_html_response'} eq "on") {
&autonotify_success_message;
  }

} # end autonotify_engine

  }

#######################################################################
#                instant_autonotify subroutine 			         #
#######################################################################

sub instant_autonotify
  {

&instant_autonotify_engine;

sub instant_autonotify_engine {

$display_results_html = "off";
$searchall = "";

  &get_file_lock("$path/temp/autonotify.lock");

    open (FILE, ">$path/temp/autonotify.data") || die "can't open data file\n";
    print FILE "$new_row";
    close (FILE);

$data_file_path = "$path/temp/autonotify.data";

  open (DATABASE, "$autonotify_data_file") || die "can't open keyword file\n";

	@lines = <DATABASE>;
	foreach $line (@lines) {
		chop ($line) if ($line =~ /\n$/);
	@notifyfields = split(/\|/,$line);

  @database_rows = ();
  @sorted_rows = ();
  @new_rows = ();
  $ad_message = "";

$form_data{'keywords'} = $notifyfields[0];
$form_data{'boolean'} = $notifyfields[1];
$form_data{'case_sensitive'} = $notifyfields[2];
$form_data{'category'} = $notifyfields[3];
$form_data{'caption_header'} = $notifyfields[4];
$form_data{'photo'} = $notifyfields[5];

$email_user = $notifyfields[6];
$form_data{'days_ago'} = $autonotify_days_interval;
$form_data{'max_hits'} = 200;

$form_data{'category'} = "";
$form_data{'db_id'} = $new_counter;

&search_and_display_db;

  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);
    $fields[9] =~ s/\&\&/, /g;
    foreach $index (@db_index_for_display)
      {
      $fields[$index] =~ s/~p~/\|/g;
      $fields[$index] =~ s/~nl~/\n/g;
      }
	&autonotify_message;
     }

unless ($total_row_count == 0) {
&autonotify_email_message;
&send_mail($master_admin_email_address, $email_user, $subject, $message);
}

} # end foreach $line
  close (DATABASE);

unlink("$path/temp/autonotify.data");
  &release_file_lock("$path/temp/autonotify.lock");

} # end instant_autonotify_engine

  }

#######################################################################
#                       autonotify_purge subroutine 			  #
#######################################################################

sub autonotify_purge
  {
if (($form_data{'print_html_response'} ne "") && ($noheader ne "on")) {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }
	}

if ((-e "$location_of_autonotify_purge_file") && (-M "$location_of_autonotify_purge_file" < ($autonotify_purge_runtime_interval-.01))) {
if ($form_data{'print_html_response'} eq "on") {
&autonotify_purge_error_message;
	}
}
else { &autonotify_purge_engine; }

sub autonotify_purge_engine {

if (!$flock) { &get_file_lock("$location_of_autonotify_lock_file"); }

  open (DATABASE, "$autonotify_data_file") || &file_open_error
	("$autonotify_data_file", "Auto-Notify Purge",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_autonotify_data_file") || &file_open_error
	("$new_autonotify_data_file", "Auto-Notify Purge",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_;
    chop $line;
    @fields = split (/\|/, $line);

($dbmonth,$dbday,$dbyear) = split (/\//, $fields[8]);

$julian_day = &jday($dbmonth,$dbday,$dbyear);
($today_month,$today_day,$today_year) = split (/\//, &get_date);
$today = &jday($today_month,$today_day,$today_year);
$posted_days_ago = ($today - $julian_day);

$expiration_days = $fields[9];

		# Then, foreach item in the delete list, we will delete it
		# if the age of the datestamp id file is greater than the
		# amount specified in the setup file.

    if ($posted_days_ago <= $expiration_days)
      {
print NEW_DATABASE "$line\n";
      }

    }

  close (NEW_DATABASE);
if ($flock) { rename($new_autonotify_data_file, $autonotify_data_file); }
  close (DATABASE);
if (!$flock) { 
unlink("$autonotify_data_file");
rename($new_autonotify_data_file, $autonotify_data_file); }

if ($os eq "unix") { chmod 0666, "$autonotify_data_file"; }

if (!$flock) { &release_file_lock("$location_of_autonotify_lock_file"); }

    &release_file_lock("$location_of_autonotify_lock_file");

    open (FILE, ">$location_of_autonotify_purge_file") || die "can't open autonotify purge file\n";
    print FILE "1";
    close (FILE);

if ($os eq "unix") { chmod 0666, "$location_of_autonotify_purge_file"; }

if ($form_data{'print_html_response'} eq "on") {
&autonotify_purge_success_message;
  }

	} # end of sub autonotify_purge_engine
  }

sub banner_rotator
 {

# Options

$link_image = "1";        # 1 = YES; 0 = NO

# Done

srand(time ^ $$);
$num = rand(@images); # Pick a Random Number

# Print Out Random Filename and Base Directory
if ($link_image eq '1' && $urls[$num] ne "") {
   print "<a href=\"$urls[$num]\">";
}

print "<img src=\"$basedir$images[$num]\"";
if ($border ne "") {
   print " border=$border";
}
if ($align ne "") {
   print " align=$align";
}
if ($alt[$num] ne "") {
   print " alt=\"$alt[$num]\"";
}
print ">";

if ($link_image eq '1' && $urls[$num] ne "") {
   print "</a>";
}

print "\n";

  }

#######################################################################
#                      Submit Auto-Notify Addition                    # 
#######################################################################

sub autonotify_submit_addition
  {              

# Check to make sure they entered an e-mail address

   if ($form_data{'email'} eq "")
       {  &autonotify_email_error;   }

# Check for valid e-mail address

           unless ($form_data{'email'} =~ /.+\@.+\..+/) {
               &autonotify_email_error;
           }

$duration_match = "off";
foreach $duration (@autonotify_duration) {
if ($form_data{'autonotify_duration'} eq "$duration") {
$duration_match = "on";
last;
  }
}
if ($duration_match ne "on") {
$form_data{'autonotify_duration'} = $autonotify_duration[0];
}

if (!$flock) { &get_file_lock("$location_of_autonotify_counter_lock_file"); }
  open (COUNTER_FILE, "$location_of_autonotify_counter_file") || 
	&file_open_error ("$location_of_autonotify_counter_file", "Autonotify Submit Addition",
	__FILE__, __LINE__);
if ($flock) { flock COUNTER_FILE, 2; }
  open (NEW_COUNTER_FILE, ">$location_of_new_autonotify_counter_file") || 
	&file_open_error ("$location_of_new_autonotify_counter_file", "Autonotify Submit Addition",
	__FILE__, __LINE__);

  while (<COUNTER_FILE>)
    {
    $current_counter = $_;
  $current_counter++;
  $new_counter = $current_counter;
  print NEW_COUNTER_FILE "$new_counter";
    }

  close (NEW_COUNTER_FILE);
if ($flock) { rename($location_of_new_autonotify_counter_file, $location_of_autonotify_counter_file); }
  close (COUNTER_FILE);
if (!$flock) { 
unlink("$location_of_autonotify_counter_file");
rename($location_of_new_autonotify_counter_file, $location_of_autonotify_counter_file); }

if ($os eq "unix") { chmod 0666, "$location_of_autonotify_counter_file"; }

if (!$flock) { &release_file_lock("$location_of_autonotify_counter_lock_file"); }

if (!$flock) { &get_file_lock("$location_of_autonotify_lock_file"); }
  open (DATABASE, ">>$autonotify_data_file") || 
        die "can't open keyword file\n";                      
if ($flock) { flock DATABASE, 2; }

    $new_row .= "$form_data{'keywords'}|$form_data{'boolean'}|$form_data{'case_sensitive'}|$form_data{'category'}|$form_data{'caption_header'}|$form_data{'photo'}|$form_data{'email'}|$form_data{'password'}|$current_date|$form_data{'autonotify_duration'}|$new_counter\n";

  print DATABASE $new_row;
  close (DATABASE);
if (!$flock) { &release_file_lock("$location_of_autonotify_lock_file"); }

if ($os eq "unix") { chmod 0666, "$autonotify_data_file"; }

if (($form_data{'add_to_mailing_list'} eq "on") && ($collect_email_addresses eq "on")) {

if (!$flock) { &get_file_lock("$location_of_mailinglist_lock_file"); }
  open (MAILINGLIST_FILE, "$location_of_email_list") ;
if ($flock) { flock MAILINGLIST_FILE, 2; }

$location_of_new_email_list = "$location_of_email_list.tmp";
  open (NEW_MAILINGLIST_FILE, ">$location_of_new_email_list") ;

  while (<MAILINGLIST_FILE>)
    {
    $line = $_; 
    chop ($line) if ($line =~ /\n$/);
    @fields = split (/\|/, $line);

	if ($form_data{'email'} eq $fields[0]) { 
	$mailmatch = "on";
	print NEW_MAILINGLIST_FILE "$line\n";
	}

	else { print NEW_MAILINGLIST_FILE "$line\n"; }
    }

if ($mailmatch ne "on") {
print NEW_MAILINGLIST_FILE "$form_data{'email'}\|$form_data{'name'}\n";
}

  close (NEW_MAILINGLIST_FILE);
if ($flock) { rename($location_of_new_email_list, $location_of_email_list); }
  close (MAILINGLIST_FILE);
if (!$flock) { 
unlink("$location_of_email_list");
rename($location_of_new_email_list, $location_of_email_list); }

if ($os eq "unix") { chmod 0666, "$location_of_email_list"; }

if (!$flock) { &release_file_lock("$location_of_mailinglist_lock_file"); }
}

# The following code causes the script to notify the admin anytime someone
# adds an entry.

$user_email = $form_data{'email'};

if ($notify_autonotify_add eq "on")
	{

&autonotify_admin_notice_message;

&send_mail($master_admin_email_address, $master_admin_email_address, $subject, $message);
    }

# The following code causes the script to send an e-mail message to the person
# who just posted a classified ad.
# First, it checks to see whether they entered an e-mail address on the form.  If not,
# it skips this section and doesn't send them the e-mail message.

if (($form_data{'email'} ne "") && ($autonotify_reply_user eq "on"))
  {

&autonotify_confirmation_message;
&send_mail($master_admin_email_address, $user_email, $subject, $message);
}

  &successful_autonotify_addition_message;
  }             

#######################################################################
#                      Submit Auto-Notify Modification                    # 
#######################################################################

sub autonotify_submit_modification
  {              

# Check to make sure they entered an e-mail address

   if ($form_data{'email'} eq "")
       {  &autonotify_email_error;   }

# Check for valid e-mail address

           unless ($form_data{'email'} =~ /.+\@.+\..+/) {
               &autonotify_email_error;
           }

if (!$flock) { &get_file_lock("$location_of_autonotify_lock_file"); }

  open (DATABASE, "$autonotify_data_file") || &file_open_error
	("$autonotify_data_file", "Auto-Notify Submit Modification",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_autonotify_data_file") || &file_open_error
	("$new_autonotify_data_file", "Auto-Notify Purge",  __FILE__, __LINE__);

  $autonotify_match_found = "off";

  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    unless (($fields[7] eq $form_data{'password'}) && ($fields[10] eq $form_data{'db_id'}))
      {
print NEW_DATABASE "$line\n";
      }

    else
      {
      $autonotify_match_found = "on";
      $old_row = "$line";

    $new_row = "$form_data{'keywords'}|$form_data{'boolean'}|$form_data{'case_sensitive'}|$form_data{'category'}|$form_data{'caption_header'}|$form_data{'photo'}|$form_data{'email'}|$form_data{'password'}|$fields[8]|$fields[9]|$fields[10]";

	$new_row =~ s/([\0-\37\177])/ /g;
	$new_row =~ s/\r\n/ /g;

print NEW_DATABASE "$new_row\n";

      } # End of  else
    } # End of while (<DATABASE>)

  close (NEW_DATABASE);
if ($flock) { rename($new_autonotify_data_file, $autonotify_data_file); }
  close (DATABASE);
if (!$flock) { 
unlink("$autonotify_data_file");
rename($new_autonotify_data_file, $autonotify_data_file); }

if ($os eq "unix") { chmod 0666, "$autonotify_data_file"; }

if (!$flock) { &release_file_lock("$location_of_autonotify_lock_file"); }

  &release_file_lock("$location_of_autonotify_lock_file");

  if ($autonotify_match_found ne "on") {
	&autonotify_no_match_error;
	exit;
	}

  &successful_autonotify_modification_message;
  }             

#######################################################################
#                      Submit Auto-Notify Deletion                    # 
#######################################################################

sub autonotify_submit_deletion
  {              

  $autonotify_match_found = "off";

if (!$flock) { &get_file_lock("$location_of_autonotify_lock_file"); }

  open (DATABASE, "$autonotify_data_file") || &file_open_error
	("$autonotify_data_file", "Auto-Notify Submit Deletion",  __FILE__, __LINE__);
if ($flock) { flock DATABASE, 2; }
  open (NEW_DATABASE, ">$new_autonotify_data_file") || &file_open_error
	("$new_autonotify_data_file", "Auto-Notify Submit Deletion",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    unless (($fields[7] eq $form_data{'password'}) && ($fields[10] eq $form_data{'db_id'}))
      {
print NEW_DATABASE "$line\n";
      }

    else
      {
      $autonotify_match_found = "on";

      } # End of  else
    } # End of while (<DATABASE>)

  close (DATABASE);

  close (NEW_DATABASE);
if ($flock) { rename($new_autonotify_data_file, $autonotify_data_file); }
  close (DATABASE);
if (!$flock) { 
unlink("$autonotify_data_file");
rename($new_autonotify_data_file, $autonotify_data_file); }

if ($os eq "unix") { chmod 0666, "$autonotify_data_file"; }

if (!$flock) { &release_file_lock("$location_of_autonotify_lock_file"); }

  if ($autonotify_match_found ne "on") {
	&autonotify_no_match_error;
	exit;
	}

  &successful_autonotify_deletion_message;
  }             

sub autonotify_get_info {

  $autonotify_match_found = "off";

  open (DATABASE, "$autonotify_data_file") || die "can't open keyword file\n";
  
  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    if (($fields[7] eq $form_data{'password'}) && ($fields[10] eq $form_data{'db_id'}))
      {
      $autonotify_match_found = "on";
	last;
      }
    } # End of while (<DATABASE>)
  close (DATABASE);

  if ($autonotify_match_found ne "on") {
	&autonotify_no_match_error;
	exit;
	}
}

sub maintenance_routines {

if ($use_builtin_warn eq "on") { &warn; }
if ($use_builtin_purge eq "on") { &purge; }
if ($use_builtin_autonotify eq "on") { &autonotify; }
if ($use_builtin_autonotify_purge eq "on") { &autonotify_purge; }

  }

###################################################################
#
#  Upload Subroutine
#
###################################################################

sub upload {

# Graphic file upload handling

 $upload_file = "$form_data{'upload_file'}";
 $upload_file_filename = "$incfn{'upload_file'}";

# Parse out the %Hex symbols and make it into alphanumeric

 $upload_file_filename =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;

$number = $form_data{'db_id'};

if ($allow_photo_uploads ne "on") {
    unlink("$upload_file");
&upload_unauthorized_error;
}

if ($upload_file_size > $maximum_attachment_size) {
    unlink("$upload_file");
&upload_large_file_error;
}

  if ($form_data{'db_id'} eq "")
    {
    unlink("$upload_file");
    &no_item_submitted_for_modification;
    exit;
    }

  $match_found = "off";

  open (DATABASE, "$data_file_path") || die "can't open data file\n";
  while (<DATABASE>)
    {
    $line = $_; 
    chop $line;
    @fields = split (/\|/, $line);

    unless ((($fields[15] eq $form_data{'password'}) || ($admin_password eq $form_data{'password'})) && ($fields[20] eq $form_data{'db_id'}))
      {
      $new_data .= "$line\n";
      }

    else
      {
      $match_found = "on";
	$status = $fields[14];
      $new_data .= "$line\n";
      } # End of  else
    } # End of while (<DATABASE>)

  close (DATABASE);

  if ($match_found ne "on") {
      unlink("$upload_file");
	&upload_no_match_error;
	exit;
	}

    if ($upload_file_filename =~ /.*\.gif/i) {
unlink("$temp_dir/$number.gif");
	rename($upload_file, "$temp_dir/$number.gif");
	&imagesize("$temp_dir/$number.gif");
	if (($image_width == 0) && ($image_height == 0))
	{ 
      unlink("$temp_dir/$number.gif");
	&upload_invalid_gif_error;
	exit;
	}
	elsif (($image_width > $max_image_width) || ($image_height > $max_image_height))
	{ 
      unlink("$temp_dir/$number.gif");
	&upload_invalid_size_error;
	exit;
	}
	else
	{ 
	unlink("$upload_path/$number.gif");
	unlink("$upload_path/$number.jpg");
	rename("$temp_dir/$number.gif", "$upload_path/$number.gif"); 

if ($os eq "unix") { chmod 0666, "$upload_path/$number.gif"; }
	}
 }

    elsif ($upload_file_filename =~ /.*\.jpg/i) {
unlink("$temp_dir/$number.jpg");
	rename($upload_file, "$temp_dir/$number.jpg");
	&imagesize("$temp_dir/$number.jpg");
	if (($image_width == 0) && ($image_height == 0))
	{ 
      unlink("$temp_dir/$number.jpg");
	&upload_invalid_jpg_error;
	exit;
	}
	elsif (($image_width > $max_image_width) || ($image_height > $max_image_height))
	{ 
      unlink("$temp_dir/$number.jpg");
	&upload_invalid_size_error;
	exit;
	}
	else
	{ 
	unlink("$upload_path/$number.gif");
	unlink("$upload_path/$number.jpg");
	rename("$temp_dir/$number.jpg", "$upload_path/$number.jpg"); 

if ($os eq "unix") { chmod 0666, "$upload_path/$number.jpg"; }
	}
 }

    else { unlink("$upload_file");
	&upload_format_error;
	exit;
 }

&successful_upload_message;

}

sub view_maillist {

if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }

  open (MAILINGLIST_FILE, "$location_of_email_list") ;
		@maillines = <MAILINGLIST_FILE>;
	foreach $mailline (@maillines) {
print qq~$mailline<br>~;
	}
  close (MAILINGLIST_FILE);
}

sub clear_maillist {

if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }

if (!$flock) { &get_file_lock("$location_of_mailinglist_lock_file"); }
  open (MAILINGLIST_FILE, ">$location_of_email_list") ;
if ($flock) { flock MAILINGLIST_FILE, 2; }
	print MAILINGLIST_FILE "";
  close (MAILINGLIST_FILE);

if ($os eq "unix") { chmod 0666, "$location_of_email_list"; }

if (!$flock) { &release_file_lock("$location_of_mailinglist_lock_file"); }
  &maillist_cleared_message;
}

sub send_maillist {

if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }

  open (MAILINGLIST_FILE, "$location_of_email_list") ;
		@maillines = <MAILINGLIST_FILE>;
	foreach $mailline (@maillines) {
		chop ($mailline) if ($mailline =~ /\n$/);
    		@fields = split (/\|/, $mailline);

      $email_user = $fields[0];
$subject = $form_data{'subject'};
$message = $form_data{'message'};

$message =~ s/~nl~/\n/g;

&send_mail($master_admin_email_address, $email_user, $subject, $message);
	}
  close (MAILINGLIST_FILE);

  &maillist_sent_message;
}

sub path_error {
print qq~<html><head><title>Path Error</title></head>
<body>
<h1>Path Error</h1>
The script was unable to determine the correct value for the \$path variable on this server.  Therefore, you will need to find out the correct value for the full internal server path to the "classifieds" directory that you created on your server and that you stored the main classifieds.cgi or classifieds.pl file in.  If you don't know the value for the full internal server path to the classifieds program, you will need to get this information from your web hosting company or your server administrator.  You may also be able to get this information by looking at the directory structure listed for the "Remote System" on your FTP program, although those listings are not always accurate.  If you have Telnet access to your server, you may be able to get this information by logging onto your site via Telnet, changing directories until you are in the directory where the classifieds program is located, and then typing "pwd", which should display the current directory.  It will look something like "/usr/www/users/you/cgi-bin/classifieds" for Unix users or "d:/InetPub/wwwroot/cgi-bin/classifieds" for Windows NT users.  These are merely examples, of course, and your actual directory will be different.  Also, do NOT add the trailing slash, as this will be done by the program.
<p>
Once you have obtained this value, you will need to open up the classifieds.cgi or classifieds.pl file in a text editor and manually edit the following line, which appears near the beginning of that file:
<p>
# \$path = "/usr/www/users/you/cgi-bin/classifieds";
<p>
You will need to remove the # sign from in front of this line and replace "/usr/www/users/you/cgi-bin/classifieds" with the correct value for the full internal server path to your classifieds directory.  Then, save the file as pure ASCII text, upload it back to your server, and run it from your browser again.
</body>
</html>~;
exit;
}

sub file_open_error
  {

  local ($bad_file, $script_section, $this_file, $line_number) = @_;
$file_open_error_message = "We're sorry, but the script may be down for maintenance.  Please try again in a few minutes.<br><br>For debugging: Specifically, the script was not able to access $bad_file in the $script_section routine of $this_file at line number $line_number. Please make sure the path is correctly defined in the db file and that the permissions are correct.";
  &CgiDie ("$file_open_error_message")
  }  
