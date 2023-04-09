#!/usr/local/bin/perl
##################################################################################
# Dick Copits
# 207 Thelma Ave.
# Dayton, Ohio, 45415
# 937-454-1357
# 
# PPALstore is ppalstore.cgi Ver. 1.2 May, 2001
# 
# ppalstore.cgi is based on 'pdestore.cgi' 
# available at http://www.smart-choices.org.
#
# Modifications made independently by Dick Copits <mail@smart-choices.org>
# The entire package as distributed here is Copyright 2001 by 
# Dick Copits and is distributed free of charge consistent with the
# GNU General Public License Version 2 dated June 1991. 
# 
# PPALstore incorporates the following:
# cgi-lib.pl,v 2.8 in its entirety
# Copyright (c) 1996 Steven E. Brenner  S.E.Brenner@bioc.cam.ac.uk
# sendmail_lib.pl version 19960505+ as well as numerous 
# additional sub-routines by Gunther Birznieks
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License Version 2 as published 
# by the Free Software Foundation.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
##################################################################################
$| = 1;
##################################################################################
# Enter your URL
@referers = ('www.weblisters.com','weblisters.com'); 
&check_url; 
##################################################################################
# Enter your URL here again (include www)
$domain_name = "www.weblisters.com";
##################################################################################
# Full URL of ppalstore.cgi
$order_ppalstorescript = "http://www.weblisters.com/cgi-bin/ppalstore/ppalstore.cgi";
##################################################################################
# Enter your URL here again (include www)
$root_url = "http://www.weblisters.com";
##################################################################################
# Enter your store directory 
$cookie_dir = "/cgi-bin/ppalstore";
##################################################################################
# Font
$font = "FONT FACE=verdana Size=-1";
##################################################################################
# Location of sendmail
$mailprog= "/usr/sbin/sendmail";
##################################################################################
# Email address for orders, leave the \
$order_email = "1qualityhost\@1qualityhost.com";
##################################################################################
# Email address for errors, leave the \
##################################################################################
# $admin_email = "1qualityhost\@1qualityhost.com";
##################################################################################
# Paypal email address for processing, leave the \
$paypal_email = "1qualityhost\@1qualityhost.com";
##################################################################################
# Enter your Company Address 

$company ="

<h3><CENTER>
1QualityHost.Com<BR>
P.O. Box 273 Garrett, Indiana<BR>
USA, 46738</CENTER></h3>

";

##################################################################################
# Subject for your email
$email_subject = "Web Hosting Purchase";
##################################################################################
# Body of your email

$email_body = "

Hello,

Thank you for your web hosting purchase! If you have chosen to pay via other means
than paypal, please email us and let us know. Once we have verified your payment,
you will be sent the link to activate your account. Thank you, and we look forward to 
working with you.

Sean Bailer 
1qualityhost\@1qualityhost.com

";

##################################################################################
# Currency Symbol leave \
$currency_symbol = "\$";
##################################################################################
# Currency Symbol Placement "front" or "back"
$currency_symbol_placement = "front";
##################################################################################
# Don't Change Anything Below this line
##################################################################################
%order_form_array = ('01-name', 'Name','02-street', 'Street','03-city', 'City','04-locality', 'Locality','05-pcode', 'Postal Code','06-country', 'Country','07-phone', 'Phone','08-fax', 'Fax','09-email', 'Email','10-pay_by', 'Payment Selection','11-special', 'Special');
@order_form_required_fields = ("01-name", "02-street", "03-city", "04-locality", "05-pcode", "06-country","07-phone", "09-email", "10-pay_by");
$header_file = "../../ppalstore/html/header.html";
$footer_file = "../../ppalstore/html/footer.html";
$carts_directory = "./carts";
$data_directory = "./db/db.file";
$options_directory = "../../ppalstore/options/";
$order_form_path = "../../ppalstore/html/orderform.html";
$store_front_path = "../../ppalstore/html/store.html";
$order_log_file = "./db/order.log";
$flags = "-t";
$mailer ="$mailprog";
if ( -e $mailer) {
$mail_program=$mailer;
} else {
print "Content-type: text/html\n\n";
print "Sendmail Error.";
exit;
}
$mail_program = "$mail_program $flags ";
sub real_send_mail {
local($fromuser, $fromsmtp, $touser, $tosmtp,$subject, $messagebody) = @_;
local($old_path) = $ENV{"PATH"};
$ENV{"PATH"} = "";
open (MAIL, "|$mail_program") ||&web_error("Could Not Open Mail Program");
$ENV{"PATH"} = $old_path;
print MAIL <<__END_OF_MAIL__;
To: $touser
From: $fromuser
Subject: $subject
$messagebody
__END_OF_MAIL__
close (MAIL);
} 
sub send_mail {
local($from, $to, $subject, $messagebody) = @_;
local($fromuser, $fromsmtp, $touser, $tosmtp);
$fromuser = $from;
$touser = $to;
$fromsmtp = (split(/\@/,$from))[1];
$tosmtp = (split(/\@/,$to))[1];
&real_send_mail($fromuser, $fromsmtp, $touser, $tosmtp, $subject, $messagebody);
}
$ppalstorescript = "ppalstore.cgi";
$db{"product_id"} = 0;
$db{"product"}= 1;
$db{"price"}= 2;
$db{"name"} = 3;
$db{"image_url"}= 4;
$db{"description"}= 5;
$db{"options"}= 6;
@db_display_fields = ("Product", "Description");
@db_index_for_display = ($db{"options"},$db{"image_url"},$db{"description"});
@db_index_for_defining_item_id = ($db{"product_id"}, $db{"product"}, $db{"price"}, $db{"name"}, $db{"image_url"});
$db_index_of_price = $db{"price"};
@db_query_criteria = ("query_price_low_range|2|<=|number", "query_price_high_range|2|>=|number",
 "product|1|=|string", "keywords|1,2,3,4,5|=|string");
$db_max_rows_returned = 4;
$cart{"quantity"}= 0;
$cart{"product_id"}= 1;
$cart{"product"} = 2;
$cart{"price"} = 3;
$cart{"name"}= 4;
$cart{"image_url"} = 5;
$cart{"options"} = 6;
$cart{"price_after_options"} = 7;
$cart{"unique_cart_line_id"} = 8;
$cart_index_of_price = $cart{"price"};
$cart_index_of_price_after_options =
$cart{"price_after_options"};
$cart_index_of_measured_value = $cart{"price"};
@cart_display_fields = ("Product Name (Price/Each)", "Style Choices &amp; Add-ons"); #, "Price After options");
@cart_index_for_display = ($cart{"name"}, $cart{"options"}); #, $cart{"price_after_options"});
$cart_index_of_item_id = $cart{"product_id"};
$cart_index_of_quantity = $cart{"quantity"};
$order_check_db = "yes";
$current_century = "20";
$number_days_keep_old_carts = .5;
$product_display_header = qq!
<CENTER><TABLE WIDTH = "500" BORDER="1" CELLPADDING="4"><TR>!;
$product_display_row = qq~
<TD WIDTH=175 VALIGN=TOP bgcolor="FFFFFF">
<FORM METHOD = "post" ACTION = "$ppalstorescript"><P><CENTER>
<INPUT TYPE="TEXT" NAME="item-%s" SIZE="3" MAXLENGTH="3" VALUE="1">
<P>
<INPUT TYPE="image" NAME="add_to_cart_button" src="../../ppalstore/button/add.jpg" BORDER="0">
<P>
<P><$font>%s</CENTER><P>%s</TD><TD WIDTH=325 bgcolor="EEEEEE" VALIGN="TOP">
<P><$font>%s</TD></TR>~;
$product_display_footer = qq!
</TABLE></CENTER>!;
sub display_order_form {
local($line);
local($subtotal);
local($total_quantity);
local($total_measured_quantity);
local($text_of_cart);
local($hidden_fields_for_cart);
open (ORDERFORM, "$order_form_path") ||
&file_open_error("$order_form_path",
"Display Order Form File Error",__FILE__,__LINE__);
while (<ORDERFORM>) {
$line = $_;
if ($line =~ /<FORM/i) {
print qq!
<FORM METHOD = "post" ACTION = "$order_ppalstorescript">
<INPUT TYPE = "hidden" NAME = "page" VALUE = "$form_data{'page'}">
<INPUT TYPE = "hidden" NAME = "cart_id" VALUE = "$form_data{'cart_id'}">\n!;
$line = "";
} 
if ($line =~ /<h2>cart.*contents.*h2>/i) {
(
$subtotal, 
$total_quantity,
$total_measured_quantity,
$text_of_cart) = &display_cart_table("orderform");
$text_of_cart =
&display_calculations($subtotal,"before",
$total_measured_quantity,$text_of_cart);
$line = "";
}
print $line;
} 
}
sub display_calculations 
{
local($subtotal,
$are_we_before_or_at_process_form,
$total_measured_quantity,
$text_of_cart) = @_;
local($grand_total) =
&calculate_final_values($subtotal,
$total_quantity,
$total_measured_quantity,
$are_we_before_or_at_process_form);
$grand_total = &display_price($grand_total);
$text_of_cart .= "Order Number:= $cart_id\n\n";
return ($text_of_cart);
}
sub confirm_order {
local($subtotal, $total_quantity,
$total_measured_quantity,
$text_of_cart,
$required_fields_filled_in);
local($hidden_fields)=&make_hidden_fields; 
print qq!
<HTML><HEAD><TITLE>Please Verify Your Order Information</TITLE></HEAD>
<BODY><FORM METHOD = "post" ACTION = "$order_ppalstorescript">
<INPUT TYPE = "hidden" NAME = "cart_id" VALUE = "$cart_id">
<INPUT TYPE="hidden" NAME="text_of_cart" VALUE="$text_of_cart">
<INPUT TYPE = "hidden" NAME = "01-name" VALUE = "$form_data{'01-name'}"> 
<INPUT TYPE = "hidden" NAME = "02-street" VALUE = "$form_data{'02-street'}">
<INPUT TYPE = "hidden" NAME = "03-city" VALUE = "$form_data{'03-city'}">
<INPUT TYPE = "hidden" NAME = "04-locality" VALUE = "$form_data{'04-locality'}">
<INPUT TYPE = "hidden" NAME = "05-pcode" VALUE = "$form_data{'05-pcode'}">
<INPUT TYPE = "hidden" NAME = "06-country" VALUE = "$form_data{'06-country'}">
<INPUT TYPE = "hidden" NAME = "07-phone" VALUE = "$form_data{'07-phone'}">
<INPUT TYPE = "hidden" NAME = "08-fax" VALUE = "$form_data{'08-fax'}">
<INPUT TYPE = "hidden" NAME = "09-email" VALUE = "$form_data{'09-email'}">
<INPUT TYPE = "hidden" NAME = "10-pay_by" VALUE = "$form_data{'10-pay_by'}">
<INPUT TYPE = "hidden" NAME = "11-special" VALUE = "$form_data{'11-special'}"><P>
!;
($subtotal, $total_quantity, $total_measured_quantity, $text_of_cart) = 
&display_cart_table("process order");
$text_of_cart =
&display_calculations($subtotal,"at",
$total_measured_quantity,$text_of_cart);
$required_fields_filled_in = "yes";
foreach $required_field (@order_form_required_fields) {
if ($form_data{$required_field} eq "") {
$required_fields_filled_in = "no";
print "<CENTER><TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 1 CELLPADDING= 4><TR><TD><TR><TD>
<$font>
I'm sorry, we can't complete your order without your " .
$order_form_array{$required_field} . ". Please use your browser's BACK button and complete the $order_form_array{$required_field} blank now. 
</FONT>
</FORM></TR></TD></TABLE>\n";
}
} 
if ($required_fields_filled_in eq "yes") {
print qq!
</CENTER>
<CENTER><TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 1 CELLPADDING= 4><TR><TD><TR><TD>
<CENTER><$font><B>Please Verify Your Order</B></font></CENTER><P>
<$font>Your order will be billed via: $form_data{'10-pay_by'}
<P>Billing &amp; Delivery Information:<BR>
<BLOCKQUOTE>$form_data{'01-name'}<BR>$form_data{'02-street'}<BR>
$form_data{'03-city'}, $form_data{'04-locality'}, $form_data{'05-pcode'}<BR>$form_data{'06-country'}</BLOCKQUOTE>
<P>Your order will be delivered to the above address unless indicated otherwise in the Special Instructions below. If we encounter any delays we will contact you by one of these methods:<BR>
<BLOCKQUOTE>Email: $form_data{'09-email'}<BR>
Phone: $form_data{'07-phone'}<BR>
Fax: $form_data{'08-fax'}</FONT></BLOCKQUOTE>
<P>
<$font>Special Instructions: <BR>
<BLOCKQUOTE>$form_data{'11-special'}</BLOCKQUOTE>
</CENTER><BR><BR>
<$font>If this information is correct please click "Continue." If you need to make any changes in the information you have submitted use your brower's BACK button and correct them now. If too much time has passed you may have to enter your order information again. This is for your protection.</FONT>
<P>
Your order number is $cart_id, please write this down and reference this number in any inquiries regarding your order.
<P>
Please click the button once and wait for confirmation. You will know it has been accepted when you see <$font><B>Thank you $form_data{'01-name'}\!</B> on the next page.</FONT>
<P><$font><CENTER><B>We appreciate your business\!</B></CENTER></font>!;
}
print qq!
<CENTER><BR><BR>
<INPUT TYPE = "image" NAME = "submit_order_confirm_button" src="../../ppalstore/button/process.jpg" BORDER="0">
<BR><BR>
</FORM></TD></TR></TABLE></BODY></HTML>
!;
} 
sub process_order_confirm {
local($subtotal, $total_quantity,
$total_measured_quantity,
$text_of_cart,
$required_fields_filled_in);
print qq!
<HTML><HEAD><TITLE>Order Confirmation</TITLE></HEAD><BODY>
<FORM METHOD = "post" ACTION = "https://secure.paypal.com/cgi-bin/webscr">
</BODY>
!;
($subtotal, $total_quantity, $total_measured_quantity, $text_of_cart) = 
&display_cart_table("process order");
$text_of_cart =
&display_calculations($subtotal,"at", $total_measured_quantity,$text_of_cart);
$required_fields_filled_in = "yes";
foreach $required_field (@order_form_required_fields) {
if ($form_data{$required_field} eq "") {
$required_fields_filled_in = "no";
print "<CENTER><TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 1 CELLPADDING= 4><TR><TD><$font>I'm sorry but we can't complete your order without your " .
$order_form_array{$required_field} . ". Please use your browser's BACK button and complete the $order_form_array{$required_field} blank now. </FONT></TR></TD></TABLE>\n";
}
}
print "\n";
if ($required_fields_filled_in eq "yes") {
foreach $form_field (sort(keys(%order_form_array))) {
$text_of_cart .= 
&format_text_field($order_form_array{$form_field})
. "= $form_data{$form_field}\n";
}
$client_email = "$form_data{'09-email'}"; 
{
&send_mail($order_email,$client_email,"$email_subject","$email_body");
}
{
&send_mail($client_email,$order_email,"Order Submitted", $text_of_cart);
}
{
open (ORDERLOG, ">>$order_log_file");
print ORDERLOG "*** BEGIN ORDER ***";
print ORDERLOG $text_of_cart;
print ORDERLOG "*** END OF ORDER ***";
close (ORDERLOG);
}
print <<ENDOFTEXT;
<CENTER><TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 0 CELLPADDING= 4>
<TR><TD WIDTH=550><CENTER><$font>
<B>Thank you $form_data{'01-name'}!</B></FONT></CENTER><P> 
<$font>Your order has been received, an email has been sent verifying this submission. We will verfiy your order with you via an email addressed to $form_data{'09-email'} before shipping. If you have any questions or concerns please feel free to contact us at $order_email. <P><CENTER><B>Please reference order number $cart_id.</B></CENTER></font>
<P>
<$font><B><CENTER>This is the Final Step!
<P>
<TABLE BORDER="1" WIDTH="500">
<TR>
<TD WIDTH=250>
<TABLE BORDER="0" WIDTH="250">
<TR>
<TD>
<BR><$font>
If you are paying through Paypal click the &quot;PayPal&quot; image below.</CENTER></B></FONT>
<P>
<CENTER>
<FORM ACTION="https://secure.paypal.com/cgi-bin/webscr" METHOD="POST">
<INPUT TYPE="hidden" NAME="cmd" VALUE="_xclick">
<INPUT TYPE="hidden" NAME="business" VALUE="$paypal_email">
<INPUT TYPE=\"hidden\" NAME=\"return\" VALUE=\"$root_url/ppalstore/html/thanks.html\">
<INPUT TYPE="hidden" NAME="item_name" VALUE="PPALstore Order - $cart_id">
<INPUT TYPE="hidden" NAME="amount" VALUE="$subtotal">
<INPUT TYPE="image" SRC="../../ppalstore/images/paypal.gif" border=0">
</FORM>
</TD></TR></TABLE></TD>
<TD WIDTH="250">
<TABLE BORDER="0">
<TR><TD WIDTH="250" VALIGN="TOP">
<$font>If you are paying by Check or Money Order click the &quot;By Mail&quot; image below.</CENTER></B></FONT>
<P>
<CENTER>
<A HREF="$root_url/ppalstore/html/mail.html\">
<image SRC="../../ppalstore/images/paymail.gif" border=0"></a>
</TD></TR></TABLE></TD></TR></TABLE>
</CENTER><P>
<$font>$company
<P></TD></TR></TABLE><CENTER>
<P></TD></TR></TABLE><CENTER>
<P><TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 0 CELLPADDING= 4><TR><TD><$font>
<CENTER><A HREF="$order_ppalstorescript">Return to Storefront</A></CENTER>
<BR><BR>
<font face="Verdana, Arial,Helvetica" size="-1">
<A HREF="http://www.smart-choices.org" TARGET="new">
Powered by PPALstore 1.2</A><BR>&copy;Dick Copits
</TD></TR></TABLE><CENTER>
<CENTER>
ENDOFTEXT
open (CART, ">$cart_path"); 
close (CART);
} 
print qq!
</BODY></HTML>
!;
} 
sub calculate_final_values {
local($subtotal,
$total_quantity,
$total_measured_quantity,
$are_we_before_or_at_process_form) = @_;
local($temp_total) = 0;
local($grand_total) = 0;
$temp_total = $subtotal;
} 
sub calculate_general_logic {
local($subtotal,
$total_quantity,
$total_measured_quantity,
*general_logic,
*general_related_form_fields) = @_;
local($general_value);
local($x, $count);
local($logic);
local($criteria_satisfied);
local(@fields);
local(@related_form_values) = ();
$count = 0;
foreach $x (@general_related_form_fields) {
$related_form_values [$count] = $form_data{$x};
$count++;
}
foreach $logic (@general_logic) {
$criteria_satisfied = "yes";
@fields = split(/\|/, $logic);
for (1..@related_form_values) {
if (!(&compare_logic_values(
$related_form_values[$_ - 1],
$fields[$_ - 1]))) {
$criteria_satisfied = "no";
}
} 
for (1..@related_form_values) {
shift(@fields);
}
if (!(&compare_logic_values(
$subtotal,
$fields[0]))) {
$criteria_satisfied = "no";
}
shift (@fields);
if (!(&compare_logic_values(
$total_quantity,
$fields[0]))) {
$criteria_satisfied = "no";
}
shift (@fields);
if (!(&compare_logic_values(
$total_measured_quantity,
$fields[0]))) {
$criteria_satisfied = "no";
}
shift (@fields);
if ($criteria_satisfied eq "yes") {
if ($fields[0] =~ /%/) {
$fields[0] =~ s/%//;
$general_value = $subtotal * $fields[0] / 100;
} else {
$general_value = $fields[0];
}
}
}
return(&format_price($general_value));
} 
sub compare_logic_values {
local($input_value, $value_to_compare) = @_;
local($lowrange, $highrange);
if ($value_to_compare =~ /-/) {
($lowrange, $highrange) = split(/-/, $value_to_compare);
 if ($lowrange eq "") {
if ($input_value <= $highrange) {
return(1);
} else {
return(0);
}
} elsif ($highrange eq "") {
if ($input_value >= $lowrange) {
return(1);
} else {
return(0);
}
 } else {
if (($input_value >= $lowrange) &&
 ($input_value <= $highrange)) {
return(1);
} else {
return(0);
}
}
} else {
if (($input_value =~ /$value_to_compare/i) ||
($value_to_compare eq "")) {
return(1);
} else {
return(0);
}
}
} 
1;
sub SetCookies
{
$cookie{'cart_id'} = "$cart_id";
$domain = $domain_name;
$path = $cookie_dir;
$secure = "";
$now = time;
$twenty_four_hours = "86400";
$expiration = $now+$twenty_four_hours;
&set_cookie($expiration,$domain,$path,$secure);
} 
sub StoreHeader
{
open (HEADER, "$header_file");
while (<HEADER>)
{
print $_;
}
close (HEADER);
}
sub StoreFooter
{
open (FOOTER, "$footer_file");
while (<FOOTER>)
{
print $_;
}
close (FOOTER);
}
1;
sub product_page_header
{
local ($page_title) = @_;
local ($hidden_fields) = &make_hidden_fields;
print qq~
<FORM METHOD = "post" ACTION = "$ppalstorescript">
$hidden_fields
~;
&StoreHeader;
printf($product_display_header, 
@db_display_fields);
}
sub product_page_footer
{
local($db_status, $total_rows_returned) = @_;
local($warn_message);
$warn_message = "";
if ($hits_seen > 0) 
{ 
if ($hits_seen > $db_max_rows_returned) 
{ 
$hits_prev = $hits_seen - $db_max_rows_returned - 
$db_max_rows_returned; 
$warn_message = qq! 
</form> 
<form action = ppalstore.cgi method = post>$hidden 
<input type = "hidden" name=category value=$category> 
<input type = "hidden" name=product value=$form_data{'product'}> 
<INPUT TYPE = "hidden" NAME = "keywords"VALUE = "$form_data{'keywords'}"> 
<input type = "hidden" name="hits_seen" value="$hits_prev"> 
<INPUT TYPE = "image" NAME = "search_request_button" src="../../ppalstore/button/previous.jpg" BORDER="0">


</form>
!; 
} 
if ($total_rows_returned >= $hits_seen) 
{ 
$hits_prev = $hits_seen - $db_max_rows_returned - 
$db_max_rows_returned; 
$warn_message = qq! 
</form>
!; 
if ($hits_prev > -4) 
{ 

$warn_message .=qq! 
<TABLE><TR><TD>
<form action = ppalstore.cgi method = post>$hidden 
<input type = "hidden" name=category value=$category> 
<input type = "hidden" name=product value=$form_data{'product'}> 
<INPUT TYPE = "hidden" NAME = "keywords" VALUE = "$form_data{'keywords'}"> 
<input type = "hidden" name="hits_seen" value ="$hits_prev"> 
<INPUT TYPE = "image" NAME = "search_request_button" src="../../ppalstore/button/previous.jpg" BORDER="0">
</TD><TD>&nbsp;&nbsp;&nbsp;</TD><TD></form>
!; 
} 
$warn_message .= qq! 
<form action = ppalstore.cgi method = post>$hidden 
<input type = "hidden" name=category value=$category> 
<input type = "hidden" name=product value=$form_data{'product'}> 
<INPUT TYPE = "hidden" NAME ="keywords" VALUE= "$form_data{'keywords'}"> 
<input type = "hidden" name = "hits_seen" value = "$hits_seen"> 
<INPUT TYPE = "image" NAME = "search_request_button" src="../../ppalstore/button/next.jpg" BORDER="0">
</TD></TR></TABLE></form>
!; 
} 
}
print qq~
$product_display_footer
<BR>
$warn_message~;
exit;
}
sub standard_page_header 
{
local($type_of_page) = @_;
local ($hidden_fields) = &make_hidden_fields;
print qq!
<HTML>
<HEAD>
<TITLE>$type_of_page</TITLE>
</HEAD>
<BODY>
<FORM METHOD = "post" ACTION = "$ppalstorescript">
$hidden_fields
!;
}
sub modify_form_footer
{
print qq!
<P> 
<INPUT TYPE = "image" NAME = "submit_change_quantity_button" src="../../ppalstore/button/submit.jpg" BORDER="0">
<INPUT TYPE = "image" NAME = "modify_cart_button" src="../../ppalstore/button/view.jpg" BORDER="0">
</FORM>
</CENTER>!;
&StoreFooter;
print qq!
</BODY>
</html>!;
}
sub delete_form_footer
{
print qq!
<P>
<INPUT TYPE = "image" NAME = "submit_deletion_button" src="../../ppalstore/button/remove.jpg" BORDER="0">
<INPUT TYPE = "image" NAME = "modify_cart_button" src="../../ppalstore/button/view.jpg" BORDER="0">
</FORM>
</CENTER>!;
&StoreFooter;
print qq!
</BODY>
</HTML>!;
}
sub cart_footer
{
print qq!
</P>
<INPUT TYPE = "image" NAME = "change_quantity_button" src="../../ppalstore/button/change.jpg" BORDER="0">
<INPUT TYPE = "image" NAME = "delete_item_button" src="../../ppalstore/button/remove.jpg" BORDER="0">
</FORM>
</CENTER>!;
<P>
&StoreFooter;
print qq!
</BODY>
</HTML>!;
}
sub bad_order_note
{
local($button_to_set) = @_;
$button_to_set = "try_again" if ($button_to_set eq "");
&standard_page_header("Minor Error");
&StoreHeader;
print qq!
<CENTER>
<TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 1 CELLPADDING= 4><TR><TD><$font>
It appears that you tried to remove a product from your cart by changing the number ordered to zero. To remove an item from your order please use the Remove Ordered Item button.
<CENTER><P>Please try again. Thank You.<P></FONT></TD></TR></TABLE>
<P><INPUT TYPE = "submit" NAME = "$button_to_set" VALUE = "Try Again">
</CENTER>
</BODY>
</HTML>!;
exit;
}
sub cart_table_header
{
local ($modify_type) = @_;
if ($modify_type ne "") 
{
$modify_type = "<TH>\&nbsp\;$modify_type\&nbsp\;</TH>";
}
&StoreHeader;
print qq!
<CENTER>
<TABLE WIDTH=500 BGCOLOR = FFFFFF BORDER = 1 CELLPADDING= 4>
<$font>Thank you\! Your order is displayed below:</font>
<TR>
<$font>
$modify_type!;
foreach $field (@cart_display_fields)
{
print qq!<TH $hbgcolor><$font>&nbsp;$field&nbsp;</FONT></TH>\n!;
}
print qq!<$font><TH $hbgcolor><$font>Qty.</FONT></TH>\n
<TH $hbgcolor><$font>&nbsp;Subtotal&nbsp;</FONT></TH>\n</TR>\n!;
}
sub display_cart_table 
{
local($reason_to_display_cart) = @_;
local(@cart_fields);
local($cart_id_number);
local($quantity);
local($unformatted_subtotal);
local($subtotal);
local($unformatted_grand_total);
local($grand_total);
local( );
local($text_of_cart);
local($total_quantity) = 0;
local($total_measured_quantity) = 0;
local($display_index);
local($counter);
local($hidden_field_name);
local($hidden_field_value);
local($display_counter);
local($product_id, @db_row);
if ($reason_to_display_cart =~ /change*quantity/i) 
{
&cart_table_header("<$font>New Qty.</FONT>");
} 
elsif ($reason_to_display_cart =~ /delete/i) 
{
&cart_table_header("<$font>Remove?</FONT>");
} 
else 
{
&cart_table_header("");
}
open (CART, "$cart_path") ||
 &file_open_error("$cart_path","display_cart_contents", __FILE__, __LINE__);
while (<CART>)
{
print "<TR>";
chop;
@cart_fields = split (/\|/, $_);
$cart_row_number = pop(@cart_fields);
push (@cart_fields, $cart_row_number);
$quantity = $cart_fields[0];
$product_id = $cart_fields[1];
if (($reason_to_display_cart =~ /orderform/i) &&
($order_check_db =~ /yes/i)) 
{
if (!($db_lib_was_loaded =~ /yes/i)) 
{
&require_supporting_libraries (__FILE__, __LINE__,
"$db_lib_path");
} 
if (!(&check_db_with_product_id($product_id,*db_row))) 
{
print qq~
</TR></TABLE><$font COLOR=\"339933\">
<BR><BR><BR>
<CENTER>Product ID: $product_id not found in database.
<P>
Your order will NOT be processed without this validation!
</CENTER>
</font></body>
</html>~;
exit;
} 
else 
{
if ($db_row[$db_index_of_price] ne 
$cart_fields[$cart_index_of_price]) 
{
print qq~
</TR></TABLE><$font COLOR=\"339933\">
<BR><BR><BR>Price for product id:$product_id did not match
database!<BR>Your order cannotbe processed without 
this validation!<P>Please contact the webmaster!<P>
Thank You!</FONT>
</BODY>
</html>~; 
exit;
}
} 
} 
$total_quantity += $quantity;
if (($reason_to_display_cart =~ /order*form/i) &&
($order_with_hidden_fields))
{
$counter++;
$hidden_field_name = "cart-"
. substr("000", length($counter))
. $counter;
$hidden_field_value = join("\|", @cart_fields);
$hidden_field_value =~ s/\"/~qq~/g;
$hidden_field_value =~ s/\>/~gt~/g;
$hidden_field_value =~ s/\</~lt~/g;
print qq!
<INPUT TYPE = "HIDDEN" NAME = "$hidden_field_name" VALUE = "$hidden_field_value">
!;
}
if ($reason_to_display_cart =~ /change*quantity/i) 
{
print qq!
<TD ALIGN = "center" VALIGN=TOP>
<INPUT TYPE = "text" NAME = "$cart_row_number" SIZE ="3"></TD>!;
} 
elsif ($reason_to_display_cart =~ /delete/i) 
{
print qq!
<TD ALIGN = "CENTER" VALIGN="TOP">
<INPUT TYPE = "checkbox" NAME = "$cart_row_number">!;
}
$display_counter = 1;
$text_of_cart .= "\n\n";
foreach $display_index (@cart_index_for_display)
{ 
if ($cart_fields[$display_index] eq "")
{
$text_of_cart .= &format_text_field(
$cart_display_fields) .
"= nothing entered\n";
$cart_fields[$display_index] = "&nbsp;";
} 
if (($display_index == $cart_index_of_price_after_options)||
($display_index == $cart_index_of_price))
{
$price = &display_price($cart_fields[$display_index]); 
print qq!<TD ALIGN="LEFT" VALIGN="TOP"><$font>$price</FONT></TD>\n!;
$text_of_cart .= &format_text_field(
$cart_display_fields) .
"= $price\n";
}
else
{
print qq!<TD ALIGN="LEFT" VALIGN="TOP"><$font>$cart_fields[$display_index]</FONT></TD>\n!;
if ($display_index != 5)
{
$text_of_cart .= &format_text_field(
$cart_display_fields) .
"= $cart_fields[$display_index]\n";
}
}
if ($display_index == $cart_index_of_measured_value) 
{
$total_measured_quantity += $cart_fields[$display_index];
}
$display_counter++;
} 
$unformatted_subtotal =
($quantity*$cart_fields[$cart_index_of_price_after_options]);
$subtotal = &format_price($unformatted_subtotal);
$unformatted_grand_total = $grand_total + $subtotal;
$grand_total = &format_price($unformatted_grand_total);
$price = &display_price($subtotal);
print qq!<TD ALIGN="center" VALIGN="BOTTOM"><$font>$quantity</FONT></TD>
<TD ALIGN="center" VALIGN="BOTTOM"><$font>$price</FONT></TD>
</TR>!;
$text_of_cart .= &format_text_field("Quantity") .
"= $quantity\n";
$text_of_cart .= &format_text_field("Subtotal For Item") .
"= $price\n";
} 
close (CART);
$price = &display_price($grand_total);
&cart_table_footer($price);
if (($reason_to_display_cart =~ /order*form/i) &&
($order_with_hidden_fields)) 
{
$hidden_field_name = "subtotal";
$hidden_field_value = $subtotal;
print qq!
<INPUT TYPE = "HIDDEN" NAME = "$hidden_field_name" VALUE = "$hidden_field_value">
!;
}
$text_of_cart .= "\n\n" . 
&format_text_field("Order Total:") .
"= $price\n\n";
return($grand_total,
$total_quantity, 
$total_measured_quantity,
$text_of_cart);
}
sub cart_table_footer
{
local($price) = @_;
print qq!
</TABLE>
</FONT><BR>
<$font><B>Total = $price</B></FONT><P>!;
}
sub make_hidden_fields
{
local($hidden);
local($db_query_row);
local($db_form_field);
$hidden = qq!
<INPUT TYPE = "hidden" NAME = "cart_id" VALUE = "$cart_id">
<INPUT TYPE = "hidden" NAME = "page" VALUE = "$form_data{'page'}">!;
if ($form_data{'keywords'} ne "") 
{
$hidden .= qq!
<INPUT TYPE = "hidden" NAME = "keywords" VALUE = "$form_data{'keywords'}">!;
}
if ($form_data{'exact_match'} ne "") 
{
$hidden .= qq!
<INPUT TYPE = "hidden" NAME = "exact_match" VALUE = "$form_data{'exact_match'}">!;
}
if ($form_data{'case_sensitive'} ne "") 
{
$hidden .= qq!
<INPUT TYPE = "hidden" NAME = "case_sensitive"
 VALUE = "$form_data{'case_sensitive'}">!;
}
foreach $db_query_row (@db_query_criteria) 
{
$db_form_field = (split(/\|/, $db_query_row))[0];
if ($form_data{$db_form_field} ne "" && $db_form_field ne "keywords") 
{
$hidden .= qq!
<INPUT TYPE = "hidden" NAME = "$db_form_field" VALUE = "$form_data{$db_form_field}">!;
}
}
return ($hidden);
} 
sub PrintNoHitsBodyHTML
{
print qq!
<CENTER>
</TD></TR></TABLE><P><$font>
I'm sorry, no keyword matches were found. <P><a href="ppalstore.cgi">Please Try Again.</a>
</body></HTML>
!;
}
1;
$db_lib_was_loaded = "yes";
sub check_db_with_product_id {
local($product_id, *db_row) = @_;
local($db_product_id);
open(DATAFILE, "$data_directory") ||
&file_open_error("$data_directory",
"Read Database",__FILE__,__LINE__);
while (($line = <DATAFILE>) &&
($product_id ne $db_product_id)) {
@db_row = split(/\|/,$line);
$db_product_id = $db_row[0];
}
close (DATAFILE);
return ($product_id eq $db_product_id);
}
sub submit_query
{
local(*database_rows, $hits_seen) = @_; 
local($status);
local(@fields);
local($row_count);
local(@not_found_criteria);
local($line); # Read line from database
local($exact_match) = $form_data{'exact_match'};
local($case_sensitive) = $form_data{'case_sensitive'};
$row_count = 0;
 open(DATAFILE, "$data_directory") ||
&file_open_error("$data_directory",
"Read Database",__FILE__,__LINE__);
while(($line = <DATAFILE> ) && 
($row_count < $db_max_rows_returned + $hits_seen)) 
{
chop($line); 
@fields = split(/\|/, $line);
$not_found = 0;
foreach $criteria (@db_query_criteria)
{
$not_found += &flatfile_apply_criteria(
$exact_match,
$case_sensitive,
*fields,
$criteria);
}
$adjusted_line_number = $db_max_rows_returned+$hits_seen; 
if (($not_found == 0) && 
($row_count <= $adjusted_line_number) && 
$row_count >= $hits_seen) 
{
push(@database_rows, join("\|", @fields));
}
if ($not_found == 0) {
$row_count++;
}
} 
close (DATAFILE);
if ($row_count > $db_max_rows_returned) {
$status = "max_rows_exceeded";
} 
if ($row_count == 0) {
&PrintNoHitsBodyHTML;
exit;
} 
return($status,$row_count);
} 
sub flatfile_apply_criteria
{
local($exact_match, $case_sensitive,
*fields, $criteria) = @_;
local($c_name, $c_fields, $c_op, $c_type);
local(@criteria_fields);
local($not_found);
local($form_value);
local($db_value);
local($month, $year, $day);
local($db_date, $form_date);
local($db_index);
local(@word_list);
($c_name, $c_fields, $c_op, $c_type) = 
 split(/\|/, $criteria);
@criteria_fields = split(/,/,$c_fields);
$form_value = $form_data{$c_name};
if ($form_value eq "")
{
return 0;
}
if 
(
($c_type =~ /date/i) ||
($c_type =~ /number/i) ||
($c_op ne "="))
{
$not_found = "yes";
foreach $db_index (@criteria_fields)
{
$db_value = $fields[$db_index];
if ($c_type =~ /date/i) 
{
($month, $day, $year) =
split(/\//, $db_value);
$month = "0" . $month
if (length($month) < 2);
$day = "0" . $day
if (length($day) < 2);
if ($year > 50 && $year < 1900) {
$year += 1900;
}
if ($year < 1900) {
$year += 2000;
}
$db_date = $year . $month . $day;
($month, $day, $year) =
split(/\//, $form_value);
$month = "0" . $month
if (length($month) < 2);
$day = "0" . $day
if (length($day) < 2);
if ($year > 50 && $year < 1900) {
$year += 1900;
}
if ($year < 1900) {
$year += 2000;
}
$form_date = $year . $month . $day;
if ($c_op eq ">") {
return 0 if ($form_date > $db_date); }
if ($c_op eq "<") {
return 0 if ($form_date < $db_date); }
if ($c_op eq ">=") {
return 0 if ($form_date >= $db_date); }
if ($c_op eq "<=") {
return 0 if ($form_date <= $db_date); }
if ($c_op eq "!=") {
return 0 if ($form_date != $db_date); }
if ($c_op eq "=") {
return 0 if ($form_date == $db_date); }
 } elsif ($c_type =~ /number/i) {
if ($c_op eq ">") {
return 0 if ($form_value > $db_value); }
if ($c_op eq "<") {
return 0 if ($form_value < $db_value); }
if ($c_op eq ">=") {
return 0 if ($form_value >= $db_value); }
if ($c_op eq "<=") {
return 0 if ($form_value <= $db_value); }
if ($c_op eq "!=") {
return 0 if ($form_value != $db_value); }
if ($c_op eq "=") {
return 0 if ($form_value == $db_value); }
} else { # $c_type is a string
if ($c_op eq ">") {
return 0 if ($form_value gt $db_value); }
if ($c_op eq "<") {
return 0 if ($form_value lt $db_value); }
if ($c_op eq ">=") {
return 0 if ($form_value ge $db_value); }
if ($c_op eq "<=") {
return 0 if ($form_value le $db_value); }
if ($c_op eq "!=") {
return 0 if ($form_value ne $db_value); }
}
}
} else { 
@word_list = split(/\s+/,$form_value);
foreach $db_index (@criteria_fields)
{
$db_value = $fields[$db_index];
$not_found = "yes";
local($match_word) = "";
local($x) = "";
if ($case_sensitive eq "on") {
if ($exact_match eq "on") {
for ($x = @word_list; $x > 0; $x--) {
$match_word = $word_list[$x - 1];
if ($db_value =~ /\b$match_word\b/) {
splice(@word_list,$x - 1, 1);
} 
}
} else {
for ($x = @word_list; $x > 0; $x--) {
$match_word = $word_list[$x - 1];
if ($db_value =~ /$match_word/) {
splice(@word_list,$x - 1, 1);
} 
} 
} 
} else {
if ($exact_match eq "on") {
for ($x = @word_list; $x > 0; $x--) {
$match_word = $word_list[$x - 1];
if ($db_value =~ /\b$match_word\b/i) {
splice(@word_list,$x - 1, 1);
} 
} 
} else {
for ($x = @word_list; $x > 0; $x--) {
$match_word = $word_list[$x - 1];
if ($db_value =~ /$match_word/i) {
splice(@word_list,$x - 1, 1);
} 
} 
} 
}
}
if (@word_list < 1) 
{
$not_found = "no";
}
} 
if ($not_found eq "yes")
{
return 1;
} else {
return 0;
}
} 
1; 
sub web_error
{
local ($error) = @_;
$error = "Error Occured: $error";
print "$error<p>\n";
die $error;
}
1;
sub web_error {
local ($error) = @_;
$error = "Error Occured: $error";
print "$error<p>\n";
die $error;
} 
1;
sub get_cookie {
local($chip, $val);
foreach (split(/; /, $ENV{'HTTP_COOKIE'})) {
s/\+/ /g;
($chip, $val) = split(/=/,$_,2); # splits on the first =.
$chip =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$val =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$cookie{$chip} .= "\1" if (defined($cookie{$chip})); 
$cookie{$chip} .= $val;
}
}
sub set_cookie {
local($expires,$domain,$path,$sec) = @_;
local(@days) = ("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
local(@months) = ("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
local($sec,$min,$hour,$mday,$mon,$year,$wday) = gmtime($expires) if ($expires > 0); 
$sec = "0" . $sec if $sec < 10; 
$min = "0" . $min if $min < 10; 
$hour = "0" . $hour if $hour < 10; 
local(@secure) = ("","secure");
if (! defined $expires) { $expires = " expires\=Wed, 31-Dec-2001 00:00:00 GMT;"; } 
elsif ($expires == -1) { $expires = "" }
else { 
$year += 1900; 
$expires = "expires\=$days[$wday], $mday-$months[$mon]-$year $hour:$min:$sec GMT; "; 
}
if (! defined $domain) { $domain = $ENV{'SERVER_NAME'}; }
if (! defined $path) { $path = "/"; } 
if (! defined $secure) { $secure = "0"; }
local($key);
foreach $key (keys %cookie) {
$cookie{$key} =~ s/ /+/g; #convert plus to space.
print "Set-Cookie: $key\=$cookie{$key}; $expires path\=$path; domain\=$domain; $secure[$sec]\n";
}
}
sub delete_cookie {
local(@to_delete) = @_;
local($name);
foreach $name (@to_delete) {
undef $cookie{$name};
print "Set-Cookie: $name=; expires=Thu, 01-Jan-1970 00:00:00 GMT; path=/\n";
}
}
sub split_cookie {
local ($param) = @_;
local (@params) = split ("\1", $param);
return (wantarray ? @params : $params[0]);
}
1;
($cgi_lib'version = '$Revision: 2.8 $') =~ s/[^.\d]//g;
$cgi_lib'maxdata= 131072;
$cgi_lib'writefiles =0; 
$cgi_lib'filepre= "cgi-lib";
$cgi_lib'bufsize=8192;
$cgi_lib'maxbound = 100; 
$cgi_lib'headerout =0;
sub ReadParse {
local (*in) = shift if @_;
local (*incfn,
*inct, 
*insfn) = @_; 
local ($len, $type, $meth, $errflag, $cmdflag, $perlwarn);
$perlwarn = $^W;
$^W = 0;
$type = $ENV{'CONTENT_TYPE'};
$len= $ENV{'CONTENT_LENGTH'};
$meth = $ENV{'REQUEST_METHOD'};
if ($len > $cgi_lib'maxdata) { #'
&CgiDie("cgi-lib.pl: Request to receive too much data: $len bytes\n");
}
if (!defined $meth || $meth eq '' || $meth eq 'GET' || 
$type eq 'application/x-www-form-urlencoded') {
local ($key, $val, $i);
if (!defined $meth || $meth eq '') {
$in = $ENV{'QUERY_STRING'};
$cmdflag = 1;
} elsif($meth eq 'GET' || $meth eq 'HEAD') {
$in = $ENV{'QUERY_STRING'};
} elsif ($meth eq 'POST') {
$errflag = (read(STDIN, $in, $len) != $len);
} else {
&CgiDie("cgi-lib.pl: Unknown request method: $meth\n");
}
@in = split(/[&;]/,$in); 
push(@in, @ARGV) if $cmdflag; 
foreach $i (0 .. $#in) {
$in[$i] =~ s/\+/ /g;
($key, $val) = split(/=/,$in[$i],2); # splits on the first =.
$key =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$val =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
$in{$key} .= "\0" if (defined($in{$key})); # \0 is the multiple separator
$in{$key} .= $val;
}
} elsif ($ENV{'CONTENT_TYPE'} =~ m#^multipart/form-data#) {
$errflag = !(eval <<'END_MULTIPART');
local ($buf, $boundary, $head, @heads, $cd, $ct, $fname, $ctype, $blen);
local ($bpos, $lpos, $left, $amt, $fn, $ser);
local ($bufsize, $maxbound, $writefiles) = 
($cgi_lib'bufsize, $cgi_lib'maxbound, $cgi_lib'writefiles);
$buf = ''; 
($boundary) = $type =~ /boundary="([^"]+)"/; #"; 
($boundary) = $type =~ /boundary=(\S+)/ unless $boundary;
&CgiDie ("Boundary not provided") unless $boundary;
$boundary ="--" . $boundary;
$blen = length ($boundary);
if ($ENV{'REQUEST_METHOD'} ne 'POST') {
&CgiDie("Invalid request method formultipart/form-data: $meth\n");
}
if ($writefiles) {
local($me);
stat ($writefiles);
$writefiles = "/tmp" unless-d _ && -r _ && -w _;
# ($me) = $0 =~ m#([^/]*)$#;
$writefiles .= "/$cgi_lib'filepre"; 
}
$left = $len;
 PART: # find each part of the multi-part while reading data
while (1) {
last PART if $errflag;
$amt = ($left > $bufsize+$maxbound-length($buf) 
?$bufsize+$maxbound-length($buf): $left);
$errflag = (read(STDIN, $buf, $amt, length($buf)) != $amt);
$left -= $amt;
$in{$name} .= "\0" if defined $in{$name}; 
$in{$name} .= $fn if $fn;
$name=~/([-\w]+)/;# This allows $insfn{$name} to be untainted
if (defined $1) {
$insfn{$1} .= "\0" if defined $insfn{$1}; 
$insfn{$1} .= $fn if $fn;
} 
BODY: 
while (($bpos = index($buf, $boundary)) == -1) {
if ($name) {# if no $name, then it's the prologue -- discard
if ($fn) { print FILE substr($buf, 0, $bufsize); }
else { $in{$name} .= substr($buf, 0, $bufsize); }
}
$buf = substr($buf, $bufsize);
$amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
$errflag = (read(STDIN, $buf, $amt, $maxbound) != $amt);
$left -= $amt;
}
if (defined $name) {# if no $name, then it's the prologue -- discard
if ($fn) { print FILE substr($buf, 0, $bpos-2); }
else { $in {$name} .= substr($buf, 0, $bpos-2); } # kill last \r\n
}
close (FILE);
last PART if substr($buf, $bpos + $blen, 4) eq "--\r\n";
substr($buf, 0, $bpos+$blen+2) = '';
$amt = ($left > $bufsize+$maxbound-length($buf) 
? $bufsize+$maxbound-length($buf) : $left);
$errflag = (read(STDIN, $buf, $amt, length($buf)) != $amt);
$left -= $amt;
undef $head;undef $fn;
HEAD:
while (($lpos = index($buf, "\r\n\r\n")) == -1) { 
$head .= substr($buf, 0, $bufsize);
$buf = substr($buf, $bufsize);
$amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
$errflag = (read(STDIN, $buf, $amt, $maxbound) != $amt);
$left -= $amt;
}
$head .= substr($buf, 0, $lpos+2);
push (@in, $head);
@heads = split("\r\n", $head);
($cd) = grep (/^\s*Content-Disposition:/i, @heads);
($ct) = grep (/^\s*Content-Type:/i, @heads);
($name) = $cd =~ /\bname="([^"]+)"/i; #"; 
($name) = $cd =~ /\bname=([^\s:;]+)/i unless defined $name;
($fname) = $cd =~ /\bfilename="([^"]*)"/i; #"; # filename can be null-str
($fname) = $cd =~ /\bfilename=([^\s:;]+)/i unless defined $fname;
$incfn{$name} .= (defined $in{$name} ? "\0" : "") . $fname;
($ctype) = $ct =~ /^\s*Content-type:\s*"([^"]+)"/i;#";
($ctype) = $ct =~ /^\s*Content-Type:\s*([^\s:;]+)/i unless defined $ctype;
$inct{$name} .= (defined $in{$name} ? "\0" : "") . $ctype;
if ($writefiles && defined $fname) {
$ser++;
$fn = $writefiles . ".$$.$ser";
open (FILE, ">$fn") || &CgiDie("Couldn't open $fn\n");
}
substr($buf, 0, $lpos+4) = '';
undef $fname;
undef $ctype;
}
1;
END_MULTIPART
&CgiDie($@) if $errflag;
} else {
&CgiDie("cgi-lib.pl: Unknown Content-type: $ENV{'CONTENT_TYPE'}\n");
}
$^W = $perlwarn;
return ($errflag ? undef :scalar(@in)); 
}
sub PrintHeader {
return "Content-type: text/html\n\n";
}
sub htmlTop
{
local ($title) = @_;
return <<END_OF_TEXT;
<html><head><title>$title</title></head><body>$title
END_OF_TEXT
}
sub htmlBot
{
return "</body>\n</html>\n";
}
sub SplitParam
{
local ($param) = @_;
local (@params) = split ("\0", $param);
return (wantarray ? @params : $params[0]);
}
sub MethGet {
return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "GET");
}
sub MethPost {
return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "POST");
}
sub MyBaseUrl {
local ($ret, $perlwarn);
$perlwarn = $^W; $^W = 0;
$ret = 'http://' . $ENV{'SERVER_NAME'} .
($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
$ENV{'SCRIPT_NAME'};
$^W = $perlwarn;
return $ret;
}
sub MyFullUrl {
local ($ret, $perlwarn);
$perlwarn = $^W; $^W = 0;
$ret = 'http://' . $ENV{'SERVER_NAME'} .
($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
$ENV{'SCRIPT_NAME'} . $ENV{'PATH_INFO'} .
(length ($ENV{'QUERY_STRING'}) ? "?$ENV{'QUERY_STRING'}" : '');
$^W = $perlwarn;
return $ret;
}
sub MyURL{
return &MyBaseUrl;
}
sub CgiError {
local (@msg) = @_;
local ($i,$name);
if (!@msg) {
$name = &MyFullUrl;
@msg = ("Error: script $name encountered fatal error\n");
};
if (!$cgi_lib'headerout) { #')
print &PrintHeader;
print "<html>\n<head>\n<title>$msg[0]</title>\n</head>\n<body>\n";
}
print "<h1>$msg[0]</h1>\n";
foreach $i (1 .. $#msg) {
print "<p>$msg[$i]</p>\n";
}
$cgi_lib'headerout++;
}
sub CgiDie {
local (@msg) = @_;
&CgiError (@msg);
die @msg;
}
sub PrintVariables {
local (*in) = @_ if @_ == 1;
local (%in) = @_ if @_ > 1;
local ($out, $key, $output);
$output ="\n<dl compact>\n";
foreach $key (sort keys(%in)) {
foreach (split("\0", $in{$key})) {
($out = $_) =~ s/\n/<br>\n/g;
$output .="<dt><b>$key</b>\n <dd>:<i>$out</i>:<br>\n";
}
}
$output .="</dl>\n";
return $output;
}
sub PrintEnv {
&PrintVariables(*ENV);
}
$cgi_lib'writefiles =$cgi_lib'writefiles;
$cgi_lib'bufsize=$cgi_lib'bufsize ;
$cgi_lib'maxbound =$cgi_lib'maxbound;
$cgi_lib'version=$cgi_lib'version;
1; #return true 
&read_and_parse_form_data;
&get_cookie; 
$page = $form_data{'page'};
$page =~ /([\w\-\=\+\/]+)\.(\w+)/;
$page = "$1.$2";
$page = "" if ($page eq ".");
$page =~ s/^\/+//; # Get rid of any residual / prefix
$search_request = $form_data{'search_request_button'};
$cart_id = $form_data{'cart_id'};
if ($cart_id =~ /^(\w+)$/) {
$cart_id = $1;
} else {
$cart_id = "";
}
$cart_path = "$carts_directory/$cart_id.cart";
&error_check_form_data;
if ($cookie{'cart_id'} eq "" && $form_data{'cart_id'} eq "")
{
&delete_old_carts;
&assign_a_unique_shopping_cart_id;
}
if ($form_data{'cart_id'} eq "")
{
$cart_id = $cookie{'cart_id'};
$cart_path = "$carts_directory/${cart_id}.cart";
}
else
{
$cart_id = $form_data{'cart_id'};
$cart_path = "$carts_directory/${cart_id}.cart";
}
$are_any_query_fields_filled_in = "no";
foreach $query_field (@db_query_criteria) {
@criteria = split(/\|/, $query_field);
if ($form_data{$criteria[0]} ne "") {
$are_any_query_fields_filled_in = "yes";
}
}
print "Content-type: text/html\n\n"; 
if ($form_data{'add_to_cart_button.x'} ne "")
{
&add_to_the_cart;
exit;
}
elsif ($form_data{'modify_cart_button.x'} ne "")
{
&display_cart_contents;
exit;
}
elsif ($form_data{'change_quantity_button.x'} ne "")
{
&output_modify_quantity_form;
exit;
}
elsif ($form_data{'submit_change_quantity_button.x'} ne "")
{
&modify_quantity_of_items_in_cart;
exit;
}
elsif ($form_data{'delete_item_button.x'} ne "")
{
&output_delete_item_form;
exit;
}
elsif ($form_data{'submit_deletion_button.x'} ne "")
{ 
&delete_from_cart;
exit;
}
elsif ($form_data{'order_form_button.x'} ne "")
{
&display_order_form;
exit;
}
elsif ($form_data{'confirm_order_button.x'} ne "")
{
&confirm_order;
exit;
}
elsif ($form_data{'submit_order_confirm_button.x'} ne "")
{
&process_order_confirm;
exit;
}
elsif (($page ne "" || $form_data{'search_request_button'} ne ""
|| $form_data{'continue_shopping_button'}
|| $are_any_query_fields_filled_in =~ /yes/i) &&
($form_data{'return_to_frontpage_button'} eq "")) 
{
&display_products_for_sale;
exit;
}
else
{
&output_frontpage;
exit;
}
sub read_and_parse_form_data
{
&ReadParse(*form_data);
}
sub error_check_form_data
{
foreach $file_extension (".html", ".htm", ".shtml")
{
if ($page =~ /$file_extension/ || $page eq "")
{
$valid_extension = "yes";
}
}
if ($valid_extension ne "yes")
{
print "That won't work!";
&update_error_log("PAGE LOAD WARNING", __FILE__, __LINE__);
exit;
}
}
sub delete_old_carts
{
opendir (carts, "$carts_directory") ||
 &file_open_error("$carts_directory", 
"Delete Old Carts", __FILE__, __LINE__);
@carts = grep(/\.cart/,readdir(carts));
closedir (carts);
foreach $cart (@carts)
{
if (-M "$carts_directory/$cart" > $number_days_keep_old_carts)
{
unlink("$carts_directory/$cart");
}
}
} 
sub assign_a_unique_shopping_cart_id
{
{
$date = &get_date;
$remote_addr = $ENV{'REMOTE_ADDR'};
$request_uri = $ENV{'REQUEST_URI'};
$http_user_agent = $ENV{'HTTP_USER_AGENT'};

if ($ENV{'HTTP_REFERER'} ne "")
{
$http_referer = $ENV{'HTTP_REFERER'};
}
else
{
$http_referer = "possible bookmarks";
}
$remote_host = $ENV{'REMOTE_HOST'};
$shortdate = `date +"%T"`; 
chop ($shortdate);
$unixdate = time;
 $new_access = "$form_data{'url'}\|$shortdate\|$request_uri\|$cookie{'visit'}\|$remote_addr\|$http_user_agent\|$http_referer\|$unixdate\|";
chop $new_access;
}
srand (time|$$);
$cart_id = int(rand(10000000));
$cart_id .= "_$$";
$cart_id =~ s/-//g;
$cart_path = "$carts_directory/${cart_id}.cart";
$cart_count = 0;
while (-e "$cart_path")
{
if ($cart_count == 3)
{
print "There's something wrong with your local rand function.";
&update_error_log("COULD NOT CREATE UNIQUE CART ID", __FILE__,
 __LINE__);
exit;
}
$cart_id = int(rand(10000000));
$cart_id .= "_$$";
$cart_id =~ s/-//g;
$cart_path = "$carts_directory/${cart_id}.cart";
$cart_count++;
}
&SetCookies;
 }
sub output_frontpage
{
&display_page("$store_front_path", "Output Frontpage", __FILE__,
__LINE__);
}
sub add_to_the_cart
{
open (CART, "+>>$cart_path") ||
&file_open_error("$cart_path",
"Add to Shopping Cart", __FILE__, __LINE__);
$highest_item_number = 100;
seek (CART, 0, 0);
while (<CART>)
{
chomp $_;
my @row = split (/\|/, $_);
my $item_number = pop (@row);
$highest_item_number = $item_number if ($item_number > $highest_item_number);
}
seek (CART, 0, 2);
@items_ordered = keys (%form_data);
foreach $item (@items_ordered)
{
if (($item =~ /^item-/i ||
$item =~ /^option/i) &&
$form_data{$item} ne "")
{
$item =~ s/^item-//i;
if ($item =~ /^option/i)
{
push (@options, $item);
}
else
{
if (($form_data{"item-$item"} =~ /\D/) ||
($form_data{"item-$item"} == 0))
{
&bad_order_note;
}
else
{
$quantity = $form_data{"item-$item"};
push (@items_ordered_with_options, "$quantity\|$item\|");
}
}
} 
} 
foreach $item_ordered_with_options (@items_ordered_with_options)
{
$options = "";
$option_subtotal = "";
$option_grand_total = "";
$item_grand_total = "";
$item_ordered_with_options =~ s/~qq~/\"/g;
$item_ordered_with_options =~ s/~gt~/\>/g;
$item_ordered_with_options =~ s/~lt~/\</g;
@cart_row = split (/\|/, $item_ordered_with_options);
$item_quantity = $cart_row[$cart_index_of_quantity];
$item_id_number = $cart_row[$cart_index_of_item_id];
$item_price = $cart_row[$cart_index_of_price];
foreach $option (@options)
{
($option_marker, $option_number, $option_item_number) = split
(/\|/, $option);
if ($option_item_number eq "$item_id_number")
{
($option_name, $option_price) = split (/\|/,$form_data{$option});
$options .= "$option_name $option_price<br>";
$unformatted_option_grand_total = $option_grand_total + $option_price;
$option_grand_total = &format_price($unformatted_option_grand_total);
} 
} 
$options =~ s/,/, /g;
$item_number = ++$highest_item_number;
$unformatted_item_grand_total = $item_price + $option_grand_total;
$item_grand_total = &format_price("$unformatted_item_grand_total");
foreach $field (@cart_row)
{
$cart_row .= "$field\|";
}
$cart_row .= "$options\|$item_grand_total\|$item_number\n";
} 
if (-e "$cart_path")
{
open (CART, ">>$cart_path") || 
&file_open_error("$cart_path", "Add to Shopping Cart", __FILE__, __LINE__);
print CART "$cart_row";
close (CART);
}
else
{
open (CART, ">$cart_path") || 

&file_open_error("$cart_path", "Add to Shopping Cart", __FILE__, __LINE__);
print CART "$cart_row";
close (CART);
}
&display_cart_contents;
}
if ($are_any_query_fields_filled_in =~ /yes/i)
{
&create_html_page_from_db;
} 
sub output_modify_quantity_form
{
&standard_page_header("Change Quantity");
&display_cart_table("changequantity");
&modify_form_footer;
}
sub modify_quantity_of_items_in_cart
{
@incoming_data = keys (%form_data);
foreach $key (@incoming_data)
{
if ((($key =~ /[\d]/) && ($form_data{$key} =~ /\D/)) ||
$form_data{$key} eq "0")
{
&update_error_log("BAD QUANTITY CHANGE", __FILE__, __LINE__);
&bad_order_note("change_quantity_button");
}
unless ($key =~ /[\D]/ && $form_data{$key} =~ /[\D]/)
{
if ($form_data{$key} ne "")
{
push (@modify_items, $key);
}
}
} 
open (CART, "<$cart_path") || 
&file_open_error("$cart_path",
"Modify Quantity of Items in the Cart", __FILE__, __LINE__);
while (<CART>)
{
@database_row = split (/\|/, $_);
$cart_row_number = pop (@database_row);
push (@database_row, $cart_row_number);
$old_quantity = shift (@database_row);
chop $cart_row_number;
foreach $item (@modify_items)
{
if ($item eq $cart_row_number)
{
$shopper_row .= "$form_data{$item}\|";
foreach $field (@database_row)
{
$shopper_row .= "$field\|";
}
$quantity_modified = "yes";
chop $shopper_row; 
} 
} 
if ($quantity_modified ne "yes")
{
$shopper_row .= $_;
}
$quantity_modified = "";
}
close (CART);
 open (CART, ">$cart_path") || 
 &file_open_error("$cart_path",
"Modify Quantity of Items in the Cart", __FILE__, __LINE__);
print CART "$shopper_row";
close (CART);
&display_cart_contents;
} 
sub output_delete_item_form
{
&standard_page_header("Delete Item");
&display_cart_table("delete");
&delete_form_footer;
} 
sub delete_from_cart
{
@incoming_data = keys (%form_data);
foreach $key (@incoming_data)
{
unless ($key =~ /[\D]/)
{
if ($form_data{$key} ne "")
{
push (@delete_items, $key);
}
} 
} 
open (CART, "<$cart_path") || 
 &file_open_error("$cart_path", 
"Delete Item From Cart", __FILE__, __LINE__);
while (<CART>)
{
@database_row = split (/\|/, $_);
$cart_row_number = pop (@database_row);
$db_id_number = pop (@database_row);
push (@database_row, $db_id_number);
push (@database_row, $cart_row_number);
chop $cart_row_number;
$old_quantity = shift (@database_row);
$delete_item = "";
foreach $item (@delete_items)
{
if ($item eq $cart_row_number)
{
$delete_item = "yes";
}
} 
if ($delete_item ne "yes")
{
$shopper_row .= $_;
}
} 
close (CART);
open (CART, ">$cart_path") || 
&file_open_error("$cart_path", 
"Delete Item From Cart", __FILE__, __LINE__);
print CART "$shopper_row";
close (CART);
&display_cart_contents;
} 
sub display_products_for_sale
{
if ($use_html_product_pages eq "no")
{
if ($form_data{'search_request_button'} ne "")
{
&standard_page_header("Search Results");
exit;
}
&display_page("$html_product_directory_path/$page",
"Display products for Sale", __FILE__, __LINE__);
}
else
{
&create_html_page_from_db;
}
}
sub create_html_page_from_db
{
local (@database_rows, @database_fields, @item_ids, @display_fields);
local ($total_row_count, $id_index, $display_index);
local ($row, $field, $empty, $option_tag, $option_location, $output);
if ($page ne "" && $form_data{'search_request_button'} eq "" &&
$form_data{'continue_shopping_button'} eq "")
{
&display_page("$html_product_directory_path/$form_data{'page'}", 
"Display products for Sale", __FILE__, __LINE__);
exit;
}
&product_page_header;
if ($form_data{'add_to_cart_button'} ne "" &&
$shall_i_let_client_know_item_added eq "yes")
{
print "$item_ordered_message";
}
if (!($db_lib_was_loaded =~ /yes/i)) {
&require_supporting_libraries (__FILE__, __LINE__, 
"$db_lib_path"); 
}
($status,$total_row_count) = &submit_query(*database_rows, 
$form_data{'hits_seen'}); 
$hits_seen = $form_data{'hits_seen'} + $db_max_rows_returned;
foreach $row (@database_rows)
{
@database_fields = split (/\|/, $row);
foreach $field (@database_fields)
{
if ($field =~ /^%%OPTION%%/)
{
($empty, $option_tag, $option_location) = split (/%%/, $field);
$field = "";
open (OPTION_FILE, "<$options_directory/$option_location")
||
&file_open_error ("$options_directory/$option_location",
"Display products for Sale", __FILE__, __LINE__);
while (<OPTION_FILE>)
{
s/%%PRODUCT_ID%%/$database_fields[$db_index_of_product_id]/g;
$field .= $_;
}
close (OPTION_FILE);
} 
} 
@display_fields = ();
@temp_fields = @database_fields;
foreach $display_index (@db_index_for_display) 
{
if ($display_index == $db_index_of_price)
{
$temp_fields[$db_index_of_price] =
&display_price($temp_fields[$db_index_of_price]);
}
push(@display_fields, $temp_fields[$display_index]);
}
@item_ids = ();
foreach $id_index (@db_index_for_defining_item_id) 
{
$database_fields[$id_index] =~ s/\"/~qq~/g;
$database_fields[$id_index] =~ s/\>/~gt~/g;
$database_fields[$id_index] =~ s/\</~lt~/g;
push(@item_ids, $database_fields[$id_index]);
}
printf ($product_display_row, 
join("\|",@item_ids), 
@display_fields);
} 
&product_page_footer($status,$total_row_count);
exit;
}
sub display_cart_contents
{
local (@cart_fields);
local ($field, $cart_id_number, $quantity, $display_number,
 $unformatted_subtotal, $subtotal, $unformatted_grand_total,
 $grand_total);
 &standard_page_header("Your Order");
&display_cart_table("");
&cart_footer;
exit;
} 
sub file_open_error
{
local ($bad_file, $script_section, $this_file, $line_number) = @_;
&update_error_log("FILE OPEN ERROR-$bad_file", $this_file, $line_number);
open(ERROR);
while (<ERROR>)
{
print $_;
} 
close (ERROR);
}
sub display_page
{
local ($page, $routine, $file, $line) = @_;
open (PAGE, "<$page") || &file_open_error("$page", "$routine", $file, $line);
while (<PAGE>)
{
s/cart_id=/cart_id=$cart_id/g;
s/%%cart_id%%/$cart_id/g;
s/%%page%%/$form_data{'page'}/g;
s/%%date%%/$date/g;
if ($form_data{'add_to_cart_button'} ne "" &&
$shall_i_let_client_know_item_added eq "yes")
{
if ($_ =~ /<FORM/)
{
print "$_";
print "$item_ordered_message";
}
}
print $_;
}
close (PAGE);
} 
sub update_error_log
{
local ($type_of_error, $file_name, $line_number) = @_;
local ($log_entry, $email_body, $variable, @env_vars);
@env_vars = keys(%ENV);
$date = &get_date;
{
$log_entry = "$type_of_error\|FILE=$file_name\|LINE=$line_number\|";
$log_entry .= "DATE=$date\|";
foreach $variable (@env_vars)
{
$log_entry .= "$ENV{$variable}\|";
}
&release_file_lock("$error_log_path.lockfile");
$email_body = "$type_of_error\n\n";
$email_body .= "FILE = $file_name\n";
$email_body .= "LINE = $line_number\n";
$email_body .= "DATE=$date\|"; 
foreach $variable (@env_vars)
{
$email_body .= "$variable = $ENV{$variable}\n";
}
&send_mail("$admin_email", "$admin_email", "Script Error","$email_body");
} 
}
sub get_date {
local ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst,$date);
local (@days, @months); 
@days = ('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
@months = ('January','February','March','April','May','June','July',
 'August','September','October','November','December');
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
if ($hour < 10) 
{ 
$hour = "0$hour"; 
}
if ($min < 10) 
{ 
$min = "0$min"; 
}
if ($sec < 10) 
{ $sec = "0$sec"; 
}
$year += 1900;
$date = "$days[$wday], $months[$mon] $mday, $year at $hour\:$min\:$sec";
return $date;
} 
sub display_price
{
local ($price) = @_;
local ($format_price);
if ($currency_symbol_placement eq "front")
{
$format_price = "$currency_symbol $price";
}
else
{
$format_price = "$price $currency_symbol";
}
return $format_price;
}
sub get_file_lock 
{
local ($lock_file) = @_;
local ($endtime);
$endtime = 20;
$endtime = time + $endtime;
while (-e $lock_file && time < $endtime) 
{
sleep(1);
}
open(LOCK_FILE, ">$lock_file") || &CgiDie ("I could not open the lock file");
} 
sub release_file_lock 
{
local ($lock_file) = @_;
close(LOCK_FILE);
unlink($lock_file);
} 
sub format_price
{
local ($unformatted_price) = @_;
local ($formatted_price);
$formatted_price = sprintf ("%.2f", $unformatted_price);
return $formatted_price;
}
sub format_text_field {
local($value, $width) = @_;
$width = 25 if (!$width);
return ($value . (" " x ($width - length($value))));
}
sub check_url { 
local($check_referer) = 0; 
if ($ENV{'HTTP_REFERER'}) { 
foreach $referer (@referers) { 
if ($ENV{'HTTP_REFERER'} =~ m|https?://([^/]*)$referer|i) { 
$check_referer = 1; 
last; 
} 
} 
} 
else { 
$check_referer = 1; 
} 
if ($check_referer != 1) { &bad_referer; } 
} 
sub bad_referer { 
print "Content-type: text/html\n\n"; 
print qq| 
<HTML><HEAD><TITLE>Minor Problem</TITLE></HEAD> 
<BODY BGCOLOR="WHITE" TEXT="BLACK"> 
<CENTER><TABLE $border WIDTH=400><TR><TD><BR><BR><BR>
<FONT FACE="verdana,arial,helvetica"><CENTER>Script Error</CENTER><P>
I'm sorry but the URL you used is not correct. Please notify the administrator of this problem.
</FONT><BR><BR><BR></TD></TR></TABLE></CENTER></BODY></HTML> 
|; 
exit(1); 
} 

