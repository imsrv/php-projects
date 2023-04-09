#################################################
# CONFIGURATION SECTION

# This is the complete path to your user data directory. If possible,
# this directory should not be browser accessible.

	$datapath = '/home/httpd/ematch_data';

# This is the complete path to the directory containing
# your pics, tmp and html subdirectories.  This directory must
# be browser accessible.

	$html_path = "/home/httpd/html/ematch35";

# This is the URL of your pics, tmp, and html directories.

	$main_url = 'http://127.0.0.1/ematch35';

# This is the URL of the [Exit e_Match] link.

	$exiturl = 'http://127.0.0.1/cgi-bin/ematch35/index35.cgi';

# The name of your current users file.  If this file is browser
# accessible, you should change its name.

	$log = 'users.log';

# The name of your expired users file.

	$xlog = 'xusers.log';

# The path to your log file.  You can leave this as-is.

	$logpath = "$datapath/log";

# This is the complete path to your form data directory. You can leave
# this as-is.

	$form_path = "$datapath/form";

# Set to 'yes' if you're running this script on an NT server.

	$nt = 'no';

# (NT Only) Your SMTP email server. (The one you do e-mail through).

	$smtp = 'mail.wipd.com';

# The return address for the generated e-mail.  Your
# e-mail address is fine. (NT - must match domain of $smtp)

	$admin = 'mb@e-scripts.com';

# After initial testing, set this to 'yes'.
# If your server allows file locking, this will reduce errors.

	$lockon = 'no';

# END OF CONFIGURATION SECTION
#################################################
# OPTIONS SECTION

# If you want e_Match to be free, set to 'yes'.
# If you want it do be subscription based, set to 'no'.

	$free = 'yes';

# Number of days of trial period (subscription based).

	$trial = 14;

# Number of days of inactivity before user is deleted (free).

	$timeout = 14;

# Set to yes if you want user notified by email 3 days before their
# membership expires.

	$notify = 'yes';

# This is the text of the reminder email. Use \n where you want a line
# break.

	$reminder = "Greetings!\n\nJust wanted to let you know that your e_Match membership is set to expire in three days.  If you want to renew your membership, go to (URL) and click [RENEW]\n\nThanks!\n(YOUR NAME)";

# The maximum size of uploaded files. The default is 10K.

	$max_size = 10240;

# Maximum number of matches displayed.

	$max_matches = 6;

# Ranking terms and values.

	%ranks = ("ESSENTIAL!" => "100", "Quite Desirable" => "10", "Desirable" => "4", "Mildly Desirable" => "1", "Mildly Undesirable" => "-1", "Undesirable" => "-4", "Quite Undesirable" => "-10", "NO THANKS!" => "-100");

# Colors of various ranks in profile display

	%colors = ("ESSENTIAL!" => "#0000FF", "Quite Desirable" => "#2200DD", "Desirable" => "#4400BB", "Mildly Desirable" => "#660099", "Mildly Undesirable" => "#990066", "Undesirable" => "BB0044", "Quite Undesirable" => "DD0022", "NO THANKS!" => "#FF0000");

# Your pages' header tags. Includes all tags from after </title> thru the banner.gif code.

	$header ="<link rel=STYLESHEET type=\"text/css\" href=\"$main_url/html/style.css\"></head><BODY BGCOLOR=\"#F2DAB2\" TEXT=\"#003366\" LINK=\"#0000FF\" VLINK=\"#660066\" ALINK=\"#FFFF00\"><center><IMG SRC=\"$main_url/html/banner.gif\" WIDTH=\"402\" HEIGHT=\"42\" BORDER=\"0\" ALT=\"banner\"></center>\n";

# Your pages' footer. (Appears at the bottom of all pages).

	$footer = "<hr><hr width=\"50%\" align=right><hr width=\"25%\" align=right><H6 align=right>Script by<br><a href=mailto:mb\@wipd.com><i>e_</i><tt><B>Scripts</B></tt> <i>Software</i></a></h6>\n";

# Various file names.  No need to change these unless you
# change the actual file's names.

	$subject='form/subject.txt';
	$object='form/object.txt';
	$interests='form/interests.txt';

# END OF OPTIONS SECTION
#################################################
1;
