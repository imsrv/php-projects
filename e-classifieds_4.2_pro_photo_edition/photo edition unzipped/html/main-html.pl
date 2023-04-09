#####################################################################
# e-Classifieds(TM)
# Copyright © Hagen Software Inc. All rights reserved.
#
# By purchasing, installing, copying, downloading, accessing or otherwise
# using the SOFTWARE PRODUCT, or by viewing, copying, creating derivative
# works from, appropriating, or otherwise altering all or any part of its
# source code (including this notice), you agree to be bound by the terms
# of the EULA that accompanied this product, as amended from time to time
# by Hagen Software Inc.  The EULA can also be viewed online at
# "http://www.e-classifieds.net/support/license.html"
#####################################################################

sub add_email_message {

$subject = "New Classified Ad";
$message = "The following classified ad (ad number $new_counter) was added to the $classifieds_name by $form_data{'name'}.

$new_row

Their home page, if any, is located at $form_data{'url'}

Their IP address is $ENV{'REMOTE_ADDR'}

";

if ($fee eq "on") {
$message .= "The total cost for this ad is $currency$total_cost, which is based on its placement in $number_of_ads categories at the rate of $currency$first_ad_cost for the first category and $currency$multiple_ad_cost for each additional category.  The customer has been sent an e-mail invoice to $form_data{'email'}, but you should follow up to make sure that they pay within a few days.";
    }
  }

sub user_response_email_message {

if ($fee eq "on") {

$fee_message = "The total cost for your ad is $currency$total_cost, which is based on its placement in $number_of_ads categories at the rate of $currency$first_ad_cost for the first category and $currency$multiple_ad_cost for each additional category.  Please remit payment immediately to the following address:

$postal_address

Your ad will be deleted if payment is not received within $mail_payment_days days."; 
  }

else {
$fee_message = "If so, please spread the word about these FREE online classifieds.";
  }

if ($require_admin_approval eq "on") {

$status_message = "Since we must approve all new ads before they are posted, your ad will not be viewable (except for modification or deletion purposes) until we have approved it for posting."; 
  }

else {
$status_message = "Your ad has been posted.";
  }

$subject = "$classifieds_name";
$message = "Dear $form_data{'name'},

Thank you for submitting your classified ad in the $classifieds_name.  $status_message  You can come back at any time and modify or delete your posting as necessary.  We hope you enjoy the new $classifieds_name and will come back often.  $fee_message

Also, please make a note of the ad number and your password now for future reference.  You will need them if you ever want to modify or delete your classified ad.  The ad number and password for this ad are as follows:

ad number: $new_counter
password: $form_data{'password'}

If you did not post a classified ad on the $classifieds_name and believe that you have received this by mistake, please accept our apologies and notify us immediately.  As a security measure, you are receiving this message because someone used your e-mail address when posting a classified ad on the $classifieds_name.

Sincerely,

$admin_name, $admin_title
$sitename
$siteurl
$slogan";
  }

sub modify_email_message {
$subject = "Classified Ad Modified";
$message = "The following classified ad was modified in the $classifieds_name by user $form_data{'name'}.  It now appears as follows:

$new_row

The old row was the following:

$old_row

Their home page, if any, is located at one of the following:

Updated URL: $form_data{'url'}

Old URL: $url_modify

Their IP address is $ENV{'REMOTE_ADDR'}

";

if (($charge_for_renewals eq "on") && ($ad_renewed eq "on")) {
$message .= "The user renewed this ad, so the renewal charge is $renewal_charge.  The user has been sent an e-mail invoice at $email_modify, but you should follow up to make sure that they send payment within $mail_payment_days days.";
    }
  }

sub renew_response_email_message {
$subject = "Invoice for Ad Renewal";
$message = "Thank you for renewing the classified ad that you posted at the $classifieds_name.  Please submit your payment of $currency$renewal_charge within $mail_payment_days days to the following address:

$postal_address

Your ad will be deleted if payment is not received within $mail_payment_days days.

Sincerely,

$admin_name, $admin_title
$sitename
$siteurl
$slogan";
  }

sub delete_email_message {
$subject = "Classified Ad Deleted";
$message = "The following classified ad was deleted from the $classifieds_name:

$deleted_row

Their home page, if any, is located at $url_delete

Their IP address is $ENV{'REMOTE_ADDR'}

The following classified ads (if any) were purged from the $classifieds_name because they had expired.

$purged_rows";
  }

sub warn_email_message {

$subject = "Classified Ad Notice";
$message = "The following classified ad that you posted at the $classifieds_name will expire within $daysleft days unless you renew this ad.  You can easily renew the ad by going back and choosing the Modify/Renew button.  As long as you check the \"Renew\" checkbox on the form, you do not have to actually change any of the information when you submit your modification in order for the ad to be renewed for another $expiration_days days.  Your ad appears below:

$user_row

Sincerely,

$admin_name, $admin_title
$sitename
$siteurl
$slogan";
  }

sub purge_email_message {

$subject = "Classified Ads Purged";
$message = "Old classified ads were purged because they had expired.";

  }

sub autonotify_admin_notice_message {

$subject = "Keyword Notify Signup";
$message = "Another user has signed up for the Keyword Notify feature of the $classifieds_name.  Their information is listed below:

$new_row";

}

sub autonotify_confirmation_message {

$subject = "$classifieds_name Keyword Notify Confirmation";
$message = "This message is merely a confirmation that your personal search agent for the $classifieds_name has been set up.  You are now enrolled in our Keyword Notify feature and will periodically be e-mailed new classified ads that match the criteria that you selected.  Your subscription to our Keyword Notify feature will automatically expire in $form_data{'autonotify_duration'} days.  You can come back at any time to modify your search criteria or remove your personal search agent.  To do so, you will need your profile number and your password, which are as follows:

Profile Number: $new_counter
Password: $form_data{'password'}

Sincerely,

$admin_name, $admin_title
$sitename
$siteurl
$slogan";

}

sub autonotify_message {

$ad_message .= "Categories: $fields[9]
Caption: $fields[10]
Date Posted: $fields[12]
Details: $script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&query=retrieval

";
}

sub autonotify_email_message {

if ($total_row_count > 0) {
$subject = "$classifieds_name";
$message = "Your personal search agent at the $classifieds_name has found $total_row_count ads that match the search criteria that you specified when you set up your personal search agent and that have been posted within the past $autonotify_days_interval days.  You can see all of the details for any ad that you are interested in by following the link next to \"Details\".  Here are your ads:

$ad_message";
  }

else {
$subject = "$classifieds_name";
$message = "Your personal search agent at the $classifieds_name did not find any new ads posted within the last $autonotify_days_interval days that match the search criteria that you specified when you set up your personal search agent.";
  }

}

$unix_mail_error_message = "Error Occurred: Could Not Open Unix Mail Program";

#################################################################
#                  Generic Form Header Subroutine               #  
#################################################################

sub generic_form_header
  {
  print qq~
  <FORM METHOD="post" ACTION="$script_url">~;
  }

#################################################################
#                  Upload Form Header Subroutine               #  
#################################################################

sub upload_form_header
  {
  print qq~
  <FORM METHOD="post" ACTION="$script_url" ENCTYPE="multipart/form-data">~;
  }

#################################################################
#                  Display Frontpage Subroutine                #
#################################################################

sub display_frontpage
  {
my %numbers = ();
my $output = "";

  open (DATABASE, "$data_file_path") || &file_open_error
        ("$data_file_path", "Purge Database",  __FILE__, __LINE__);

  while (<DATABASE>)
    {
    $line = $_;
    chop $line;
    @fields = split (/\|/, $line);
if ($fields[14] eq "ok") { 
@ad_categories = split (/&&/, $fields[9]);

foreach $adcategory (@ad_categories) {
$numbers{$adcategory}++;
}
}
	} 
	close (DATABASE);

print qq~
<p>
<table border=0 width=100% cellpadding=4 cellspacing=4>
<tr>
<td colspan=2 align=center><font size=4 face="arial">Classified Ad Categories</font>~;
print qq~
</td>
</tr>
<tr>~;
$end_of_row = "off";
$i = 0;

foreach $category (@categories) {
$category_link = $category;
$category_link =~ s/\+/plussign/g;
$category_link =~ s/ /\+/g;
$category_link =~ s/&/ampersand/g;
$category_link =~ s/=/equalsign/g;

if ($numbers{$category} eq "") {
$numbers{$category} = 0;
}

print qq~
<td valign=top><font face="arial" size=2><a href="$script_url?search_and_display_db_button=on&query=category&category=$category_link&results_format=$default_results_format"><b>$category</b></a> <i>($numbers{$category})</i><br>
<font size=1>$category_desc[$i]
</font></td>~;
if ($end_of_row eq "off") {
$end_of_row = "on";
  }
else {
print qq~</tr>
<tr>~;
$end_of_row = "off";
  }
$i++;
}

if ($end_of_row eq "off") {
print qq~<td valign=top><font face="arial" size=2><a href="$script_url?search_and_display_db_button=on&query=category&results_format=$default_results_format"><b>All Categories</b></a></font></td></tr>~;
  }

else {
print qq~<td colspan=2 valign=top><font face="arial" size=2><a href="$script_url?search_and_display_db_button=on&query=category&results_format=$default_results_format"><b>All Categories</b></a></font></td></tr>~;
  }

print qq~
</table>
<P>
</form>
<P>~;
}

#################################################################
#                  Add Item Form Subroutine                     #
#################################################################

sub add_modify_data_entry_form
  {
  print qq~
</center>

<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Contact Information</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>
<tr>
<th align=left><font face=arial size=2>Your Name:</font></th>
<td><input type=text name=name size=20 maxlength=20 value="$fields[0]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Street Address:</font></th>
<td><input type=text name=street size=40 maxlength=40 value="$fields[1]"></td>
</tr>
<tr>
<th align=left><font face=arial size=2>City:</font></th>
<td><input type=text name=city size=20 maxlength=40 value="$fields[2]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>State/Province:</font></th>
<td><input type=text name=state size=20 maxlength=40 value="$fields[3]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Zip/Postal Code:</font></th>
<td><input type=text name=zip size=20 maxlength=20 value="$fields[4]"></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Telephone Number:</font></th>
<td><input type=text name=phone size=20 maxlength=20 value="$fields[6]"></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Country:</font></th>
<td><input type=text name=country size=20 maxlength=50 value="$fields[5]"></td>
</tr>
<tr>
<th align=left><font face=arial size=2>E-mail Address:</font></th>
<td><input type=text name=email size=20 maxlength=40 value="$fields[7]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Web Site URL:</font></th>
<td><input type=text name=url size=40 maxlength=40 value="$fields[8]"></td>
</tr>
<tr>
<th align=left colspan=2><font face=arial size=2>Display Street Address and Phone Number in Ad?:</font></th></tr>
<tr><td colspan=2><SELECT NAME="display_address">
<option>$fields[18]
<option>Yes
<option>No
</select></td>
</tr>
</table>
<p>

<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Ad Information</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>~;

if ($form_data{'add_item_button'} ne "") {
print qq~
<tr>
<td colspan=2><font face=arial size=2>Place a checkmark in the box next to each category that you want to post your ad in. ~;
if ($limit_ads eq "on") {
print qq~You may place your ad in a maximum of <b>$max_ads</b> categories. <font size=4 color="#ff0000"><b>*</b></font>~;
  }

print qq~</td></tr>
<tr><td colspan=2><font face=arial size=2>~;

foreach $category (@categories) {
print qq~
<INPUT TYPE="checkbox" NAME="category" VALUE="$category"> <b>$category</b><br>~;
  }
print qq~</font></td></tr>~;
 }

else {
$fields[9] =~ s/\&\&/<br>/g;
print qq~<tr><td colspan=2><font face=arial size=2><b>You cannot change the categories when modifying your ad.  If you wish to change the categories, you must place a new ad.  This ad is listed in the following categories:<p>
<blockquote>$fields[9]</blockquote>
</b></font></td></tr>~;
  }

if ($use_caption_headers eq "on") {
print qq~
<tr>
<th align=left><font face=arial size=2>Caption Header:</font></th>
<td><SELECT NAME = "caption_header">
  <OPTION>$fields[17]~;
foreach $caption_header (@caption_headers) {
print qq~
  <OPTION>$caption_header
~;
   }
print qq~
  </select></td>
</tr>~;
}

print qq~
<tr>
<th align=left><font face=arial size=2>Caption:</font></th>
<td><input type=text name=caption size=30 maxlength=30 value="$fields[10]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Text of your ad:<br>
(maximum of $maxwords words)</font></th>
<td><TEXTAREA NAME="text" ROWS=5 COLS=40 wrap=physical>$fields[11]</TEXTAREA> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>

</table>

<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Other Information</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>
<tr>
<th align=left><font face=arial size=2>Password:</font></th>
<td><input type=password name=password size=20 maxlength=20 value="$fields[15]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>~;

if ($form_data{'add_item_button'} ne "") {
print qq~
<tr>
<th align=left><font face=arial size=2>Ad Duration:</font></th>
<td><SELECT name=ad_duration>~;
foreach $duration (@ad_duration) {
print qq~<OPTION value="$duration">$duration days
~;
}
print qq~
</select> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>~;
}

if (($form_data{'add_item_button'} ne "") && ($collect_email_addresses eq "on")) {
print qq~
<tr>
<th align=left><font face=arial size=2>Join Mailing List:</font></th>
<td><INPUT type="checkbox" name="add_to_mailing_list"></td>
</tr>~;
}

print qq~</table>~;

if ($form_data{'display_modification_form_button'} ne "") {
 if ($limit_renewals eq "on") {
  if ($fields[13] < $max_renewals) {
print qq~
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Renewal Options</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>
<tr><td><INPUT type="checkbox" name="renew_ad"> <b>Renew this ad for another $fields[16] days.  Please keep in mind that so far, it has been renewed $fields[13] times, and that you are allowed a maximum of $max_renewals renewals. ~;

if ($charge_for_renewals eq "on") {
print qq~The cost for renewing your ad is $currency$renewal_charge, which must be submitted to us within $mail_payment_days days.  Once your ad has been renewed, you will receive an e-mail invoice informing you of the address where you should send your payment.~;
}

else {
print qq~There is no charge for renewing your ad.~;
}

print qq~</b></td></tr></table>~; }

  else {
print qq~<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Renewal Options</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>
<tr><td><b>This ad has already been renewed $max_renewals times, which is the limit on this system.</b></td></tr></table>~; }
}

else {
print qq~<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Renewal Options</FONT></th></tr>
</table>

<table border=0 cellpadding=4 cellspacing=4>
<tr><td><INPUT type="checkbox" name="renew_ad"> <b>Renew this ad for another $fields[16] days.  ~;

if ($charge_for_renewals eq "on") {
print qq~The cost for renewing your ad is $currency$renewal_charge, which must be submitted to us within $mail_payment_days days.  Once your ad has been renewed, you will receive an e-mail invoice informing you of the address where you should send your payment.~;
}

else {
print qq~There is no charge for renewing your ad.~;
}

print qq~</b></td></tr></table>~;
}
}

# print qq~</table>~;

}

#################################################################
#                  Preview Ad Form Subroutine               #
#################################################################

sub preview_ad_form
  {
if ($fee eq "on") {
$fee_statement = "The total cost for your ad will be <b>$currency$total_cost</b>, which is based on its placement in <b>$number_of_ads</b> categories at the rate of <b>$currency$first_ad_cost</b> for the first category and <b>$currency$multiple_ad_cost</b> for each additional category."; 
  }

  &pagesetup;

  print qq~
  <H2>Preview of Your Ad</H2></center>~;
  &generic_form_header;

print qq~
Your new ad will appear as displayed below.  Your ad contains approximately <b>$number_of_words</b> words and will appear in <b>$number_of_ads</b> categories. $fee_statement If you are satisfied with the appearance of your ad, please click on the "Post My Ad" button to place your ad.  If you would like to make changes to your ad, please click on the "Go Back" button below or use your browser's "Back" function to go back to the Add form and make your desired changes.
<p>~;

$ad_categories =~ s/\&\&/<br>/g;

if ($european_date_format eq "on") { ($today_month,$today_day,$today_year) = split (/\//, &get_date);
$current_date = "$today_day/$today_month/$today_year";
 }

  print qq~<center>
  <TABLE BORDER="$table_border" CELLPADDING=2 cellspacing=2 width="$table_width">
  <TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background"><FONT FACE="$text_font" SIZE="3" COLOR="$ad_bar_text_color">$form_data{'caption_header'} $form_data{'caption'}</FONT></th></tr><TR>~;

@form_fields = ("name", "street", "city", "state", "zip", "country", "phone", "email", "url", "caption", "text", "password", "ad_duration", "caption_header");

foreach $field (@form_fields) {
    $form_data{$field} =~ s/~p~/\|/g;
    $form_data{$field} =~ s/~nl~/<br>/g;
}

    print qq~
<TD bgcolor="$table_color">
<TABLE BORDER=0 cellpadding=2 CELLSPACING=1 WIDTH=460>
<TR>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Categories:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$category_color"><B>$ad_categories</B></FONT></TD>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Date Posted:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$category_color"><B>$current_date</B></FONT></TD>

</TD>
</TR>
<TR>
	<TD VALIGN="TOP" WIDTH=60 rowspan=2><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Contact:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP" rowspan=2><FONT FACE="$text_font" SIZE="2">$form_data{'name'}<br>~;
if ($form_data{'display_address'} eq "Yes") { print qq~$form_data{'street'}<br>~; }
else { print qq~~; }
print qq~
$form_data{'city'}, $form_data{'state'} $form_data{'zip'}<br>
$form_data{'country'}
</font></td>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">Telephone:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2">~;
if ($form_data{'display_address'} eq "Yes") { print qq~$form_data{'phone'}~; }
else { print qq~~; }
print qq~
</FONT></TD>
</tr>
<tr>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">E-Mail:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2">~;

if (($use_personal_inbox eq "on") && ($form_data{'show_temp_ads'} eq "")) {
print qq~
Reply to Ad (this will be active once your ad is posted)~;
	}
else {
print qq~
<a href="mailto:$form_data{'email'}">$form_data{'email'}</a>~;
	}

print qq~
</FONT></TD>
</tr>
<TR>
	<TD WIDTH=60><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">Web Site:</FONT></TD>
	<TD COLSPAN=3><FONT FACE="$text_font" SIZE="2"><a href="$form_data{'url'}">$form_data{'url'}</a><br></FONT></TD>
</TR>
</table>
<br>
<br>
	<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=460><TR>
	<TD><FONT FACE="$text_font" SIZE="2" COLOR="$bar_color"><B>Description</B></FONT><BR>
	<FONT FACE="$text_font" SIZE="2">$form_data{'text'}</FONT></td>
	</tr></TABLE></TD>
	</TR>	
</table>
<p>~;

foreach $field (@form_fields) {
    $form_data{$field} =~ s/<br>/\n/g;
    $form_data{$field} =~ s/\"/\&quot\;/g;
    $form_data{$field} =~ s/\</\&lt\;/g;
    $form_data{$field} =~ s/\>/\&gt\;/g;
}

print qq~
<input type=hidden name=name value="$form_data{'name'}">
<input type=hidden name=street value="$form_data{'street'}">
<input type=hidden name=city value="$form_data{'city'}">
<input type=hidden name=state value="$form_data{'state'}">
<input type=hidden name=zip value="$form_data{'zip'}">
<input type=hidden name=country value="$form_data{'country'}">
<input type=hidden name=display_address value="$form_data{'display_address'}">
<input type=hidden name=phone value="$form_data{'phone'}">
<input type=hidden name=email value="$form_data{'email'}">
<input type=hidden name=url value="$form_data{'url'}">
<input type=hidden name=caption value="$form_data{'caption'}">
<input type=hidden name=text value="$form_data{'text'}">
<input type=hidden name=password value="$form_data{'password'}">
<input type=hidden name=ad_duration value="$form_data{'ad_duration'}">
<input type=hidden name=caption_header value="$form_data{'caption_header'}">
<input type=hidden name=add_to_mailing_list value="$form_data{'add_to_mailing_list'}">~;

foreach $item (@ad_categories)
{
print qq~<input type=hidden name=category value="$item">~;
}

print qq~
  <INPUT TYPE = "submit" NAME = "submit_addition"
	 VALUE = "Post My Ad">
</form>
<p>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;

  &pageclose;

  }

#################################################################
#                  Modify Search Form Subroutine               #
#################################################################

sub modify_search_form
  {
  &pagesetup("Search for an Ad to Modify");

  print qq~
  <center><H2>Search the Classifieds for Ad to Modify</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Modify your ad.</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your ad number and password.</FONT></TD></TR>

<TR><TD align="right"><b>Ad Number:</b> </TD><TD><INPUT type=text NAME="db_id"></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<INPUT TYPE="hidden" NAME="query" VALUE="edit">
<INPUT TYPE="submit" VALUE="Search for Ad to Modify" NAME="display_modification_form_button">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

#################################################################
#                  Delete Search Form Subroutine                #
#################################################################

sub delete_search_form
  {          
  &pagesetup("Search for an Ad to Delete");

  print qq~<center>
  <H2>Search the Classifieds for Ad to Delete</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Delete your ad.</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your ad number and password.</FONT></TD></TR>

<TR><TD align="right"><b>Ad Number:</b> </TD><TD><INPUT type=text NAME="db_id"></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<INPUT TYPE="hidden" NAME="query" VALUE="edit">
<INPUT TYPE="submit" VALUE="Search for Ad to Delete" NAME="search_and_display_for_deletion_button">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

</form>~;

  &pageclose;
  }

#################################################################
#           View Database Form Subroutine (Simple Search)       #
#################################################################

sub view_database_form
  {          
  &pagesetup("Search the Classified Ads");

  &generic_form_header;

  print qq~
</center>
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff">
<tr><td colspan=2><font size=4 face=arial color="#0000ff">Advanced Search</font></td></tr>
<tr>
<th align=left><font face=arial size=2>Find Keywords:</font></th>
<td><input name=keywords type=text size=30></td>
</tr>~;

if ($show_quick_search_categories eq "on") {
print qq~
<tr>
<th align=left><font face=arial size=2>Category</font></th>
<td><SELECT NAME = "category">
  <OPTION VALUE="">All~;

foreach $category (@categories) {
print qq~<OPTION>$category~;
  }

print qq~
  </select>
</td>
</tr>~;
}

if ($use_caption_headers eq "on") {
print qq~
<tr>
<th align=left><font face=arial size=2>Type</font></th>
<td><SELECT NAME = "caption_header">
  <OPTION VALUE="">All~;
foreach $caption_header (@caption_headers) {
print qq~
  <OPTION>$caption_header
~;
   }
print qq~
  </select>
</td></tr>~;
}

print qq~
<tr>
<th align=left><font face=arial size=2>Posted in the last:</font></th>
<td><SELECT NAME = "days_ago">
  <OPTION VALUE="">Any
  <OPTION>1
  <OPTION>2
  <OPTION>3
  <OPTION>4
  <OPTION>5
  <OPTION>6
  <OPTION>7
  <OPTION>8
  <OPTION>9
  <OPTION>10
  <OPTION>11
  <OPTION>12
  <OPTION>13
  <OPTION>14
  <OPTION>30
  <OPTION>60
  <OPTION>90
</select> Days</font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Ads Must Match</font></th>
<td><SELECT NAME="boolean">
<OPTION value="any terms">any of my keywords
<OPTION value="all terms">all of my keywords
<OPTION value="as a phrase">this exact phrase
</SELECT></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Case</font></th>
<td><SELECT NAME="case_sensitive">
<OPTION value="">insensitive
<OPTION value="on">sensitive
</SELECT></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Display Ads As:</font></th>
<td><SELECT NAME="results_format">
<OPTION value="headlines">Headlines
<OPTION value="">Full Ads
</SELECT></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Must Have Photos</font></th>
<td><INPUT TYPE="checkbox" NAME="photo"></TD>
</tr>
<tr>
<td colspan=2>
<INPUT TYPE="hidden" NAME="query" value="advanced_search">
<INPUT TYPE = "hidden" NAME = "search_and_display_db_button"   
         VALUE = "Search for Matching Ads">
  <INPUT TYPE = "submit" VALUE = "Search for Matching Ads"></center>
</td></tr>
</table>
<p>
</form>
<p>~;

  &pageclose;
  }

#################################################################
#                  Preview Ads Form Subroutine               #
#################################################################

sub preview_ads_form
  {
  &pagesetup("Preview New Ads");

  print qq~
  <center><H2>Preview New Ads</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Preview New Ads</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type="hidden" name="results_format" value="preview_mode">
<input type="hidden" NAME="display_new_ads_button" value="on">
<INPUT TYPE="submit" VALUE="Display New Ads">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

#################################################################
#                 hits_header Subroutine              #
#################################################################

sub hits_header {

  $page_hits_first = $hits_seen+"1";
  $page_hits_last = $hits_seen+$max_rows_returned;
  $rows_left_to_view = $total_row_count-$hits_seen;
  
  if (($total_row_count >= $hits_seen) &&   
      (($total_row_count-$hits_seen) > $max_rows_returned))
    
  {

  print qq~</center>
  <b>We found <font color="#ff0000">$total_row_count</font> matching ads.  Now displaying ads <font color="#0000ff">$page_hits_first</font> to <font color="#0000ff">$page_hits_last</font>.</b>
<p><center>~;
  }
  
  elsif (($total_row_count-$hits_seen) == 1)
  {
  $rows_left_to_view = $total_row_count-$hits_seen;
    print qq~</center>
  <b>We found <font color="#ff0000">$total_row_count</font> matching ad.  Now displaying the final ad.</b>
<p><center>~;
  }
else
{
print qq~</center>
   <b>We found <font color="#ff0000">$total_row_count</font> matching ads. Now displaying the remaining <font color="#0000ff">$rows_left_to_view</font> ads.</b>
<p><center>~;
}
}

#################################################################
#                 search_results_body Subroutine              #
#################################################################
   
sub search_results_body
  {

unless ($form_data{'results_format'} eq "off") { &hits_header; }

if ($form_data{'results_format'} eq "off") { 
  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);

for ($i = 0;$i <= 20;$i++) {
      $fields[$i] =~ s/~p~/\|/g;
      $fields[$i] =~ s/~nl~/\n/g;
	if ($fields[$i] eq "") { $fields[$i] = "."; }
      }
    print qq~~;
     }
 }

elsif ($form_data{'results_format'} eq "preview_mode") { 

print qq~
<table border=2 cellpadding=2 cellspacing=2 width=100%>
<tr><td bgcolor="$primary_large_table_color" align=center colspan=7><font size=4><b>Preview Ads Manager</b></font></td></tr>
<tr>
<td bgcolor="#cccccc" valign=top align=center><b>Approve</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>Modify</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>Delete</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>Caption</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>Categories</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>Date Posted</b></td>
<td bgcolor="#cccccc" valign=top align=center><b>View</b><br><font size=2>(Click to view)</font></td>
</tr>~;

  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);

$fields[9] =~ s/\&\&/<br>/g;

if ($european_date_format eq "on") { ($today_month,$today_day,$today_year) = split (/\//, $fields[12]);
$fields[12] = "$today_day/$today_month/$today_year";
 }

for ($i = 0;$i <= 20;$i++) {
      $fields[$i] =~ s/~p~/\|/g;
      $fields[$i] =~ s/~nl~/<br>/g;
	if ($fields[$i] eq "") { $fields[$i] = "&#151;"; }
}

$fields[17] =~ s/&#151;//g;

	print qq~
<tr>~;
&generic_form_header;
print qq~
<INPUT type=hidden NAME="db_id" value="$fields[20]">
<INPUT type=hidden NAME="password" value="$admin_password">
<INPUT type=hidden NAME="admin_password" value="$admin_password">
<INPUT type=hidden NAME="query" value="edit">
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2><INPUT TYPE="submit" NAME="approve_button" VALUE="Approve"></font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2><INPUT TYPE="submit" NAME="display_modification_form_button" VALUE="Modify"></font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2><INPUT TYPE="submit" NAME="search_and_display_for_deletion_button" VALUE="Delete"></font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2>$fields[17] $fields[10]</font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2>$fields[9]</font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2>$fields[12]</font></td>
<td bgcolor="$primary_large_table_color" align=center><font face=arial size=2><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&show_temp_ads=on&query=retrieval">Details</a></font></td>
</form>
</tr>~;
     }
print qq~</table><p>~;
 }

elsif ($form_data{'results_format'} eq "headlines") { 

$hit_counter = $page_hits_first;

print qq~
<table border=0 cellpadding=2 cellspacing=2 width=100%>
<tr><th bgcolor="$short_results_header_color" valign=top align=center><font face=$text_font size=2><b>#</b></font></th>
<th bgcolor="$short_results_header_color" valign=top align=left><font face=$text_font size=2><b>Subject</b></font></th>
<th bgcolor="$short_results_header_color" valign=top align=center><font face=$text_font size=2><b>Posted On</b></font></th>
<th bgcolor="$short_results_header_color" valign=top align=center><font face=$text_font size=2><b>Photo</b></font></th>
<th bgcolor="$short_results_header_color" valign=top align=center><font face=$text_font size=2><b>Details</b></font></th></tr>~;

# Go through each result

  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);
    $fields[9] =~ s/\&\&/<br>/g;

if ($european_date_format eq "on") { ($today_month,$today_day,$today_year) = split (/\//, $fields[12]);
$fields[12] = "$today_day/$today_month/$today_year";
 }

for ($i = 0;$i <= 20;$i++) {
      $fields[$i] =~ s/~p~/\|/g;
      $fields[$i] =~ s/~nl~/<br>/g;
	if ($fields[$i] eq "") { $fields[$i] = "&#151;"; }
}

$fields[17] =~ s/&#151;//g;

	print qq~
<tr><td bgcolor="$short_results_background_color" align=right><font face=$text_font size=2>$hit_counter </font></td>
<td bgcolor="$short_results_background_color" align=left><font face=$text_font size=2>$fields[17] $fields[10]</font></td>
<td bgcolor="$short_results_background_color" align=center><font face=$text_font size=2>$fields[12]</font></td>~;

if ($allow_photo_uploads eq "on") {

$number = $fields[20];

if (-e "$upload_path/$number.gif") {
	print qq~<td bgcolor="$short_results_background_color" align=center><img src="$graphics_dir/smallcamera.gif" width=16 height=12 border=0 alt="small camera icon"></td>~;
}
elsif (-e "$upload_path/$number.jpg") {
	print qq~<td bgcolor="$short_results_background_color" align=center><img src="$graphics_dir/smallcamera.gif" width=16 height=12 border=0 alt="small camera icon"></td>~;
}
else { 
    print qq~<td bgcolor="$short_results_background_color" align=center>&#151;</td>~;
  }
}

else {
    print qq~<td bgcolor="$short_results_background_color" align=center>&#151;</td>~;
}

print qq~
<td bgcolor="$short_results_background_color" align=center><font face=$text_font size=2><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&query=retrieval~;

if (($require_admin_approval eq "on") && ($fields[14] eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~">Details</a></font></td>
</tr>~;

$hit_counter++;

 } # end of foreach $row

print qq~
</table><p>~;

 }

else {

  foreach $row (@database_rows)
    {
    @fields = split (/\|/, $row);

$fields[9] =~ s/\&\&/<br>/g;

if ($european_date_format eq "on") { ($today_month,$today_day,$today_year) = split (/\//, $fields[12]);
$fields[12] = "$today_day/$today_month/$today_year";
 }

  print qq~
  <TABLE BORDER="$table_border" CELLPADDING=2 cellspacing=2 width="$table_width">
  <TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background"><FONT FACE="$text_font" SIZE="3" COLOR="$ad_bar_text_color">$fields[17] $fields[10]</FONT></th></tr><TR>~;


    if ($form_data{'display_modification_form_button'} ne "")
      {
      print qq~
      <td align="center" bgcolor="$tertiary_large_table_color">
      <INPUT TYPE = "radio" NAME = "item_to_modify"
	     VALUE = "$fields[20]" ~;
if ($total_row_count == "1") { print "CHECKED"; }
print qq~></TD>~;
      }

    if ($form_data{'search_and_display_for_deletion_button'} ne "")
      {
      print qq~
      <td align="center" bgcolor="$tertiary_large_table_color">
      <INPUT TYPE = "radio" NAME = "item_to_delete"
	     VALUE = "$fields[20]" ~;
if ($total_row_count == "1") { print "CHECKED"; }
print qq~></TD>~;
      }

for ($i = 0;$i <= 20;$i++) {
      $fields[$i] =~ s/~p~/\|/g;
      $fields[$i] =~ s/~nl~/<br>/g;
}

    print qq~
<TD bgcolor="$table_color">
<TABLE BORDER=0 cellpadding=2 CELLSPACING=1 WIDTH=460>
<TR>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Categories:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$category_color"><B>$fields[9]</B></FONT></TD>

<td colspan=2 rowspan=6 width=130 align=center><FONT FACE="$text_font" SIZE="2">~;

if ($allow_photo_uploads eq "on") {

$number = $fields[20];

if (-e "$upload_path/$number.gif") {
  if (($ad_photo_size eq "full") || ($form_data{'photo_size'} eq "full")) {
	&imagesize("$upload_path/$number.gif");
	print qq~<img src="$photo_dir/$number.gif" width=$image_width height=$image_height alt="Photo for Ad $number">~;
	}
  elsif ($ad_photo_size eq "thumbnail") {
	print qq~Click on thumbnail below to see full size photo with this ad<p><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&photo_size=full&query=retrieval~;

if (($require_admin_approval eq "on") && ($fields[14] eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~"><img src="$photo_dir/$number.gif" width=$thumbnail_size height=$thumbnail_size alt="Thumbnail photo for Ad $number"></a>~;
	}
  elsif ($ad_photo_size eq "icon") {
	print qq~Click on icon below to see full size photo with this ad<p><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&photo_size=full&query=retrieval~;

if (($require_admin_approval eq "on") && ($fields[14] eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~"><img src="$graphics_dir/photo.gif" width=41 height=41 border=0 alt="photo icon"></a>~;
	}
  else {
    print qq~~;
	}
}
elsif (-e "$upload_path/$number.jpg") {
  if (($ad_photo_size eq "full") || ($form_data{'photo_size'} eq "full")) {
	&imagesize("$upload_path/$number.jpg");
	print qq~<img src="$photo_dir/$number.jpg" width=$image_width height=$image_height alt="Photo for Ad $number">~;
	}
  elsif ($ad_photo_size eq "thumbnail") {
	print qq~Click on thumbnail below to see full size photo with this ad<p><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&photo_size=full&query=retrieval~;

if (($require_admin_approval eq "on") && ($fields[14] eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~"><img src="$photo_dir/$number.jpg" width=$thumbnail_size height=$thumbnail_size alt="Thumbnail photo for Ad $number"></a>~;
	}
  elsif ($ad_photo_size eq "icon") {
	print qq~Click on icon below to see full size photo with this ad<p><a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&photo_size=full&query=retrieval~;

if (($require_admin_approval eq "on") && ($fields[14] eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~"><img src="$graphics_dir/photo.gif" width=41 height=41 border=0 alt="photo icon"></a>~;
	}
  else {
    print qq~~;
	}
}
else { 
  if (($ad_photo_size eq "full") || ($ad_photo_size eq "thumbnail") || ($ad_photo_size eq "icon")) {
print qq~<table border=4 width=120 height=120 cellpadding=0 cellspacing=0><tr><td align=center><FONT FACE="$text_font" SIZE="2">No<br>Photo</font></td></tr></table>~;
           }
  else {
    print qq~~;
	}
  }
}

print qq~
</font>
</TD>
</TR>
<TR>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Ad Number:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$category_color"><B>$fields[20]</B></FONT></TD>
</tr>

<TR>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Date Posted:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2" COLOR="$category_color"><B>$fields[12]</B></FONT></TD>
</tr>
<tr>
	<TD VALIGN="TOP" WIDTH=60><FONT FACE="$text_font" SIZE="2" COLOR="$label_color">Contact:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2">$fields[0]<br>~;
if ($fields[18] eq "Yes") { print qq~$fields[1]<br>~; }
else { print qq~~; }
print qq~
$fields[2], $fields[3] $fields[4]<br>
$fields[5]
</font></td>
</tr>
<tr>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">Telephone:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2">~;
if ($fields[18] eq "Yes") { print qq~$fields[6]~; }
else { print qq~~; }
print qq~
</FONT></TD>
</tr>
<tr>
	<TD WIDTH=60 VALIGN="TOP"><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">E-Mail:</FONT></TD>
	<TD WIDTH=160 VALIGN="TOP"><FONT FACE="$text_font" SIZE="2">~;

if (($use_personal_inbox eq "on") && ($form_data{'show_temp_ads'} eq "")) {
print qq~
<a href="$script_url?display_reply_form_button=on&results_format=off&db_id=$fields[20]&exact_match=on&query=retrieval">Reply to Ad</a>~;
	}
else {
print qq~
<a href="mailto:$fields[7]">$fields[7]</a>~;
	}

print qq~
</FONT></TD>
</tr>
<TR>
	<TD WIDTH=60><FONT FACE="$text_font" COLOR="$label_color" SIZE="2">Web Site:</FONT></TD>
	<TD COLSPAN=3><FONT FACE="$text_font" SIZE="2">~;

if ($allow_clickable_urls eq "on") {
print qq~
<a href="$fields[8]">$fields[8]</a>~;
	}
else {
print qq~$fields[8]~;
	}

print qq~<br></FONT></TD>
</TR>
</table>
<br>
<br>
	<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH=460><TR>
	<TD><FONT FACE="$text_font" SIZE="2" COLOR="$bar_color"><B>Description</B></FONT><BR>
	<FONT FACE="$text_font" SIZE="2">$fields[11]</FONT></td>
	</tr></TABLE>

</TD>
</TR>
</table><p>~;
      }
    }

} #end of sub search_results_body

#################################################################
#                 search_results_footer Subroutine              #
#################################################################
                
sub search_results_footer
  {
      
  if ($form_data{'search_and_display_for_deletion_button'} ne "") 
    {
  print qq~<p>~;
   if (($total_row_count >= $new_hits_seen) &&
      (($total_row_count-$new_hits_seen) >= $max_rows_returned))
    {
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_for_deletion_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $max_rows_returned Hits">~;
    }

  elsif (($total_row_count-$new_hits_seen) == 1)
    {
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_for_deletion_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Last Hit">~;
     }
  elsif ((($total_row_count-$new_hits_seen) < $max_rows_returned) &&  (($total_row_count-$new_hits_seen) > 1))
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_for_deletion_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $rows_left_to_view Hits">~;
    }
  elsif (($total_row_count-$new_hits_seen) < 1)
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    <INPUT TYPE = "hidden" NAME = "search_and_display_for_deletion_button"
         VALUE = "on">~;

    }
    &navbar;
    print qq~<table border=0><tr><td bgcolor="#ddeeee"><center><h2>Delete This Ad</h2>
    </center>The ad above is about to be deleted.  Are you sure that you want to delete this ad?  If so, then please click on the button below.<center><p>
<INPUT TYPE = "submit" NAME = "submit_deletion_button"
	   VALUE = "Delete This Ad"></td></tr></table>~;
    }         

  elsif ($form_data{'display_modification_form_button'} ne "")
    {
    print qq~<h2>Make Modifications</h2>
    </center>The ad that you selected to modify appears above.  Please make your modifications using the form below.  For your convenience, all of your current information is already included on this form.<center><p>~;
print qq~<p>~;
$fields[9] =~ s/<br>/\&\&/g;
for ($i = 0;$i <= 20;$i++) {
      $fields[$i] =~ s/<br>/\n/g;
      $fields[$i] =~ s/\"/\&quot\;/g;
      $fields[$i] =~ s/\</\&lt\;/g;
      $fields[$i] =~ s/\>/\&gt\;/g;
	}
    &add_modify_data_entry_form;
    print qq~<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Submit Modifications</FONT></th></tr>
</table>
<P>
<INPUT TYPE="submit" NAME="submit_modification_button" VALUE="Submit Modification(s)"></center>~;
	if ($form_data{'admin_password'} ne "") {
	print qq~<INPUT type=hidden NAME="admin_password" value="$form_data{'admin_password'}">~; }
    }         

  elsif ($form_data{'display_reply_form_button'} ne "")
    {
  print qq~
<table border=0 cellpadding=2 cellspacing=2 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Reply to Ad</FONT></th></tr>
</table>
<p>
</center>You can use the form below to reply to <b>$fields[0]</b>, who posted <a href="$script_url?search_and_display_db_button=on&db_id=$fields[20]&exact_match=on&query=retrieval">this ad</a>. If you are responding to a personal ad and would like to remain somewhat anonymous yourself, you may want to place your own personal ad here and then reference it in your reply to this person.
<p>

<table border=0 cellpadding=2 cellspacing=2>
<input type=hidden name="db_id" value="$fields[20]">
<input type=hidden name="exact_match" value="on">
<input type=hidden name="results_format" value="off">
<input type=hidden name="query" value="retrieval">
<input type=hidden name="db_id" value="$fields[20]">
<tr>
<th align=left><font face=arial size=2>Your E-mail address:</font></th>
<td><input type=text name="reply_email" size=20 maxlength=40> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Message:</font></th>
<td><textarea name="reply_body" WRAP=on COLS=30 ROWS=5></textarea> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<td colspan=2><INPUT TYPE="submit" NAME="send_reply_button" VALUE="Send Reply to $fields[0]"></td></tr>
</table>
</form>~;
    }       

  elsif ($form_data{'send_reply_button'} ne "")
    {

$form_data{'reply_body'} =~ s/~p~/\|/g;
$form_data{'reply_body'} =~ s/~nl~/\n/g;
$form_data{'reply_body'} =~ s/~r~/\r\r/g;

$reply_email = $form_data{'reply_email'};

if ($require_admin_from_address) { $from = $master_admin_email_address; }
else { $from = $reply_email; }

$to = $fields[7];
$subject = "Reply To Your Ad at the $classifieds_name";

if ($require_admin_from_address) {
$message = "You received the following reply to your ad (Ad Number $form_data{'db_id'}) at the $classifieds_name.  If you wish to reply to this person, please reply to them at $reply_email.  Do NOT reply directly to this message.

_____________________________

$form_data{'reply_body'}";
}

else {
$message = "$form_data{'reply_body'}";
}

&send_mail($from, $to, $subject, $message);

  print qq~
  <H2>Reply Sent</H2>
Your reply has been sent to <b>$fields[0]</b>.~;
    }       

  elsif ($form_data{'display_new_ads_button'})
       {
&generic_form_header;
   print qq~<p>
<INPUT type=hidden NAME="admin_password" value="$admin_password">~;
  if (($total_row_count >= $new_hits_seen) &&
      (($total_row_count-$new_hits_seen) >= $max_rows_returned))
    {
    print qq~
    <INPUT TYPE = "hidden" NAME = "display_new_ads_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $max_rows_returned Hits">~;
    }

  elsif (($total_row_count-$new_hits_seen) == 1)
    {
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    <INPUT TYPE = "hidden" NAME = "display_new_ads_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Last Hit">~;
     }
  elsif ((($total_row_count-$new_hits_seen) < $max_rows_returned) &&  (($total_row_count-$new_hits_seen) > 1))
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    <INPUT TYPE = "hidden" NAME = "display_new_ads_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $rows_left_to_view Hits">~;
    }
  elsif (($total_row_count-$new_hits_seen) < 1)
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    <INPUT TYPE = "hidden" NAME = "display_new_ads_button"
         VALUE = "on">~;
    }
    &navbar;
       }

    else
       {
   print qq~<p>~;
  if (($total_row_count >= $new_hits_seen) &&
      (($total_row_count-$new_hits_seen) >= $max_rows_returned))
    {
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_db_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $max_rows_returned Hits">~;
    }

  elsif (($total_row_count-$new_hits_seen) == 1)
    {
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_db_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Last Hit">~;
     }
  elsif ((($total_row_count-$new_hits_seen) < $max_rows_returned) &&  (($total_row_count-$new_hits_seen) > 1))
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    
    <INPUT TYPE = "hidden" NAME = "search_and_display_db_button"
         VALUE = "on">
    <INPUT TYPE = "submit" VALUE = "See The Next $rows_left_to_view Hits">~;
    }
  elsif (($total_row_count-$new_hits_seen) < 1)
    {  
    $rows_left_to_view = $total_row_count-$new_hits_seen;
    print qq~
    <INPUT TYPE = "hidden" NAME = "search_and_display_db_button"
         VALUE = "on">~;
    }
    &navbar;
       }

  print qq~</form>~;
  &pageclose;
  }


sub navbar {

      if ($form_data{'category'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "category" VALUE = "$form_data{'category'}">~;
         }

      if ($form_data{'keywords'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "keywords" VALUE = "$form_data{'keywords'}">~;
         }

      if ($form_data{'exact_match'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "exact_match" VALUE = "$form_data{'exact_match'}">~;
         }
      if ($form_data{'case_sensitive'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "case_sensitive" VALUE = "$form_data{'case_sensitive'}">~;
         }
      if ($form_data{'results_format'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "results_format" VALUE = "$form_data{'results_format'}">~;
         }
      if ($form_data{'query'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "query" VALUE = "$form_data{'query'}">~;
         }
      if ($form_data{'photo'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "photo" VALUE = "$form_data{'photo'}">~;
         }

      if ($form_data{'caption_header'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "caption_header" VALUE = "$form_data{'caption_header'}">~;
         }
      if ($form_data{'boolean'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "boolean" VALUE = "$form_data{'boolean'}">~;
         }
      if ($form_data{'days_ago'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "days_ago" VALUE = "$form_data{'days_ago'}">~;
         }

      if ($form_data{'date_begin'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "date_begin" VALUE = "$form_data{'date_begin'}">~;
         }
      if ($form_data{'date_end'} ne "")
        {
           print qq~
            <INPUT TYPE = "hidden" NAME = "date_end" VALUE = "$form_data{'date_end'}">~;
         }

print qq~
    <INPUT TYPE = "hidden" NAME = "new_hits_seen"    
           VALUE = "$new_hits_seen">~;

print qq~<p><a href="$script_url?~;
  if ($form_data{'search_and_display_db_button'} ne "")
    { print qq~view_database_button=on~; }
  if ($form_data{'search_and_display_for_modification_button'} ne "")
    { print qq~modify_item_button=on~; }
  if ($form_data{'search_and_display_for_deletion_button'} ne "")
    { print qq~delete_item_button=on~; }
print qq~"><img src="$graphics_dir/newsearch.gif" width=100 height=20 alt="New Search" border=0></a><p>~;

} # End of sub navbar

#################################################################
#                       no_hits_message Subroutine              #
#################################################################
  
sub no_hits_message
  {
  print qq~<center><h2>No Matches Found</h2></center>
  <BLOCKQUOTE>
  We're sorry, but it appears that there were no records in the database
  that matched your search criteria.  Please go back and try again.  You may want to broaden your search by leaving more of the search fields blank.
  </BLOCKQUOTE><p><center>~;
  if ($form_data{'search_and_display_db_button'} ne "")
    { print qq~ 
<INPUT TYPE = "submit" NAME = "view_database_button"
         VALUE = "New Search">~; }
  if ($form_data{'search_and_display_for_modification_button'} ne "")
    { print qq~ 
<INPUT TYPE = "submit" NAME = "modify_item_button"
         VALUE = "New Search">~; }
  if ($form_data{'search_and_display_for_deletion_button'} ne "")
    { print qq~ 
<INPUT TYPE = "submit" NAME = "delete_item_button"
         VALUE = "New Search">~; }
print qq~
</form></center>~;
&pageclose;
  }

sub preview_ads
  {
if ($form_data{'admin_password'} ne "$admin_password") { &admin_password_error; }
  &pagesetup("Preview New Ads");
  &search_and_display_db;
  }

sub search_and_display_db_for_view
  {
  &pagesetup("View");
  &generic_form_header;
  &search_and_display_db;
  }

sub search_and_display_for_deletion
  {
if (($form_data{'password'} eq "") || ($form_data{'db_id'} eq "")) { &password_error; }
  &pagesetup("Delete");
  &generic_form_header;
  &search_and_display_db;
  }

sub display_modification_form
  {
if (($form_data{'password'} eq "") || ($form_data{'db_id'} eq "")) { &password_error; }
  &pagesetup("Modify");
  &generic_form_header;
  &search_and_display_db;
  }

sub display_reply_form
  {
  &pagesetup("Reply To Ad");
  &generic_form_header;
  &search_and_display_db;
  }

sub send_reply
  {
if ($form_data{'reply_body'} eq "") { &blank_field_error; }

unless ($form_data{'reply_email'} =~ /.+\@.+\..+/) {
      &email_error; }
  &pagesetup("Reply To Ad");
  &generic_form_header;
  &search_and_display_db;
  }


sub add_form_header
  {
  print qq~
  <H2>Post a Classified Ad</H2></center>
Please fill in the fields below to post your ad.  Required fields are denoted by <font size=4 color="#ff0000"><b>*</b></font>.  You will be given the opportunity to preview your ad before it is posted.  By posting an ad here, you agree that it is in compliance with our <a href="$script_url?print_guidelines_page_button=on">guidelines</a>.<p>~;

if ($fee eq "on") {
print qq~The cost for posting ads here is $currency$first_ad_cost for the first category and $currency$multiple_ad_cost for each additional category.  By posting your ad here, you agree to promptly submit the appropriate payment for your ad.<p>~;
    }

if ($use_personal_inbox) { print qq~Your <b>e-mail address</b> will not be displayed in your ad.  Instead, viewers will click on a "Reply to Ad" link to send e-mail to you, and they will not see your e-mail address.~;
}

else { print qq~Your <b>e-mail address</b> will be displayed in your ad.~; }

if ($allow_photo_uploads eq "on") {
print qq~<p>
<b>You will be able to upload a photo to your ad once it has been posted.</b><p>~;
}

print qq~<center>~;
  }

sub add_form_footer
  {
  print qq~
  <P>
  <INPUT TYPE = "submit" NAME = "preview_ad_button"
	 VALUE = "Preview My Ad"></form>~;
  }

sub successful_addition_message
  {

  &pagesetup("Success: Your Ad has been posted to the Classifieds");
  print qq~
  <h3>Your Ad Has Been Successfully Posted</h3></center>
Thank you for posting your ad here at the $classifieds_name.  Please make a note of your password and your ad number, as you will need them if you ever want to modify or delete this ad.  Your ad number is <b>$new_counter</b>.  Your ad will expire in $form_data{'ad_duration'} days unless you renew it prior to that time.~;
if ($limit_renewals eq "on") {
print qq~  You can renew your ad for an additional $form_data{'ad_duration'} days a maximum of $max_renewals times.~; }
print qq~
  <P>~;
if ($fee eq "on") {
print qq~The total cost for your ad is $currency$total_cost, which is based on its placement in $number_of_ads categories at the rate of $currency$first_ad_cost for the first category and $currency$multiple_ad_cost for each additional category.  An invoice has been sent to your e-mail address.  Please remit payment immediately.  Thank you.<p>~;
  }
print qq~You can view your ad <a href="$script_url?website=$website&search_and_display_db_button=on&db_id=$new_counter&exact_match=on&query=retrieval~;

if ($require_admin_approval eq "on") { print qq~&show_temp_ads=on~; }

print qq~
">here</a>.
<p>~;

if ($require_admin_approval eq "on") {

print qq~<b>Since we must approve all new ads before they are posted, your ad will not be viewable (except for modification or deletion purposes) until we have approved it for posting.</b><p>~; 
  }

if ($allow_photo_uploads eq "on") {
print qq~
If you would like to add a photo to your ad, you can do so by using the form below.
<p>
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Upload a Photo to Your Ad</FONT></th></tr>
</table>
<p>
You may upload a photo to your ad by filling in the fields below.  The image <b>type</b> must be in the <b>.GIF</b> or <b>.JPG</b> format, have a file size no larger than approximately $maximum_attachment_size bytes, and have a width no greater than $max_image_width pixels and a height no greater than $max_image_height pixels.  Depending on the size of your photo and the speed of your Internet connection, it may take a minute or two to upload your image.  Please note that this process will overwrite any previous photos that you have added to this ad.~;

print qq~<p>~;

&upload_form_header;

if (!$browser_uploading) {
print qq~
<font color="#ff0000">NOTICE: Your web browser may not support File Uploads.  You may attempt to upload a multimedia file, but you may not be able to use this feature without first upgrading to a newer browser version.</font>~;
}

print qq~
<input type="hidden" name="db_id" value="$new_counter">
<input type="hidden" name="password" value="$form_data{'password'}">
<table border=0 cellpadding=2 cellspacing=2>
<tr><td colspan=2><font face=arial size=2>Please choose the file that you want to upload by clicking on the "Browse" button below and selecting the file from your local hard drive.<br></font>
<INPUT TYPE=FILE NAME="upload_file"></td></tr>
<tr><td colspan=2><br><br>
<INPUT TYPE = "submit" NAME = "upload" VALUE = "Upload Photo to your Ad"></td></tr></form>
</table>
<p>~;
  }
print qq~<p>~;
  &pageclose;
}

sub successful_deletion_message
  {
  &pagesetup("Success: Your ad has been successfully deleted");
  print qq~
  <center><h3>The Ad that you selected has been Deleted from the Classifieds!</h3>
  <P>~;
  &pageclose;
  }

sub successful_modification_message
  {
  &pagesetup("Success: Your Ad has been modified in the Classifieds");
  print qq~
  <h3>Your Ad Has Been Successfully Modified</h3></center>
Thank you for updating your ad here at the $classifieds_name.  You can view your ad <a href="$script_url?search_and_display_db_button=on&db_id=$db_id_modify&exact_match=on&query=retrieval~;

if (($require_admin_approval eq "on") && ($new_status eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~
">here</a>.
<p>~;

if (($require_admin_approval eq "on") && ($new_status eq "temp")) {

print qq~<b>Your ad has not been approved by the administrator yet, so it will not be viewable (except for modification or deletion purposes) until we have approved it for posting.  This is a generic system message and does not necessarily indicate that there is any type of problem with your ad.</b><p>~; 
  }

if ($allow_photo_uploads eq "on") {
print qq~
If you haven't added a photo to your ad yet, or if you would like to replace your current photo with a new one, you can use the form below to add a photo to your classified ad.
<p>

</center>
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Upload a Photo to Your Ad</FONT></th></tr>
</table>
<p>
You may upload a photo to your ad by filling in the fields below.  The image <b>type</b> must be in the <b>.GIF</b> or <b>.JPG</b> format, have a file size no larger than approximately $maximum_attachment_size bytes, and have a width no greater than $max_image_width pixels and a height no greater than $max_image_height pixels.  Depending on the size of your photo and the speed of your Internet connection, it may take a minute or two to upload your image.  Please note that this process will overwrite any previous photos that you have added to this ad.~;

print qq~<p>~;

&upload_form_header;

if (!$browser_uploading) {
print qq~
<font color="#ff0000">NOTICE: Your web browser may not support File Uploads.  You may attempt to upload a multimedia file, but you may not be able to use this feature without first upgrading to a newer browser version.</font>~;
}

print qq~
<input type="hidden" name="db_id" value="$form_data{'item_to_modify'}">
<input type="hidden" name="password" value="$form_data{'password'}">
<table border=0 cellpadding=2 cellspacing=2>
<tr><td colspan=2><font face=arial size=2>Please choose the file that you want to upload by clicking on the "Browse" button below and selecting the file from your local hard drive.<br></font>
<INPUT TYPE=FILE NAME="upload_file"></td></tr>
<tr><td colspan=2><br><br>
<INPUT TYPE = "submit" NAME = "upload" VALUE = "Upload Photo to your Ad"></td></tr></form>
</table>
<p>~;
  }
print qq~<P>~;
  &pageclose;
}

sub unsuccessful_modification_message
  {
  &pagesetup("Error: Your Ad has not been modified");
  print qq~<center><h3>Error: Access Denied</h3></center>
  We're sorry, but you are only allowed to modify or delete ads posted by you.~;
  &pageclose;
  }

sub successful_approval_message
  {
  &pagesetup("Success: The ad that you selected has been approved");
  print qq~
  <center><h3>The ad that you selected has been approved</h3>
  <P>~;
&generic_form_header;
   print qq~
<INPUT type=hidden NAME="admin_password" value="$admin_password">
    <INPUT TYPE = "hidden" NAME = "display_new_ads_button" VALUE = "on">
<input type="hidden" name="results_format" value="preview_mode">
    <INPUT TYPE = "submit" VALUE = "Reload Ads Awaiting Approval">
</form>~;
  &pageclose;
  }

sub no_item_submitted_for_modification
  {
  &pagesetup("Error: Your Ad has not been modified");
  print qq~<center><h2>Error: No ad chosen</h2>
  </center>We're sorry, but we were unable to modify your ad because you did not
  select an ad to modify.  Please hit the back button and make
  sure that you use the radio button or checkbox to choose an ad to
  modify or delete.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
  &pageclose;
  }

sub successful_autonotify_addition_message
  {

  &pagesetup("Success: Your personal search agent has been set up");
  print qq~
  <center><h3>Your Personal Search Agent has been set up!</h3>
  <P></center>
  You will now receive an e-mail message that contains all of the latest ads that match the search criteria that you specified.  Please feel free to come back here and modify or cancel your personal search agent at any time.  To do so, you will need your profile number and your password for this profile, which are as follows:<p>
Profile Number: $new_counter<br>
Password: $form_data{'password'}<p>
~;
  &pageclose;
  }

sub successful_autonotify_modification_message
  {

  &pagesetup("Success: Your personal search agent has been updated");
  print qq~
  <center><h3>Your Personal Search Agent has been Updated!</h3>
  <P></center>
Your personal search agent has been updated as you specified.  As before, you will continue to receive an e-mail message that contains all of the latest ads that match the search criteria that you specified.  Please feel free to come back here and modify or cancel your personal search agent at any time.<p>~;
  &pageclose;
  }

sub successful_autonotify_deletion_message
  {

  &pagesetup("Success: Your personal search agent has been deleted");
  print qq~
  <center><h3>Your Personal Search Agent has been Deleted!</h3>
  <P></center>
Your personal search agent has been deleted as you specified.  You will no longer be notified of new ads here at the $classifieds_name.  Please feel free to come back here and create a new personal search agent at any time.<p>~;
  &pageclose;
  }

sub print_autonotify_options_page {

&pagesetup("$classifieds_name Keyword Notify Options");
&generic_form_header;

  print qq~
<h2><font color="#0000ff">Keyword Notify Options</font></h2>
</center>

Please choose one of the buttons below to either setup your Keyword Notify search agent, modify your search criteria, or delete your Keyword Notify search agent.  Please note that you will be asked to logon.  If you have previously registered when posting an ad, you can use the same username and password here.  Otherwise, you will need to register so that only you have control over your search agent.<p>
<center>
  <INPUT TYPE = "submit" NAME = "autonotify_add_form_button"
	 VALUE = "Create Agent">
  <INPUT TYPE = "submit" NAME = "autonotify_modify_search_button"
         VALUE = "Modify Agent">
  <INPUT TYPE = "submit" NAME = "autonotify_delete_search_button"
         VALUE = "Delete Agent">
</form>
<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
&pageclose;
      exit;
 }

sub autonotify_add_form {

  print qq~
  <H2>Keyword Notify Setup Form</H2></center>~;

if ($form_data{'autonotify_modify_form_button'} ne "") {
print qq~
The search agent form appears below with your previous search criteria filled in.<p><center>
~;
}

else {
print qq~
Please use the following form to define how your personal search agent will retrieve the new ads according to the keywords or other criteria that you select.  If you want the search agent to send you all ads, you can simply leave all fields blank, with the exception that you must enter your e-mail address and select a password.
<p><center>~;
}

  &generic_form_header;

  print qq~
</center>
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff">
<tr>
<th align=left><font face=arial size=2>Find Keywords:</font></th>
<td><input name=keywords type=text size=30 value="$fields[0]"></td>
</tr>~;

if ($show_quick_search_categories eq "on") {
print qq~
<tr>
<th align=left><font face=arial size=2>Category</font></th>
<td><SELECT NAME = "category">~;
if ($fields[3] ne "") { print qq~<OPTION>$fields[3]~; }
print qq~
  <OPTION VALUE="">All~;

foreach $category (@categories) {
print qq~<OPTION>$category~;
  }

print qq~
  </select>
</td>
</tr>~;
}

if ($use_caption_headers eq "on") {
print qq~
<tr>
<th align=left><font face=arial size=2>Type</font></th>
<td><SELECT NAME = "caption_header">~;
if ($fields[4] ne "") { print qq~<OPTION>$fields[4]~; }
print qq~
  <OPTION VALUE="">All~;
foreach $caption_header (@caption_headers) {
print qq~
  <OPTION>$caption_header
~;
   }
print qq~
  </select>
</td></tr>~;
}

print qq~
<tr>
<th align=left><font face=arial size=2>Ads Must Match</font></th>
<td><SELECT NAME="boolean">~;
if ($fields[1] eq "any terms") { print qq~<OPTION>any of my keywords~; }
if ($fields[1] eq "all terms") { print qq~<OPTION>all of my keywords~; }
if ($fields[1] eq "as a phrase") { print qq~<OPTION>this exact phrase~; }
print qq~
<OPTION value="any terms">any of my keywords
<OPTION value="all terms">all of my keywords
<OPTION value="as a phrase">this exact phrase
</SELECT></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Case</font></th>
<td><SELECT NAME="case_sensitive">~;
if ($fields[2] ne "") { print qq~<OPTION value="on">sensitive~; }
print qq~
<OPTION value="">insensitive
<OPTION value="on">sensitive
</SELECT></td>
</tr>
<tr>
<th align=left><font face=arial size=2>Must Have Photos</font></th>
<td><INPUT TYPE="checkbox" NAME="photo"~;
if ($fields[5] ne "") { print qq~ CHECKED~; }
print qq~></TD>
</tr>

~;

if ($form_data{'autonotify_modify_form_button'} ne "") {
print qq~
  <INPUT TYPE = "hidden" NAME = "autonotify_submit_modification"   
         VALUE = "Search for Matching Ads">
  <INPUT TYPE = "hidden" NAME = "db_id"   
         VALUE = "$fields[10]">
~;
}
else {
print qq~
  <INPUT TYPE = "hidden" NAME = "autonotify_submit_addition"   
         VALUE = "Search for Matching Ads">~;
}
print qq~
<tr>
<th align=left><font face=arial size=2>Your E-Mail Address:</font></th>
<td><input type=text size=30 name="email" VALUE="$fields[6]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>

<tr>
<th align=left><font face=arial size=2>Choose Password:</font></th>
<td><input type=text size=30 name="password" VALUE="$fields[7]"> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>~;

if ($form_data{'autonotify_add_form_button'} ne "") {
print qq~
<th align=left><font face=arial size=2>Auto-Expire Agent in:</font></th>
<td>
<SELECT name=autonotify_duration>~;
foreach $duration (@autonotify_duration) {
print qq~<OPTION value="$duration">$duration days
~;
}
print qq~
</select> Days
</td>
</tr>~;
}

print qq~
<tr>
<td colspan=2>
  <INPUT TYPE = "submit" VALUE = "Send Me Matching Ads">
</td></tr>
</table>
<p>
</form>
<p>~;
}

#################################################################
#                  Keyword Notify Search Form Subroutine               #
#################################################################

sub autonotify_search_form
  {
  &pagesetup("Search for a Keyword Notify Profile");

  print qq~
  <center><H2>Search for a Keyword Notify Profile</H2>~;
  &generic_form_header;
print qq~
<table border=0 cellpadding=4 cellspacing=4 width=470>
<tr>
<td bgcolor="$primary_large_table_color">
<center><font size=4>Profile Information</font></center><p>
Please provide the profile number and the password that you submitted with this Keyword Notify profile.<p>
<table><tr><td>Profile Number</td><td><input type=text name=db_id size=20 maxlength=20></td>
</tr>
<tr><td>Password</td><td><input type=text name=password size=20 maxlength=40></td></tr>
</table>
</td></tr></table>
<p>

  <P>~;
if ($form_data{'autonotify_modify_search_button'} ne "") {
print qq~
  <INPUT TYPE = "submit" NAME = "autonotify_modify_form_button"
         VALUE = "Search for Keyword Notify Profile to Modify"></form>~;
	}

if ($form_data{'autonotify_delete_search_button'} ne "") {
print qq~
  <INPUT TYPE = "submit" NAME = "autonotify_delete_form_button"
         VALUE = "Search for Keyword Notify Profile to Delete"></form>~;
	}

  &pageclose;
  }

sub autonotify_delete_form {

print qq~
  <H2>Keyword Notify Deletion Warning!</H2></center>
You are about to delete your personal search agent at the $classifieds_name.  Are you sure that you want to do this?  If not, please go back and choose another option.  If you're sure that you want to cancel your personal search agent, then click on the "Delete Search Agent" button below.
<p>
Your current search agent criteria are as follows:<p>
<b>Keywords:</b> $fields[0]<br>
<b>To be searched for:</b> $fields[1]<br>
<b>Case sensitive?:</b> $fields[2]<br>
<b>Category:</b> $fields[3]<br>
<b>Type:</b> $fields[4]<br>
<b>Only Ads with Photos?:</b> $fields[5]<br>
<b>E-mail Address:</b> $fields[6]<br>
<b>Profile Number:</b> $fields[10]<br>
<p>
<center>~;

  &generic_form_header;

  print qq~
  <INPUT TYPE = "hidden" NAME = "password"   
         VALUE = "$fields[7]">
  <INPUT TYPE = "hidden" NAME = "db_id"   
         VALUE = "$fields[10]">
  <INPUT TYPE = "submit" NAME = "autonotify_submit_deletion"   
         VALUE = "Delete Search Agent"></form>


<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
}

sub print_help_page {

&pagesetup("$classifieds_name FAQ");

  print qq~
<a name="top">
<h2>Frequently Asked Questions and Answers</h2></center>
Here are brief explanations for some of the questions that you may have 
about the $classifieds_name.<hr>
<ul>
<li><a href="#system">How does this system work?</a>
<li><a href="#post">How do I post an ad?</a>
<li><a href="#name">Do I have to use my real name when posting a message?</a>
<li><a href="#links">Can I use HTML tags anywhere in my posts?</a>
<li><a href="#describe">What should I put in the "Text of Ad" box?</a>
<li><a href="#reload">Why didn't my classified ad show up?</a>
<li><a href="#modify">How do I modify my ad?</a>
<li><a href="#remove">How do I remove my ad?</a>
<li><a href="#hits">Why didn't my search turn up any hits?</a>
<li><a href="#results">How do I navigate the search results page?</a>
<li><a href="#abbreviations">What do all of those abbreviations in the personal ads stand for?</a>
<li><a href="#contact">How do I contact someone who has posted a classified ad?</a>
<li><a href="#purchase">How can I obtain a copy of this program?</a>
</ul><hr><p>

<a name="system"><b>How does this system work?</b></a><p>
On the front page for the $classifieds_name, you will see several buttons that allow you to view, post, modify, or delete ads.  Please click on one of these buttons, depending on the action that you want to take.  If you post an ad, you will be asked to select a password for that ad.  You will also be given an ad number.  In the future, anytime that you want to modify or delete that ad, you will need to know the ad number and password.  Therefore, please make a note of them.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="post"><b>How do I post an ad?</b></a><p>
From the main page, click on the "Place Ad" button.   and logon as described above.  You will then be taken to the "Post a Classified Ad" page.  Here, you will see a form with many fields.  You will also be asked to select a password for that ad.  When you have filled out the form, click on the "Post my ad" button.  You should then see an acknowledgement page if your ad was successfully posted.  You will also be given an ad number.  Please make a note of your password and the ad number, because you will need these if you ever want to modify or delete your ad.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="name"><b>Do I have to use my real name when posting a message?</b></a><p>
No.  Even if you use your real name when you register (and we encourage that), you do not have to use your real name when you post an ad.  The script will simply publish whatever you put in the first and last name fields.  If you feel more comfortable, you can use a nickname or pseudoname.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="links"><b>Can I put HTML tags anywhere in my posts?</b></a><p>
No.  You can not use HTML tags in the body of the message.  
If you put HTML tags in your message, the script will just throw out everything in between the 
&lt;&gt;'s.  You do have the option, however, of putting a link to a picture of something if you have posted it somewhere else on the Web.
<p><a href="#top">Back to Top</a>
<p><hr><p> 

<a name="describe"><b>What should I put in the "Text of Ad" box?</b></a><p>
Please describe the item that you are trying to sell in as much detail as you can.  If you're posting a classified ad advertising a car, tell people about the year, make, model, number of miles, options, etc.  If you're posting a classified ad advertising a piece of real estate for sale or for rent, tell them about the number of bedrooms, bathrooms, and other rooms; about the amenities; etc.  If you're announcing a garage sale, be sure to tell readers the exact time and location of the garage sale and describe some of the items that will be available. For personal ads, tell people what you look like, what you do for a living,
what your hobbies and interests are, where you're from, etc.  Also, don't be afraid to say what
you're looking for both in terms of physical or personality traits and in terms of the relationship. 
If you want someone who is a specific age or looks a certain way or has certain political or
recreational interests, say so!  Being honest about both what you're really like and what you
really want will help to avoid misunderstandings in the future. If you're posting a help wanted ad, tell people about the type of work, what skills, education, or experience is required, what the rate of pay is, the geographic location of the job, and any other information relevant to this particular position.  If you're posting an employment wanted ad, tell potential employers about the type of work you desire, your skills, education, and experience, what salary level you are seeking, what geographic areas you would prefer to work in, and any other relevant information about yourself.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="reload"><b>Why didn't my classified ad show up?</b></a><p>
Your classified ad most likely did not show up because either you were in the wrong category (such as "Housing" instead of "Personals") or you specified search criteria that don't appear in your ad.  If so, please verify that you selected the correct category and then broaden your search by leaving more of the search fields blank.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="modify"><b>How do I modify my ad?</b></a><p>
At the bottom of every page you will find the "Modify Ad" button.  If you click on this button, you will see a search form.  The form will ask for the ad number and the password that you entered with this ad.  Once you have entered these, click on the "Search for Item to Modify" button.  If you entered the correct information, your ad will be displayed with a modification form beneath it.  The current information from your ad will already be filled in, so you only need to modify the fields that you want to change.  Once you have filled in the form, click on the "Submit Modification(s)" button.  You should then see an acknowledgement page if your ad was successfully modified.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="remove"><b>How do I remove my ad?</b></a><p>
At the bottom of every page you will find the "Delete Ad" button.  If you click on this button, you will see a search form.  The form will ask for the ad number and the password that you entered with this ad.  Once you have entered these, click on the "Search for Item to Delete" button.  Narrow your search by filling in the fields with information specific to your ad (such as your last name, etc.) and click on the "Search for Item to Delete" button. If you entered the correct information, your ad will be displayed with a warning beneath it indicating that you are about to delete it.  If you are sure that you want to delete this ad, click on the "Delete This Ad" button.  You should then see an acknowledgement page if your ad was successfully deleted.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="hits"><b>Why didn't my search turn up any hits?</b></a><p>
Your search criteria may have been too narrow.  Go back to the search form and leave more of the search fields blank, or click on the "New Search" button and do a general search. For the broadest possible search, simply click on the "See All Ads" button.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="results"><b>How do I navigate the search results page?</b></a><p>
The results of your search will be displayed on the search results page.  To see more of your search results, you can click on the "See The Next X Hits" button beneath the ads displayed on this page.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="abbreviations"><b>What do all of those abbreviations in the personal ads stand for?</b></a><p>
Below are some of the most commonly used abbreviations for personal ads and what they mean:<ul>
<li>M--Male
<li>F--Female
<li>W--White
<li>B--Black
<li>H--Hispanic
<li>A--Asian
<li>J--Jewish
<li>S--Single
<li>D--Divorced
<li>M--Married (not that we're encouraging this)
<li>Wi--Widowed
<li>G--Gay
<li>Bi--Bisexual
<li>C--Christian
<li>P--Professional
<li>NS--Non-smoking
<li>ISO--In Search Of
<li>y.o.--Years Old
</ul>
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="contact"><b>How do I contact someone who has posted a classified ad?</b></a><p>
All of the classified ads will list either the e-mail address of the person who posted the ad or their phone number.  The e-mail listings are also links, so you can click on the person's e-mail address to send the person a reply message.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<a name="purchase"><b>How can I obtain a copy of this program?</b></a><p>
This program is developed and licensed by Hagen Software Inc.  Several versions are available, ranging in price from \$79 to \$999, depending on the features that you need.  You can purchase a license to use one of these versions.  This license allows you to install and use the program on one web site.  It does not allow you to resell, give away, or otherwise distribute the source code, nor does it allow you to extend this program to other web sites.  More information is available <a href="http://www.e-classifieds.net/">here</a>.
<p><a href="#top">Back to Top</a>
<p><hr><p>

<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
&pageclose;
      exit;
 }

sub print_guidelines_page {

&pagesetup("$classifieds_name Guidelines");

  print qq~
<h2>Guidelines</h2></center>
By posting your classified ad here, you agree that it is in compliance with our guidelines.  We do not wish to censor or police the ads being posted here, nor do we have the time to monitor every posting, but in order to prevent abuses by a few people and to keep this forum comfortable and appropriate for our general audience, which includes people of all ages, races, religions, and nationalities, we reserve the right to remove any ads in violation of our guidelines that are brought to our attention.  Therefore, all ads that are in violation of our guidelines are subject to being removed immediately and without prior notice.  By posting an ad here, you agree to the following statement:
<ol>
I agree that I will be solely responsible for the content of all classified ads that I post under this program and that I will indemnify the $sitename and hold it harmless for any losses or damages to myself or to others that may result directly or indirectly from any ads that I post here.
</ol>
By posting an ad here, you further agree to the following guidelines:
<ol>
<li>No foul or otherwise inappropriate language will be tolerated.  Ads in violation of this rule are subject to being removed immediately and without warning.
<li>No racist, hateful, or otherwise offensive comments will be tolerated.
<li>No ad promoting activities that would be illegal under the laws of this State or Province, this Country, or of the state or country of domicile of the person posting the ad shall be allowed.
<li>Any ad that appears to be merely a test posting, a joke, or otherwise insincere or non-serious is subject to removal.
<li>The $sitename reserves the ultimate discretion as to which ads, if any, are in violation of these guidelines.
</ul>
Thank you.  We hope that these guidelines will make the $classifieds_name more enjoyable for everyone.<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
&pageclose;
      exit;
 }

sub print_tips_page {

&pagesetup("$classifieds_name Search Tips");

print qq~
<h2>Search Tips</h2></center>
The $classifieds_name are controlled by a powerful search engine.  You can use the fields on the search form to narrow your search according to the keywords or other criteria that you select.  If you want the broadest possible search, leave all fields blank (although this may result in an inordinately large number of results).<p>
<b>"As A Phrase":</b> You can also use the "as a phrase" option under "Find" in the Keyword Search box to narrow your search (for example, if you select the "as a phrase" option and search for "dog" then only listings with "dog" in them will show up.  Listings with "dogs" or "hot dog" in them would not).<p>
<b>Case Sensitive:</b> If you you select the case sensitive option, capitalization will matter (for example, if you search for "Star", then listings with the word "star" will not show up).<p>
<b>E-Mail address:</b> Did you know that you can search for people using a specific Internet Access Provider?  For example, if you wanted to find all people using Erols, you could enter the keywords "erols.com" in the Keywords search form.<p>
<b>Phone Number:</b> Even if you don't know the whole number, you can enter parts of the number in the Keywords search box (make sure that Exact Match is not turned on).  Or, you could search for people in the 703 area code by entering "703".<p>
<b>URL of Homepage:</b> Again, you could search for people whose home pages reside at a specific server.  For example, to find people whose homepages reside at America Online, type "aol.com" in the Keyword Search form.  In fact, if you just wanted to see people with home pages, you could simply type "http://" in this field, and the script will ony display entries for people who have homepages.<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
&pageclose;
      exit;
 }

#######################################################################
#                    duplicate_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid e-mail address in the
# form someuser@somedomain.com

sub duplicate_error
  {

&pagesetup("Error: Duplicate Found");

  print qq~
<h2>Error: Duplicate Found</h2></center>
We're sorry, but this ad is a duplicate of an ad that has already been posted.  If you just attempted to post an ad before posting this one, then this message is an indication that your original post was successful.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    word_limit_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad entered too many words in their ad.

sub word_limit_error
  {

&pagesetup("Error: Maximum Word Limit Exceeded");

  print qq~
<h2>Error: Maximum Word Limit Exceeded</h2></center>
We're sorry, but the text of your ad contains <b>$number_of_words</b> words, which exceeds our word limit.  The maximum number of words allowed in each ad is <b>$maxwords</b> words.  Please go back and trim the text of your ad so that it contains no more than $maxwords words.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    ad_limit_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid e-mail address in the
# form someuser@somedomain.com

sub ad_limit_error
  {

&pagesetup("Error: Maximum Ads Exceeded");

  print qq~
<h2>Error: Maximum Ads Exceeded</h2></center>
We're sorry, but you are attempting to post your ad in $number_of_ads categories, which is greater than the maximum allowable number of ads, which is $max_ads ads.  Please go back and make sure that you have selected no more than $max_ads categories.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

sub kill_error
  {
&pagesetup("Forbidden");

  print qq~
<center><h1>Forbidden</h1></center>\n
You don't have permission to access this program.<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

sub badwords_error
  {
&pagesetup("Error: Censor Triggered");

  print qq~
<center><h1>Error: Censor Triggered</h1></center>\n
Your text contains one or more words that are not allowed in ads posted under this system.  The unacceptable words are highlighted in bold below:<p></center>~;

  $n = @check_fields;
  for ($i = 0;$i <= $n-1;$i++)
    {
	$form_data{$check_fields[$i]} =~ s/~nl~/<br>/gi;
	$form_data{$check_fields[$i]} =~ s/~p~/\|/gi;
	print qq~$check_fields[$i] = $form_data{$check_fields[$i]}<br>~;
    }

print qq~<center>
<p>Please use your browser's BACK button to edit your text and make it suitable for everyone.  If your company name, e-mail address, or telephone number were listed in bold above, then you are not allowed to post ads on this site.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

#######################################################################
#                    email_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid e-mail address in the
# form someuser@somedomain.com

sub email_error
  {

&pagesetup("Invalid E-Mail Address");

  print qq~
<center><h2>Invalid E-Mail Address</h2></center>\n
      We're sorry, but you did not enter a valid e-mail address.  Please go BACK and make sure that you have entered a valid e-mail address.<p>\n
      If you do not have an e-mail address, you can leave this field blank, but please be sure to provide other contact information, such as your phone number.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

sub blank_field_error
  {
&pagesetup("Missing Field");

  print qq~
<h1>Missing Field</h1></center>\n
We're sorry, but you did not enter any information in a required field.  Please go BACK and make sure that you have written a message and that you have included your e-mail address, phone number, or some other means for your recipient to contact you.  Thank you.
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

#######################################################################
#                    autonotify_email_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid e-mail address in the
# form someuser@somedomain.com

sub autonotify_email_error
  {

&pagesetup("Invalid E-Mail Address");

  print qq~
<center><h2>Invalid E-Mail Address</h2></center>\n
      We're sorry, but you did not enter a valid e-mail address.  Please go BACK and make sure that you have entered your correct e-mail address.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    autonotify_duplicate_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid e-mail address in the
# form someuser@somedomain.com

sub autonotify_duplicate_error
  {

&pagesetup("Keyword Notify Error");

  print qq~
<h2>Keyword Notify Error</h2></center>\n
      We're sorry, but you have already created a personal search agent under this username.  If you would like to modify your e-mail address or search criteria for this agent, you can do so by clicking on the "Modify Search Agent" button below.  If you are trying to set up additional search agents, you will need to use a separate username for each personal search agent.  We require this in order to reduce the load on our servers, and because most people do not want or need more than one agent per section.  If you want an additional search agent for this section, please click on the "Setup Additional Search Agents" button below and use a new username.<p>
<center>
<table><tr>
<td>~;
&generic_form_header;
print qq~<input type=submit name="autonotify_modify_form_button" value="Modify Search Agent"></form></td>
<td>
  <FORM METHOD = "post" ACTION = "$script_url">
  <INPUT TYPE = "hidden" NAME = "setup_file"  
         VALUE = "$form_data{'setup_file'}">  
  <INPUT TYPE = "hidden" NAME = "website_file"  
         VALUE = "$form_data{'website_file'}">
<input type=submit name="autonotify_add_form_button" value="Setup Additional Search Agents"></form>
</td>
</tr></table>
<p>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    autonotify_no_match_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to modify
# or delete their Keyword Notify profile does not already have a profile in
# the database

sub autonotify_no_match_error
  {

&pagesetup("Keyword Notify Error");

  print qq~
<h2>Keyword Notify Error</h2></center>\n
      We're sorry, but we couldn't find your personal search agent profile to modify or delete.  Please go back and check to make sure that you have entered the correct profile number and password.  If you do not currently have a Keyword Notify profile, and if you would like to create one, you can do so by clicking on the "Setup Personal Search Agent" button below.<p>
<center>~;
&generic_form_header;
print qq~<input type=submit name="autonotify_add_form_button" value="Setup Personal Search Agent"></form>
<p>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    url_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to add
# or modify a classified ad didn't enter a valid URL in the form # "http://somedomain.suffix"

sub url_error
  {

&pagesetup("Invalid URL");

  print qq~
<center><h2>Invalid URL</h2></center>\n
      We're sorry, but you did not enter a valid URL for either your home page or the map feature.  Please go BACK and make sure that you have entered the correct URL for your home page or the map feature.  To be a valid URL, it must begin with "http://" and be in the form "http://somedomain.suffix".  Valid suffixes include "com", "net", "gov", "org", "mil", and others such as "de" or "jp".<p>\n
      If you do not have a home page (or if you were trying to point to a gopher site or some other site besides a web site), please leave this field blank.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

sub required_error
  {

&pagesetup("Missing Field");

  print qq~
<center><h2>Missing Field</h2></center>\n
We're sorry, but you did not select a value for a required field.  Would you please go BACK and make sure that you have selected a value for all of the required fields.  Thank you.
<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

sub password_error
  {

&pagesetup("Error: Missing Ad Number or Password");

  print qq~
<center><h2>Error: Missing Ad Number or Password</h2></center>\n
We're sorry, but you did not enter either your ad number or your password.  Please go BACK and make sure that you have entered both your ad number and your password.  Thank you.
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
  }  

sub admin_password_error
  {

&pagesetup("Error: Invalid Password");

  print qq~
<center><h2>Error: Invalid Password</h2></center>\n
We're sorry, but you did not enter a valid password.  Please go BACK and make sure that you have entered the correct password.  Thank you.
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;

  }  

sub successful_upload_message
  {
  &pagesetup("Success: Your Photo has been uploaded and added to your ad");
  print qq~
  <center><h3>Upload Successful</h3>
Your photo has been uploaded and added to your ad.  For your information, your photo has a file size of approximately <b>$upload_file_size</b> bytes, a width of <b>$image_width</b> pixels, and a height of <b>$image_height</b> pixels.  You can view your new ad <a href="$script_url?search_and_display_db_button=on&db_id=$form_data{'db_id'}&exact_match=on&query=retrieval~;

if (($require_admin_approval eq "on") && ($status eq "temp")) { print qq~&show_temp_ads=on~; }

print qq~">here</a>.  Please note that you may need to reload it in order to see your new photo with the ad.
  <P>~;
  &pageclose;
  exit;
  }

#######################################################################
#                    upload_unauthorized_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to upload
# a photo to their ad didn't upload a photo in the correct format (such as
# .gif or .jpg)

sub upload_unauthorized_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but we are not currently allowing users to upload photos with their ads.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    upload_no_match_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to upload
# a photo to their ad didn't enter the correct id number and password
# for their ad

sub upload_no_match_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but you did not enter the matching ID number and password for your ad.  Please go back and check to make sure that you have entered the correct ID number and password.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    upload_large_file_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to upload
# a photo to their ad attempted to upload a file that exceeds the maximum
# number of bytes specified in the $maximum_attachment_size variable in
# the user.cfg file

sub upload_large_file_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but we were unable to upload your photo because its file size is too large.  The largest file size that we allow for uploads is $maximum_attachment_size bytes.  The file that you attempted to upload has a file size of $upload_file_size bytes.  Please go back and either shrink the file size of your photo by using a graphics program or choose another photo that has a file size of less than $maximum_attachment_size bytes.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
exit;
}  

#######################################################################
#                    upload_format_error Subroutine
#######################################################################

# This subroutine prints an error message if the person trying to upload
# a photo to their ad didn't upload a photo in the correct format (such as
# .gif or .jpg)

sub upload_format_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but we were unable to upload your photo because it is not in the correct format.  You must use photos in the .GIF or .JPG format.  Please go back and check to make sure that the photo that you are attempting to upload ends in either ".gif" or ".jpg".  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    upload_invalid_gif_error Subroutine
#######################################################################

# This subroutine prints an error message if the .gif photo that the person
# is trying to upload doesn't appear to be a valid .gif file when it is
# tested by the program.

sub upload_invalid_gif_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but the photo that you were trying to upload (<b>$upload_file_filename</b>) does not appear to be a valid <b>.gif</b> file.  Please go back and check to make sure that it is a valid .gif file or rename it to have a .jpg extension if it is a .jpg file.  You can test this by viewing it in a graphics program.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    upload_invalid_jpg_error Subroutine
#######################################################################

# This subroutine prints an error message if the .jpg photo that the person
# is trying to upload doesn't appear to be a valid .jpg file when it is
# tested by the program.

sub upload_invalid_jpg_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but the photo that you were trying to upload (<b>$upload_file_filename</b>) does not appear to be a valid <b>.jpg</b> file.  Please go back and check to make sure that it is a valid .jpg file or rename it to have a .gif extension if it is a .gif file.  You can test this by viewing it in a graphics program.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#######################################################################
#                    upload_invalid_size_error Subroutine
#######################################################################

# This subroutine prints an error message if the photo that the person
# is trying to upload exceeds either the maximum width or height in pixels
# as set by the $max_image_width and $max_image_height variables in the
# user.cfg file.

sub upload_invalid_size_error
  {

&pagesetup("Upload Error");

  print qq~
<h2>Upload Error</h2></center>\n
      We're sorry, but the photo that you were trying to upload ($upload_file_filename) is too large.  Your photo has a width of <b>$image_width</b> pixels and a height of <b>$image_height</b> pixels.  We do not allow photos that have dimensions larger than a width of <b>$max_image_width</b> pixels and a height of <b>$max_image_height</b> pixels.  Please go back and either resize your photo in a graphics program to fit within our maximum dimensions or choose another photo.  Thank you.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>
~;
&pageclose;
      exit;
}  

#################################################################
#                  Upload Form Subroutine                     #
#################################################################

sub upload_form
  {

if ($allow_photo_uploads ne "on") {
&upload_unauthorized_error;
}

&pagesetup("Upload a Photo to your Ad");
&upload_form_header;

print qq~</center>
<table border=0 cellpadding=4 cellspacing=4 bgcolor="#ffffff" width=100%>
<TR><th colspan=2 BGCOLOR="$bar_color" background="$ad_bar_background" align=left><FONT FACE="$text_font" SIZE="2" COLOR="$ad_bar_text_color">Upload a Photo to Your Ad</FONT></th></tr>
</table>
<p>
You may upload a photo to your ad by filling in the fields below.  The image <b>type</b> must be in the <b>.GIF</b> or <b>.JPG</b> format, have a file size no larger than approximately $maximum_attachment_size bytes, and have a width no greater than $max_image_width pixels and a height no greater than $max_image_height pixels.  Depending on the size of your photo and the speed of your Internet connection, it may take a minute or two to upload your image.  Please note that this process will overwrite any previous photos that you have added to this ad.~;

print qq~<p>~;

if (!$browser_uploading) {
print qq~
<font color="#ff0000">NOTICE: Your web browser may not support File Uploads.  You may attempt to upload a multimedia file, but you may not be able to use this feature without first upgrading to a newer browser version.</font>~;
}

print qq~
<table border=0 cellpadding=2 cellspacing=2>
<tr>
<th align=left colspan=2><font face=arial size=2>Ad Number:</font> <input type=text name="db_id" size=20 maxlength=40> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr>
<th align=left colspan=2><font face=arial size=2>Password:</font> <input type=password name="password" size=20 maxlength=40> <font size=4 color="#ff0000"><b>*</b></font></td>
</tr>
<tr><td colspan=2><font face=arial size=2>Please choose the file that you want to upload by clicking on the "Browse" button below and selecting the file from your local hard drive.<br></font>
<INPUT TYPE=FILE NAME="upload_file"></td></tr>
<tr><td colspan=2><br><br>
<INPUT TYPE = "submit" NAME = "upload" VALUE = "Upload Photo to your Ad"></td></tr></form>
</table>
<p>~;

&pageclose;
      exit;

}

sub warn_error_message {

&pagesetup("Error: Warn Program Already Run Recently");
  print qq~
<h1>Error: Warn Program Already Run Recently</h1></center>
Notices have already been mailed out within the past $warn_runtime_interval days to users whose classified ads are about to expire. Please try running this script again in $warn_runtime_interval or more days.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub warn_success_message {

&pagesetup("Expiration Notices Successfully Sent");
  print qq~
<h1>Expiration Notices Successfully Sent</h1></center>
The script has successfully sent out the expiration notices.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub purge_error_message {

&pagesetup("Error: Purge Already Run Recently");
  print qq~
<h1>Error: Purge Already Run Recently</h1></center>
The classified ads have already been purged within the past $purge_runtime_interval days. Please try running this script again in $purge_runtime_interval or more days.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub purge_success_message {

&pagesetup("Classified Ads Successfully Purged");
  print qq~
<h1>Classified Ads Successfully Purged</h1></center>
The script has successfully purged the classified ads.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub autonotify_error_message {

&pagesetup("Error: Keyword Notify Program Already Run Recently");
  print qq~
<h1>Error: Keyword Notify Program Already Run Recently</h1></center>
The Keyword Notify program has already been run within the past $autonotify_days_interval days. Please try running this script again in $autonotify_days_interval or more days.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub instant_autonotify_error_message {

&pagesetup("Error: Instant Keyword Notify Being Used");
  print qq~
<h1>Error: Instant Keyword Notify Being Used</h1></center>
You are have turned on the Instant Keyword Notify feature.  As a result, running the Keyword Notify program could cause many users to receive duplicate notices of new ads that they have already been informed of.  If you would rather run the Keyword Notify program periodically at timed, regular intervals and not have it run automatically for each new ad that is posted, you need to set the <b>\$use_instant_autonotify</b> variable equal to "off".<p>
<center>

<form>

<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub autonotify_success_message {

&pagesetup("Keyword Notify Notices Successfully Sent");
  print qq~
<h1>Keyword Notify Notices Successfully Sent</h1></center>
The script has successfully sent out the Keyword Notify e-mail messages containing ads posted within the past $autonotify_days_interval days.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub autonotify_purge_error_message {

&pagesetup("Error: Keyword Notify Purge Already Run Recently");
  print qq~
<h1>Error: Keyword Notify Purge Already Run Recently</h1></center>
The old Keyword Notify profiles have already been purged within the past $autonotify_purge_runtime_interval days. Please try running this script again in $autonotify_purge_runtime_interval or more days.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub autonotify_purge_success_message {

&pagesetup("Keyword Notify Profiles Successfully Purged");
  print qq~
<h1>Keyword Notify Profiles Successfully Purged</h1></center>
The script has successfully purged the old Keyword Notify profiles.<p>
<center>
<form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center>~;
&pageclose;
exit;
}

sub admin_form {

&pagesetup;
  print qq~

<table width=470 border=6 cellpadding=4 cellspacing=0>
<tr>
<td bgcolor="$logon_bar_color" align=center colspan=2><font size=4 face=arial color="$logon_bar_text_color">e-Classifieds Control Panel</font></td></tr>
<tr><td align=center bgcolor="$logon_background_color">
<img src="$graphics_dir/e-classifieds_photo.gif" width=150 height=54 alt="e-Classifieds: $edition">
</td>
<td bgcolor="$system_info_color" valign=top>
<font size=4><center>System Info</center></font><p>
<font face=arial size=2>
<b>Status:</b> Online<br>
<b>Edition:</b> $edition<br>
<b>Version:</b> $version {<A HREF="#modify" onClick="window.open('http://www.e-classifieds.net/cgi-bin/version.pl?edition=photo&version=$version','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">Version Info</a>}<br>
<b>Build Date:</b> $build_date<br>
<b>Manufacturer:</b> Hagen Software Inc.<br>
<b>Web Site:</b> <a href="http://www.e-classifieds.net/">http://www.e-classifieds.net</a>
</td>
</tr>
<tr>
<td valign=top colspan=2 bgcolor="$secondary_large_table_color">
<font size=4 face=arial><center>System Maintenance</center></font><p>
<font face=arial size=2>
You will need your administrative password to access any of the functions below.  What would you like to do?<p>
<blockquote><b>Attention Internet Explorer users:</b> Unfortunately, versions of IE prior to version 4.x do NOT support the JavaScript popup menus used by the "About" links below.  The administrative functions will still work, however, although you will need to consult the program documentation if you need help in using them.  If you are using IE version 3.x you may want to upgrade to either IE 4.x or <a href="http://home.netscape.com/download/index.html">Netscape 4.x</a>.</blockquote>
<table cellspacing=0 cellpadding=0 align=center>~;

&generic_form_header;
print qq~
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="modify"></font></td>
<td><font face="arial" size=2><font face="arial">Modify User Ads {<A HREF="#modify" onClick="window.open('$script_url?print_control_panel_help=on#modify','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="delete"></font></td>
<td><font face="arial" size=2><font face="arial">Delete User Ads {<A HREF="#delete" onClick="window.open('$script_url?print_control_panel_help=on#delete','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="photo"></font></td>
<td><font face="arial" size=2><font face="arial">Add or Change Photo in User Ads {<A HREF="#photo" onClick="window.open('$script_url?print_control_panel_help=on#photo','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="autonotify"></font></td>
<td><font face="arial" size=2><font face="arial">Run Keyword Notify Program {<A HREF="#keywordnotify" onClick="window.open('$script_url?print_control_panel_help=on#keywordnotify','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="warn"></font></td>
<td><font face="arial" size=2>Send Out Expiration Notices {<A HREF="#warn" onClick="window.open('$script_url?print_control_panel_help=on#warn','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="purge"></font></td>
<td><font face="arial" size=2>Purge Old Ads {<A HREF="#purge" onClick="window.open('$script_url?print_control_panel_help=on#purge','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="delete_all"></font></td>
<td><font face="arial" size=2>Delete All Ads {<A HREF="#delete_all" onClick="window.open('$script_url?print_control_panel_help=on#delete_all','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="autonotify_purge"></font></td>
<td><font face="arial" size=2>Purge Old Keyword Notify Profiles {<A HREF="#autonotify_purge" onClick="window.open('$script_url?print_control_panel_help=on#autonotify_purge','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="preview"></font></td>
<td><font face="arial" size=2>Preview New Ads {<A HREF="#preview" onClick="window.open('$script_url?print_control_panel_help=on#preview','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="view"></font></td>
<td><font face="arial" size=2>View Your Mailing List {<A HREF="#view" onClick="window.open('$script_url?print_control_panel_help=on#view','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="clear"></font></td>
<td><font face="arial" size=2>Clear Your Mailing List {<A HREF="#clear" onClick="window.open('$script_url?print_control_panel_help=on#clear','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td><font face="arial" size=2>
<input type=radio name="action" value="send"></font></td>
<td><font face="arial" size=2>Send Mass E-Mail {<A HREF="#send" onClick="window.open('$script_url?print_control_panel_help=on#send','cphelp','WIDTH=300,HEIGHT=300,scrollbars=yes,left=150,top=100,screenX=150,screenY=100');return false">About</a>}</font></td>
</tr>
<tr>
<td colspan=2 align=center><font face="arial" size=2>
<input type=submit name="admin" value="Do it!"></font></td>
</tr>
</form>
</table>
</td>
</tr>
</table>

<p>
~;
&pageclose;
  }

sub view_maillist_form
  {
  &pagesetup;

  print qq~
  <center><H2>View Your Mailing List</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;View Your Mailing List</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="view_maillist" value="on">
<INPUT TYPE="submit" VALUE="View Your Mailing List">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub clear_maillist_form {

print qq~
  <H2>Mailing List Warning!</H2></center>
You are about to clear your entire mailing list.  Are you sure that you want to do this?  Please make sure that you have saved this list if you want to before clearing it.  You can view it (and optionally save it) by going back to the Control Panel and clicking on the "View Mailing List" button.  If you're sure that you want to clear your mailing list, type in your administrative password and then click on the "Clear Mailing List" button below.
<p>
<center>~;

  &generic_form_header;

  print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Clear Mailing List</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type="hidden" name="results_format" value="preview_mode">
<input type=hidden name="clear_maillist" value="on">
<INPUT TYPE="submit" VALUE="Clear Mailing List">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

</form>
<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
}

sub maillist_cleared_message
  {
  &pagesetup;
  print qq~
  <center><h3>Your Mailing List Has Been Cleared</h3>
  <P>~;
  &pageclose;
  }

sub send_maillist_form {

print qq~
  <H2>Send Mass E-Mail to Mailing List Subscribers</H2></center>
You can use the form below to send a mass e-mail to all subscribers who have signed up for your newsletter by checking the signup box on the form when they posted their ads.  To do so, type in your administrative password, fill in the Subject and Message boxes below, and then click on the "Send Mass E-Mail" button below.
<p>
<center>~;

  &generic_form_header;

  print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Send Mass E-Mail</FONT></B></TD></TR>
<tr><td colspan=2>
<br><br>
<b>Password:</b><br>
<INPUT type=password NAME="admin_password"><p>
<b>Subject of your Message:</b><br>
<input type=text name="subject" size=30><p>
<b><b>Your Message:</b><br>
<TEXTAREA NAME="message" ROWS=5 COLS=50 wrap=physical></TEXTAREA>
</td></tr>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="send_maillist" value="on">
<INPUT TYPE="submit" VALUE="Send Mass E-Mail">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

</form>
<p>
<center><form>
<input type=button value="<< Go Back " onClick="history.go(-1)"></form></center><p>
~;
}

sub maillist_sent_message
  {
  &pagesetup;
  print qq~
  <center><h3>Your Mass E-Mail Has Been Sent</h3>
  <P>~;
  &pageclose;
  }

sub autonotify_form
  {
  &pagesetup;

  print qq~
  <center><H2>Run the Keyword Notify Program</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Run the Keyword Notify Program</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="print_html_response" value="on">
<input type=hidden name="autonotify_button" value="on">
<INPUT TYPE="submit" VALUE="Run Keyword Notify Program">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub warn_form
  {
  &pagesetup;

  print qq~
  <center><H2>Send Out Expiration Notices</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Send Out Expiration Notices</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="print_html_response" value="on">
<input type=hidden name="warn_button" value="on">
<INPUT TYPE="submit" VALUE="Send Out Expiration Notices">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub purge_form
  {
  &pagesetup;

  print qq~
  <center><H2>Purge Old Ads</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Purge Old Ads</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="print_html_response" value="on">
<input type=hidden name="purge_button" value="on">
<INPUT TYPE="submit" VALUE="Purge Old Ads">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub delete_all_form
  {
  &pagesetup;

print qq~
  <H2>Delete All Ads Warning!</H2></center>
You are about to delete your entire ads database.  Are you sure that you want to do this?  If you're sure that you want to delete all ads from your system, type in your administrative password and then click on the "Delete All Ads" button below.
<p>
<center>~;

  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Delete All Ads</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="print_html_response" value="on">
<input type=hidden name="delete_all_button" value="on">
<INPUT TYPE="submit" VALUE="Delete All Ads">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub delete_all_success_message
  {
  &pagesetup;
  print qq~
  <center><h3>All Ads Have Been Deleted</h3>
  <P>~;
  &pageclose;
  }

sub autonotify_purge_form
  {
  &pagesetup;

  print qq~
  <center><H2>Purge Old Keyword Notify Profiles</H2>~;
  &generic_form_header;
print qq~

<TABLE WIDTH="400" BORDER="1" CELLSPACING="0" CELLPADDING="0" BGCOLOR="$logon_background_color">
<TR>
<TD><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
<TR>
<TD BGCOLOR="$logon_bar_color" COLSPAN="2" HEIGHT="20"><B><FONT COLOR="$logon_bar_text_color" SIZE=-1 FACE="Arial,Helvetica">&nbsp;Purge Old Keyword Notify Profiles</FONT></B></TD></TR>
<TR>
<TD ALIGN="CENTER" COLSPAN="2" height="50"><BR>
<FONT COLOR="" SIZE=2  FACE="Arial,Helvetica">Please enter your administrative password.</FONT></TD></TR>
<TR><TD align="right"><b>Password:</b> </TD><TD><INPUT type=password NAME="admin_password"></TD></TR>
<TR>
<TD COLSPAN="2" height=50><P><CENTER>&nbsp;
<input type=hidden name="print_html_response" value="on">
<input type=hidden name="autonotify_purge_button" value="on">
<INPUT TYPE="submit" VALUE="Purge Old Keyword Notify Profiles">
</CENTER></TD></TR>
</TABLE>
</TD></TR>
</TABLE>

<p>

</form>~;

  &pageclose;
  }

sub print_popup_help {
print qq~
<html>
<head><title>Popup Help</title></head>
<body bgcolor="$tertiary_large_table_color" onBlur="window.close()">
<a name="">
<center><h2>General Help</h2></center>
All of the system options are available from the toolbar that appears along the left hand side of each page.  The "Search Options" section contains various methods for viewing and/or searching the ads.  You can enter some keywords in the input field and then click on the "Search" button.  To quickly see all ads, just click on the "Browse Ads" link.  For more advanced keyword searching that also allows you to conduct advanced Boolean searches (AND, OR, or AS A PHRASE), case-sensitive searching, and date-range searching, click on the "Advanced Search" link.  
<p>
The Ad Options section allows you to post, modify, or delete ads by clicking on the appropriate link.  If you want to upload a photo to your ad or to replace your current photo with a new one, click on the Add Photos link.
<p>
The Other Options section allows you to access powerful features such as our Keyword Notify system.  By clicking on the "Keyword Notify" link, you can set up your own personal search agent that will automatically notify you of any new ads that are posted that match the keywords that you define when you set up your agent.  The FAQ link takes you to a comprehensive Frequently Asked Questions section that should answer most questions that you might have about the system.  The Admin link should be used only by the administrator, as it requires the administrative password for access.  Finally, the Classifieds Home link will take you back to the front page of the $classifieds_name.

<a name="advanced_search">
<center><h2>Advanced Search Options</h2></center>
The Advanced Search form allows you to conduct an advanced keyword search.  You can use Boolean logic to conduct a search for ads that contain ANY of your keywords, ALL of your keywords, or your keywords as AN EXACT PHRASE.  You can also specify whether you want the search to be case sensitive or not, and how many days ago you want to retrieve ads from.  You can specify a particular category or search on all categories, and you can even specify only ads that match a specific caption header.  Finally, you also have the option of displaying the ads full size or in the short "headlines" format.

<a name="post_ad_form">
<center><h2>Posting A New Ad</h2></center>
To post your ad, please fill out the form on this page.  Required fields are indicated by a *.  Once you have filled out the form, click on the "Preview My Ad" button.  You will be given the opportunity to preview your ad before it is actually posted.  Once your ad has been posted, you will be given the opportunity to upload a photo to be included with your ad.

<a name="modify_form">
<center><h2>Modifying Your Ad</h2></center>
To modify your ad, please enter the Ad Number and the Password that you assigned to this ad in the form and click on the "Search for Ad to Modify" button.  If you entered the information correctly, your ad will be displayed with the current information already filled in.  You can simply modify whatever fields you wish to change and then click on the "Modify" button.

<a name="delete_form">
<center><h2>Deleting Your Ad</h2></center>
To delete your ad, please enter the Ad Number and the Password that you assigned to this ad in the form and click on the "Search for Ad to Delete" button.  If you entered the information correctly, your ad will be displayed with a warning notice that you are about to delete it.  If you are sure that you want to delete the ad, click on the "Delete" button.

<a name="upload_form">
<center><h2>Add or Change Photo in Your Ad</h2></center>
This option allows you to upload a new photo to your ad or to overwrite the existing photo for that ad.  In the Upload A Photo form, enter the Ad Number of the ad that you want to add the photo to, and then enter your password in the Password field.  Then you will need to click on the Browse button and select a file from your local computer to upload for inclusion in the ad.  Once you have done so, click on the "Upload Photo to your ad" button to upload the photo to your ad.  Since the program will be uploading a file, it may take a couple of minutes, depending on the size of the photo and the speed of your Internet connection.

<a name="autonotify_options">
<center><h2>Set Up A Keyword Notify Profile</h2></center>
This option allows you to set up a Keyword Notify profile, which is your personal search agent that will automatically send you new ads that match the keywords that you define here.  You will also be able to set the number of days that your personal search agent should operate before it automatically expires.  Of course, you can always come back and modify or delete your search agent at any time.  To set up your personal search agent, click on the "Setup Search Agent" button.

<a name="faq">
<center><h2>Frequently Asked Questions</h2></center>
This page displays the Frequently Asked Questions for the $classifieds_name.  Almost any question that you might have about the system is probably answered somewhere on this page.

<a name="admin">
<center><h2>Administrative Control Panel</h2></center>
This page displays the administrative Control Panel, which allows the administrator to control all aspects of the system.  You will need your administrative password to access any of these functions.  Next to each function is an "About" link that displays a pop-up window that explains what that function does and how to use it.

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</body>
</html>~;
}

sub print_control_panel_help {
print qq~
<html>
<head><title>Control Panel Help</title></head>
<body bgcolor="$tertiary_large_table_color" onBlur="window.close()">
<a name="modify">
<center><h2>Modify User Ads</h2></center>
This option allows you to modify any ad posted by any user.  In the Modify Your Ad form, enter the Ad Number of the ad that you want to modify, and then enter your administrative password in the Password field.  The ad and a modification form will then be displayed for you.

<a name="delete">
<center><h2>Delete User Ads</h2></center>
This option allows you to delete any ad posted by any user.  In the Delete Your Ad form, enter the Ad Number of the ad that you want to delete, and then enter your administrative password in the Password field.  The ad will be displayed along with a warning notice asking you if you are sure that you want to delete this ad.  If so, click on the Delete button to delete the ad.

<a name="photo">
<center><h2>Add or Change Photos in User Ads</h2></center>
This option allows you to upload a new photo to any user's ad or to overwrite the existing photo for that ad.  In the Upload A Photo form, enter the Ad Number of the ad that you want to add the photo to, and then enter your administrative password in the Password field.  Then you will need to click on the Browse button and select a file from your local computer to upload for inclusion in this user's ad.

<a name="keywordnotify">
<center><h2>Run Keyword Notify Program</h2></center>
This option allows you to run the Keyword Notify program, which will cause the program to perform a search for each user who has signed up for the Keyword Notify feature and e-mail that person with a message containing a short description of all ads matching his or her search criteria that have been posted in the past $autonotify_days_interval days.  The message will contain links to the full ads in your database.

<a name="warn">
<center><h2>Send Out Expiration Notices</h2></center>
This option allows you to run the Warn program, which will cause the program to send out expiration notices to all users who have posted ads that are about to expire.

<a name="purge">
<center><h2>Purge Old Ads</h2></center>
This option allows you to run the Purge program, which will purge all ads that have expired.

<a name="delete_all">
<center><h2>Delete All Ads</h2></center>
This option allows you to delete all ads from your classifieds.  Please make sure that you want to do this before running this program, because you may not be able to recover the deleted ads.

<a name="autonotify_purge">
<center><h2>Purge Old Keyword Notify Profiles</h2></center>
This option allows you to purge all Keyword Notify profiles that have expired.

<a name="preview">
<center><h2>Preview New Ads</h2></center>
This option allows you to preview all new ads that have been posted since you last ran the preview program.  For each ad, you will have the option of approving the ad, modifying the ad, deleting the ad, or deferring action until a later time.  If you defer action, the ad will remain in a temporary state (and thus will not be displayed to general viewers) and will be displayed again the next time that you run this Preview program.

<a name="view">
<center><h2>View Your Mailing List</h2></center>
This option allows you to view the mailing list of users who have signed up for your newsletter by checking the signup box on the form when they posted their ads.  Each user is listed on a separate line, with their e-mail address preceding their name.  You can use the "Save" feature of your browser to save this file and then rename it as a text file and import it into your regular mailing list file or even a spreadsheet program.

<a name="clear">
<center><h2>Clear Your Mailing List</h2></center>
This option allows you to clear the mailing list of users who have signed up for your newsletter by checking the signup box on the form when they posted their ads.  You may want to clear this list periodically after you have viewed it using the form above and have saved the file and imported the list into your regular mailing list file.

<a name="send">
<center><h2>Send Mass E-Mail to Mailing List</h2></center>
This option allows you to send a mass e-mail to your subscribers who have signed up for your newsletter by checking the signup box on the form when they posted their ads.
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</body>
</html>~;
}

1; # Returns a true value because it is a library file
