####################################################################
#
# CyberCart Pro Internet Commerce System, Version 3.04
# Copyright 1997, Richard Torzynski
# 1-25-98
# All rights reserved
# This is NOT a shareware script.
#
# Merchant Setup File for demo merchant on NT
#
####################################################################
#
# For each merchant to use CyberCart IP Pro, this merchant file
# defines html page characteristics and also where files are stored
# on the system.
#
# For example, this file is set up for a merchant with the merchant
# ID of demo. This file should be called demo.pl and placed in the
# merchant file directory defined in the main CyberCart script.
# In this merchant file directory there should be a subdirectory
# called demo with three subdirectories (Data, Orders, and Logs). So here's
# a summary of the directory and file structure:
#
# c:\Merchant
# c:\Merchant\Demo.pl
# c:\Merchant\Demo
# c:\Merchant\Demo\Orders
# c:\Merchant\Demo\Data
# c:\Merchant\Demo\Logs
#
# These directories should be OUTSIDE of the html root directory so people
# can't browse these files. 
#
# CyberCart Script Variables:
#
# Script URL. Set to the full url of the cybercart script. If you have
# a virtual domain with your own cgi-bin, it will be:
$script_url="http://www.name.com/cgi-bin/cybercart.pl";
#
# Secure URL. The full URL to the secure server script. Usually this
# means adding an s to http to indicate a secure server is being used.
# $secure_url = "https://www.name.com/cgi-bin/cybercart.pl";
#
# NEW
# Secure Domain.  If the domain name of the secure server differs from the 
# unsecure server, then set this variable.  This will enable a domain 
# transfer, where the session_id and order will be 'transferred' to the 
# secure server.  This allows you to run the script off of two servers, but
# you must duplicate the directory structure and files onto the secure 
# server if its on a separate machine.  
#$secure_domain = "www.name2.com";
#
# Toggle for whether script is running on secure server or not.
# 1=secure, 0=not secure
$secure=0;
#
# To supress unsecure ordering feature, set $no_unsecure=1.
# $no_unsecure = 1;
#
# To supress fax/email option, set $no_offline=1.
# $no_offline = 1;
#
# New Mail Error feature.  To help with debugging and possible browser
# related incompatabilities, you can set a toggle to email you when
# someone encounters an error.  This error report will include the date,
# the error message, the users browser, ip number, the url, the server,
# and the session_id variables.  This will also be helpful if you need
# to send a message to support@cybercart.com.
$mail_error = 1;

####################################################################
#
#
# Merchant Data File Variables:
#
# Path of directory of merchant data directory
$home_dir="C:\\merchant\\Demo";
#
# Order Directory - temp order files stored here.
$order_dir= $home_dir . "\\Orders";
#
# Invoice Directory - Final invoices stored here. getorder.pl script is
# used to view these files using netscape or MSE.
$invoice_dir= $home_dir . "\\Data";
#

# Log files are kept here.
$log_dir = $home_dir . "\\Logs";

# Status File - stores order status information.
$status_file= $home_dir . "\\status.dat";

#
# Client list file.  
$clientlist = $home_dir . "\\referrer.dat";
$sendclient = 1;
#
# Don't change this.
$price_file = "none";
#
#
####################################################################
#
# Merchant HTML File Variables:
#
# URL of directory where merchant HTML files are. This can be on another
# system or provider. End this with a slash.
$home_url="http://www.name.com/Demo/";
#
# URL of merchant home page.  
$home_page="http://www.name.com/Demo/demo.html";
#
# Full Path name of merchant html files (if stored on this system). Used
# by search engine. If files are stored on another server, you need to
# install the cybersearch.pl script on that server to use the search engine.
$home_html = "c:\\inetpub\\wwwroot";
#
#
####################################################################
#
# Company Information
#
# Company email address. This is where orders are emailed to.  Make sure you
# escape the '@' by putting a '\' in front of it.
$recipient="userid\@name.com";
#
# Array of email to send copies of customer's receipt
# @mailcc = ("address2\@name.com","address3\@name.com");
#
# Company Name
$company="Company Name";
#
# Company Phone Number
$phone="1-999-999-9999";
#
# Company Fax Number
$fax = "1-999-999-9999";
#
# Address
$address="123 Main Street, City, State, Zip";

# Additional header info printed underneath the company info
# $additional_header = " ";

#
# Set to "none" if don't use creditcards
# $creditcards = "none";

# Payment types accepted (list creditcards, checks, moneyorders, etc.).
@credit=("Check","Visa","Mastercard");
#
# Checks. Who checks should be made out to.
$checks="Company";
#
# State taxes.  Us the two letter appreviation for states.
%statetaxes=("NM",".0525");
#
# Tax option.  In some states (such as California), shipping and 
# handling is taxable.  Set this variable to 1 to add shipping and 
# handling to taxable total.
# $tax_option = 1;
#
# State textbox. Set this to 1 to have a textbox instead of drop down
# menu of states or 2 to supress state input field for countries 
# other than the United States.  If you supress, remember to remove
# state form @required array down below.
# $state_textbox = 2;
#
####################################################################
#
#
# Script Pages Appearence Variables. Sets the properties of script
# generated forms.
#
# title pict that appears at the top.
# $titlepict="http://www.name.com/logo.gif";
#
# Button images.  If you wish to use images instead of standard
# form buttons, set each of these to the URL of the image.
#
# Directory of where the button images are located
# $button_dir = "http://www.name.com/Demo/graphics/";
#
# Button images
# $button_search = $button_dir . "buttonsearch.gif";
# $button_order= $button_dir . "buttonorder.gif";
# $button_check= $button_dir . "buttoncheck.gif";
# $button_clear= $button_dir . "buttonclear.gif";
# $button_shop= $button_dir . "buttonshop.gif";
# $button_continue= $button_dir . "buttoncontinue.gif";
# $button_update= $button_dir . "buttonupdate.gif";
# $button_secure= $button_dir . "buttonsecure.gif";
# $button_online= $button_dir . "buttononline.gif";
# $button_offline= $button_dir . "buttonoffline.gif";
#
# Body background (specify full url of background image)
$bodyback = "";
#
# Body background color.
$bodycolor = "FFFFFF";
#
# Body text and link colors.
$bodytext = "";
$bodylink = "";
$bodyvlink = "";
$bodyalink = "";
#
# Define table background tables
$Table_width = "580";
$Table_Header_Color = "C9CFF8"; 
$Table_Body_Color = "FFFFE1";
$Table_Entry_Color = "C8FFC8";
#
# Item properties used by merchant (Size, Color, Style). Can have up to 
# three.
@properties=("Color");
#
# Pagelinks that appear at the bottom of each script generated page. The location
# specified in the first of the pair, is the file location relative to the
# $home_url specified directory.
%pagelinks=("demo.html","Demo Book Page");
#
# List of required information in order form.
# Possible choices: Name,Street,City,State,Zip,Country,Phone,Email.
@required = ("Name","Street","City","State","Zip","Country","Email");
#
# Show order toggle.  Set this variable to 1 to show contents of cart after
# customer adds item to cart.
# $showorder = 1;
#
# Redirect after adding.  Set this variable to the number of seconds to 
# wait before returning customer to last page after adding item to cart.
# Comment this variable out if you don't want them redirected back automatically.
# $redirect=3;
#
# Set $print_code = 1 to print the order number of the items on the forms
# $print_code = 1;
#
# Message to put at the end of the customers receipt
$mail_closing = "\n 
Thank you for ordering from $company! If your order as listed is 
incorrect, please let us know immediately!
Email: $recipient
Phone: $phone";
#
# Order Note.  General message printed out in the order form.  Frequently used to 
# indicate that shipping will be calculated later for international orders.
# $order_note = "Order Note";
#
####################################################################
#
#
# Shipping variables.
#
# Method of calculating shipping [flat,percent,table,weight,items,actual,none]
# Select one of these methods, uncomment the lines and set variables
# needed for that method.
#
# Base country for shipping charges.
$shipping_base = "US";
# ==================================================================
# Shipping Method 1
# For flat, set the $shipping_modifier to the flat shipping charge.
$shipping_cost = "flat";
$shipping_modifier = 4.5;
$world_shipping_cost = "flat";
$world_shipping_modifier = "10";
#
# ==================================================================
# Shipping Method 2
# For percentage of the total cost.
# $shipping_cost = "percent";
# $shipping_modifier = .10;
# $world_shipping_cost = "percent";
# $world_shipping_modifier = .10;
# 
# ==================================================================
# Shipping Method 3
# For a table based on the total cost.
# Associative array containing ranges, and the cost of shipping for each of
# the ranges.
# $shipping_cost = "table";
# %ship_table=("1-20","3.00","20-50","4.50","60-100","6.00","100-300","10.00","300-1000","15.00");
# $show_table = qq[
#  1 -  19.99 	\$ 3.00
# 20 -  49.99	\$ 4.50
# 50 -  99.99	\$ 6.00
#100 - 299.99	\$10.00
#300+		\$15.00
#];


# $world_shipping_cost = "table";
# %world_ship_table =("1-20","13.00","20-50","14.50","60-100","16.00","100-300","20.00","300-1000","25.00");
#$world_show_table = qq[
#  1 -  19.99    \$13.00
# 20 -  49.99    \$14.50
# 50 -  99.99    \$16.00
#100 - 299.99    \$20.00
#300+            \$25.00
#];
#
#
# ==================================================================
# Shipping Method 4
# For a table based on the total weight. If you use this method, each item
# must contain a hidden form variable for weight,
# <input type=hidden name=id_weight value=itemweight>
# $shipping_cost = "weight";
# %ship_table=("1-2","2.00","2-4","4.00",4-10","6.00","10-20","8.00");
# $world_shipping_cost = "weight";
# %world_ship_table=("1-2","2.00","2-4","4.00",4-10","6.00","10-20","8.00");
# Measurement units weight is given in if using weight to calculate shipping.
# $weight="lbs";
# 
# ==================================================================
# Shipping Method 5
# For a table based on the number of items ordered.
# $shipping_cost = "items";
# %ship_table=("1-2","3.00","3-4","4.00","5-6","6.00","7-10","10.00");
# $world_shipping_cost = "items";
# %world_ship_table=("1-2","2.00","2-4","4.00",4-10","6.00","10-20","8.00");
#
# ==================================================================
# Shipping Method 6
# To use UPS and USPS actual shipping rates from within the United States.
# $shipping_cost = "actual";
# $world_shipping_cost = "actual";
# Set the weight units - this must be set for weight to show up on the order forms
# $weight = "lbs";
#
# If using actual, uncomment and set the variables = 1 for the services
# used by merchant
# $upsground=1; # UPS Commercial Ground
# $ups2day=1; # UPS 2 Day Air
# $ups2dayam=1; # UPS 2 Day Air AM
# $ups1day=1; # UPS Next Day Air
# $ups1daysav=1; # UPS Next Day Air Saver
# $ups3daysel=1; # UPS 3 day Select
# $usps_express=1; # USPS Express Mail
# $usps_priority=1; # USPS Priority Mail
# $usps_mparcel=1; # USPS Machinable Parcel
# $usps_nmparcel=1; # USPS Non-Machinable Parcel
#
# Merchant zip code for determining domestic shipping rates
# $merchantzip = "87106";
#
# Merchant State for determining world UPS shipping rates
# $merchantstate = "NM";
#
# Path of appropriate shipping zone chart.  The zone chart is based
# on the first three digits of the *merchants* zip code that the order
# is being shipped from.
# $zone_chart = "c:\\merchant\\Shipping\\Zones\\870.csv";
#
# ==================================================================
# Shipping Method 7
# Special per item shipping cost.  If the shipping cost varies by
# item, you can set the shipping charge individually.  On the html
# pages, you must include an additional hidden form variable
# called item_ship.  See the pages.html for more instructions.
# 
# $shipping_cost = "per_item";
# 
# ==================================================================
# Shipping Method 8
# Custom shipping table for international orders.  Special tables 
# must be created to use this method - see specialship.html for more
# information.
# 
# Tables can be constructed to determine rate by either weight or
# number of items. 
# Special shipping by weight
# $shipping_cost = "special_weight";
# $shipping_cost = "special_items";
# $world_shipping_cost = "special_weight";
# $world_shipping_cost = "special_items";
#
# Path name of the special zone chart.
# $special_zone = "c:\\merchant\\Shipping\\State_Zone.txt";
# $world_special_zone = "c:\\merchant\\Shipping\\Country_Zone.txt";
#
# Path name of the special rate chart.
# $special_rate = "c:\\merchant\\Shipping\\State_Rate.txt";
# $world_special_rate = "c:\\merchant\\Shipping\\Country_Rate.txt";
#
# Name for the shipping method to be displayed on orderform
# $special_name = "Demo Shipping Charges";
#
# Max item or weight.  The upper limit of the custom charts.
# $max_item_rate = 23;
#
# Item or weight increment above the $max_item_rate.
# $item_inc = 5;
#
# Rate per item or unit weight above the $max_item_rate.
# @add_item = (0,0,3.5,5.5,7.5,9.0);
#
# ==================================================================
# Shipping Method 9 - NO SHIPPING COST
# No shipping option. If the price includes shipping, set shipping to none.
# $shipping_cost = "none";
#
# ==================================================================
#
# Set this to 1 for no International Orders
# $no_world_shipping = 1;
#
# Set to the minimum shipping cost.  Shipping cost will be set to this minimum
# if calculated shipping is less.
# $min_shipping = 2.00;
#
# Set the maximum shipping cost.
# $max_shipping = 12.00;
#
####################################################################
#
# Handling costs. 
#
# If there is additional cost for handling, indicate one of
# the following options:
# For handling charge for whole order:
# $handling_order = 2;
#
# For handling charge for EACH ITEM:
# $handling_item = 1;
#
# Per item handling.  A special form variable must be included for each item.
# $handling_special = 1;
#
####################################################################
#
# Discounts Variables.
#
# To apply a discount for all items, or a discount if you order a 
# certain amount, set this variable to one of the following:
# [fixed_table,percent_table, percent, none].
#
$discount = "none";
#
# Fixed_table discount. Set a range of total amount ordered, and the amount of
# the discount.
# $discount = "fixed_table";
# %discount_table = ("0-20",0,"20-50","5.00","50-100","10.00");
#
# Percent_table discount. Set a range of total amount ordered, and the percentage
# discount:
# $discount = "percent_table";
# %discount_table = ("0-10",0,"10-20",".05","20-100",".10","100-500",".15");
#
# Percent. Straight percent of total.
# $discount = "percent";
# $discount_percent = ".10";
#
#
####################################################################
# Special Options:
# 
# Required fields.  List of required fields.  Options are:
# Name, Street, City, State, Zip, Country, Phone, Email
@required = ("Name","Street","City","State","Zip","Country","Email");
#
# Special Selections.  These are options that are added onto the 
# billing form.  If there are cost associated with them, they will be
# listed in a separate entry on the invoice form.
# The format is:
# $special_selection{'Name'} = "form element | text | additional cost";
# The additional cost will be added to the total amount and shown in
# form as its own entry. The name of the form variable must be the
# same as the key in the $special_selections.  For example, to add cod:
#
# $special_selections{'COD'} = "<input type=checkbox name=COD>|Send by COD|4.95";
#
# Additional Fields. 
# Use to include additional fields in the form.  Note that the name
# of the hash has to be the same as the "name" of the form element.
# Separate the title and form tag with the '|' character.
# $additional_fields{'Work Number'} = "Work Number|<input name=\"Work Number\" size=20 maxsize=20>";
#
#
# Minimum total order amount.  Set this to the minimum order amount.  Customer will
# get a warning if their order is less than this minimum amount.
# $min_total = 10;

# Set $no_gift_message to "1" to suppress print of gift textarea.
# $no_gift_message = 1;

# Set $no_billing_address to "1" to suppress printing of separate billing address option
# $no_billing_address = 1;

# Supress the decimal point in the currency displayed
# $no_decimal = 1;

####################################################################
# Onanalysis for real-time credit card processing
# See th instruction manual and Online Analysis' Web Site for 
# complete instructions on using Online Analysis Gateway.
# 
# Enables 
# $onanalysis = 1;
#
# Vendor ID assigned by Online Analysis
# $vendor_id = "Demo";
#
# Vendor Password assigned by Online Analysis
# $oa_password = "analyze";
#
# $transaction_type = "C6";
#
# Transaction log location
# $oa_log_file = $home_dir . "\\Logs\\oalog.dat";
#
# onanalysis script references which you get from onanalysis
# $oa_ref = "/socketlink/demotest.cgi";
#
#############################################################
#
# Download enable
# Each file must be kept in the Files subdirectory of the
# merchant's root directory.  Each item must also have a
# code_dlfile hidden form variable.
#
# There are three methods of download:
# $dl_type = 1 : A list of files will be shown immediately
# after customer completes the order.  Least secure.
# $dl_type = 2 : An email message is sent to the customer
# with the download authorization code.
# $dl_type = 3 : An email message is sent to the merchant
# with the download authorization code which can then be
# forwarded to the customer after payment processing.
# $dl_type = 2;
#
# URL for the CyberCart Download script
$dl_url = "http://www.name.com/cgi-bin/ccdown.pl";
#
# URL for the Web Page interface where customers can
# enter their download authorization code.
$dl_page = "http://www.name.com/ccdown.html";
#
# Location of the files to be downloaded.  This should be a file 
# outside the root directory.
$dl_files = $home_dir . "/Files/";
#
# The merchant_id
$merchant_name = "Demo";
#
####################################################################
#
# Copyright 1997, Richard Torzynski
#
####################################################################

return 1;
