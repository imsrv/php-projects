#variables

##########################################################################
##																		##
##						 IntelliLink Manager Pro						##
##						 -----------------------						##
##					   by Jimmy (wordx@hotmail.com)						##
##						http://www.smartCGIs.com						##
##																		##
##	IntelliLink Pro is not a free script. If you got this from someone  ##
##  please contact me. Visit our site for up to date versions. Most		##
##  CGIs are over $100, sometimes more than $500, this script is much	##
##  less. We can keep this script cheap, as well as a free version on	##
##  our site, if people don't steal it. If you are going to use a		##
##	stolen version, please atleast DO NOT remove any of the copyrights  ##
##	or links to our site, they keep this CGI cheap for everyone.		##
##	Thanks!																##
##																		##
##				  (c) copyright 2000 The Mp3eCom Network				##
##########################################################################
#
# Fill out everything below
###
  #
#####
 ###
  #

#######################
# The password you will use to access the Admin page.
$variables{'adminpass'} = 'gissa';

#######################
# The name of your site
$variables{'sitename'} = 'Mp3 Hits';

#######################
#The URL of your site (where incoming visitors will be sent)
$variables{'siteurl'} = 'http://www.mp3hits.net/~findyourmp3';

#######################
# Give the full URL to where you stored the 3 admin graphics (admin_1.gif, admin_2.gif and admin_3.gif)
#	They are used to give color to your admin page graphs.
# DO NOT include the trailing slash /
$variables{'graphicurl'} = "http://www.mp3hits.net/images";

#######################
#The URL of the page where you keep banners (and graphics) for webmasters to link to your site with.
$variables{'bannerurl'} = 'http://www.mp3hits.net/~findyourmp3/links.shtml';

#######################
#The URL to the folder where your files for this CGI are. DO NOT include the trailing slash /
$variables{'cgiurl'} = 'http://www.mp3hits.net/~findyourmp3/links';

#######################
#This is the body tag for link colors and so on for your site, it will be used for the sign up pages.
$variables{'body'} = '<body link="#000080" vlink="#0000C1">';

#######################
#Your e-mail address.
$variables{'wemail'} = 'ghis@emaila.nu';

#######################
#Path to Sendmail on your server (Important for the CGI to send e-mails out).
$variables{'mailp'} = "/usr/sbin/sendmail -t";

##################################################################
###### The following are not necessary to change, you might ######
###### just want to change them for more customization.		######
##################################################################
  #
#####
 ###
  #

#######################
# Default minimum amount of hits required (sent in) for sites to be listed.
$variables{'mintoshow'} = "1";

#######################
#Maximum number of characters allowed for the submission of a title and description.
$variables{'maxtitle'} = "24";
$variables{'maxdescription'} = "100";

#######################
# Send out a report at the end of the day to any webmaster who requests it (when signing up).
#	About: This might only be bad if you have a slow server and many members, as it could take too long.
# Yes = 1	No = 0
$variables{'report'} = "1";

#######################
# Do you want to receive an e-mail notification every time a new site joins?
# Yes = 1	No = 0
$variables{'emailwebmaster'} = "1";

#######################
# Make links of sites--which have not gotten as many hits from your site as they have sent you--stand out more.
#(Recommended)
# Leave these blank if you do not want to give special attention to these sites.
$variables{'standout1'} = '<b>';
$variables{'standout2'} = '</b>';

#######################
# Display 'sign up links' if there is no site to display.
# Yes = 1	No = 0
$variables{'signup'} = "1";

#######################
# Anti-cheating gateway: part or full protection?
# Partial protection: will send incoming visitors straight to your site (redirected).
#					  This protects against SOME forms of cheating.
# Full protection: will require people to click on a "Continue..." link before counting the hit and being sent to your site.
#				   This protects against MOST forms of cheating.
# Part = 0
# Full = 1
$variables{'anticheat'} = "0";

#######################
# For the random site picker: if there is no site to display--which has sent you more, than you have them--
#							  what should be displayed?
# 0 = Nothing
# 1 = ANY Random Site
# 2 = "Your Site?" Join link
$variables{'randshow'} = "1";

#######################
# Do not display sites which have already received X many times more hits from you as they have sent you.
# (eg. If you set this to 5: a site that has sent you 100 hits and that you have sent 500 will not be displayed, until they send you more hits.)
# Set this to zero (0) if you don't care.
$variables{'displaymult'} = "10";

#######################
# How often should the stats be reset? (1 is daily, etc...)
$variables{'resetdays'} = "1";

#######################
# Characters (or words) you don't want webmasters to use in their title or description. Seperate by spaces.
# eg. sex !!! =
$variables{'badchar'} = 'sex !!! =';

#end of variables

##########################################
#### DO NOT edit anything below this! ####
##########################################

sub getdate {
($second, $minute, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime(time);
$realmonth = $month + 1;
$year = reverse $year;
chop($year);
$year = reverse $year;
$date = "$realmonth/$dayofmonth/$year";
}

sub info {
print <<EOF;
<p><br><br><br><br><br><br><br><br><br>
<center><small>
Script by <a href="mailto:wordx\@hotmail.com">Jimmy</a> for <a href="http://www.smartcgis.com" target="_blank">SmartCGIs.com</a>
</small></center>
EOF
}

1;