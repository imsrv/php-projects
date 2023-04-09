#!/usr/bin/perl

# You will find a complete HTML tutorial/manual in our
# Registered Users Area of our website:
# http://www.cgiscriptcenter.com

# Version 1.030
##############################################################
# EDIT USER CONFIGURATIONS BELOW
##############################################################

# Add your BODY tag information, like background graphic, color, etc.
$bodyspec = "background=\"\" bgcolor=\"#FFFFFF\" link=\"#0000FF\" vlink=\"#0000FF\"";

# Add your own graphics, text, links, etc., to the top of your pages.
# Give the full directory path to your header.txt file.  DO NOT include
# the header.txt file in the path here, just the directories.
# $header = "/full/path/to/directory";
$header = "";

# Add your own graphics, text, links, etc., to the bottom of your pages.
# Give the full directory path to your footer.txt file.  DO NOT include
# the footer.txt file in the path here, just the directories.
# $footer = "/full/path/to/directory";
$footer = "";

# Edit the font colors of the text on the help and error screens that
# users will see.  This is helpful if you add a background color or
# graphic.
$fontcolor = "#000000";

# Type the name of your organization, group, or company
$orgname = "CGI Script Center";

# Type an email address that customer/user can respond to
$orgmail = "cgi\@elitehost.com";


# Type the full path to your Mail program.  Our NT version is
# designed to use BLAT while our UNIX version is designed to use
# Sendmail.
$mailprog = "/usr/bin/sendmail";

# If you would like the amform.htm to redirect to another web
# page URL, after it has finished processing the amform.htm,
# simply place that URL in the quotations below.
# Example: $redirect = "http://www.yourserver.com/page.htm";
# We recommend using a FULL URL to the page.

$redirect = "";

# Here you can create the text message that the potential
# new members/user will receive in the email once they fill
# in your web form.
# Place the information in a text file
# and save the file as: email.txt
# Place the full path to the email.txt file (if any) here.
# DO NOT place the name of the file (email.txt) here, just
# the directory path where the file is kept.
$closing = "/full/directory/path/to/info";


# If you use IBiLL or choose to allow Instant Approval/Access
# to your members area, enter the number 1 between the quotes
# for $instantaccess, like so:  $instantaccess = "1";
# This will automatically add the new user to your private
# area and update your members database.

$instantaccess = "";


# This is the Suject of the email that is sent to anyone that
# signs up.
$sign_up_response = "Thank you for your submission!";


# This would be the suject of the Aproval email the user will
# receive if you have Instant Access on.
$approved_email_subject = "You've Been Approved!";


# If you would like to customize the e-mail messages that your
# customers/users receive when they complete and submit any of
# your website forms, create the following text files and upload
# them all to your $memberinfo directory:
#
# email.txt - In this file, include information someone would
# receive when they submit an account request to you, prior to
# approval or denial of account.
#
# approved.txt - In this file, include the information that you
# would like your customer/user to receive once you have approved
# his/her account.
#
# denied.txt - In this file, include the information that you would
# like your customer/user to receive if their account has been denied.
#
# Once completed, upload these three text files to your $memberinfo
# directory.

# If you are run the script and receive File Locking (flock)
# errors, remove the number 2 from between the quotes.
# Then it would appear: $LOCK_EX = "";
$LOCK_EX = "2";

# If you choose to offer limited time accounts, make sure to place
# a "1" between the quotes below.
# Example: $acctlength = "1";
# Otherwise, do not place anything between the quotation marks.

$acctlength = "1";


# If you are offering accounts for purchase, place the account
# Information here.  We have included some examples below
# Note, do not place dollar signs ($).  The program will do that
# for you.

# If you do not need an expiration of the account, simply leave
# the $length(one-two-three) = ""; empty.  Like so.
# You can set the $lengthone, $lengthtwo, and $lengthtree variables
# to any number of days that you want each account to expire in.
# If your accounts do not expire, and do not need to renewal,
# simply leave those variables blank, and make sure that your
# $acctlength above also has nothing between the quotes.


$account_one = "Basic Plan";
$setup_one = "25";
$monthly_one = "24.99";
$lengthone = "30";

$account_two = "Deluxe Plan";
$setup_two = "45";
$monthly_two = "44.99";
$lengthtwo = "60";

$account_three = "Gold Plan";
$setup_three = "";
$monthly_three = "";
$lengththree = "90";


# If you choose to offer limited time accounts (above), choose the
# number of days before expiration that you would like your customer
# notified of his/her account expiring.
# Example: $renewal = "7"; 
# This will send your customer a reminder 7 days before his/her account
# expiring, to contact you to renew his/her account.

$renewal = "7";

# Place the full directory path here to the backup directory, where you
# want your nightly backups of your membership database and the
# htpasswd files.

$backup = "/full/directory/path/to/backup/directory";

# Enter your website URL here

$website = "http://www.cgiscriptcenter.com";


# Give the full directory path where you would like your password.txt
# file to be saved.  DO NOT include the name password.txt in the path
# here, just the directories.  $passfile = "/full/path/to/directory";
# Permissions settings should be between 755 - 777.  Permission
# settings vary between servers.
$passfile = "/full/directory/path/to/info";



# Type the subject that will appear in the email customer/user
# receives
$subject = "ABC Member Info";


# If you use .htaccess or .nsconfig, use a "1", otherwise leave blank
# or set to "0".  This is if you use a secure users area.

$htaccess = "1";



# If you entered "1" above, enter the full path to your
# htpasswd or .nsconfig file.
# Like this: $memaccess = "/full/path/to/htpasswd";
# This is the file that houses the usernames and encrypted passwords
# but is only needed if you use .htaccess or .nsconfig
# Permissions settings should be between 755 - 777.  Permission
# settings vary between servers.
# The program will create the file called "htpasswd" for you.
# We placed the actual path name here in case you already have
# a password file that you want to replace it with.
$memaccess = "/full/directory/path/to/info/htpasswd";

# Type the full path to the database file that contains all the info
# Permissions settings should be between 755 - 777.  Permission
# settings vary between servers.
$memberinfo = "/full/directory/path/to/info";


# Subject of email that is automatically sent to users that you
# chose not to accept in your Account Manager.
$denied_email_subject = "Application Denied";

# Subject for email that is automatically sent to users that you
# chose to accept in your Account Manager.
$approved_email_subject ="Application Approved";

# If accepting/charging for a membership account, enter a "1"
# between the quotations, other wise leave it empty "";
$payment = "1";

## The information below will appear on Emailed billing
# statements.  If you are not billing your customers,
# you will not need to edit the information below.

# Name of your billing supervisor who's name will appear on
# emailed billing statments.
$billing = "Billing Supervisor";

# Make Checks out to:
$billingaddress1 = "Elite Web Design and Marketing";

# Address
$billingaddress2 = "10680 Los Alamitos Blvd.";

# City, State, Zip
$billingaddress3 = "Los Alamitos, CA  90720";

# Billing Inquiries, email at yourname\@yourdomain.com
# or call (enter phone number).
$billinginquiries = "Billing Inquires at (phone) or E-mail at accounts\@elitehost.com";


# Enter the maximum IP addresses that you would like any one account
# to have access from in any single 24 hour period.  Keep in mind that
# most ISP's will issue a user a new IP address each time they log off
# and back on the Internet.

$userips = "10";

#################### IBILL USERS ONLY ############################
##################################################################

# If you are using IBILL's pincoding, enter the number "1" between
# the quotations below.  Otherwise, leave it empty.
# Example:  $IBILL = "1"; for IBILL pincoding turned on
# Exmaple:  $IBILL = "";  for IBILL pincoding turned off

$IBILL = "";

# If you wish to redirect those that are denied an account due to
# a non matching Pincode, place the full url of where you would
# like this person directed.
# Example:  $Idenyurl = "http://www.yourserver.com/deniedaccess.htm";

$Idenyurl = "";

# Enter the full directory path to the pincode file provided you by
# IBILL here.  Be sure to include the name of the file itself.
#
# Account Manager is presently designed to offer up to three account
# types.  Using IBILL, each account will have its own set of
# authorization pincodes. Enter the path for up to 3 separate pin
# code text files here.  Make sure to place these pin codes in a
# directory that is not accessible by the web, if possible. Most
# ISP's will offer their customers at least one directory for this.
# Make sure to set permissions on the files for read and write.
# 744-766.  Some servers will require as high as 777. Contact your
# server administration for specific settings on your server.
# Example:  /home/httd/yourserver/directory/1pincode.txt";


$act1pincodes = "/full/directory/path/to/your/account1pincodes.txt";
$act2pincodes = "/full/directory/path/to/your/account2pincodes.txt";
$act3pincodes = "/full/directory/path/to/your/account3pincodes.txt";

####################################################################