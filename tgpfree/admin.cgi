#!/usr/bin/perl
require "config.pl";
require HTTP::Request; 
require LWP::UserAgent;
require "funct.pm";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
use MIME::Base64 ();


read(STDIN, $namevalues, $ENV{'CONTENT_LENGTH'});
@namevalues = split(/&/, $namevalues);
foreach $namevalue (@namevalues) {
($name, $value) = split(/=/, $namevalue);
$name =~ tr/+/ /;
$value =~ tr/+/ /;
$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$INPUT{$name} = $value;
}
if ($adminusername ne $INPUT{'adminuser'} || $adminpassword ne 
$INPUT{'adminpass'}) {
       print "Content-type: text/html\n\n";
       &login;
       exit;
}

        #Anyone happen to know what today is?
                $isnow=time;
                @numdays = (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
                ($sec, $min, $hr, $day, $mon, $year) = localtime;
                $year += 1900;
                $min = "0$min" if $min < 10;
                $sec = "0$sec" if $sec < 10;
                $realday = "$day";
                $sse = $hr;

                $hr += $timefix;
                if($hr >= 24) {
                        $hr -= 24;
                        $day++;
                        if($day > $numdays[$mon]) {
                                $mon++;
                                $day = 1;
                        }
                }
                if ($hr < 0) {
                        $hr += 24;
                        $day--;
                        if(!$day) {
                                $mon--;
                                $day = $numdays[$mon];
                        }
                }
                $mon++;
                $moncode = "$mon";
                $moncode = "0$mon" if $mon < 10;
                $xm = ($hr > 11) ? 'pm' : 'am';
                $hr = 12 if ($hr == 0);
                $hr -= 12 if ($hr > 12);
				$bday = $day;
                $day = "0$day" if $day < 10;

                $when = "$mon/$realday/$year at $hr:$min$xm $zone";
                $whenlocal = "$hr:$min$xm $zone";
                $whenserver = "$sse:$min:$sec";
                $date_today = "$mon/$realday/$year";
                $datecode = "$year$moncode$day";

## Read in options
open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10)=split(/::/, $poi);

open(Q, "$tgpoptions_db") || print "Cant open $tgpoptions_db REASON ($!)";
$tgpb = <Q>;
close(Q);
($tgp1,$tgp2,$tgp3,$tgp4)=split(/::/, $tgpb);

$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");

#Declare some variables
$adminname = $INPUT{'adminuser'};
$pass= $INPUT{'adminpass'};
# Done declaring variables

#Specify a content type
print "Content-type: text/html\n\n";

 if (@okaydomains == 0) {return;}
  $DOMAIN_OK=0;                                         
  $RF=$ENV{'HTTP_REFERER'};                             
  $RF=~tr/A-Z/a-z/;                                     
  foreach $ts (@okaydomains)                            
   {                                                    
     if ($RF =~ /$ts/)                                  
      { $DOMAIN_OK=1; }
   }                                                    
   if ( $DOMAIN_OK == 0)                                
     { 
 &login;    
      exit;
     } 

#Do the dirty work
        if($INPUT{'loginadmin'}) { &domain; }
        elsif ($INPUT{'appdec'}) { &doappform; }
        elsif ($INPUT{'mailform'}) { &message; }
        elsif ($INPUT{'setapproval'}) { &setapproval; }
        elsif ($INPUT{'searchfor'}) { &searchfor; }
        elsif ($INPUT{'dosearch'}) { &dosearch; }
        elsif ($INPUT{'editpost'}) {&editpost;}
        elsif ($INPUT{'editnow'}) {&editnow;}
        elsif ($INPUT{'deletenow'}) {&deletenow;}
        elsif ($INPUT{'rebuild'}) {&generate;}
        elsif ($INPUT{'genarch'}) {&message;}
        elsif ($INPUT{'editbanlist'}) {&message;}
        elsif ($INPUT{'editdomlist'}) {&message;}
        elsif ($INPUT{'modifytemp'}) {&modifytemp;}
        elsif ($INPUT{'open_page'}) {&modifytemp;}
        elsif ($INPUT{'savetemplate'}) {&savetemplate;}
        elsif ($INPUT{'modifyoptions'}) {&modifyoptions;}
        elsif ($INPUT{'saveoptions'}) {&saveoptions;}
        elsif ($INPUT{'temptags'}) {&temptags;}
        elsif ($INPUT{'savenewtag'}) {&savenewtag;}
        elsif ($INPUT{'searchtags'}) {&searchtags;}
        elsif ($INPUT{'edittag'}) {&edittag;}
        elsif ($INPUT{'remtag'}) {&remtag;}
        elsif ($INPUT{'modtag'}) {&modtag;}
        elsif ($INPUT{'modifymail'}) {&message;}
        elsif ($INPUT{'open_mail'}) {&message;}
        elsif ($INPUT{'savemail'}) {&message;}
        elsif ($INPUT{'bulkdelete'}) {&bulkdelete;}
        elsif ($INPUT{'dodeletes'}) {&dodeletes;}
        elsif ($INPUT{'savenewpost'}) {&savenewpost;}
        elsif ($INPUT{'managecats'}) {&managecats;}
        elsif ($INPUT{'deletecat'}) {&deletecat;}
        elsif ($INPUT{'addcat'}) {&addcat;}
        elsif ($INPUT{'modifyads'}) {&message;}
        elsif ($INPUT{'open_ad'}) {&modifyads;}
        elsif ($INPUT{'addpost'}) {&addpost;}
        elsif ($INPUT{'blindtags'}) {&message;}
        elsif ($INPUT{'editblind'}) {&message;}
        elsif ($INPUT{'modblind'}) {&message;}
        elsif ($INPUT{'police'}) {&message;}
        elsif ($INPUT{'botsettings'}) {&message;}
        elsif ($INPUT{'botresults'}) {&message;}
        elsif ($INPUT{'decmess'}) {&message;}
        elsif ($INPUT{'choose'}) {&choose;}
        elsif ($INPUT{'moddec'}) {&message;}
        elsif ($INPUT{'editbantextlist'}) {&message;}
        elsif ($INPUT{'appall'}) {&message;}
        elsif ($INPUT{'decall'}) {&message;}
#
        elsif ($INPUT{'tgpbaseoptions'}) {&tgpbaseoptions;}
        elsif ($INPUT{'deletecatrename'}) {&deletecatrename;}
        elsif ($INPUT{'savecatrename'}) {&savecatrename;}
        elsif ($INPUT{'savetgpbaseoptions'}) {&savetgpbaseoptions;}
        elsif ($INPUT{'gogetemboy'}) {&gogetemboy;}
        elsif ($INPUT{'makemoney'}) {&blingbling;}
        else { &login; }

## Print login page
sub login {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>$sitetitle Administration</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p><big><font color=\"#000000\" face=\"Arial\"><big>TGP Devil System Administration:</big></font></big></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<p><font face=\"Arial\">Please enter your login username and password to access your\n";
print "administration.</font></p>\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<div align=\"center\"><center><table border=\"0\" width=\"36%\" bgcolor=\"#E6E7C9\"\n";
print "cellpadding=\"2\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"100%\" colspan=\"2\" bgcolor=\"#48486F\"><font face=\"Arial\" color=\"#FFFFFF\"><strong>Login:</strong></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"30%\"><strong><font face=\"Arial\">Username:</font></strong></td>\n";
print "<td width=\"70%\"><input type=\"text\" NAME=\"adminuser\" size=\"28\"\n";
print "style=\"background-color: rgb(223,223,223); font-weight: bold; color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"30%\"><strong><font face=\"Arial\">Password:</font></strong></td>\n";
print "<td width=\"70%\"><input type=\"password\" name=\"adminpass\" size=\"28\"\n";
print "style=\"background-color: rgb(223,223,223); font-weight: bolder\"></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"30%\">.</td>\n";
print "<td width=\"70%\"><input type=\"submit\" value=\"Submit\" name=\"loginadmin\"> * <input\n";
print "type=\"reset\" value=\"Reset\" name=\"B1\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<p><font face=\"Arial\"><strong>Powered By:</strong> <a href=\"http://www.tgpdevil.com\">TgpDevil \n";
print "TGP System</a></font></p>\n";
print "</body>\n";
print "</html>\n";
}


sub domain{
if ($pass eq $pass) {
if ($adminusername eq $adminname) {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>$sitename Administration</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<b><font color=\"#000000\" face=\"Verdana\">\n";
print "\n";
print "<p></font></b><big><big><font face=\"Arial\"><font color=\"#000000\">$sitename System\n";
print "Administration:</font> </font></big><font color=red>\n";

if ($INPUT{'rebuild'}){
print "  <font face=\"Verdana\" color=\"red\"><B>TGP was updated!</b></font><BR>\n";
}
elsif ($INPUT{'genarch'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Archive pages were rebuilt.</b></font><BR>\n";
}
elsif ($INPUT{'setapproval'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Database updated.<BR>Changes will take effect on next rebuild.</b></font><BR>\n";
}
elsif ($INPUT{'savebanlist'}){
print "  <font face=\"Verdana\" color=\"red\"><B>IP ban list updated.</b></font><BR>\n";
}
elsif ($INPUT{'savedomlist'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Domain ban list updated.</b></font><BR>\n";
}
elsif ($INPUT{'savetemplate'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Modified template was saved.</b></font><BR>\n";
}
elsif ($INPUT{'saveoptions'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Program options were modified.</b></font><BR>\n";
}
elsif ($INPUT{'dodeletes'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Posts made on or before $INPUT{'delmonth'}/$INPUT{'delday'}/$INPUT{'delyear'} were deleted.</b></font><BR>\n";
}
elsif ($INPUT{'savead'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Ad for $INPUT{'edited'} category was modified.</b></font><BR>\n";
}
elsif ($INPUT{'savemodtext'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Banned text was modified.</b></font><BR>\n";
}
elsif ($INPUT{'delbantext'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Banned text was deleted.</b></font><BR>\n";
}
elsif ($INPUT{'deleteallday'}){
print "  <font face=\"Verdana\" color=\"red\"><B>All posts from selected date were deleted.</b></font><BR>\n";
}
elsif ($INPUT{'approveallday'}){
print "  <font face=\"Verdana\" color=\"red\"><B>All posts from selected date were approved.</b></font><BR>\n";
}

print "</font>";

print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";

        my $sth = $dbh->prepare("SELECT COUNT(*) FROM DMtgpgalleries WHERE approval = '1' and VERMAIL = '1'") or die "Unable to prepare query: ".$dbh->errstr;
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        my $alink = $sth->fetchrow;

        my $sth = $dbh->prepare("SELECT COUNT(*) FROM DMtgpgalleries WHERE approval = '0' and VERMAIL = '1'") or die "Unable to prepare query: ".$dbh->errstr;
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        my $wlink = $sth->fetchrow;


$date = localtime;
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$INPUT{'adminuser'}\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$INPUT{'adminpass'}\"><div align=\"center\"><center><table border=\"0\"\n";
print "width=\"85%\" style=\"border: 2px solid rgb(0,0,0)\" cellpadding=\"3\" cellspacing=\"0\">\n";
print "<tr>\n";
print "<td width=\"32%\" colspan=\"2\" bgcolor=\"#48486F\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Administrative\n";
print "Options:</strong></font></td>\n";
print "<td width=\"27%\" colspan=\"2\" bgcolor=\"#48486F\"><div align=\"left\"><p><font color=\"#48486F\">.</font></td>\n";
print "<td width=\"41%\" colspan=\"2\" bgcolor=\"#48486F\"><small><font color=\"#FFFFFF\" face=\"Arial\"><div\n";
print "align=\"center\"><center><p></font><font face=\"Arial\" color=\"#FFFF00\"><small>$date</small></font></small></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#ff8000\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><font\n";
print "color=\"#FFFFFF\" face=\"Arial\"><strong>Basic Options</strong></font></td>\n";
print "<td width=\"11%\" bgcolor=\"#FF8000\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><font\n";
print "color=\"#FF8000\">.</font></td>\n";
print "<td width=\"24%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0)\"\n";
print "bgcolor=\"#ff8000\" align=\"left\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Template Options</strong></font></td>\n";
print "<td width=\"12%\" bgcolor=\"#ff8000\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><font\n";
print "color=\"#ff8000\">.</font></td>\n";
print "<td width=\"38%\" bgcolor=\"#48486F\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 0px none; border-bottom: 2px none rgb(0,0,0)\"\n";
print "colspan=\"2\"><font color=\"#48486F\">.</font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Approve/Decline Posts:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><input\n";
print "type=\"submit\" value=\"Submit\" name=\"choose\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0)\"\n";
print "bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Manage\n";
print "Template Tags:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><input\n";
print "type=\"submit\" value=\"Submit\" name=\"temptags\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#48486F\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 0px none; border-bottom: 2px solid rgb(0,0,0)\"\n";
print "colspan=\"2\"><div align=\"center\"><center><p><font color=\"#FFFFFF\" face=\"Arial\"><strong>DAILY\n";
print "TASKS</strong></font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Search\n";
print "Posts:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"searchfor\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Manage Decline Messages: </b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"decmess\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#F5F5EB\" style=\"border-left: 2px solid rgb(0,0,0)\" align=\"center\"\n";
print "colspan=\"2\"><input type=\"submit\" value=\"Review Submissions\" name=\"choose\"\n";
print "style=\"font-weight: bold; background-color: rgb(255,255,255); color: rgb(72,72,111)\"></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Delete\n";
print "Posts:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"bulkdelete\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Modify Templates:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"modifytemp\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#DCDDD9\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"\n";
print "align=\"center\" colspan=\"2\"><input type=\"submit\" value=\"Rebuild Gallery\" name=\"rebuild\"\n";
print "style=\"background-color: rgb(255,255,255); color: rgb(72,72,111); font-weight: bold\"></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Manually \n";
print "Add Posts:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"addpost\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Modify Email Mesages:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"modifymail\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#F5F5EB\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-bottom: 2px none rgb(0,0,0)\" align=\"center\"\n";
print "colspan=\"2\"><input type=\"submit\" value=\"Rebuild Archive\" name=\"genarch\"\n";
print "style=\"font-weight: bold; background-color: rgb(255,255,255); color: rgb(72,72,111)\"></font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Manage Categories\n";
print ":</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"managecats\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-right: 2px none rgb(0,0,0); border-top: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"\n";
print "bgcolor=\"#ff8000\" align=\"left\"><strong><font color=\"#FFFFFF\" face=\"Arial\">Other Options:</font></strong></td>\n";
print "<td width=\"12%\" bgcolor=\"#ff8000\" align=\"left\"\n";
print "style=\"border-right: 2px none rgb(0,0,0); border-top: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"><font\n";
print "color=\"#ff8000\">.</font></td>\n";
print "<td width=\"38%\" bgcolor=\"#FF8000\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"\n";
print "align=\"left\" colspan=\"2\"><strong><font color=\"#FFFFFF\" face=\"Arial\">System Information:</font></strong></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Modify\n";
print "Program Options:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"modifyoptions\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Manage Blind Links: </b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"blindtags\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"37%\" bgcolor=\"#F5F5EB\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"\n";
print "align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><strong>Total Active Links:</strong></small></font></small></td>\n";
print "<td width=\"3%\" bgcolor=\"#F5F5EB\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\"\n";
print "align=\"left\"><font color=\"#FF0000\" face=\"Arial\"><strong>$alink</strong></font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Check Cheat Reports\n";
print ": </b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"police\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Manage Archive Ads: </b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"modifyads\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"37%\" bgcolor=\"#DCDDD9\" style=\"border-left: 2px solid rgb(0,0,0)\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><strong>Waiting Approval Links:</strong></small></font></small></td>\n";
print "<td width=\"3%\" bgcolor=\"#DCDDD9\" style=\"border-left: 2px solid rgb(0,0,0)\" align=\"left\"><font\n";
print "color=\"#FF0000\" face=\"Arial\"><strong>$wlink</strong></font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#F5F5EB\" align=\"left\">\n";
print "<small><font color=\"#800000\" face=\"Arial\"><b>Link\n";
print "Bot Settings:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"botsettings\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Edit IP Ban List:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"editbanlist\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#F5F5EB\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0)\" align=\"left\"\n";
print "colspan=\"2\"><small><font face=\"Arial\"><strong>Created By: <a href=\"$creator\">$creator</a></strong></font><font\n";
print "face=\"Arial\" color=\"#F5F5EB\">.</font></small></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" align=\"left\">\n";
print "<small><font color=\"#800000\" face=\"Arial\"><b>Check\n";
print " Bot Report:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"botresults\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Edit Domain Ban List:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"editdomlist\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#DCDDD9\" style=\"border-left: 2px solid rgb(0,0,0)\" align=\"left\"\n";
print "colspan=\"2\"><small><font face=\"Arial\" color=\"#DCDDD9\"></font><strong><font face=\"Arial\">E-Mail:\n";
print "<a href=\"mailto:$creator_email\">$creator_email</a> </font></strong></small></td>\n";
print "</tr>\n";
##
print "<tr align=\"center\">\n";
print "<td width=\"24%\" bgcolor=\"#F5F5EB\" align=\"left\">\n";
print "<small><font color=\"#800000\" face=\"Arial\"><b>Email\n";
print "Previous Submitters:</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"mailform\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"24%\" style=\"border-left: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Edit Banned Text List:</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#F5F5EB\" align=\"left\"><input type=\"submit\" value=\"Submit\"\n";
print "name=\"editbantextlist\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\"></td>\n";
print "<td width=\"38%\" bgcolor=\"#F5F5EB\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0)\" align=\"left\"\n";
print "colspan=\"2\"><small><font face=\"Arial\"><strong>ICQ: 4445137</strong></font><font\n";
print "face=\"Arial\" color=\"#F5F5EB\">.</font></small></td>\n";
print "</tr>\n";
print "</table><BR><BR>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\"><BR>\n";
print "<table width=\"60%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#48486F\"> \n";
print "<td colspan=\"3\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#FFFFFF\">TGPBase.com \n";
print "Management</font></b> </font></div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#FF8000\" bordercolor=\"#000000\"> \n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><b>Get \n";
print "TGPBase Galleries</b></font></div>\n";
print "</td>\n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><b>TGPBase \n";
print "Options</b></font></div>\n";
print "</td>\n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><b>Make \n";
print "Money</b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr bordercolor=\"#000000\"> \n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"submit\" name=\"gogetemboy\" value=\"Submit\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</div>\n";
print "</td>\n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\" bgcolor=\"#F5F5EB\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"submit\" name=\"tgpbaseoptions\" value=\"Submit\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</div>\n";
print "</td>\n";
print "<td style=\"border-top: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"submit\" name=\"makemoney\" value=\"Submit\" style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "<BR><a href=\"http://www.tgpdevil.com\"><IMG SRC=\"http://www.tgpdevil.com/versions/v11free.gif\" border=\"0\"></a>\n";
print "</center></div>\n";
print "</form>\n";

print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";





exit;
}}
&error;
print "Invalid Username and Password Combo. ( This is case sensitive )";
&error2;
}



sub choose {
print "<html>\n";
print "<head>\n";
print "<title>Galleries Pending Approval</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Galleries Pending \n";
print "Review : </big></font></p>\n";
print "<hr size=\"1\" color=\"#800000\"> \n";
print "<table width=\"45%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Date</font> \n";
print "</b></font>\n";
print "</td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Pending \n";
print "Review</font> </b></font>\n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<div align=\"center\"><b><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\"># to \n";
print "view</font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Review</font> \n";
print "</b></font>\n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Bulk Process</font> \n";
print "</b></font>\n";
print "</td>\n";
print "</tr>\n";

        my($query) = "SELECT DISTINCT webdate FROM DMtgpgalleries WHERE approval = '0' AND vermail = '1' ORDER BY datecode";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@datez = $sth->fetchrow)  {

                my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE webdate = '$datez[0]' AND approval='0' AND vermail = '1'") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $cou = $sth->fetchrow;


print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"18%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"><font color=\"#000000\"><b><font face=\"Arial\">$datez[0] \n";
print "</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"19%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"><font color=\"#000000\"><b><font face=\"Arial\">$cou \n";
print "</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<input type=\"text\" name=\"revnum\" value=\"50\" size=\"5\">\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<input type=\"hidden\" name=\"appdate\" value=\"$datez[0]\">\n";
print "<input type=\"submit\" name=\"appdec\" value=\"Submit\">\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<input type=\"submit\" name=\"appall\" value=\"Approve All Submitted This Day\"><BR>\n";
print "<input type=\"submit\" name=\"decall\" value=\" Decline All Submitted This Day \">\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "</tr></form>\n";
}


print "</table>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";

exit;
}


## Print approve/deny form
sub doappform {

my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE approval = '0' AND vermail = '1' ") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $pending = $sth->fetchrow;

        my($query) = "SELECT decname FROM DMtgpdeclines ORDER BY 'decname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@decs = $sth->fetchrow)  {
                push (@deco, "$decs[0]\|\|");
        }
print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Approve or Decline Galleries</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"white\" TEXT=\"black\" LINK=\"blue\" VLINK=\"red\" ALINK=\"yellow\">\n";
print "<font color=\"#000000\" face=\"Arial\" size=\"5\"><b>\n";
print "\n";
print "<p align=\"left\">Submissions pending approval - <font color=red>$pending</font></b></font></p>\n";
print "<div align=\"center\"><center>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\" width=\"100%\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"94%\" bordercolor=\"#FFFFFF\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\"\n";
print "color=\"#FFFFFF\" size=\"3\">Poster/IP Address</font></strong></td>\n";
print "<td width=\"40%\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\"\n";
print "color=\"#FFFFFF\" size=\"3\"># of pics & description. / URL</font></strong></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\"\n";
print "color=\"#FFFFFF\" size=\"3\">Category </font></strong></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\"\n";
print "color=\"#FFFFFF\" size=\"3\">Approve</font></strong></td>\n";
print "</tr>\n";
print "<tr>\n";

    $liono = 0;

 my ( $webname, $webemail, $weburl, $webcate, $webpics, $webdesc, $webdate, $datecode, $approval, $idnum, $webip, $uniqueid, $vermail, $stamp );
        my($query) = "SELECT * FROM DMtgpgalleries WHERE webdate = '$INPUT{'appdate'}' AND vermail = '1' AND approval != '1' ORDER BY webip LIMIT $INPUT{'revnum'}";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        $sth->bind_columns( undef, \$webname, \$webemail, \$weburl, \$webcate, \$webpics, \$webdesc, \$webdate, \$datecode, \$approval, \$idnum, \$webip, \$uniqueid, \$vermail, \$stamp );

        while ( $sth->fetch ) {
        $liono++;
        if ($liono % 2) {
        $rowcolor = "#DCDDD9";
} else {
$rowcolor = "silver";
}
                print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"$rowcolor\" align=\"center\"><font face=\"Verdana\" size=\"1\"><a href=\"mailto:$webemail\">$webname</a><BR>$webip</font></td>\n";
print "<td width=\"40%\" bgcolor=\"$rowcolor\" align=\"center\"><font face=\"Verdana\" size=\"1\">$webpics - $webdesc</font><BR><a href=\"$weburl\" target=\"_blank\"><font face=\"Verdana\" size=\"1\">$weburl</font></a></td>\n";
print "<td width=\"20%\" bgcolor=\"$rowcolor\" align=\"center\">\n";
print "<select name=\"catt\">\n";
print "<option value=\"$webcate\|\|$idnum\">$webcate</option>\n";
        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@rowz = $sth->fetchrow)  {


        print "<option value=\"$rowz[0]\|\|$idnum\">$rowz[0]</option>\n";
}
print "</select>\n";
print "<td width=\"20%\" bgcolor=\"$rowcolor\" align=\"center\">\n";
print "<p><font face=\"Verdana\" color=\"#FF0000\" size=\"1\">No</font><input type=\"radio\" name=\"$idnum\" value=\"delete\"><font face=\"Verdana\" color=\"blue\" size=\"1\">Yes<input type=\"radio\" name=\"$idnum\" value=\"keep\"></font></p>\n";
print "</td>\n";
print "</tr>\n";
}
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "\n";
print "\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<p align=\"center\"><input type=\"Submit\" value=\"Update Database\" name=\"setapproval\">    <input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></p>\n";
print "</form>\n";
print "  <p align=\"center\"></p>\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "</body>\n";
print "\n";
print "</html>\n";
exit;
}

## Print search form
sub searchfor {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Search for users</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" size=\"4\" color=\"#000000\"><big>Search for users</big></font></p>\n";
print "\n";
print "<hr width=\"75%\" size=\"1\" align=\"left\" color=\"#800000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"password\" value=\"password\"><input type=\"hidden\" name=\"dosearch\"\n";
print "value=\"dosearch\"><input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input\n";
print "type=\"hidden\" name=\"adminpass\" value=\"$pass\"><p><strong><font face=\"Arial\">Please\n";
print "enter the content you wish to search for. </font></strong></p>\n";
print "<table border=\"0\" width=\"65%\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"0\">\n";
print "<tr>\n";
print "<td width=\"100%\" colspan=\"2\" bgcolor=\"#48486F\"><strong><font color=\"#FFFFFF\" face=\"Arial\">Search\n";
print "Information:</font></strong></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"34%\" bgcolor=\"#E6E7C9\"><font face=\"Arial\"><strong>Search postings where:</strong></font></td>\n";
print "<td width=\"85%\" bgcolor=\"#E6E7C9\"><font color=\"#FFFFFF\" face=\"Verdana\"><big><b><select\n";
print "name=\"searchparam\" size=\"1\">\n";
print "<option value=\"webname\">Submitter Name</option>\n";
print "<option value=\"webip\">Submitter IP Address</option>\n";
print "<option value=\"webemail\">Submitter Email</option>\n";
print "<option value=\"weburl\" selected>Gallery URL</option>\n";
print "<option value=\"webdate\">Submission Date</option>\n";
print "<option value=\"webdesc\">Description</option>\n";
print "<option value=\"webcate\">Category</option>\n";
print "</select></b></big></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"34%\" bgcolor=\"#E6E7C9\">.</td>\n";
print "<td width=\"85%\" bgcolor=\"#E6E7C9\"><font color=\"#FFFFFF\" face=\"Verdana\"><big><b><select\n";
print "name=\"searchtype\" size=\"1\">\n";
print "<option value=\"IS\" selected>IS</option>\n";
print "<option value=\"LIKE\">IS LIKE</option>\n";
print "</select></b></big></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"34%\" bgcolor=\"#E6E7C9\">.</td>\n";
print "<td width=\"85%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\"><input type=\"text\" name=\"tofind\"\n";
print "size=\"49\"></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"34%\" bgcolor=\"#DCDDD9\">.</td>\n";
print "<td width=\"85%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\"><input type=\"submit\"\n";
print "name=\"dosearch\" value=\"Begin Search\"></font> * <input type=\"submit\" name=\"loginadmin\"\n";
print "value=\"Back to main menu\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "</form>\n";
print "\n";
print "<hr width=\"75%\" size=\"1\" align=\"left\" color=\"#800000\">\n";
print "</body>\n";
print "</html>\n";
print "\n";

exit;
}

## Do the search
sub dosearch {
print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Approve or Decline Galleries</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminpass\" value=\"$pass\"><input type=\"hidden\"\n";
print "name=\"adminuser\" value=\"$adminname\"><table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\"><big><big><big>Search Results:</big></big></big></font></td>\n";
print "<td width=\"33%\"><div align=\"center\"><center><p><input type=\"submit\" value=\"New Search\"\n";
print "name=\"searchfor\"\n";
print "style=\"background-color: rgb(255,255,255); color: rgb(128,0,0); font-weight: bold\"></td>\n";
print "<td width=\"34%\"><div align=\"center\"><center><p><input type=\"submit\" value=\"Main Menu\"\n";
print "name=\"loginadmin\"\n";
print "style=\"font-weight: bold; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";

print "<hr width=\"100%\" size=\"1\" align=\"center\" color=\"#800000\">\n";
print "<div align=\"center\"><center>\n";
print "\n";
print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"80%\" bordercolor=\"#FFFFFF\">\n";
print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>Poster</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>URL</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>Description</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>Category</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>Edit</b></font></td>\n";
print "</tr>\n";


  #DO QUERY
if ($INPUT{'searchtype'} eq "IS"){
my($query) = "SELECT * FROM DMtgpgalleries WHERE $INPUT{'searchparam'} = '$INPUT{'tofind'}' AND approval = '1' AND vermail = '1'";
$spank = $query;
}
else {
        my($query) = "SELECT * FROM DMtgpgalleries WHERE $INPUT{'searchparam'} LIKE '%$INPUT{'tofind'}%' AND approval = '1' AND vermail = '1'";
        $spank = $query;
}

        my($sth) = $dbh->prepare($spank);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {

print " <tr>\n";
print "<td><form method=\"POST\" action=\"$adminurl\" target=\"_blank\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">\n";
print " \n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"center\"><font\n";
print "face=\"Verdana\" size=\"1\" color=\"#800000\"><a href=\"mailto:$row[1]\">$row[0]</a><br>\n";
print "$row[10]</font></td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"left\"><font face=\"Verdana\" size=\"1\"\n";
print "color=\"#800000\"><a href=\"$row[2]\" target=\"_blank\">$row[2]</a></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"left\"><font face=\"Verdana\" size=\"1\"\n";
print "color=\"#800000\">$row[5]</font></td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"left\"><font face=\"Verdana\" size=\"1\"\n";
print "color=\"#800000\">$row[3]</font></td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"center\"><!--webbot bot=\"HTMLMarkup\" startspan --><INPUT type=\"hidden\" name=\"id\" value=\"$row[9]\"><!--webbot\n";
print "bot=\"\n";
print "HTMLMarkup\" endspan --><input type=\"Submit\" value=\"Edit Post\" name=\"editpost\" style=\"background-color: rgb(72,72,111); color: rgb(255,255,255); font-weight: bold\"> </td>\n";
print "</tr></form>\n";

}
print "</table>\n";
print "</center></div>\n";
print "\n";
print "<hr width=\"100%\" size=\"1\" align=\"center\" color=\"#800000\">\n";


print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminpass\" value=\"$pass\"><input type=\"hidden\"\n";
print "name=\"adminuser\" value=\"$adminname\"><table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\"><big><big><big></big></big></big></font></td>\n";
print "<td width=\"33%\"><div align=\"center\"><center><p><input type=\"submit\" value=\"New Search\"\n";
print "name=\"searchfor\"\n";
print "style=\"background-color: rgb(255,255,255); color: rgb(128,0,0); font-weight: bold\"></td>\n";
print "<td width=\"34%\"><div align=\"center\"><center><p><input type=\"submit\" value=\"Main Menu\"\n";
print "name=\"loginadmin\"\n";
print "style=\"font-weight: bold; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";




print "<p align=\"center\">&nbsp;</p>\n";
print "</body>\n";
print "</html>\n";


exit;

}


## Set approval or delete if not approved.
sub setapproval {
foreach $namevalue (@namevalues) {
($name, $value) = split(/=/, $namevalue);
$name =~ tr/+/ /;
$value =~ tr/+/ /;
$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$INPUT{$name} = $value;
if ($value eq "keep"){
my $qy = "UPDATE DMtgpgalleries SET approval = '1' WHERE idnum ='$name'";
$dbh->do($qy);


($catt,$pnum)=split(/\|\|/, $INPUT{'catt'});
my $qy = "UPDATE DMtgpgalleries SET webcate = '$catt' WHERE idnum ='$pnum'";
$dbh->do($qy);

if ($pont7 eq "yes"){
        &appmail;
}
}
#if ($value eq "delete"){
$matcher = "delete";
if("$value" =~ /^$matcher/i) {
$reason = $value;
if ($pont8 eq "yes"){
        &decmail;
}
my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$name'";
$dbh->do($qy);
}
}
&domain;
}


## Print edit entry page
sub editpost {
        my($query) = "SELECT * FROM DMtgpgalleries WHERE idnum = '$INPUT{'id'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Post</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p><big><big><big><font face=\"Arial\">Edit Post:</font></big></big></big></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\" width=\"70%\">\n";
print "\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\" align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"hidden\" name=\"pidnum\" value=\"$row[9]\"><table width=\"528\" border=\"0\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\" width=\"520\" colspan=\"2\"><strong><font face=\"Arial\" color=\"#FFFFFF\">Edit\n";
print "Information Below</font></strong></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"123\"><b><div align=\"left\"><p><font\n";
print "color=\"#000000\" face=\"Arial\">Name</b> </font></td>\n";
print "<td align=\"left\" bgcolor=\"#DCDDD9\" width=\"397\"><input type=\"text\" name=\"pname\"\n";
print "value=\"$row[0]\" size=\"30\"> </td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"123\"><b><div align=\"left\"><p><font\n";
print "color=\"#000000\" face=\"Arial\">URL</b> </font></td>\n";
print "<td align=\"left\" bgcolor=\"#DCDDD9\" width=\"397\"><input type=\"text\" name=\"purl\" size=\"30\"\n";
print "value=\"$row[2]\"> </td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"123\"><b><div align=\"left\"><p><font\n";
print "color=\"#000000\" face=\"Arial\">Description</b> </font></td>\n";
print "<td align=\"left\" bgcolor=\"#DCDDD9\" width=\"397\"><input type=\"text\" name=\"pdesc\" size=\"30\"\n";
print "value=\"$row[5]\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"123\"><b><div align=\"left\"><p><font\n";
print "color=\"#000000\" face=\"Arial\">Category</b> </font></td>\n";
print "<td align=\"left\" bgcolor=\"#DCDDD9\" width=\"397\"><select name=\"pcat\" size=\"1\">\n";
print "<option value=\"$row[3]\" selected>$row[3]</option>\n";


        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@rowz = $sth->fetchrow)  {


        print "<option value=\"$rowz[0]\">$rowz[0]</option>\n";
}

print "</select> </td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"123\"></td>\n";
print "<td align=\"center\" bgcolor=\"#E6E7C9\" width=\"397\"><div align=\"left\"><p><input type=\"submit\"\n";
print "name=\"editnow\" value=\"Change Post\"> * <input type=\"submit\" name=\"deletenow\"\n";
print "value=\"Delete Post\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\" width=\"70%\">\n";
print "</body>\n";
print "</html>\n";

exit;
}
}

## Edit entry in DB
sub editnow {
        my        $qy = "UPDATE DMtgpgalleries SET webname = '$INPUT{'pname'}' where idnum = '$INPUT{'pidnum'}'";
         $dbh->do($qy);

         my        $qy = "UPDATE DMtgpgalleries SET weburl = '$INPUT{'purl'}' where idnum = '$INPUT{'pidnum'}'";
         $dbh->do($qy);

         my $qy = "UPDATE DMtgpgalleries SET webdesc = '$INPUT{'pdesc'}' where idnum = '$INPUT{'pidnum'}'";
         $dbh->do($qy);

         my $qy = "UPDATE DMtgpgalleries SET webcate = '$INPUT{'pcat'}' where idnum = '$INPUT{'pidnum'}'";
         $dbh->do($qy);
         $act = "modified";
         &endmod;
 }

## Delete entry
sub deletenow {
        my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$INPUT{'pidnum'}'";
$dbh->do($qy);
$act="deleted";
&endmod;
}


## Print edit verification
sub endmod {
print "        <html>\n";
print "<head>\n";
print "<title>Done deal!</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#C0C0C0\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "  <p><font color=\"#000000\" face=\"Verdana\"><b>Post has been $act.</b></font></p>\n";
print "  <p><b><font color=\"#000000\" face=\"Verdana\">You may close this window.</font></b></p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}


#################################
#################################
####### NEW GENERATE ############
#################################
#################################

sub generate {

        #Generate the smut catalog
my $sth = $dbh->prepare("SELECT COUNT(approval) FROM DMtgpgalleries WHERE approval = '1' AND vermail = '1' ") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $num_rows = $sth->fetchrow;

        open(TGPMAIN,">$main_html") || print "Can't open $main_html REASON: ($!)\n";
        open(HTML, "$header_txt") || print "Can't open $header_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $later (@html_text) {
        chomp $later;
        $later =~ s/#LINKCOUNT#/$num_rows/g;
        print TGPMAIN "$later\n";
}


        open(HTML, "$maintemp") || print "Can't open $maintemp\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $laters (@html_text) {
        chomp $laters;
        ##

        while ($laters =~ /(%(.+?)%)/) {
        $hoho = $2;
        my($query) = "SELECT * FROM DMtgpblind WHERE linkname = '$hoho' ORDER BY rand()";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
                while(@rowze = $sth->fetchrow)  {
                $linkname = $rowze[0];
                $linkurl = $rowze[1];
                $linkdesc = $rowze[2];
                $numpics = $rowze[3];
                }


        open(LINE, "$blind") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
foreach $laters (@linetemp){
        chomp $laters;
        $laters =~ s/#LINKDESC#/$linkdesc/g;
        $laters =~ s/#LINKURL#/$linkurl/g;
        $laters =~ s/#NUMPICS#/$numpics/g;
        $laters =~ s/#MON#/$mon/g;
        $laters =~ s/#DAY#/$bday/g;
        print TGPMAIN "$laters\n";
        }
        last;
        }
##

##
        while ($laters =~ /(##(.+?)##)/) {
        $hehe = $2;
        my($query) = "SELECT * FROM DMtgptemps WHERE tagname = '$hehe'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
                while(@rowz = $sth->fetchrow)  {
                $tagname = $rowz[0];
                $categ = $rowz[1];
                $startat = $rowz[2];
                $endat = $rowz[3];

        }

         my ( $webname, $webemail, $weburl, $webcate, $webpics, $webdesc, $webdate, $datecode, $approval, $idnum, $webip, $uniqueid, $vermail, $stamp );
        my($query) = "SELECT * FROM DMtgpgalleries WHERE webcate = '$categ' and approval = '1' and vermail = '1' ORDER BY 'idnum' DESC LIMIT $startat, $endat";

        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        $sth->bind_columns( undef, \$webname, \$webemail, \$weburl, \$webcate, \$webpics, \$webdesc, \$webdate, \$datecode, \$approval, \$idnum, \$webip, \$uniqueid, \$vermail, \$stamp );

        while ( $sth->fetch ) {

        open(LINE, "$linetemp") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
$dc = $webdate;
($rday,$rmon,$ryear)=split(/\//, $dc);
foreach $laters (@linetemp){
        chomp $laters;
        $webdesc =~ s/_//;
        $laters =~ s/#LINKDESC#/$webdesc/g;
        $laters =~ s/#LINKURL#/$weburl/g;
        $laters =~ s/#NUMPICS#/$webpics/g;
        $webcate =~ s/ /%20/g;
        $laters =~ s/#CATEG#/$webcate/g;
        $laters =~ s/#IDNUM#/$idnum/g;
        $laters =~ s/#MON#/$rmon/g;
        $laters =~ s/#DAY#/$rday/g;
        print TGPMAIN "$laters\n";
        }
}
last;
}
    $laters =~ s/%(.+?)%//g;
    $laters =~ s/##(.+?)##//g;
        print TGPMAIN "$laters\n";
}
        open(HTML, "$footer_txt") || print "Can't open $footer_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $laters (@html_text) {
        chomp $laters;
        $laters =~ s/#UPDATED#/$when/g;
        print TGPMAIN "$laters\n";
}
	print TGPMAIN "<center><font face=\"Arial\"><a href=\"http://www.tgpdevil.com\">Powered by - TGPDevil Free</a></font></center>\n";
        close(TGPMAIN);
&domain;
}

#################################
## Print modify template form
sub modifytemp {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Page Templates</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p><font color=\"#000000\" face=\"Arial\"><big><big><big>Page Templates:</big></big></big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\"><div align=\"center\"><center><table border=\"0\"\n";
print "width=\"88%\" style=\"border: 2px solid rgb(0,0,0)\" bgcolor=\"#48486F\">\n";
print "<tr>\n";
print "<td width=\"33%\"><div align=\"right\"><p><strong><font face=\"Arial\" color=\"#FFFFFF\">Select\n";
print "template to edit </font><font color=\"#000000\" face=\"Arial\">&nbsp; </font></strong></td>\n";
print "<td width=\"30%\"><select name=\"template_open\" size=\"1\">\n";
print "<option value=\"none\" selected>- Select Template to Edit -</option>\n";
print "<option value=\"header\">Main Header</option>\n";
print "<option value=\"main_page\">Main Gallery Page</option>\n";
print "<option value=\"footer\">Main Footer</option>\n";
print "<option value=\"line\">Regular Link Line Template</option>\n";
print "<option value=\"submission_accepted\">Post Submitted</option>\n";
print "<option value=\"no_reciprocal_link\">No Reciprocal Link Found Error</option>\n";
print "<option value=\"excessive_posts\">Excessive Posts Error</option>\n";
print "<option value=\"duplicate_post_error\">Duplicate Post Error</option>\n";
print "</select></td>\n";
print "<td width=\"37%\"><input type=\"submit\" name=\"open_page\" value=\"Open Template\">\n";
print "\n";
print "\n";
print "</center>";
print "</div>\n";
print "</td>\n";
print "</form></table>";


          if($INPUT{'open_page'}) {

print "<input type=\"hidden\" name=\"temp_name\" value=\"$INPUT{'template_open'}\">\n";
$openwhat = $INPUT{'template_open'};
$the_file = "$INPUT{'template_open'}";
$INPUT{'template_open'}=~ s/_/ /g;
print "<font color=\"black\" face=\"Verdana\"><strong>Currently working with $INPUT{'template_open'} template.</strong></font>\n";

open(THE_TEMP, "$filesdir\/templates\/$openwhat\.temp");
@the_file = <THE_TEMP>;
close(THE_TEMP);
}


print "<table border=\"0\"\n";
print "width=\"88%\" style=\"border: 2px solid rgb(0,0,0)\" bgcolor=\"#48486F\">";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"silver\">\n";
print "<div align=\"center\">\n";
print "<form name=\"form2\" method=\"post\" action=\"$adminurl\">\n";
print "<p>\n";
print "<textarea name=\"temptext\" cols=\"85\" rows=\"30\">\n";
if($INPUT{'open_page'}) {
print @the_file;
}
print "</textarea>\n";
print "</p>\n";
print "<p>\n";
print "<input type=\"hidden\" name=\"edited\" value=\"$openwhat\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"submit\" name=\"savetemplate\" value=\"Save Template\">\n";
print "</p>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<p align=\"center\"><input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></p>\n";
print "</form>\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}

## Save edited template
sub savetemplate {
                         open (BLIST,">$filesdir\/templates\/$INPUT{'edited'}\.temp");
                        print BLIST "$INPUT{'temptext'}";
                        close (BLIST);
                        &domain;
                        }


## Print modify options form
sub modifyoptions {
print "<html>\n";

print "\n";
print "<head>\n";
print "<title>Modify Program Options</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\"><b><font size=\"4\" face=\"Verdana\">\n";
print "\n";
print "<p align=\"left\"></font></b><font face=\"Arial\" size=\"6\">Modify Program Options </font></p>\n";
print "\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\"><input type=\"hidden\" name=\"adminuser\"\n";
print "value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\"><table\n";
print "width=\"50%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"3\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Program\n";
print "Options:</strong></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Minimum\n";
print "number of pics per gallery.</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><input type=\"text\" name=\"fie1\" value=\"$pont1\" size=\"3\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Maximum\n";
print "number of posts per person per day.</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><input type=\"text\" name=\"fie2\" value=\"$pont2\" size=\"3\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Require\n";
print "reciprocal link?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Confirm\n";
print "posters email address?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email after submitting?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email if post is approved?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email if post is declined?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Block auto\n";
print " submission programs</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Using link\n";
print " checking bot?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><font face=\"Verdana\" color=\"#000000\">N/A</font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"60%\" bgcolor=\"#E6E7C9\"><div align=\"right\"><p><input type=\"submit\"\n";
print "name=\"loginadmin\" value=\"Back to main menu\"> * </td>\n";
print "<td width=\"40%\" bgcolor=\"#E6E7C9\"><div align=\"right\"><p><input type=\"submit\"\n";
print "name=\"saveoptions\" value=\"Save Changes\"></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\">&nbsp;</td>\n";
print "</tr>\n";
print "</table>\n";
print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div><hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "</form>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
print "\n";



exit;
}

## Save options
sub saveoptions {
                open(P, ">$options_db") || print "Cant open $option_db REASON ($!)";
                print P "$INPUT{'fie1'}::$INPUT{'fie2'}::$INPUT{'recip'}::$INPUT{'conf'}::$INPUT{'submail'}::$INPUT{'appmail'}::$INPUT{'decmail'}::$INPUT{'blocker'}::$INPUT{'bott'}";
                close(P);
                &domain;
        }



sub temptags {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Manage Template Tags</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Add/Remove/Edit Template\n";
print "Tags: </big></font>";

if ($INPUT{'savenewtag'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>New tag was saved!</b></font>\n";
}
elsif ($INPUT{'modtag'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>Tag was modified.</b></font>\n";
}
elsif ($INPUT{'remtag'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>Tag was deleted.</b></font>\n";
}
print "</p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";

print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table width=\"95%\" border=\"0\" align=\"center\">\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p>Category</font></b> </td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p>Tag </font></b></td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p>Start At #</font></b> </td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p>Show How Many</font></b> </td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p>Add Tag</font></b> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"18%\" bgcolor=\"#DCDDD9\">\n";
print "<dd align=\"center\"><select name=\"catnam\" size=\"1\">\n";


        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@roe = $sth->fetchrow)  {


        print "<option value=\"$roe[0]\">$roe[0]</option>\n";
}
print "<option value=\"Universal\">Archive Tag</option>\n";
      print "</select> </dd>\n";
print "</td>\n";
print "<td width=\"19%\" bgcolor=\"#DCDDD9\">\n";
print "<dd align=\"center\"><input type=\"text\" name=\"tagname\" size=\"20\"> </dd>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\">\n";
print "<dd align=\"center\"><input type=\"text\" name=\"startat\" size=\"20\"> </dd>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\">\n";
print "<dd align=\"center\"><input type=\"text\" name=\"howmany\" size=\"20\"> </dd>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\">\n";
print "<dd align=\"center\"><input type=\"submit\" name=\"savenewtag\" value=\"Add Tag\"\n";
print "style=\"background-color: rgb(72,72,111); color: rgb(255,255,255)\"> </dd>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";




print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\"><div align=\"center\"><center><table border=\"0\"\n";
print "width=\"20%\">\n";
print "<tr>\n";
print "<td width=\"76%\" bgcolor=\"#48486F\"><big><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"center\"><center><p></font></b><font color=\"#FFFFFF\" face=\"Arial\">From category\n";
print "&nbsp; </font></big></td>\n";
print "<td width=\"24%\"><font face=\"Verdana\">\n";
print "<dd align=\"center\"><div align=\"left\"><p></font><b><font face=\"Verdana\" color=\"#FFFFFF\"><big><select\n";
print "name=\"catnam\" size=\"1\">\n";
        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@roe = $sth->fetchrow)  {


        print "<option value=\"$roe[0]\">$roe[0]</option>\n";
}
print "<option value=\"Universal\">Archive Tags</option>\n";
print "</select></big></font></b></p>\n";
print "</div></dd>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"76%\" bgcolor=\"#FFFFFF\"><div align=\"right\"><p><input type=\"submit\"\n";
print "name=\"loginadmin\" value=\"Back to main menu\"></td>\n";
print "<td width=\"24%\"><font face=\"Verdana\"><input type=\"submit\" name=\"searchtags\"\n";
print "value=\"Open Tags List\"></font></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div><div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "</body>\n";
print "</html>\n";

exit;
}

sub savenewtag {
        $sql = "INSERT INTO DMtgptemps VALUES('$INPUT{'tagname'}','$INPUT{'catnam'}','$INPUT{'startat'}','$INPUT{'howmany'}')";
$dbh->do($sql);
&temptags;
}


###########################
## Manage temp tags #######
###########################
sub searchtags {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>View/Modify Tags</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"><big>Remove/Edit Template Tags:</big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "\n";
print "\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Category</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\"><font face=\"Verdana\"><b><p align=\"center\"><font\n";
print "color=\"#FFFFFF\">Tag </font></b></font></td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Start At #</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Show How Many</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Edit Tag</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "</tr>\n";

my($query) = "SELECT * FROM DMtgptemps WHERE category = '$INPUT{'catnam'}' ORDER BY 'tagname'";
my($sth) = $dbh->prepare($query);
$sth->execute || die("Could not execute!");
while(@lin = $sth->fetchrow)  {
print "<tr>\n";
print "<td width=\"18%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[1] </font></td>\n";
print "<td width=\"19%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[0] </font></td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[2] </font></td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[3] </font></td>\n";

print "<form method=\"POST\" action=\"$adminurl\">\n";
  print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";

print " \n";
print " \n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"><div align=\"center\"><!--webbot bot=\"HTMLMarkup\"\n";
print "startspan TAG=\"XBOT\" --><INPUT type=\"hidden\" name=\"toedit\" value=\"$lin[0]\"><!--webbot bot=\"HTMLMarkup\" endspan -->\n";
print "\n";
print "<dd><input type=\"submit\" name=\"edittag\" value=\"Edit Tag\"\n";
print "style=\"background-color: rgb(72,72,111); color: rgb(255,255,255)\"> </dd>\n";
print "</div></td>\n";
print "</tr> </form>\n";
print "\n";



  }
  print "</table><hr size=\"1\" color=\"#800000\">\n";
  print "<form method=\"POST\" action=\"$adminurl\">\n";
  print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"><big></big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";


print "</html>\n";

  exit;
}

sub edittag {

        my($query) = "SELECT * FROM DMtgptemps WHERE tagname = '$INPUT{'toedit'}' LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@linz = $sth->fetchrow)  {
        $tago = $linz[0];
        $cateo = $linz[1];
        $starto = $linz[2];
        $endo = $linz[3];
}
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Template Tag</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p><big><font face=\"Arial\"><big>Edit Tag</big>:</font></big></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\" align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\"><input type=\"hidden\" name=\"tgname\" value=\"$tago\"><table\n";
print "width=\"457\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" bgcolor=\"#DCDDD9\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\" colspan=\"2\" width=\"453\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Tag\n";
print "Information:</strong></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"139\"><div align=\"left\"><p><font color=\"#000000\" face=\"Arial\"><strong>Tag\n";
print "Name is: </strong></font></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"310\"><input type=\"text\" name=\"newtagname\" value=\"$tago\"\n";
print "size=\"30\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"139\"><div align=\"left\"><p><font color=\"#000000\" face=\"Arial\"><strong>Starts\n";
print "At: </strong></font></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"310\"><input type=\"text\" name=\"startat\" size=\"30\"\n";
print "value=\"$starto\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"139\"><font color=\"#000000\" face=\"Arial\"><strong>Show How\n";
print "Many: </strong></font></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"310\"><input type=\"text\" name=\"endat\" size=\"30\" value=\"$endo\"></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"139\"><b><font color=\"#FFFFFF\" face=\"Verdana\"><div\n";
print "align=\"center\"><center><p></font></b>.</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"310\" align=\"center\"><input type=\"submit\" name=\"modtag\"\n";
print "value=\"Change Tag\"> * <input type=\"submit\" name=\"remtag\" value=\"Delete Tag\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";
print "\n";
exit;

}
sub modtag {
        my        $qy = "UPDATE DMtgptemps SET tagname = '$INPUT{'newtagname'}' where tagname = '$INPUT{'tgname'}'";
         $dbh->do($qy);

         my        $qy = "UPDATE DMtgptemps SET startat = '$INPUT{'startat'}' where tagname = '$INPUT{'newtagname'}'";
         $dbh->do($qy);

         my $qy = "UPDATE DMtgptemps SET endat = '$INPUT{'endat'}' where tagname = '$INPUT{'newtagname'}'";
         $dbh->do($qy);
         &temptags;
 }

## Delete entry
sub remtag {
        my $qy = "DELETE FROM DMtgptemps WHERE tagname ='$INPUT{'tgname'}'";
$dbh->do($qy);
&temptags;
}

sub bulkdelete {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Delete Posts</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" size=\"4\" color=\"#000000\"><big>Bulk Delete:</big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\"\n";
print "name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\"\n";
print "value=\"$pass\"><input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input\n";
print "type=\"hidden\" name=\"adminpass\" value=\"$pass\"><div align=\"center\"><div\n";
print "align=\"center\"><center><table border=\"0\" width=\"93%\" bgcolor=\"#FFFFFF\">\n";
print "<tr>\n";
print "<td><font color=\"#FFFFFF\" face=\"Verdana\"><big><div align=\"center\"></big><table border=\"0\"\n";
print "width=\"44%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-right: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#48486F\" align=\"center\"></font><big><font color=\"#FFFFFF\"\n";
print "face=\"Arial\">Delete posts from category</font><font color=\"#FFFFFF\" face=\"Verdana\"><b> </b></big></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" align=\"center\" bgcolor=\"#DCDDD9\"><big><b><select name=\"delcate\" size=\"1\">\n";
print "<option value=\"All\" selected>All Categories</option>\n";

        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@row = $sth->fetchrow)  {


        print "<option value=\"$row[0]\">$row[0]</option>\n";
}
print "</select></b></big></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" align=\"center\" bgcolor=\"#DCDDD9\"><big><font color=\"#000000\" face=\"Arial\">that\n";
print "were made on or before</font><font color=\"#FFFFFF\" face=\"Verdana\"> </big></font></td>\n";
print "</tr>\n";
print "</table>\n";
print "<big><p>&nbsp;</p>\n";
print "<table width=\"477\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" height=\"37\">\n";
print "<tr bgcolor=\"#999999\">\n";
print "<td bgcolor=\"#48486F\" height=\"24\" width=\"173\" align=\"center\"><b><font size=\"3\"><div\n";
print "align=\"center\"><center><p></font><font face=\"Arial\"><font color=\"#FFFFFF\" size=\"3\">Year</font></b><font\n";
print "color=\"#FFFFFF\"> </font></font></td>\n";
print "</big><td bgcolor=\"#48486F\" height=\"24\" width=\"173\" align=\"center\"><big><font\n";
print "color=\"#FFFFFF\" face=\"Arial\"></font><font face=\"Arial\"><b><font color=\"#FFFFFF\" size=\"3\">Month</font></b><font\n";
print "color=\"#FFFFFF\"> </font></font><font color=\"#FFFFFF\" face=\"Arial\"></font></big></td>\n";
print "<td bgcolor=\"#48486F\" height=\"24\" width=\"1\" align=\"center\"><big><font color=\"#FFFFFF\"\n";
print "face=\"Arial\"></font><font face=\"Arial\"><b><font color=\"#FFFFFF\" size=\"3\">Day</font></b><font\n";
print "color=\"#FFFFFF\"> </font></font><font color=\"#FFFFFF\" face=\"Arial\"></font></big></td>\n";
print "<font color=\"#FFFFFF\" face=\"Verdana\"><big>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td bgcolor=\"#DCDDD9\" height=\"5\" width=\"172\" align=\"center\"><select name=\"delyear\"\n";
print "size=\"1\">\n";
print "<option value=\"2001\">2001</option>\n";
print "<option value=\"2002\">2002</option>\n";
print "<option value=\"2003\">2003</option>\n";
print "</select></td>\n";
print "</big><td bgcolor=\"#DCDDD9\" height=\"5\" width=\"171\" align=\"center\"></font><select\n";
print "name=\"delmonth\" size=\"1\">\n";
print "<option value=\"01\">January</option>\n";
print "<option value=\"02\">February</option>\n";
print "<option value=\"03\">March</option>\n";
print "<option value=\"04\">April</option>\n";
print "<option value=\"05\">May</option>\n";
print "<option value=\"06\">June</option>\n";
print "<option value=\"07\">July</option>\n";
print "<option value=\"08\">August</option>\n";
print "<option value=\"09\">September</option>\n";
print "<option value=\"10\">October</option>\n";
print "<option value=\"11\">November</option>\n";
print "<option value=\"12\">December</option>\n";
print "</select><font color=\"#FFFFFF\" face=\"Verdana\"></td>\n";
print "<td bgcolor=\"#DCDDD9\" height=\"5\" width=\"1\" align=\"center\"></font><select name=\"delday\"\n";
print "size=\"1\">\n";
print "<option value=\"01\">1</option>\n";
print "<option value=\"02\">2</option>\n";
print "<option value=\"03\">3</option>\n";
print "<option value=\"04\">4</option>\n";
print "<option value=\"05\">5</option>\n";
print "<option value=\"06\">6</option>\n";
print "<option value=\"07\">7</option>\n";
print "<option value=\"08\">8</option>\n";
print "<option value=\"09\">9</option>\n";
print "<option value=\"10\">10</option>\n";
print "<option value=\"11\">11</option>\n";
print "<option value=\"12\">12</option>\n";
print "<option value=\"13\">13</option>\n";
print "<option value=\"14\">14</option>\n";
print "<option value=\"15\">15</option>\n";
print "<option value=\"16\">16</option>\n";
print "<option value=\"17\">17</option>\n";
print "<option value=\"18\">18</option>\n";
print "<option value=\"19\">19</option>\n";
print "<option value=\"20\">20</option>\n";
print "<option value=\"21\">21</option>\n";
print "<option value=\"22\">22</option>\n";
print "<option value=\"23\">23</option>\n";
print "<option value=\"24\">24</option>\n";
print "<option value=\"25\">25</option>\n";
print "<option value=\"26\">26</option>\n";
print "<option value=\"27\">27</option>\n";
print "<option value=\"28\">28</option>\n";
print "<option value=\"29\">29</option>\n";
print "<option value=\"30\">30</option>\n";
print "<option value=\"31\">31</option>\n";
print "</select><font color=\"#FFFFFF\" face=\"Verdana\"></td>\n";
print "<big>\n";
print "</tr>\n";
print "</table>\n";
print "<dd align=\"center\">&nbsp;</big></font></dd>\n";
print "</div></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "<dd align=\"center\">&nbsp;</dd>\n";
print "<dd align=\"center\">&nbsp;</dd>\n";
print "</div><div align=\"center\"><center><table border=\"0\" width=\"27%\">\n";
print "<tr>\n";
print "<td width=\"50%\" align=\"center\"><font face=\"Verdana\"><input type=\"submit\" name=\"dodeletes\"\n";
print "value=\"Delete Posts\"></font></td>\n";
print "<td width=\"50%\" align=\"center\"><input type=\"submit\" name=\"loginadmin\"\n";
print "value=\"Back to main menu\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div><div align=\"center\"><center><p><font face=\"Verdana\">&nbsp;</font> </p>\n";
print "</center></div><font color=\"#FFFFFF\" face=\"Verdana\"><hr size=\"1\" color=\"#800000\"\n";
print "align=\"center\">\n";
print "</font>\n";
print "</form>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub dodeletes{

        if ($INPUT{'delcate'} eq "All"){
        my $qy = "DELETE FROM DMtgpgalleries WHERE datecode <= '$INPUT{'delyear'}$INPUT{'delmonth'}$INPUT{'delday'}'";
$dbh->do($qy);
}
else {
                my $qy = "DELETE FROM DMtgpgalleries WHERE webcate = '$INPUT{'delcate'}' datecode <= '$INPUT{'delyear'}$INPUT{'delmonth'}$INPUT{'delday'}'";
$dbh->do($qy);
}
&domain;
}

sub managecats {
print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Manage Categories</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table border=\"0\" ellspacing=\"2\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"><big>Manage Categories:</big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";

if ($INPUT{'addcat'}){
print "<font face=\"Arial\" color=\"red\"><B><center><big>Category Added</center><br></big></b></font>\n";
}
elsif ($INPUT{'deletecat'}){
print "  <font face=\"Verdana\" color=\"red\"><B><center><big>Category Deleted.<br></center></big></b></font>\n";
}
print "<div align=\"center\"><center>\n";

print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"2\" width=\"80%\" bordercolor=\"#FFFFFF\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font color=\"#FFFFFF\"\n";
print "face=\"Arial\" size=\"3\">Category Name</font></strong></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font color=\"#FFFFFF\"\n";
print "face=\"Arial\" size=\"3\">Category Tag</font></strong></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><strong><font color=\"#FFFFFF\"\n";
print "face=\"Arial\" size=\"3\">Delete</font></strong></td>\n";
print "</tr>\n";
        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@row = $sth->fetchrow)  {
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"><font color=\"#000000\" face=\"Verdana\">$row[0]</font></td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"><font color=\"#000000\" face=\"Verdana\">$row[1]</font></td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"> \n";
print "<p> \n";
print "<input type=\"hidden\" name=\"deletewhich\" value=\"$row[0]\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"Submit\" value=\"Delete Category\" name=\"deletecat\" style=\"background-color: rgb(72,72,111); color: rgb(255,255,255)\">\n";
print "</p>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
}
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "<p align=\"center\"><font face=\"Verdana\" size=\"4\" color=\"#000000\"><b>Add New Category</b></font></p>\n";
print "<div align=\"center\">\n";
print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"80%\" bordercolor=\"#FFFFFF\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font size=\"3\" face=\"Verdana\"><b><font color=\"#FFFFFF\">Category \n";
print "Name</font></b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Verdana\" color=\"#FFFFFF\" size=\"3\"><b>Category \n";
print "Tag<br>\n";
print "(1 word only, no special characters)</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Verdana\" color=\"#FFFFFF\" size=\"3\"><b>Delete</b></font></td>\n";
print "</tr>\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\">\n";
print "<input type=\"text\" name=\"catnam\">\n";
print "</td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\">\n";
print "<input type=\"text\" name=\"cattag\">\n";
print "</td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"> \n";
print "<p> \n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"Submit\" value=\"Add Category\" name=\"addcat\">\n";
print "</p>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
print "</table>\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"></big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "</body>\n";
print "\n";
print "</html>\n";
exit;

}

sub tgpbaseoptions {

print "<html>\n";
print "<head>\n";
print "<title>Modify TGPBase.com Options</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\"> \n";
print "<p align=\"left\"><font face=\"Arial\" size=\"6\">Modify TGPBase.com Options</font></p>\n";
if ($INPUT{'deletecatrename'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Category Redirect Was Deleted!</b></font><BR>\n";
}
elsif ($INPUT{'savecatrename'}){
print "  <font face=\"Verdana\" color=\"red\"><B>New Category Redirect Was Saved!</b></font><BR>\n";
}
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table\n";
print "width=\"50%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"3\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>TGPBase \n";
print "Options :</strong></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Currently \n";
print "a TGPBase.com PAID member?<BR><a href=\"http://www.tgpbase.com\" target=\"_blank\">TGPBase.com - Join Now!</a></font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<select name=\"member\">\n";
print "<option value=\"$tgp1\" selected>$tgp1</option>\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "</select>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">TGPBase \n";
print "username.</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<input type=\"text\" name=\"myusername\" value=\"$tgp2\" size=\"10\">\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">TGPBase \n";
print "password. </font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<input type=\"text\" name=\"mypassword\" size=\"10\" value=\"$tgp3\">\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Auto-Approve \n";
print "galleries from TGPBase.com. </font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<select name=\"autoapprove\">\n";
print "<option value=\"$tgp4\" selected>$tgp4</option>\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "</select>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"60%\" bgcolor=\"#E6E7C9\"> \n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\"\n";
print "name=\"loginadmin\" value=\"Back to main menu\">\n";
print "</td>\n";
print "<td width=\"40%\" bgcolor=\"#E6E7C9\"> \n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\"\n";
print "name=\"savetgpbaseoptions\" value=\"Save Changes\">\n";
print "</td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div><hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "</form>\n";
print "</div>\n";

print "<div align=\"center\"> \n";

print "<table\n";
print "width=\"50%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"3\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>TGPBase \n";
print "Options :</strong></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\">TGPBase \n";
print "Category </font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"33%\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\">Your \n";
print "Category</font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\">Delete \n";
print "</font></b></div>\n";
print "</td>\n";
print "</tr>\n";
        my($query) = "SELECT * FROM DMtgpredirects ORDER BY 'tgpbase'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<tr> \n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\">\n";

print "<font face=\"Arial, Helvetica, sans-serif\">$row[0]</font>\n";


print "</div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"33%\"> \n";
print "<div align=\"center\">\n";

print "<font face=\"Arial, Helvetica, sans-serif\">$row[1]\n";

print "</font></div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"hidden\" name=\"tgpbdelete\" value=\"$row[0]\"><input type=\"hidden\" name=\"youdelete\" value=\"$row[1]\">\n";
print "<input type=\"submit\" name=\"deletecatrename\" value=\"Delete\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
}
print "</table>\n";
print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<table\n";
print "width=\"50%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"2\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>TGPBase \n";
print "Renames:</strong><br>\n";
print "<font color=\"#000000\" size=\"2\"> <font color=\"#FFFFFF\"><i>The left column \n";
print "is the name of the category on our site, the right column is the name \n";
print "of the category on your site. This allows you to send galleries from \n";
print "TGPBase.com's &quot;Amateur&quot; category to your &quot;Teens&quot; \n";
print "category for instance.</i></font></font></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\">TGPBase \n";
print "Category </font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"33%\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\">Your \n";
print "Category</font></b></div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<div align=\"center\">\n";
print "<select name=\"mycat\">\n";
print "<option value=\"Amateurs\">Amateurs</option>\n";
print "<option value=\"Anal Sex\">Anal Sex</option>\n";
print "<option value=\"Asians\">Asians</option>\n";
print "<option value=\"Babes\">Babes</option>\n";
print "<option value=\"Blondes\">Blondes</option>\n";
print "<option value=\"Brunettes\">Brunettes</option>\n";
print "<option value=\"Celebrities\">Celebrities</option>\n";
print "<option value=\"Cheerleaders/Uniforms\">Cheerleaders/Uniforms</option>\n";
print "<option value=\"Cumshots\">Cumshots</option>\n";
print "<option value=\"Dicks/Shemales\">Dicks/Shemales</option>\n";
print "<option value=\"Fat Women (BBW)\">Fat Women (BBW)</option>\n";
print "<option value=\"Fetish/Bondage/Watersports\">Fetish/Bondage/Watersports</option>\n";
print "<option value=\"Gays\">Gays</option>\n";
print "<option value=\"Groups\">Groups</option>\n";
print "<option value=\"Hardcore\">Hardcore</option>\n";
print "<option value=\"Interracial\">Interracial</option>\n";
print "<option value=\"Legal Teens\">Legal Teens</option>\n";
print "<option value=\"Lesbians\">Lesbians</option>\n";
print "<option value=\"Older Women\">Older Women</option>\n";
print "<option value=\"Oral Sex\">Oral Sex</option>\n";
print "<option value=\"Pregnant\">Pregnant</option>\n";
print "<option value=\"Redheads\">Redheads</option>\n";
print "<option value=\"Sex Toys\">Sex Toys</option>\n";
print "<option value=\"Videos/MPEGs/AVIs\">Videos/MPEGs/AVIs</option>\n";
print "<option value=\"Voyeur/Exhibitionists/Upskirts\">Voyeur/Exhibitionists/Upskirts</option>\n";
print "</select>\n";
print "</div>\n";
print "</td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"33%\"> \n";
print "<div align=\"center\">\n";
print "<select name=\"yourcat\">\n";
        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@rowz = $sth->fetchrow)  {


        print "<option value=\"$rowz[0]\">$rowz[0]</option>\n";
}
print "</select>\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr align=\"center\"> \n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\"\n";
print "name=\"loginadmin\" value=\"Back to main menu\">\n";
print "</td>\n";
print "<td width=\"33%\" bgcolor=\"#E6E7C9\"> \n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\"\n";
print "name=\"savecatrename\" value=\"Save Changes\">\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";


print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div><hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "</form>\n";
print "</div>\n";


print "</body>\n";
print "</html>\n";


exit;
}

sub savetgpbaseoptions {
                open(Q, ">$tgpoptions_db") || print "Cant open $tgpoption_db REASON ($!)";
                print Q "$INPUT{'member'}::$INPUT{'myusername'}::$INPUT{'mypassword'}::$INPUT{'autoapprove'}";
                close(Q);
                &domain;
        }


sub addcat {
        $sql = "INSERT INTO DMtgpcategories VALUES('$INPUT{'catnam'}','$INPUT{'cattag'}')";
$dbh->do($sql);
&managecats;

}

sub deletecat {
        my $qy = "DELETE FROM DMtgpcategories WHERE catname ='$INPUT{'deletewhich'}'";
$dbh->do($qy);

        my $qy = "DELETE FROM DMtgpgalleries WHERE webcate ='$INPUT{'deletewhich'}'";
$dbh->do($qy);
&managecats;
}

sub deletecatrename {
        my $qy = "DELETE FROM DMtgpredirects WHERE tgpbase ='$INPUT{'tgpbdelete'}' and you = '$INPUT{'youdelete'}'";
$dbh->do($qy);
&tgpbaseoptions;
}

sub savecatrename {

        $sql = "INSERT INTO DMtgpredirects VALUES('$INPUT{'mycat'}','$INPUT{'yourcat'}')";
$dbh->do($sql);
&tgpbaseoptions;
}

sub addpost {
print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Manual Gallery Submission</title>\n";
print "</head>\n";
print "<body bgcolor=\"white\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" size=\"6\">Manually Add Posts:";

if ($INPUT{'savenewpost'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Post was added.</b></font>\n";
}


print "</font></p>\n";
print "\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "\n";
print "<p align=\"left\"><font size=\"2\" face=\"Verdana\">Please enter the posting you wish. But<strong>\n";
print "REMEMBER: these posts are exempt from duplicate/error checking</strong></font></p>\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\"><div align=\"center\"><center><table border=\"0\"\n";
print "cellpadding=\"0\" cellspacing=\"1\" width=\"426\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\" width=\"422\" colspan=\"2\"><font face=\"Arial\" color=\"#FFFFFF\"><strong>Posting\n";
print "Information:</strong></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Your Name</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><input type=\"text\"\n";
print "name=\"webname\" size=\"20\" value=\"Admin\"> </b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Email Address</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><input type=\"text\"\n";
print "name=\"webemail\" size=\"30\" value=\"$adminemail\"> </b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Gallery URL</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><input type=\"text\" name=\"weburl\"\n";
print "size=\"30\"> </b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Category</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><select name=\"addcat\" size=\"1\">\n";

        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        print "<option value=\"$row[0]\">$row[0]</option>\n";
}
print "</select> </b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Number of Pics</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><input type=\"text\"\n";
print "name=\"webpics\" size=\"4\"> </b></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\"><b>Description</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><font face=\"Verdana\"><b><input type=\"text\"\n";
print "name=\"webdesc\" size=\"31\"> </b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td bgcolor=\"#E6E7C9\" width=\"113\"><font color=\"#000000\" face=\"Arial\">.</font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"309\"><input type=\"submit\" value=\"Add Post\" name=\"savenewpost\">\n";
print "* <input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div><div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div><hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "</form>\n";
print "</body>\n";
print "</html>\n";


exit;

}

sub savenewpost {
$passwd = random_password();

		my($query) = "SELECT idnum FROM `DMtgpgalleries` ORDER BY `idnum` DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@PID = $sth->fetchrow)  {
        $CURPID = $PID[0];
        }
$newpid = $CURPID+1;

$sql = "INSERT INTO DMtgpgalleries VALUES('$INPUT{'webname'}','$INPUT{'webemail'}','$INPUT{'weburl'}','$INPUT{'addcat'}','$INPUT{'webpics'}','$INPUT{'webdesc'}','$date_today','$datecode','1','$newpid','$ENV{'REMOTE_ADDR'}','$passwd','1','$isnow')";
$dbh->do($sql);
&addpost
}

sub random_password {
($length) = @_;
if ($length eq "" or $length < 3) {
$length = 8;
}
$vowels = "aeiouyAEUY";
$consonants = "bdghjmnpqrstvwxzBDGHJLMNPQRSTVWXZ12345678";
srand(time() ^ ($$ + ($$ << 15)) );
$alt = int(rand(2)) - 1;
$s = "";
$newchar = "";
foreach $i (0..$length-1) {
if ($alt == 1) {
$newchar =
substr($vowels,rand(length($vowels)),1);
} else {
$newchar = substr($consonants,
rand(length($consonants)),1);
}
$s .= $newchar;
$alt = !$alt;
}
return $s;
}

## Print edit verification
sub oos {
print "        <html>\n";
print "<head>\n";
print "<title>Done deal!</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#C0C0C0\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "  <p><font color=\"#000000\" face=\"Verdana\"><b>Gallery has been $act.</b></font></p>\n";
print "  <p><b><font color=\"#000000\" face=\"Verdana\">You may close this window.</font></b></p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}


sub message {
$header = header();
print "$head\n";
}

sub blingbling {
$bling = bling();
print "$bling\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$pass\">";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></form>\n";
print "</div></body></html>\n";
}

sub gogetemboy {
print "<html>\n";
print "<head>\n";
print "<title>Fetching galleries</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "<p><b><font face=\"Arial, Helvetica, sans-serif\" color=\"#000000\" size=\"4\">Now \n";
print "fetching galleries from TGPBase.com</font></b></p>\n";
print "<p><font face=\"Arial, Helvetica, sans-serif\" color=\"#FF0000\" size=\"4\"><b>Please \n";
print "wait...\n";

       	my($query) = "SELECT datecode FROM `DMtgpgalleries` where webname = 'TGPBASE.COM' ORDER BY `datecode` DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@dcr = $sth->fetchrow)  {
        $dc1 = $dcr[0];
        }

        if ($datecode = "$dc1") {
        	print "</b></font></p>\n";
print "<p>&nbsp;</p>\n";
print "<p>&nbsp;</p>\n";
print "<p><b><font face=\"Arial, Helvetica, sans-serif\" size=\"4\" color=\"#FF0000\">Gallery \n";
print "listings have already been retrieved today. Please try again tomorrow.</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Click here to return to the main menu.\">\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}

$isnow=time;
&gloc;
my $agent = new LWP::UserAgent; 
$agent->timeout(30); 
my $req = new HTTP::Request GET => "$location"; 
$req->header('Accept' => 'text/html');
my $result = $agent->request( $req ); 
my $xmlin = $result->content; 

if ($tgp4 eq "yes") {
	$apstat = 1;
} else {
$apstat = 0;
}

        open(TGPMAIN,">gall") || print "Can't open gall REASON: ($!)\n";
print TGPMAIN "$xmlin\n";
        close(TGPMAIN);      
 
        open(HTML, "gall") || print "Can't open gall\n";
        @html_text = <HTML>;
       close(HTML);
		my($query) = "SELECT idnum,datecode FROM `DMtgpgalleries` ORDER BY `idnum` DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@PID = $sth->fetchrow)  {
        $CURPID = $PID[0];
        $dc = $PID[1];
        }

$newpid = $CURPID+1;

    
        foreach $later (@html_text) {
        chomp $later;
        ($gurl,$gcat,$gpics,$gdesc,$gd,$gdc)=split(/\|\|/, $later);
        
    if ($gurl eq "-ERROR-"){
        	print "</b></font></p>\n";
print "<p>&nbsp;</p>\n";
print "<p>&nbsp;</p>\n";
print "<p><b><font face=\"Arial, Helvetica, sans-serif\" size=\"4\" color=\"#FF0000\">ERROR!<BR> \n";
print "$gcat</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Click here to return to the main menu.\">\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
unlink gall;
exit;
}
       
    if ($gurl){
      $sql = "INSERT INTO DMtgpgalleries VALUES('TGPBASE.COM','galleries\@tgpbase.com','$gurl','$gcat','$gpics','$gdesc','$gd','$gdc','$apstat',$newpid,'000.000.000.000','00000000','1','$isnow')";
	$dbh->do($sql);
	$newpid++;
	}
}

        
        my($query) = "SELECT * FROM DMtgpredirects";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        my $qy = "UPDATE DMtgpgalleries SET webcate = '$row[1]' WHERE webcate ='$row[0]'";
$dbh->do($qy);
}

print "</b></font></p>\n";
print "<p>&nbsp;</p>\n";
print "<p>&nbsp;</p>\n";
print "<p><b><font face=\"Arial, Helvetica, sans-serif\" size=\"4\" color=\"#FF0000\">Gallery \n";
print "listings successfully retrieved.</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$pass\">\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Click here to return to the main menu.\">\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
unlink gall;

exit;
}



1;



