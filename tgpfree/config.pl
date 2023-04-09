#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);
#################################
### Configuration Settings ######
#################################
#MY SQL INFO
$dbhost = "localhost"; #Database hostname. Can usually be left as is. localhost is the default.
$dbport = "3306"; #Database port number. Can usually be left as is. 3306 is the default.
$user = "username"; #Database username.
$pass = "password"; #Database password
$database = "DBname"; #Database Name

@okaydomains=("http://domain.com", "http://www.domain.com");
$mailprog = "/usr/sbin/sendmail -t";
$adminemail = 'you@domain.com';
$sitename = "Your TGP";
$reciplink = "domain.com"; #This is the domain the script will look for a reciprocal link to.
$adminusername =  "admin";
$adminpassword =  "password";
$requireapproval = "yes";
$timefix = "-1";
$zone = "CDT";
$main_html = "/path/to your/index.shtml"; #This is the path and file name of the main page of your TGP
$cat_html = "/path to your/tgp/archives"; #This is the path to the dir. that all of your archive pages will be built in.
$filesdir = "/path/to your/cgi-bin/tgp/files";
$adminurl = "http://www.domain.com/cgi-bin/tgp/admin.cgi";
$cgiurl = "http://www.domain.com/cgi-bin/tgp";

####################################################################
######### No need to modify below this point #######################
####################################################################

$category_db = "$filesdir/categories.db";
$pid_db =  "$filesdir/pid.txt";
$banlist = "$filesdir/banlist.txt";
$domainlist = "$filesdir/domainlist.txt";
$options_db = "$filesdir/options.txt";
$botoptions_db = "$filesdir/botoptions.txt";
$linetemp = "$filesdir/templates/line.temp";
$header_txt = "$filesdir/templates/header.temp";
$footer_txt = "$filesdir/templates/footer.temp";
$archheader_txt = "$filesdir/templates/archive_header.temp";
$archfooter_txt = "$filesdir/templates/archive_footer.temp";
$noreciptemp = "$filesdir/templates/no_reciprocal_link.temp";
$successpage = "$filesdir/templates/submission_accepted.temp";
$bannedpage = "$filesdir/templates/banned_user.temp";
$domainpage = "$filesdir/templates/domain_blacklisted.temp";
$excessiveposts = "$filesdir/templates/excessive_posts.temp";
$duplicateerror = "$filesdir/templates/duplicate_post_error.temp";
$texterror = "$filesdir/templates/banned_text_error.temp";
$maintemp = "$filesdir/templates/main_page.temp";
$archtemp = "$filesdir/templates/archives.temp";
$postverified = "$filesdir/templates/post_verified.temp";
$blind = "$filesdir/templates/blind.temp";
$texterror = "$filesdir/templates/banned_text_error.temp";
###FILES###
$police_pl = "$cgiurl/police.cgi";
###MAIL TEMPLATES###
$recmail = "$filesdir/templates/confirm_email.mail";
$submail = "$filesdir/templates/submission_received.mail";
$appmail = "$filesdir/templates/submission_approved.mail";
$decmail = "$filesdir/templates/submission_declined.mail";
$version = "1.1";
$creator = "http://www.TGPDevil.com";
$creator_email = "support\@tgpdevil.com";
sub error {
	
print "	<html>\n";
print "\n";
print "<head>\n";
print "<title>Submission Error</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"$bg_color\">\n";
print "\n";
print "<dl>\n";
print "<dd align=\"center\"><p align=\"center\"><br>\n";
print "<br>\n";
print "</p>\n";
print "<div align=\"center\"><center><table border=\"0\" width=\"750\" bgcolor=\"black\">\n";
print "<tr>\n";
print "<td width=\"100%\"><div align=\"center\"><center><table border=\"0\" width=\"100%\"\n";
print "bgcolor=\"#FFFFFF\" cellspacing=\"4\" cellpadding=\"9\">\n";
print "<tr>\n";
print "<td width=\"100%\"><div align=\"center\"><center><table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"35%\"><big><font face=\"Arial\"><big>Submission Error</big></font></big></td>\n";
print "<td width=\"65%\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\">&nbsp;<hr width=\"80%\" size=\"1\">\n";
print "<p><font face=\"Arial\">There has been an error on the form you filled out. </font><ul>\n";
print "<li><strong><font face=\"Arial\">Reason:\n";

}

sub error2 {
print "\n";
print "</font></strong></li>\n";
print "</ul>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\"><font face=\"Arial\">Please use the BACK button on your browser to correct\n";
print "this problem.</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\"><hr width=\"80%\" size=\"1\">\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div></dd>\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "</dl>\n";
print "</body>\n";
print "\n";
print "</html>\n";
exit;

}