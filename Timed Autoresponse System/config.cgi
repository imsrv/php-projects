#!/usr/bin/perl
######################################################################
# Configuration Variables
######################################################################

# This is the full path and name to the data file containing your emails
$path_to_members_file = "/path/to/cgi-bin/autoresponder/data/members.txt";

# This is the URL the web surfer is sent to after they signed up
$redirect_to_this_page_after_signup = "http://www.yoursite.com/thanks.html";

# This is the URL the web surfer is send to after they remove their email
$redirect_to_this_page_after_removal = "http://www.yoursite.com/sorry.html";

# This is the PATH to the first email to be sent to them upon signing up
$path_to_first_email = "path/to/cgi-bin/autoresponder/first.txt";

# This is the PATH to the DIRECTORY containing the emails (no trailing slash!)
$path_to_email_template_directory = "/path/to/cgi-bin/autoresponder";

#This is the path to the directory where your logs are stored (no trailing slash!)
$path_to_data_files = "/path/to/cgi-bin/autoresponder/data";

# This is the path to your sendmail program
$path_to_sendmail = "/usr/sbin/sendmail";

# This is the email used in the "FROM" area of the emails you send out
# (make sure to put a slash in front of the @ character!)
$admin_email = "you\@yoursite.com";

# If you create your messages in HTML format, set this to 1
# It will send the messages out as html...
$send_as_html = 0;

1;
