#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
use MIME::Base64 ();
require HTTP::Request; 
require LWP::UserAgent;


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
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10,$pont11,$pont12,$pont13,$pont14)=split(/::/, $poi);

open(Q, "$tgpoptions_db") || print "Cant open $tgpoptions_db REASON ($!)";
$tgpb = <Q>;
close(Q);
($tgp1,$tgp2,$tgp3,$tgp4,$tgp5)=split(/::/, $tgpb);

$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");

#Declare some variables
$adminname = $INPUT{'adminuser'};
$adminpwd= $INPUT{'adminpass'};
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
        elsif ($INPUT{'setapproval'}) { &setapproval; }
        elsif ($INPUT{'searchfor'}) { &searchfor; }
        elsif ($INPUT{'dosearch'}) { &dosearch; }
        elsif ($INPUT{'editpost'}) {&editpost;}
        elsif ($INPUT{'editnow'}) {&editnow;}
        elsif ($INPUT{'deletenow'}) {&deletenow;}
        elsif ($INPUT{'rebuild'}) {&generate;}
        elsif ($INPUT{'genarch'}) {&genarch;}
        elsif ($INPUT{'editbanlist'}) {&editbanlist;}
        elsif ($INPUT{'savebanlist'}) {&savebanlist;}
        elsif ($INPUT{'editdomlist'}) {&editdomlist;}
        elsif ($INPUT{'savedomlist'}) {&savedomlist;}
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
        elsif ($INPUT{'modifymail'}) {&modifymail;}
        elsif ($INPUT{'open_mail'}) {&modifymail;}
        elsif ($INPUT{'savemail'}) {&savemail;}
        elsif ($INPUT{'bulkdelete'}) {&bulkdelete;}
        elsif ($INPUT{'dodeletes'}) {&dodeletes;}
        elsif ($INPUT{'savenewpost'}) {&savenewpost;}
        elsif ($INPUT{'managecats'}) {&managecats;}
        elsif ($INPUT{'deletecat'}) {&deletecat;}
        elsif ($INPUT{'addcat'}) {&addcat;}
        elsif ($INPUT{'modifyads'}) {&modifyads;}
        elsif ($INPUT{'open_ad'}) {&modifyads;}
        elsif ($INPUT{'savead'}) {&savead;}
        elsif ($INPUT{'addpost'}) {&addpost;}
        elsif ($INPUT{'blindtags'}) {&blindtags;}
        elsif ($INPUT{'savenewblind'}) {&savenewblind;}
        elsif ($INPUT{'searchblind'}) {&searchblind;}
        elsif ($INPUT{'editblind'}) {&editblind;}
        elsif ($INPUT{'modblind'}) {&modblind;}
        elsif ($INPUT{'remblind'}) {&remblind;}
        elsif ($INPUT{'police'}) {&police;}
        elsif ($INPUT{'bust'}) {&bust;}
        elsif ($INPUT{'unfounded'}) {&unfounded;}
        elsif ($INPUT{'botsettings'}) {&botsettings;}
        elsif ($INPUT{'savebots'}) {&savebots;}
        elsif ($INPUT{'botresults'}) {&botresults;}
        elsif ($INPUT{'botresultact'}) {&botresultact;}
        elsif ($INPUT{'decmess'}) {&decmess;}
        elsif ($INPUT{'choose'}) {&choose;}
        elsif ($INPUT{'editdecs'}) {&editdecs;}
        elsif ($INPUT{'moddec'}) {&moddec;}
        elsif ($INPUT{'deldec'}) {&deldec;}
        elsif ($INPUT{'adddec'}) {&adddec;}
        elsif ($INPUT{'editbantextlist'}) {&editbantextlist;}
        elsif ($INPUT{'savenewtext'}) {&savenewtext;}
        elsif ($INPUT{'edittextban'}) {&edittextban;}
        elsif ($INPUT{'savemodtext'}) {&savemodtext;}
        elsif ($INPUT{'delbantext'}) {&delbantext;}
        elsif ($INPUT{'mailform'}) {&mailform;}
        elsif ($INPUT{'sendemail'}) {&sendemail;}
        elsif ($INPUT{'appall'}) {&appall;}
        elsif ($INPUT{'decall'}) {&decall;}
        elsif ($INPUT{'approveallday'}) {&approveallday;}
        elsif ($INPUT{'deleteallday'}) {&deleteallday;}
        elsif ($INPUT{'partnermenu'}) {&partnermenu;}
        elsif ($INPUT{'addpartner'}) {&addpartner;}
        elsif ($INPUT{'listpartner'}) {&listpartner;}
        elsif ($INPUT{'savenewpartner'}) {&savenewpartner;}
        elsif ($INPUT{'savemodpartner'}) {&savemodpartner;}
        elsif ($INPUT{'viewmodpartner'}) {&viewmodpartner;}
        elsif ($INPUT{'viewpartsubs'}) {&viewpartsubs;}
        #
        elsif ($INPUT{'tgpbaseoptions'}) {&tgpbaseoptions;}
        elsif ($INPUT{'deletecatrename'}) {&deletecatrename;}
        elsif ($INPUT{'savecatrename'}) {&savecatrename;}
        elsif ($INPUT{'savetgpbaseoptions'}) {&savetgpbaseoptions;}
        elsif ($INPUT{'gogetemboy'}) {&gogetemboy;}
        elsif ($INPUT{'delpartner'}) {&delpartner;}
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
print "<p><big><font color=\"#000000\" face=\"Arial\"><big>TGP Devil System Administration:</big><!--CyKuH--></font></big></p>\n";
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
print "<p><font face=\"Arial\"><strong>Powered By:</strong><!--CyKuH-->TgpDevil \n";
print "TGP System</font></p>\n";
print "</body>\n";
print "</html>\n";
}


## Print main menu
sub domain{
if ($adminpassword eq $adminpwd) {
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
print "</table>\n";
print "</center></div>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "<div align=\"center\">\n";

print "<table border=\"0\"\n";
print "width=\"85%\" style=\"border: 2px solid rgb(0,0,0)\" cellpadding=\"3\" cellspacing=\"0\">\n";
print "<big><font color=\"#000000\" face=\"Verdana\"> \n";
print "<tr> \n";
print "<td colspan=\"6\" bgcolor=\"#48486F\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Other \n";
print "Management Options:</strong></font> </td>\n";
print "</tr>\n";
print "<tr align=\"center\"> \n";
print "<td width=\"24%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Manage Partners</b></font></small></td>\n";
print "<td width=\"11%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"> \n";
print "<input\n";
print "type=\"submit\" value=\"Submit\" name=\"partnermenu\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</td>\n";
print "<td width=\"24%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0)\"\n";
print "bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>TGPBase \n";
print "Options </b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"> \n";
print "<big><font color=\"#000000\" face=\"Verdana\"> \n";
print "<input\n";
print "type=\"submit\" value=\"Submit\" name=\"tgpbaseoptions\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</font></big></td>\n";
print "<td width=\"24%\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0)\"\n";
print "bgcolor=\"#DCDDD9\" align=\"left\"><small><font color=\"#800000\" face=\"Arial\"><b>Get \n";
print "TGPBase Galleries</b></font></small></td>\n";
print "<td width=\"12%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"> \n";
print "<big><font color=\"#000000\" face=\"Verdana\"> \n";
print "<input\n";
print "type=\"submit\" value=\"Submit\" name=\"gogetemboy\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</font></big></td>\n";
print "</tr>\n";
print "</font></big><big> </big> \n";
print "</table><BR><BR><!--CyKuH--></div>\n";

    
    
    
print "</form>\n";
print "</body>\n";
print "</html>\n";





exit;
}}
&error;
print "Invalid Username and Password Combo. ( This is case sensitive )";
&error2;
}

sub botresults {
my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpdead WHERE deadurl != '' ") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $bad = $sth->fetchrow;
print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>LinkBot Results</title>\n";
print "</head>\n";
print "<body bgcolor=\"white\" TEXT=\"black\" LINK=\"blue\" VLINK=\"red\" ALINK=\"yellow\">\n";
print "<p align=\"left\"><font face=\"Arial\"><b>Possible dead links found - <font color=red>$bad</font></b></font></p>\n";
print "<div align=\"center\">\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\" width=\"100%\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td width=\"544\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\"\n";
print "color=\"#FFFFFF\" size=\"3\">URL</font></strong></td>\n";
print "<td width=\"155\" bgcolor=\"#48486F\" align=\"center\"><strong><font face=\"Arial\" color=\"#FFFFFF\" size=\"3\">Link \n";
print "is OK?</font></strong></td>\n";
print "</tr>\n";
    $lionx = 0;
        my($query) = "SELECT * FROM DMtgpdead WHERE idnum != ''";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {


        $lionx++;
        if ($lionx % 2) {
        $rowcolor = "#DCDDD9";
} else {
$rowcolor = "silver";
}

print "<tr> \n";
print "<td width=\"544\" bgcolor=\"$rowcolor\" align=\"center\">\n";
print "<a href=\"$row[0]\" target=\"_blank\"><font face=\"Verdana\" size=\"1\">$row[0]</font></a></td>\n";
print "<td width=\"155\" bgcolor=\"$rowcolor\" align=\"center\"> \n";
print "<p><font face=\"Verdana\" color=\"#FF0000\" size=\"1\">No</font> \n";
print "<input type=\"radio\" name=\"$row[1]\" value=\"delete\">\n";
print "<font face=\"Verdana\" color=\"blue\" size=\"1\">Yes \n";
print "<input type=\"radio\" name=\"$row[1]\" value=\"keep\">\n";
print "</font></p>\n";
print "</td>\n";
print "</tr>\n";
}

print "</table>\n";
print "</div>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<p align=\"center\"><input type=\"Submit\" value=\"Update Database\" name=\"botresultact\">    <input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></p>\n";
print "</form>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub botresultact {
foreach $namevalue (@namevalues) {
($name, $value) = split(/=/, $namevalue);
$name =~ tr/+/ /;
$value =~ tr/+/ /;
$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

if ($value eq "keep"){
my $qy = "DELETE FROM DMtgpdead WHERE idnum ='$name'";
$dbh->do($qy);
}
if ($value eq "delete"){
my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$name'";
$dbh->do($qy);
my $qy = "DELETE FROM DMtgpdead WHERE idnum ='$name'";
$dbh->do($qy);
}
}
&domain;
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
print "<div align=\"center\"><b><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Category to \n";
print "view</font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<div align=\"center\"><b><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">From \n";
print "Whom</font></b></div>\n";
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

        my($query) = "SELECT DISTINCT webdate FROM DMtgpgalleries WHERE approval = '0' AND vermail = '1' ORDER BY datecode,idnum";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@datez = $sth->fetchrow)  {

            my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE webdate = '$datez[0]' AND approval='0' AND vermail = '1'") or die "Unable to prepare query: ".$dbh->errstr;
		$sth->execute() or die "Unable to execute query: ".$sth->errstr;
		my $cou = $sth->fetchrow;


print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">\n";
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
	  print "<select name=\"catt\">\n";
	  print "<option value=\"%\%\">All - $cou</option>\n";

#Get Category Names

	  my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@rowz = $sth->fetchrow)  {

#Count galleries pending review in each category

            my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE webdate = '$datez[0]' AND webcate = '$rowz[0]' AND approval='0' AND vermail = '1'") or die "Unable to prepare query: ".$dbh->errstr;
		$sth->execute() or die "Unable to execute query: ".$sth->errstr;
		my $coun = $sth->fetchrow;
        	print "<option value=\"\%$rowz[0]\%\">$rowz[0] - $coun</option>\n";
		}
print "</select>\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
	  print "<select name=\"porno\">\n";
	  print "<option value=\"%\%\">All</option>\n";
	  print "<option value=\"1\">Partners Only</option>\n";
	  print "<option value=\"0\">Non-Partners Only</option>\n";
print "</select>\n";
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

 my ( $webname, $webemail, $weburl, $webcate, $webpics, $webdesc, $webdate, $datecode, $approval, $idnum, $webip, $uniqueid, $vermail, $stamp, $rate, $aff );
        my($query) = "SELECT * FROM DMtgpgalleries WHERE webdate = '$INPUT{'appdate'}' AND vermail = '1' AND approval != '1' AND webcate LIKE '$INPUT{'catt'}' AND aff LIKE '$INPUT{'porno'}' ORDER BY webip LIMIT $INPUT{'revnum'}";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        $sth->bind_columns( undef, \$webname, \$webemail, \$weburl, \$webcate, \$webpics, \$webdesc, \$webdate, \$datecode, \$approval, \$idnum, \$webip, \$uniqueid, \$vermail, \$stamp, \$rate, \$aff );

        while ( $sth->fetch ) {
        $liono++;
        if ($liono % 2) {
        $rowcolor = "#DCDDD9";
} else {
$rowcolor = "silver";
}


print "<tr>\n";
print "<td width=\"20%\" bgcolor=\"$rowcolor\" align=\"center\"><font face=\"Verdana\" size=\"1\"><a href=\"mailto:$webemail\">$webname</a><BR>$webip</font></td>\n";
print "<td width=\"40%\" bgcolor=\"$rowcolor\" align=\"center\"><a href=\"$weburl\" target=\"_blank\"><font face=\"Verdana\" size=\"1\">$weburl</font></a><BR><font face=\"Verdana\" size=\"1\">$webpics - </font><input type=\"text\" name=\"newdesc\+\+$idnum\" size=\"30\" value=\"$webdesc\">&nbsp;\n";
print "<select name=\"prate\-\-$idnum\">\n";
print "<option value=\"$rate\" selected>$rate</option>\n";
print "  <option value=\"1\">1</option>\n";
print "  <option value=\"2\">2</option>\n";
print "  <option value=\"3\">3</option>\n";
print "  <option value=\"4\">4</option>\n";
print "  <option value=\"5\">5</option>\n";
print "  <option value=\"6\">6</option>\n";
print "  <option value=\"7\">7</option>\n";
print "  <option value=\"8\">8</option>\n";
print "  <option value=\"9\">9</option>\n";
print "  <option value=\"10\">10</option>\n";
print "</select></td>\n";
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
if ($pont8 eq "yes"){
print "<select name=\"$idnum\">\n";
print "<option value=\"\">Unreviewed</option>\n";
print "<option value=\"keep\">Approve</option>\n";
foreach $dcats (@deco) {
                chop $line;
                        ($w00t,$woot) = split(/\|\|/,$dcats);
print "<option value=\"delete\|$w00t\">Deny - $w00t</option>\n";
}
print "</select>\n";
}
if ($pont8 eq "no") {
print "<p><font face=\"Verdana\" color=\"#FF0000\" size=\"1\">No</font><input type=\"radio\" name=\"$idnum\" value=\"delete\"><font face=\"Verdana\" color=\"blue\" size=\"1\">Yes<input type=\"radio\" name=\"$idnum\" value=\"keep\"></font></p>\n";
}
print "</td>\n";
print "</tr>\n";



}
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "\n";
print "\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
print "<input type=\"hidden\" name=\"dosearch\"\n";
print "value=\"dosearch\"><input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input\n";
print "type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><p><strong><font face=\"Arial\">Please\n";
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
print "<input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\"\n";
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
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
print "<input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\"\n";
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
if ($name =~ /\+\+/) {
	($act, $actid) = split(/\+\+/, $name);
	$sval = $value;
}
if ($name =~ /\-\-/) {
	($act1, $actid1) = split(/\+\+/, $name);
	$rate1 = $value;
}
$INPUT{$name} = $value;
if ($value eq "keep"){

	my $qy = "UPDATE DMtgpgalleries SET webdesc = '$sval' WHERE idnum ='$actid'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgpgalleries SET approval = '1' WHERE idnum ='$name'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgpgalleries SET rate = '$rate1' WHERE idnum ='$name'";
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
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
        if ($numpics < 10) {
        $laters =~ s/#NUMPICS#/0$numpics/g;
        } else {
        $laters =~ s/#NUMPICS#/$numpics/g;
        }
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

         my ( $webname, $webemail, $weburl, $webcate, $webpics, $webdesc, $webdate, $datecode, $approval, $idnum, $webip, $uniqueid, $vermail, $stamp, $rate, $aff );
        my($query) = "SELECT * FROM DMtgpgalleries WHERE webcate = '$categ' and approval = '1' ORDER BY datecode DESC, rate DESC, idnum DESC LIMIT $startat, $endat";

        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        $sth->bind_columns( undef, \$webname, \$webemail, \$weburl, \$webcate, \$webpics, \$webdesc, \$webdate, \$datecode, \$approval, \$idnum, \$webip, \$uniqueid, \$vermail, \$stamp, \$rate, \$aff );

        while ( $sth->fetch ) {

        open(LINE, "$linetemp") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
$dc = $webdate;
($rday,$rmon,$ryear)=split(/\//, $dc);
foreach $laters (@linetemp){
        chomp $laters;
        $webdesc =~ s/_//;
	if ($pont14 eq "yes") {
	$webdesc =~ s/\b(\w)/uc($1)/eg;
	} 
        $laters =~ s/#LINKDESC#/$webdesc/g;
        $laters =~ s/#LINKURL#/$weburl/g;
	  if ($webpics < 10) {
        $laters =~ s/#NUMPICS#/0$webpics/g;
        } else {
        $laters =~ s/#NUMPICS#/$webpics/g;
        }
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
        close(TGPMAIN);
&domain;
}

#################################
#################################
#################################
#################################

## Print ban form
sub editbanlist {
                        open (BLIST,"$banlist");
                        @banlist = <BLIST>;
                        close (BLIST);
                        chomp(@banlist);
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Banlist</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\"><b><font color=\"#000000\" size=\"4\" face=\"Verdana\">\n";
print "\n";
print "<p align=\"left\"></font><font face=\"Arial\"><font size=\"6\"><font color=\"#000000\">Update </b>Banned IP\n";
print "List</font></font><big><big> </big></big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\">\n";
print "\n";
print "<table width=\"80%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\"><form name=\"form1\" method=\"post\" action=\"$adminurl\" align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\" name=\"adminuser\"\n";
print "value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\"><strong> Current IP Addresses being Banned:</strong></font></p>\n";
print "\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\"><p align=\"center\"><textarea name=\"banlist\" cols=\"60\" rows=\"21\">\n";


for $item(@banlist) {
print "$item\n";
}
print "\n";
print "</textarea></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#E6E7C9\"><p align=\"center\"><input type=\"submit\" name=\"savebanlist\"\n";
print "value=\"Save Ban List\"> * <input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>\n";
print "</form>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\">\n";
print "</body>\n";
print "</html>\n";
print "\n";
exit;
}

## Save banlist
sub savebanlist {
                        open (BLIST,">$banlist");
                        print BLIST "$INPUT{'banlist'}\n";
                        print BLIST "\cM";
                        close (BLIST);
                        &domain;
                }


##Print edit banlist form
sub editdomlist {

                        open (BLIST,"$domainlist") || print "Cant open $domainlist REASOn ($!)";
                        @domlist = <BLIST>;
                        close (BLIST);
                        chomp(@domlist);

print "\n";
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Domain Banlist</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\"><b><font color=\"#000000\" size=\"4\" face=\"Verdana\">\n";
print "\n";
print "<p align=\"left\"></font><font face=\"Arial\"><font size=\"6\"><font color=\"#000000\">Update </b>Banned Domain \n";
print "List</font></font><big><big> </big></big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\">\n";
print "\n";
print "<table width=\"80%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\"><form name=\"form1\" method=\"post\" action=\"$adminurl\" align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\" name=\"adminuser\"\n";
print "value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\"><strong> Current Domain Addresses being Banned:</strong></font></p>\n";
print "\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\"><p align=\"center\"><textarea name=\"domlist\" cols=\"60\" rows=\"21\">\n";


for $item(@domlist) {
print "$item\n";
}

print "\n";
print "</textarea></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#E6E7C9\"><p align=\"center\"><input type=\"submit\" name=\"savedomlist\"\n";
print "value=\"Save Ban List\"> * <input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>\n";
print "</form>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"left\">\n";
print "</body>\n";
print "</html>\n";
print "\n";
exit;
}


## Save domain ban list
sub savedomlist {
                        open (BLIST,">$domainlist");
                        print BLIST "$INPUT{'domlist'}";
                        print BLIST "\cM";
                        close (BLIST);
                        &domain;
                }

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
print "name=\"adminpass\" value=\"$adminpwd\"><div align=\"center\"><center><table border=\"0\"\n";
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
print "<option value=\"blind\">Blind Link Line Template</option>\n";
print "<option value=\"archive_header\">Archive Header</option>\n";
print "<option value=\"archives\">Archive Pages</option>\n";
print "<option value=\"archive_footer\">Archive Footer</option>\n";
print "<option value=\"submission_accepted\">Post Submitted</option>\n";
print "<option value=\"post_verified\">Post Confirmed</option>\n";
print "<option value=\"no_reciprocal_link\">No Reciprocal Link Found Error</option>\n";
print "<option value=\"banned_user\">Banned IP Error</option>\n";
print "<option value=\"domain_blacklisted\">Blacklisted Domain Error</option>\n";
print "<option value=\"excessive_posts\">Excessive Posts Error</option>\n";
print "<option value=\"duplicate_post_error\">Duplicate Post Error</option>\n";
print "<option value=\"banned_text_error\">Banned Text Error</option>\n";
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"savetemplate\" value=\"Save Template\">\n";
print "</p>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
print "name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\" name=\"adminuser\"\n";
print "value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><table\n";
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
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"recip\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont3\" selected>$pont3</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Confirm\n";
print "posters email address?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"conf\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont5\" selected>$pont5</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email after submitting?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"submail\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont6\" selected>$pont6</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email if post is approved?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"appmail\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont7\" selected>$pont7</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Send\n";
print "poster an email if post is declined?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"decmail\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont8\" selected>$pont8</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Block auto\n";
print " submission programs</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"blocker\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont9\" selected>$pont9</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Using link\n";
print " checking bot?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"bott\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont10\" selected>$pont10</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Default Submitted Gallery Rank\n";
print "</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\">\n";
print "<select name=\"srate\">\n";
print "<option value=\"$pont11\" selected>$pont11</option>\n";
print "  <option value=\"1\">1</option>\n";
print "  <option value=\"2\">2</option>\n";
print "  <option value=\"3\">3</option>\n";
print "  <option value=\"4\">4</option>\n";
print "  <option value=\"5\">5</option>\n";
print "  <option value=\"6\">6</option>\n";
print "  <option value=\"7\">7</option>\n";
print "  <option value=\"8\">8</option>\n";
print "  <option value=\"9\">9</option>\n";
print "  <option value=\"10\">10</option>\n";
print "</select>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Default Partner Submitted Gallery Rank\n";
print "</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\">\n";
print "<select name=\"prate\">\n";
print "<option value=\"$pont12\" selected>$pont12</option>\n";
print "  <option value=\"1\">1</option>\n";
print "  <option value=\"2\">2</option>\n";
print "  <option value=\"3\">3</option>\n";
print "  <option value=\"4\">4</option>\n";
print "  <option value=\"5\">5</option>\n";
print "  <option value=\"6\">6</option>\n";
print "  <option value=\"7\">7</option>\n";
print "  <option value=\"8\">8</option>\n";
print "  <option value=\"9\">9</option>\n";
print "  <option value=\"10\">10</option>\n";
print "</select>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Require Reciprocal\n";
print " in partner posts</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"partnerrecip\" size=\"1\">\n";
print "<option value=\"$pont13\" selected>$pont13</option>\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "</select> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Capitalize\n";
print " first letter of description?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"><select name=\"autocap\" size=\"1\">\n";
print "<option value=\"yes\">yes</option>\n";
print "<option value=\"no\">no</option>\n";
print "<option value=\"$pont14\" selected>$pont14</option>\n";
print "</select> </td>\n";
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
                print P "$INPUT{'fie1'}::$INPUT{'fie2'}::$INPUT{'recip'}::$INPUT{'conf'}::$INPUT{'submail'}::$INPUT{'appmail'}::$INPUT{'decmail'}::$INPUT{'blocker'}::$INPUT{'bott'}::$INPUT{'srate'}::$INPUT{'prate'}::$INPUT{'partnerrecip'}::$INPUT{'autocap'}";
                close(P);
                &domain;
        }


## Generate archives
sub genarch {
        my($query) = "SELECT * FROM DMtgpcategories WHERE catname != ''";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
                while(@categ = $sth->fetchrow)  {

        open(TGPMAIN1,">$cat_html/$categ[1]\.shtml") || print "Can't open $cat_html REASON: ($!)\n";
        open(HTML, "$archheader_txt") || print "Can't open $archheader_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $later (@html_text) {
        chomp $later;
        print TGPMAIN1 "$later\n";
}

$haha = $categ[0];


        open(HTML, "$archtemp") || print "Can't open $archtemp\n";
        @html_text = <HTML>;
        close(HTML);

        my($query) = "SELECT * FROM DMtgpads WHERE webcate = '$haha' LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@ads = $sth->fetchrow)  {
        $adtext = "$ads[1]";
        }

        foreach $laters (@html_text) {
        chomp $laters;
        $laters =~ s/#CATEGORYNAME#/$haha/g;
        $laters =~ s/#CATAD#/$adtext/g;
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
$adtext="";



        my($query) = "SELECT * FROM DMtgpgalleries WHERE webcate = '$haha' AND approval='1' AND vermail = '1' ORDER BY 'datecode' desc limit $startat, $endat";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@rows = $sth->fetchrow)  {
        open(LINE, "$linetemp") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
        
        $dc = $rows[6];
		($rday,$rmon,$ryear)=split(/\//, $dc);
foreach $laters (@linetemp){
        chomp $laters;
        $rows[5] =~ s/_//;
	if ($pont14 eq "yes") {
	$rows[5] =~ s/\b(\w)/uc($1)/eg;
	} 
        $laters =~ s/#LINKDESC#/$rows[5]/g;
        $laters =~ s/#LINKURL#/$rows[2]/g;
        $laters =~ s/#IDNUM#/$rows[9]/g;
	  if ($rows[4] < 10) {
        $laters =~ s/#NUMPICS#/0$rows[4]/g;
        } else {
        $laters =~ s/#NUMPICS#/$rows[4]/g;
        }

        $rows[3] =~ s/ /%20/g;
        $laters =~ s/#CATEG#/$rows[3]/g;
        $laters =~ s/#MON#/$rmon/g;
        $laters =~ s/#DAY#/$rday/g;
        
        
        

        print TGPMAIN1 "$laters\n";
        }
}
last;
}
        $laters =~ s/##(.+?)##//g;
        print TGPMAIN1 "$laters\n";
}

        open(HTML, "$archfooter_txt") || print "Can't open $archfooter_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $laters (@html_text) {
        chomp $laters;
        $laters =~ s/#UPDATED#/$when/g;
        print TGPMAIN1 "$laters\n";
}
        close(TGPMAIN1);
}
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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
print "name=\"adminpass\" value=\"$adminpwd\"><div align=\"center\"><center><table border=\"0\"\n";
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

####################
## Do add/edit blinds
####################
sub blindtags {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Manage Blind Link Tags</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Add/Remove/Edit Blind\n";
print "Links: ";

if ($INPUT{'savenewblind'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>New blind link was saved!</b></font><BR>\n";
}
elsif ($INPUT{'modblind'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>Blind link was modified.</b></font><BR>\n";
}
elsif ($INPUT{'remtag'}){
print " <font face=\"Arial\" color=\"red\" size=\"5\"><B>Blind link was deleted.</b></font><BR>\n";
}
print "</big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"><b><div align=\"center\"><center><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\">Blind Group</b> </font></td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"><b><div align=\"center\"><center><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\">Link URL</b> </font></td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"><b><div align=\"center\"><center><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\">Link Description</b> </font></td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"><b><div align=\"center\"><center><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\">Claim how many pics</b> </font></td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"><b><div align=\"center\"><center><p><font\n";
print "face=\"Arial\" color=\"#FFFFFF\">Add Blind Link</b> </font></td>\n";
print "</tr>\n";
print "<tr align=\"center\">\n";
print "<td width=\"18%\" bgcolor=\"#DCDDD9\" align=\"left\"><dl>\n";
print "<dd align=\"center\"><select name=\"blndnam\" size=\"1\">\n";
print "<option value=\"BLIND1\">BLIND1</option>\n";
print "<option value=\"BLIND2\">BLIND2</option>\n";
print "<option value=\"BLIND3\">BLIND3</option>\n";
print "<option value=\"BLIND4\">BLIND4</option>\n";
print "<option value=\"BLIND5\">BLIND5</option>\n";
print "<option value=\"BLIND6\">BLIND6</option>\n";
print "<option value=\"BLIND7\">BLIND7</option>\n";
print "<option value=\"BLIND8\">BLIND8</option>\n";
print "<option value=\"BLIND9\">BLIND9</option>\n";
print "<option value=\"BLIND10\">BLIND10</option>\n";
print "<option value=\"BLIND11\">BLIND11</option>\n";
print "<option value=\"BLIND12\">BLIND12</option>\n";
print "<option value=\"BLIND13\">BLIND13</option>\n";
print "<option value=\"BLIND14\">BLIND14</option>\n";
print "<option value=\"BLIND15\">BLIND15</option>\n";
print "<option value=\"BLIND16\">BLIND16</option>\n";
print "<option value=\"BLIND17\">BLIND17</option>\n";
print "<option value=\"BLIND18\">BLIND18</option>\n";
print "<option value=\"BLIND19\">BLIND19</option>\n";
print "<option value=\"BLIND20\">BLIND20</option>\n";
print "<option value=\"BLIND21\">BLIND21</option>\n";
print "<option value=\"BLIND22\">BLIND22</option>\n";
print "<option value=\"BLIND23\">BLIND23</option>\n";
print "<option value=\"BLIND24\">BLIND24</option>\n";
print "<option value=\"BLIND25\">BLIND25</option>\n";
print "</select> </dd>\n";
print "</dl>\n";
print "</td>\n";
print "<td width=\"19%\" bgcolor=\"#DCDDD9\" align=\"left\"><dl>\n";
print "<dd align=\"center\"><div align=\"left\"><p><input type=\"text\" name=\"tagname\" size=\"20\"></p>\n";
print "</div></dd>\n";
print "</dl>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\" align=\"left\"><dl>\n";
print "<dd align=\"center\"><input type=\"text\" name=\"startat\" size=\"20\"></dd>\n";
print "</dl>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\" align=\"left\"><dl>\n";
print "<dd align=\"center\"><input type=\"text\" name=\"howmany\" size=\"20\"></dd>\n";
print "</dl>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\" align=\"left\"><dl>\n";
print "<dd align=\"center\"><div align=\"left\"><p><input type=\"submit\" name=\"savenewblind\"\n";
print "value=\"Add Blind Link\"></form></p>\n";
print "</div></dd>\n";
print "</dl>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "\n";
print "\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\"><div align=\"center\"><div align=\"center\"><center><table\n";
print "border=\"0\" width=\"52%\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"38%\" bgcolor=\"#48486F\"><font face=\"Arial\" color=\"#FFFFFF\"><strong>From blind\n";
print "group:</strong></font></td>\n";
print "<td width=\"29%\" bgcolor=\"#48486F\"><big><b><font face=\"Verdana\" color=\"#FFFFFF\"><select\n";
print "name=\"blndnam\" size=\"1\">\n";
print "<option value=\"BLIND1\">BLIND1</option>\n";
print "<option value=\"BLIND2\">BLIND2</option>\n";
print "<option value=\"BLIND3\">BLIND3</option>\n";
print "<option value=\"BLIND4\">BLIND4</option>\n";
print "<option value=\"BLIND5\">BLIND5</option>\n";
print "<option value=\"BLIND6\">BLIND6</option>\n";
print "<option value=\"BLIND7\">BLIND7</option>\n";
print "<option value=\"BLIND8\">BLIND8</option>\n";
print "<option value=\"BLIND9\">BLIND9</option>\n";
print "<option value=\"BLIND10\">BLIND10</option>\n";
print "<option value=\"BLIND11\">BLIND11</option>\n";
print "<option value=\"BLIND12\">BLIND12</option>\n";
print "<option value=\"BLIND13\">BLIND13</option>\n";
print "<option value=\"BLIND14\">BLIND14</option>\n";
print "<option value=\"BLIND15\">BLIND15</option>\n";
print "<option value=\"BLIND16\">BLIND16</option>\n";
print "<option value=\"BLIND17\">BLIND17</option>\n";
print "<option value=\"BLIND18\">BLIND18</option>\n";
print "<option value=\"BLIND19\">BLIND19</option>\n";
print "<option value=\"BLIND20\">BLIND20</option>\n";
print "<option value=\"BLIND21\">BLIND21</option>\n";
print "<option value=\"BLIND22\">BLIND22</option>\n";
print "<option value=\"BLIND23\">BLIND23</option>\n";
print "<option value=\"BLIND24\">BLIND24</option>\n";
print "<option value=\"BLIND25\">BLIND25</option>\n";
print "</select></font></b></big></td>\n";
print "<td width=\"33%\" bgcolor=\"#DCDDD9\"><div align=\"left\"><p><font face=\"Verdana\"><input\n";
print "type=\"submit\" name=\"searchblind\" value=\"Open Blind Link Group\"></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"67%\" colspan=\"2\" bgcolor=\"#DCDDD9\"><big><b><font face=\"Verdana\" color=\"#FFFFFF\"><div\n";
print "align=\"left\"><p>&nbsp; </font><font face=\"Verdana\" color=\"#DCDDD9\">.</font></b></big></td>\n";
print "<td width=\"33%\" bgcolor=\"#DCDDD9\"><input type=\"submit\" name=\"loginadmin\"\n";
print "value=\"- Back To Main Menu -\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "<dd align=\"center\"><div align=\"left\"></div></dd>\n";
print "</div><div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";


exit;
}

sub savenewblind {
$sql = "INSERT INTO DMtgpblind VALUES('$INPUT{'blndnam'}','$INPUT{'tagname'}','$INPUT{'startat'}','$INPUT{'howmany'}')";
$dbh->do($sql);
&blindtags;
}

sub searchblind {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>View/Modify Blind Links</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">";
print "<table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"><big>Remove/Edit Blind Links:</big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Blind Group</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Link URL</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Link Description</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Claim How Many Pics</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\"><p align=\"center\"></font><font\n";
print "color=\"#FFFFFF\" face=\"Verdana\">Edit Link</font></b><font color=\"#FFFFFF\"> </font></td>\n";
print "</tr>\n";
my($query) = "SELECT * FROM DMtgpblind WHERE linkname = '$INPUT{'blndnam'}' ORDER BY 'linkname'";
my($sth) = $dbh->prepare($query);
$sth->execute || die("Could not execute!");
while(@lin = $sth->fetchrow)  {
print "<tr>\n";
print "<td width=\"18%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[0] </font></td>\n";
print "<td width=\"19%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[1] </font></td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[2] </font></td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"><font face=\"Verdana\" size=\"1\"><p align=\"center\">$lin[3] </font></td>\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "\n";
print "\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"><div align=\"center\"><!--webbot bot=\"HTMLMarkup\"\n";
print "startspan TAG=\"XBOT\" -->\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">";
print "<INPUT type=\"hidden\" name=\"toedit\" value=\"$lin[1]\"><INPUT type=\"hidden\" name=\"toedit1\" value=\"$lin[2]\"><INPUT type=\"hidden\" name=\"toedit2\" value=\"$lin[0]\">\n";
print "\n";
print "<dd><input type=\"submit\" name=\"editblind\" value=\"Edit Blind Link\"> </dd>\n";
print "</div></td>\n";
print "</tr>\n";
print "</form>\n";
}
print "</table>\n";



print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">";
print "<table border=\"0\" width=\"100%\">\n";
print "<tr>\n";
print "<td width=\"33%\"><font face=\"Arial\" color=\"#000000\" size=\"4\"><big></big></font></td>\n";
print "<td width=\"33%\" align=\"center\"></td>\n";
print "<td width=\"34%\" align=\"center\"><input type=\"submit\" value=\"Main Menu\" name=\"loginadmin\"\n";
print "style=\"font-weight: bolder; background-color: rgb(255,255,255); color: rgb(128,0,0)\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";


print "</HTML>\n";

exit;
}

sub editblind {

        my($query) = "SELECT * FROM DMtgpblind WHERE linkurl = '$INPUT{'toedit'}' AND linkdesc = '$INPUT{'toedit1'}' AND linkname = '$INPUT{'toedit2'}' LIMIT 1";
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
print "<title>Edit Blind Link</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p><big><big><font face=\"Arial\">Edit Blind Link:</font></big></big></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\" align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\" name=\"tgname\" value=\"$cateo\"><input\n";
print "type=\"hidden\" name=\"tgurl\" value=\"$starto\"><table width=\"514\" border=\"0\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\" colspan=\"2\" width=\"559\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Blind\n";
print "Link Information:</strong></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"218\"><div align=\"left\"><p><strong><font\n";
print "color=\"#000000\" face=\"Arial\">Link URL :</font></strong></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"337\"><input type=\"text\" name=\"newtagname\" value=\"$cateo\"\n";
print "size=\"30\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"218\"><div align=\"left\"><p><strong><font\n";
print "color=\"#000000\" face=\"Arial\">Link Description :</font></strong></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"337\"><input type=\"text\" name=\"startat\" size=\"30\"\n";
print "value=\"$starto\"> </td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" align=\"left\" width=\"218\"><strong><font color=\"#000000\" face=\"Arial\">Claim\n";
print "How Many Pics :</font></strong></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"337\"><input type=\"text\" name=\"endat\" size=\"30\" value=\"$endo\"></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"218\"><b><div align=\"center\"></div></td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"337\" align=\"center\">&nbsp;<input type=\"submit\"\n";
print "name=\"modblind\" value=\"Edit Blind Link\"> * <input type=\"submit\" name=\"remblind\"\n";
print "value=\"Delete Link\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "</body>\n";
print "</html>\n";


exit;

}
sub modblind {
        my        $qy = "UPDATE DMtgpblind SET linkurl = '$INPUT{'newtagname'}' where linkurl = '$INPUT{'tgname'} and linkdesc = '$INPUT{'tgurl'}'";
         $dbh->do($qy);

         my        $qy = "UPDATE DMtgpblind SET linkdesc = '$INPUT{'startat'}' where linkurl = '$INPUT{'newtagname'}' and linkdesc = '$INPUT{'tgurl'}'";
         $dbh->do($qy);

         my $qy = "UPDATE DMtgpblind SET numpics = '$INPUT{'endat'}' where linkurl = '$INPUT{'newtagname'}' and linkdesc = '$INPUT{'tgurl'}'";
         $dbh->do($qy);
         &blindtags;
 }

## Delete entry
sub remblind {
        my $qy = "DELETE FROM DMtgpblind WHERE linkurl = '$INPUT{'tgname'}' AND linkdesc = '$INPUT{'tgurl'}'";
$dbh->do($qy);
&blindtags;
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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
print "name=\"adminpass\" value=\"$adminpwd\">";

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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
print "name=\"adminpass\" value=\"$adminpwd\"><input type=\"hidden\" name=\"tgname\" value=\"$tago\"><table\n";
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

sub modifymail {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Templates</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\"><big><big>E-Mail Message Templates:</big></big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<div align=\"center\"><center>\n";
print "\n";
print "<table width=\"80%\" border=\"0\"\n";
print "style=\"border-left: 2px solid rgb(0,0,0); border-right: 2px solid rgb(0,0,0); border-top: 2px solid rgb(0,0,0); border-bottom: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\"><div align=\"center\"><form name=\"form1\" method=\"post\"\n";
print "action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\"><font face=\"Verdana\" color=\"#FFFFFF\"><p></font><font\n";
print "face=\"Arial\"><strong><font color=\"#FFFFFF\">Select template to edit</font> </strong></font><select\n";
print "name=\"template_open\" size=\"1\">\n";
print "<option value=\"none\" selected>- Select Template to Edit -</option>\n";
print "<option value=\"confirm_email\">Confirm Address Email</option>\n";
print "<option value=\"submission_received\">Submission Received Email</option>\n";
print "<option value=\"submission_approved\">Submission Approved Email</option>\n";
print "<option value=\"submission_declined\">Submission Declined Email</option>\n";
print "</select> <input type=\"submit\" name=\"open_mail\" value=\"Open Template\"> </p>\n";
print "</form>\n";
print "</div></td>\n";
print "</tr>\n";


          if($INPUT{'open_mail'}) {
print "<input type=\"hidden\" name=\"temp_name\" value=\"$INPUT{'template_open'}\">\n";
$openwhat = $INPUT{'template_open'};
$the_file = "$INPUT{'template_open'}";
$INPUT{'template_open'}=~ s/_/ /g;
print "<td><font color=\"black\" face=\"Verdana\"><strong><center>Currently working with <font color=red>$INPUT{'template_open'}</font> template.</center></strong></font></tr>\n";

open(THE_TEMP, "$filesdir\/templates\/$openwhat\.mail");
@the_file = <THE_TEMP>;
close(THE_TEMP);
}
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td bgcolor=\"silver\">\n";
print "<div align=\"center\">\n";
print "<form name=\"form2\" method=\"post\" action=\"$adminurl\">\n";
print "<p>\n";
print "<textarea name=\"temptext\" cols=\"85\" rows=\"30\">\n";
if($INPUT{'open_mail'}) {
print @the_file;
}
print "</textarea>\n";
print "</p>\n";
print "<p>\n";
print "<input type=\"hidden\" name=\"edited\" value=\"$openwhat\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"savemail\" value=\"Save Email\">\n";
print "</p>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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

sub savemail {
                         open (BLIST,">$filesdir\/templates\/$INPUT{'edited'}\.mail");
                        print BLIST "$INPUT{'temptext'}";
                        close (BLIST);
                        &domain;
                        }


sub appmail {
        my($query) = "SELECT * FROM DMtgpgalleries WHERE idnum = '$name'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@info = $sth->fetchrow)  {
$galurl=$info[2];
$galname=$info[0];
$galdate=$info[6];
$galip=$info[10];
$galcate=$info[3];
$galid=$info[11];
$galmail=$info[1];
}

        open(MAIL,"|$mailprog") || &error("Could not open Sendmail ($!)");
print MAIL "To: $galmail\n";
print MAIL "From: $adminemail\n";
print MAIL "Subject: Your post to $sitename... \n\n";
        open(LINE, "$appmail") || print "Can't open $appmail\n";
        @linetemp = <LINE>;
        close(LINE);
foreach $laters (@linetemp){
        chomp $laters;
        $laters =~ s/#GALLERYURL#/$galurl/g;
        $laters =~ s/#NAME#/$galname/g;
        $laters =~ s/#DATE#/$galdate/g;
        $laters =~ s/#IP#/$galip/g;
        $laters =~ s/#CATEGORY#/$galcate/g;
        $laters =~ s/#UNIQUEID#/$galid/g;
        print MAIL "$laters\n";
        }
close (MAIL);
}

sub decmail {
        my($query) = "SELECT * FROM DMtgpgalleries WHERE idnum = '$name'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@info = $sth->fetchrow)  {
$galurl=$info[2];
$galname=$info[0];
$galdate=$info[6];
$galip=$info[10];
$galcate=$info[3];
$galid=$info[11];
$galmail=$info[1];
}
$reason =~ s/delete\|//g;

        my($query) = "SELECT decvalue FROM DMtgpdeclines WHERE decname = '$reason'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@reasons = $sth->fetchrow)  {
        $reas = $reasons[0];
        }

        open(MAIL,"|$mailprog") || &error("Could not open Sendmail ($!)");
print MAIL "To: $galmail\n";
print MAIL "From: $adminemail\n";
print MAIL "Subject: Your post to $sitename... \n\n";
        open(LINE, "$decmail") || print "Can't open $decmail\n";
        @linetemp = <LINE>;
        close(LINE);
foreach $laters (@linetemp){
        chomp $laters;
        $laters =~ s/#GALLERYURL#/$galurl/g;
        $laters =~ s/#NAME#/$galname/g;
        $laters =~ s/#DATE#/$galdate/g;
        $laters =~ s/#IP#/$galip/g;
        $laters =~ s/#CATEGORY#/$galcate/g;
        $laters =~ s/#UNIQUEID#/$galid/g;
        $laters =~ s/#DECLINEREASON#/$reas/g;
        print MAIL "$laters\n";
        }
close (MAIL);
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
print "value=\"$adminpwd\"><input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input\n";
print "type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\"><div align=\"center\"><div\n";
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

sub editbantextlist {
print "<html>\n";
print "<head>\n";
print "<title>Manage Text Bans</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Add/Remove/Edit Banned Text:\n";
print "</big></font></p>\n";
if ($INPUT{'savenewtext'}){
print "  <font face=\"Arial\" color=\"red\" size=\"5\"><B>New banned text was saved!</b></font><BR>\n";
}
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Banned Text Description<br>\n";
print "<font size=\"1\">(A short, easy to remember name for this ban)</font></font> \n";
print "</b>\n";
print "</td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Text to Ban<br>\n";
print "<font size=\"1\">(Text the script should look for)</font></font> </b>\n";
print "</td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#FFFFFF\">Ban \n";
print "Reason<br>\n";
print "<font size=\"1\">(Will be shown to users submitting galleries containing \n";
print "banned text)</font></font></b></font></td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Add Banned Text</font> </b>\n";
print "</td>\n";
print "</tr>\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<dl> \n";
print "<dd align=\"center\"> \n";
print "<input type=\"text\" name=\"texttitle\" size=\"20\">\n";
print "</dd>\n";
print "</dl>\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "\n";
print "<textarea name=\"texttext\" cols=\"20\" rows=\"3\"></textarea>\n";
print "\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<textarea name=\"bantextreason\" cols=\"20\" rows=\"3\"></textarea>\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "\n";
print " \n";
print "</div>\n";
print "<dl> \n";
print "\n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\" name=\"savenewtext\"\n";
print "value=\"Add Banned Text\">\n";
print "</p>\n";
print " \n";
print "</dl>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</form>\n";
print "\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<div align=\"center\"><div align=\"center\"><center><table\n";
print "border=\"0\" width=\"52%\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td width=\"38%\" bgcolor=\"#48486F\"><font face=\"Arial\" color=\"#FFFFFF\"><strong>Manage \n";
print "text bans:</strong></font></td>\n";
print "<td width=\"29%\" bgcolor=\"#48486F\"><big><b><font face=\"Verdana\" color=\"#FFFFFF\">\n";
print "<select name=\"bannam\" size=\"1\">\n";
        my($query) = "SELECT * FROM DMtgpfilter ORDER BY 'fname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        print "<option value=\"$row[0]\">$row[0]</option>\n";
}
print "</select>\n";
print "</font></b></big></td>\n";
print "<td width=\"33%\" bgcolor=\"#DCDDD9\">\n";
print "<p><font face=\"Verdana\"><input\n";
print "type=\"submit\" name=\"edittextban\" value=\"Modify/Delete Banned text\"></font></td>\n";
print "</tr>\n";
print "<tr>\n";
print "<td width=\"67%\" colspan=\"2\" bgcolor=\"#DCDDD9\">\n";
print "<p>&nbsp;\n";
print "</td>\n";
print "<td width=\"33%\" bgcolor=\"#DCDDD9\"><input type=\"submit\" name=\"loginadmin\"\n";
print "value=\"- Back To Main Menu -\"></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center></div>\n";
print "<dd align=\"center\"><div align=\"left\"></div></dd>\n";
print "</div><div align=\"center\"><center><p>&nbsp;</p>\n";
print "</center></div>\n";
print "</form>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";

exit;
}

 sub savenewtext {
$INPUT{'texttitle'} =~ s/"/&quot;/g;
$INPUT{'texttitle'} =~ s/'/&#39;/g;
$INPUT{'texttext'} =~ s/"/&quot;/g;
$INPUT{'texttext'} =~ s/'/&#39;/g;
$INPUT{'bantextreason'} =~ s/"/&quot;/g;
$INPUT{'bantextreason'} =~ s/'/&#39;/g;


$sql = "INSERT INTO DMtgpfilter VALUES('$INPUT{'texttitle'}','$INPUT{'texttext'}','$INPUT{'bantextreason'}')";
$dbh->do($sql);
&editbantextlist;
}

sub edittextban {

        my($query) = "SELECT * FROM DMtgpfilter where fname = '$INPUT{'bannam'}' LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@texts = $sth->fetchrow)  {
        $fname = $texts[0];
        $ffilter = $texts[1];
        $freason = $texts[2];
        }
print "<html>\n";
print "<head>\n";
print "<title>Remove/Edit Text Bans</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Remove/Edit Banned \n";
print "Text: </big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"hidden\" name=\"realname\" value=\"$fname\">\n";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Banned Text Description<br>\n";
print "<font size=\"1\">(A short, easy to remember name for this ban)</font></font> \n";
print "</b>\n";
print "</td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Text to Ban<br>\n";
print "<font size=\"1\">(Text the script should look for)</font></font> </b>\n";
print "</td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#FFFFFF\">Ban \n";
print "Reason<br>\n";
print "<font size=\"1\">(Will be shown to users submitting galleries containing \n";
print "banned text)</font></font></b></font></td>\n";
print "<td width=\"17%\" height=\"21\" bgcolor=\"#48486F\" align=\"center\"> \n";
print "<p><b><font face=\"Arial\" color=\"#FFFFFF\">Add Banned Text</font> </b>\n";
print "</td>\n";
print "</tr>\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<dl> \n";
print "<dd align=\"center\"> \n";
print "<input type=\"text\" name=\"fname\" size=\"20\" value=\"$fname\">\n";
print "</dd>\n";
print "</dl>\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"23%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "\n";
print "<textarea name=\"ftext\" cols=\"20\" rows=\"3\">$ffilter</textarea>\n";
print "\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "<textarea name=\"freason\" cols=\"20\" rows=\"3\">$freason</textarea>\n";
print "</div>\n";
print "</td>\n";
print "<td width=\"17%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> \n";
print "\n";
print " \n";
print "</div>\n";
print "<dl> \n";
print "\n";
print "<p align=\"center\"> \n";
print "<input type=\"submit\" name=\"savemodtext\"\n";
print "value=\"Modify Banned Text\">\n";
print "</p>\n";
print " \n";
print "</dl>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "<p align=\"center\">\n";
print "<input type=\"submit\" name=\"delbantext\"\n";
print "value=\"Delete Banned Text\">\n";
print "</p>\n";
print "<p align=\"center\"><input type=\"submit\" name=\"loginadmin\"\n";
print "value=\"Return to Main Menu\"></p>\n";
print "</form>\n";
print "\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub savemodtext {

        my $qy = "UPDATE DMtgpfilter SET ffilter = '$INPUT{'ftext'}' where fname = '$INPUT{'realname'}'";
         $dbh->do($qy);

         my $qy = "UPDATE DMtgpfilter SET freason = '$INPUT{'freason'}' where fname = '$INPUT{'realname'}'";
         $dbh->do($qy);
         
         my $qy = "UPDATE DMtgpfilter SET fname = '$INPUT{'fname'}' where fname = '$INPUT{'realname'}'";
         $dbh->do($qy);
         &domain;
	
}

sub delbantext {
	my $qy = "DELETE FROM DMtgpfilter WHERE fname ='$INPUT{'realname'}'";
$dbh->do($qy);
&domain;
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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"Submit\" value=\"Add Category\" name=\"addcat\">\n";
print "</p>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
print "</table>\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\"\n";
print "name=\"adminpass\" value=\"$adminpwd\">";
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



sub modifyads {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Edit Templates</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\"><big><big>Manage Archive Ads:</big></big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<div align=\"center\"><center>\n";
print "\n";
print "<table width=\"80%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\"><div align=\"center\"><form name=\"form1\" method=\"post\"\n";
print "action=\"$adminurl\">\n";
print "<font face=\"Verdana\" color=\"#FFFFFF\"><p></font><strong><font face=\"Arial\"><font\n";
print "color=\"#FFFFFF\">Select template to edit</font> <select name=\"ad_open\" size=\"1\">\n";
print "\n";

        my($query) = "SELECT * FROM DMtgpcategories ORDER BY 'catname'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@row = $sth->fetchrow)  {
        print "<option value=\"$row[0]\">$row[0]</option>\n";
}

print "</font></strong></select>\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"open_ad\" value=\"Open Template\">\n";
print "</form>\n";


          if($INPUT{'open_ad'}) {

    my($query) = "SELECT * FROM DMtgpads WHERE webcate = '$INPUT{'ad_open'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");

        while(@ad = $sth->fetchrow)  {
        $adcat="$ad[0]";
        $adtext="$ad[1]";
}
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<input type=\"hidden\" name=\"temp_name\" value=\"$INPUT{'ad_open'}\">\n";
print "<tr><td><center><font color=\"black\" face=\"Verdana\"><strong>Currently working with <font color=red>$INPUT{'ad_open'}</font> archive ad.</strong></font></center></tr>\n";
}


print "<tr>\n";
print "<td bgcolor=\"silver\">\n";
print "<div align=\"center\">\n";
print "<form name=\"form2\" method=\"post\" action=\"$adminurl\">\n";
print "<p>\n";
print "<textarea name=\"adtext\" cols=\"85\" rows=\"30\">\n";
print "$adtext\n";
print "</textarea>\n";
print "</p>\n";
print "<p>\n";
print "<input type=\"hidden\" name=\"edited\" value=\"$INPUT{'ad_open'}\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"savead\" value=\"Save Ad\">\n";
print "</p>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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

sub savead {
my $qy = "DELETE FROM DMtgpads WHERE webcate ='$INPUT{'edited'}'";
$dbh->do($qy);

$sql = "INSERT INTO DMtgpads VALUES('$INPUT{'edited'}','$INPUT{'adtext'}')";
$dbh->do($sql);

&domain;
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
print "name=\"adminpass\" value=\"$adminpwd\"><div align=\"center\"><center><table border=\"0\"\n";
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
$adminpwdwd = random_password();

		my($query) = "SELECT idnum FROM `DMtgpgalleries` ORDER BY `idnum` DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@PID = $sth->fetchrow)  {
        $CURPID = $PID[0];
        }
$newpid = $CURPID+1;

$sql = "INSERT INTO DMtgpgalleries VALUES('$INPUT{'webname'}','$INPUT{'webemail'}','$INPUT{'weburl'}','$INPUT{'addcat'}','$INPUT{'webpics'}','$INPUT{'webdesc'}','$date_today','$datecode','1','$newpid','$ENV{'REMOTE_ADDR'}','$adminpwdwd','1','$isnow','$pont11','0')";
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

sub police {
print "<html>\n";
print "\n";
print "<head>\n";
print "<title>Cheat Reports</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#FFFFFF\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"6\">Cheat Reports :</font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<div align=\"center\"><center>\n";
print "\n";
print "<table width=\"95%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\">\n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><p\n";
print "align=\"center\">Number of Reports</font></b> </td>\n";
print "<td width=\"19%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><p\n";
print "align=\"center\">URL</font></b> </td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><p\n";
print "align=\"center\">Gallery Posters IP</font></b> </td>\n";
print "<td width=\"23%\" height=\"21\" bgcolor=\"#48486F\"><b><font face=\"Verdana\" color=\"#FFFFFF\"><p\n";
print "align=\"center\">Action</font></b> </td>\n";
print "</tr>\n";
my($query) = "SELECT * FROM DMtgppolice ORDER BY 'reports' desc";
my($sth) = $dbh->prepare($query);
$sth->execute || die("Could not execute!");
while(@lin = $sth->fetchrow)  {
print "<tr> \n";
print "<td width=\"18%\"> \n";
print "<div align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#000000\">$lin[2] </font></div>\n";
print "</td>\n";
print "<td width=\"19%\"> \n";
print "<div align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#000000\"><a href=\"$lin[1]\" target=\"_blank\">$lin[1] </a></font></div>\n";
print "</td>\n";
print "<td width=\"23%\"> \n";
print "<div align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#000000\">$lin[3] </font></div>\n";
print "</td>\n";
print "<form method=\"POST\" action=\"$adminurl\" target=\"_blank\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<td width=\"17%\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"hidden\" name=\"towork\" value=\"$lin[0]\">\n";
print "<input type=\"submit\" name=\"bust\" value=\"Delete Gallery\"><input type=\"submit\" name=\"unfounded\" value=\"Delete Report\">\n";
print "</div>\n";
print "</td>\n";
print "</form>\n";
print "</tr>\n";
}
print "</table>\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<p align=\"center\"><input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></p>\n";
print "</form>\n";
print "</HTML>\n";
exit;
}

## Delete entry
sub bust {
        my $qy = "DELETE FROM DMtgpgalleries WHERE idnum ='$INPUT{'towork'}'";
$dbh->do($qy);
        my $qy = "DELETE FROM DMtgppolice WHERE idnum ='$INPUT{'towork'}'";
$dbh->do($qy);
$act="deleted";
&oos;
}

sub unfounded {
        my $qy = "DELETE FROM DMtgppolice WHERE idnum ='$INPUT{'towork'}'";
$dbh->do($qy);
$act="removed from the report list";
&oos;
}

sub botsettings {
open(B, "$botoptions_db") || print "Cant open $botoptions_db REASON ($!)";
$poin = <B>;
close(B);
($pon1,$pon2,$pon3)=split(/::/, $poin);
print "<html>\n";
print "<head>\n";
print "<title>Modify Bot Options</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "<p align=\"left\"><font face=\"Arial\" size=\"6\">Modify Link Bot Options </font></p>\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table\n";
print "width=\"42%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"3\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Bot \n";
print "Options:</strong></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Scan \n";
print "posts older than</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> <font face=\"Verdana\"> \n";
print "<input type=\"text\" name=\"old\" value=\"$pon1\" size=\"3\">\n";
print "days</font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Scan \n";
print "posts newer than</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> <font face=\"Verdana\"> \n";
print "<input type=\"text\" name=\"new\" value=\"$pon2\" size=\"3\">\n";
print "days </font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">What \n";
print "should bot do with bad links?</font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<select name=\"act\" size=\"1\">\n";
print "<option value=\"$pon3\" selected>$pon3</option>\n";
print "<option value=\"delete\">delete</option>\n";
print "<option value=\"queue\">queue</option>\n";
print "</select>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"60%\" bgcolor=\"#E6E7C9\"> \n";
print "<p> \n";
print "<input type=\"submit\"\n";
print "name=\"loginadmin\" value=\"Back to main menu\">\n";
print "* \n";
print "</td>\n";
print "<td width=\"40%\" bgcolor=\"#E6E7C9\"> \n";
print "<p> \n";
print "<input type=\"submit\"\n";
print "name=\"savebots\" value=\"Save Changes\">\n";
print "</td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\">&nbsp;</td>\n";
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

sub savebots {
                open(P, ">$botoptions_db") || print "Cant open $botoptions_db REASON ($!)";
                print P "$INPUT{'old'}::$INPUT{'new'}::$INPUT{'act'}";
                close(P);
                &domain;
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

sub decmess {
print "<html>\n";
print "<head>\n";
print "<title>View/Modify Decline Messages</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>View/Modify Decline \n";
print "Messages : </big></font></p><BR>\n";
if ($INPUT{'deldec'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Decline message was removed.</b></font><BR>\n";
}
elsif ($INPUT{'moddec'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Decline message was modified.</b></font><BR>\n";
}
elsif ($INPUT{'adddec'}){
print "  <font face=\"Verdana\" color=\"red\"><B>New decline message was added.</b></font><BR>\n";
}
print "<hr size=\"1\" color=\"#800000\">\n";


print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table width=\"55%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print " \n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Title \n";
print "<br>\n";
print "</font></b><font face=\"Arial\" size=\"3\"> <font size=\"1\">(Max length 255 \n";
print "Characters)</font></font></font>\n";
print "</td>\n";
print " \n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\">\n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Message \n";
print "<br>\n";
print "</font></b><font face=\"Arial\" size=\"1\">(Max Length 1024 Characters)</font></font> \n";
print "</td>\n";
print "</tr>\n";
print "\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"35%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"><font color=\"#000000\"><b>\n";
print "<input type=\"text\" name=\"addtitle\">\n";
print "</b></font></div>\n";
print "</td>\n";
print "<td width=\"65%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<textarea name=\"addmessage\" cols=\"60\" rows=\"5\"></textarea>\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>    \n";
print "<div align=\"center\"><br>\n";
print "<input type=\"submit\" name=\"adddec\" value=\"Add Decline Message\">\n";
print "</div>\n";
print "</form>\n";



print " <table width=\"55%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Title</font></b></font> \n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Modify</font></b></font> \n";
print "</td>\n";
print "</tr>\n";

        my($query) = "SELECT decname FROM DMtgpdeclines";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@decs = $sth->fetchrow)  {
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"80%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"><font color=\"#000000\"><b><font face=\"Arial\">$decs[0]</font></b></font></div>\n";
print "</td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<input type=\"hidden\" name=\"decname\" value=\"$decs[0]\">\n";
print "<input type=\"submit\" name=\"editdecs\" value=\"Submit\">\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
}
print "</table>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<p align=\"center\"><input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\"></p></form>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub editdecs {
        my($query) = "SELECT * FROM DMtgpdeclines where decname = '$INPUT{'decname'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@deco = $sth->fetchrow)  {
print "<html>\n";
print "<head>\n";
print "<title>View/Modify Decline Messages</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Modify or Delete \n";
print "Decline Message: </big></font></p>\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<table width=\"55%\" border=\"0\" align=\"center\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td width=\"18%\" height=\"21\" bgcolor=\"#48486F\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Edit \n";
print "Title <br>\n";
print "</font></b><font face=\"Arial\" size=\"3\"> <font size=\"1\">(Max length 255 \n";
print "Characters)</font></font></font>\n";
print "</td>\n";
print "<td bgcolor=\"#48486F\" width=\"23%\" height=\"21\" align=\"center\"> \n";
print "<p align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial\" size=\"3\">Edit \n";
print "Message <br>\n";
print "</font></b><font face=\"Arial\" size=\"1\">(Max Length 1024 Characters)</font></font>\n";
print "</td>\n";
print "</tr>\n";
print "<tr align=\"center\" valign=\"middle\"> \n";
print "<td width=\"35%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"><font color=\"#000000\"><b>\n";
print "<input type=\"text\" name=\"declinetitle\" value=\"$deco[0]\">\n";
print "</b></font></div>\n";
print "</td>\n";
print "<td width=\"65%\" bgcolor=\"#DCDDD9\"> \n";
print "<div align=\"center\"> <font color=\"#000000\"><b><font face=\"Arial\"> \n";
print "<textarea name=\"declinemess\" cols=\"60\" rows=\"5\">$deco[1]</textarea>\n";
print "</font></b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>        \n";
print "<div align=\"center\"><br>\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"hidden\" name=\"subj\" value=\"$deco[0]\">\n";
print "<input type=\"submit\" name=\"moddec\" value=\"Modify Decline Message\">\n";
print "<input type=\"submit\" name=\"deldec\" value=\"Delete Decline Message\">\n";
print "</div>\n";
print "</form>\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";
}
}

sub deldec {
my $qy = "DELETE FROM DMtgpdeclines WHERE decname ='$INPUT{'subj'}'";
$dbh->do($qy);
&decmess;
}

sub moddec {
$INPUT{'declinemess'} =~ s/"/&quot;/g;
$INPUT{'declinemess'} =~ s/'/&#39;/g;
$INPUT{'declinetitle'} =~ s/"/&quot;/g;
$INPUT{'declinetitle'} =~ s/'/&#39;/g;

        my        $qy = "UPDATE DMtgpdeclines SET decvalue = '$INPUT{'declinemess'}' WHERE decname = '$INPUT{'subj'}'";
         $dbh->do($qy);
        my        $qy = "UPDATE DMtgpdeclines SET decname = '$INPUT{'declinetitle'}' WHERE decname = '$INPUT{'subj'}'";
         $dbh->do($qy);
          &decmess;
 }

 sub adddec {
$INPUT{'addtitle'} =~ s/"/&quot;/g;
$INPUT{'addtitle'} =~ s/'/&#39;/g;
$INPUT{'addmessage'} =~ s/"/&quot;/g;
$INPUT{'addmessage'} =~ s/'/&#39;/g;

        $sql = "INSERT INTO DMtgpdeclines VALUES('$INPUT{'addtitle'}','$INPUT{'addmessage'}')";
$dbh->do($sql);
&decmess;
}

sub mailform {
	
print "<html>\n";
print "<head>\n";
print "<title>Send bulk email</title>\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Email all submitters: \n";
print "</big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<div align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table width=\"65%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr>\n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><b>Email \n";
print "submitters accepted within last</b></font></div>\n";
print "</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"52%\"> <font face=\"Arial, Helvetica, sans-serif\"> \n";
print "<b>\n";
print "<input type=\"text\" name=\"accepted\" value=\"30\">\n";
print "DAYS </b></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\">From \n";
print "Email </font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"52%\"> \n";
print "<div align=\"left\"> \n";
print "<input type=\"text\" name=\"frommail\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\">From \n";
print "Name</font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"52%\"> \n";
print "<div align=\"left\"> \n";
print "<input type=\"text\" name=\"fromname\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\">Subject</font></b></div>\n";
print "</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"52%\"> \n";
print "<div align=\"left\"> \n";
print "<input type=\"text\" name=\"mailsubject\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#FFFFFF\">Message</font></b></font></div>\n";
print "</td>\n";
print "<td bgcolor=\"#DCDDD9\" width=\"52%\"> \n";
print "<div align=\"left\"> \n";
print "<textarea name=\"mailmessage\" cols=\"50\" rows=\"6\"></textarea>\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td colspan=\"2\"> \n";
print "<div align=\"center\"> \n";
print "<input type=\"submit\" name=\"sendemail\" value=\"Mail All Submitters\">\n";
print "* \n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>\n";
print "</form>\n";
print "\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";
exit;
}


sub sendemail {
#set the variables
$accepted = "$INPUT{'accepted'}";
$frommail = "$INPUT{'frommail'}";
$fromname = "$INPUT{'fromname'}";
$mailsubject = "$INPUT{'mailsubject'}";
$mailmessage = "$INPUT{'mailmessage'}";
$daysold = 86400 * $accepted;
$mailtime = $isnow - $daysold;	
# Count how many will be sent.....
$sthy = $dbh->prepare("SELECT COUNT(DISTINCT webemail) FROM DMtgpgalleries WHERE approval = '1' AND stamp >= '$mailtime'") or die "Unable to prepare query: ".$dbh->errstr;
$sthy->execute() or die "Unable to execute query: ".$sthy->errstr;
$count_send = $sthy->fetchrow;



$fin = "0";

$fork = fork();
$fork;

if($fork) {
$dbh->disconnect();
print "<html>\n";
print "<head>\n";
print "<title>Mailing in progress</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "\n";
print "<p align=\"left\"><font face=\"Arial\" color=\"#000000\" size=\"5\"><big>Email all submitters: \n";
print "</big></font></p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<form method=\"POST\" action=\"$adminurl\">\n";
print "<div align=\"center\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table width=\"65%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" width=\"48%\"> \n";
print "<div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><b>Email \n";
print "is currently being sent to $count_send users.</b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Back to Main Menu\">\n";
print "</div>\n";
print "</form>\n";
print "\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "\n";
print "<hr size=\"1\" color=\"#800000\" align=\"center\">\n";
print "</body>\n";
print "</html>\n";

	exit(0);
}

else {
	close (STDOUT);

$query = "SELECT DISTINCT webemail FROM DMtgpgalleries WHERE approval = '1' AND stamp >= '$mailtime'";
$sth = $dbh->prepare($query);
$sth->execute || die("Could not execute!");

open(FILE, ">$filesdir\/mailtemp");
flock (FILE, 2);
while(@row = $sth->fetchrow)  {
print FILE "$row[0]\n";
}
flock (FILE, 8);
close(FILE); 

	open(FILE2, "<$filesdir\/mailtemp");
	flock FILE2, 2;
	@list = <FILE2>;
	flock FILE2, 8;
	close(FILE2);
	$i=0;
	foreach $list (@list) {
	chomp $list;

	
	#Do the emailing...
	open (MAIL, "|$mailprog") || die "Cant open mailprog at $mailprog";
	print MAIL "To: $list\n";
	print MAIL "Reply-to: $frommail<$frommail>\n";
	print MAIL "From: $fromname <$fromname>\n";
	print MAIL "Subject: $mailsubject\n\n"; 
	
	
	#slap in the message...
	print MAIL "$mailmessage";
	close (MAIL);
	$i++;
	}

	


#	 #Send a confirmation email to the admin, along with a few stats.
	open (MAIL, "|$mailprog") || die "Cant open mail prog at $mailprog";
	print MAIL "To: $adminemail\n";
	print MAIL "Reply-to: $adminemail <$adminemail>\n";
	print MAIL "From: TGPSystem <TGPSystem>\n";
	print MAIL "Subject: Bulk Confirmation E-Mail \n\n";
	print MAIL "\n";
	print MAIL "	Hello,\n";
	print MAIL "\n";
	print MAIL "This email is to confirm that your email was successfully sent to $i\n";
	print MAIL "webmasters. Webmasters who had their galleries accepted in the last $accepted\n";
	print MAIL "days were emailed. The following message was delivered:\n";
	print MAIL "\n";
	print MAIL "---\n";
	print MAIL "$mailmessage\n";
	print MAIL "---\n";
	print MAIL "\n";
	print MAIL "Thanks!\n";
	print MAIL "TGP Script\n";
	close(MAIL);
	
	unlink("$filesdir\/mailtemp");
	
exit;
	
}
# End email sub..
}


sub decall {

my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE webdate = '$INPUT{'appdate'}' AND approval='0' and vermail = '1'") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $coun = $sth->fetchrow;

print "<html>\n";
print "<head>\n";
print "<title>Confirm Mass Delete</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\"><!--CyKuH-->\n";
print "<p><font face=\"Verdana\"><b>Are you sure you want to delete all <font color=\"#FF0000\">$coun</font> \n";
print "unreviewed galleries submitted on <font color=\"#FF0000\">$INPUT{'appdate'}</font>?</b></font></p>\n";
print "<p><b><font face=\"Verdana\">You can not undo this you know!</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"hidden\" name=\"datetomod\" value=\"$INPUT{'appdate'}\">\n";
print "<p><input type=\"submit\" name=\"deleteallday\" value=\"YES - Do it!\">\n";
print "</p>\n";
print "<p>\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"NO WAY - Return to Main Menu\">\n";
print "</p>\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub deleteallday {
my $qy = "DELETE FROM DMtgpgalleries WHERE webdate ='$INPUT{'datetomod'}' AND approval='0'";
$dbh->do($qy);
&domain;
}	

sub appall {

my $sth = $dbh->prepare("SELECT COUNT(idnum) FROM DMtgpgalleries WHERE webdate = '$INPUT{'appdate'}' AND approval='0' and vermail='1'") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $coun = $sth->fetchrow;

print "<html>\n";
print "<head>\n";
print "<title>Confirm Mass Approve</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<div align=\"center\">\n";
print "<p><font face=\"Verdana\"><b>Are you sure you want to approve all <font color=\"#FF0000\">$coun</font> \n";
print "unreviewed galleries submitted on <font color=\"#FF0000\">$INPUT{'appdate'}</font>?</b></font></p>\n";
print "<p><b><font face=\"Verdana\">You can not undo this you know!</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"hidden\" name=\"datetomod\" value=\"$INPUT{'appdate'}\">\n";
print "<p><input type=\"submit\" name=\"approveallday\" value=\"YES - Do it!\">\n";
print "</p>\n";
print "<p>\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"NO WAY - Return to Main Menu\"><!--CyKuH-->\n";
print "</p>\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub approveallday {
my $qy = "UPDATE DMtgpgalleries SET approval = '1' WHERE webdate ='$INPUT{'datetomod'}' and vermail='1'";
$dbh->do($qy);
&domain;
}

sub partnermenu {
print "<html>\n";
print "<head>\n";
print "<title>Partner Management</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
print "</head>\n";
print "\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<p></font></b><big><big><font face=\"Arial\"><font color=\"#000000\">Partner Management\n";
print ":</font> </font></big><font color=red>\n";
if ($INPUT{'savenewpartner'}){
print "  <font face=\"Verdana\" color=\"red\"><B>New Partner Was Saved!</b></font><BR>\n";
} 
elsif ($INPUT{'savemodpartner'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Partner Was Modified!</b></font><BR>\n";
}
elsif ($INPUT{'delpartner'}){
print "  <font face=\"Verdana\" color=\"red\"><B>Partner Was Deleted!</b></font><BR>\n";
}
print "<HR><BR><form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<table border=\"0\"\n";
print "width=\"30%\" style=\"border: 2px solid rgb(0,0,0)\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\">\n";
print "<big><font color=\"#000000\" face=\"Verdana\"> \n";
print "<tr> \n";
print "<td colspan=\"2\" bgcolor=\"#48486F\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>Partner \n";
print "Management Options:</strong></font> </td>\n";
print "</tr>\n";
print "<tr align=\"center\"> \n";
print "<td width=\"54%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><small><font\n";
print "color=\"#800000\" face=\"Arial\"><b>Add Partner</b></font></small></td>\n";
print "<td width=\"46%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"> \n";
print "<input\n";
print "type=\"submit\" value=\"Submit\" name=\"addpartner\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</td>\n";
print "</tr>\n";
print "<tr align=\"center\"> \n";
print "<td width=\"54%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#8000000\"><b>View/Edit \n";
print "Partners </b></font></td>\n";
print "<td width=\"46%\" bgcolor=\"#DCDDD9\" style=\"border-top: 2px solid rgb(0,0,0)\" align=\"left\"><big><font color=\"#000000\" face=\"Verdana\"> \n";
print "<input\n";
print "type=\"submit\" value=\"Submit\" name=\"listpartner\"\n";
print "style=\"background-color: rgb(230,231,201); color: rgb(0,0,0)\">\n";
print "</font></big></td>\n";
print "</tr>\n";
print "</font></big><big> </big> \n";
print "</table>\n";
print "</form>\n";
print "<div align=\"center\"></div>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub addpartner {
print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Manual Gallery Submission</title>\n";
print "</head>\n";
print "<body bgcolor=\"white\">\n";
print "<p align=\"left\"><font face=\"Arial, Helvetica, sans-serif\" size=\"6\">Add Partners:</font></p>\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<p align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Add partners \n";
print "here. You can elect to allow your preferred submitters posts to be automatically \n";
print "approved and assign them a permanent rating to make sure their galleries appear \n";
print "higher in your listings.</font></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<font face=\"Arial, Helvetica, sans-serif\"> \n";
print "</font> \n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<table border=\"0\"\n";
print "cellpadding=\"0\" cellspacing=\"1\" width=\"55%\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" colspan=\"2\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><strong>Partner \n";
print "Information:</strong></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Name</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\"\n";
print "name=\"name\" size=\"20\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Email \n";
print "Address</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\"\n";
print "name=\"email\" size=\"30\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Password</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\" name=\"password\"\n";
print "size=\"30\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Max \n";
print "Submissions Per Day</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\" name=\"msd\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Automatically \n";
print "Approve </b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<select name=\"app\">\n";
print "<option value=\"0\">No</option>\n";
print "<option value=\"1\">Yes</option>\n";
print "</select>\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Default \n";
print "Rating</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<select name=\"drate\">\n";
print "<option value=\"1\">1</option>\n";
print "<option value=\"2\">2</option>\n";
print "<option value=\"3\">3</option>\n";
print "<option value=\"4\">4</option>\n";
print "<option value=\"5\">5</option>\n";
print "<option value=\"6\">6</option>\n";
print "<option value=\"7\">7</option>\n";
print "<option value=\"8\">8</option>\n";
print "<option value=\"9\">9</option>\n";
print "<option value=\"10\">10</option>\n";
print "<option value=\"99\" selected>Default</option>\n";
print "</select>\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\">.</font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"> <font face=\"Arial, Helvetica, sans-serif\"> \n";
print "<input type=\"submit\" value=\"Add Partner\" name=\"savenewpartner\">\n";
print " \n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\">\n";
print "</font></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<p>&nbsp;</p>\n";
print "</center>\n";
print "</div>\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<p>&nbsp;</p>\n";
print "</center>\n";
print "</div>\n";
print "</form>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub savenewpartner {
$sql = "INSERT INTO DMtgppartners VALUES('$INPUT{'name'}','$INPUT{'email'}','$INPUT{'password'}','$INPUT{'msd'}','$INPUT{'app'}','$INPUT{'drate'}')";
$dbh->do($sql);
&partnermenu;
}

sub listpartner {	
print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Manage Categories</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\" text=\"#000000\">\n";
print "<p><font face=\"Arial, Helvetica, sans-serif\" size=\"4\"><b>Manage Existing Partners:</b></font></p>\n";
print "<hr size=\"1\" color=\"#800000\">\n";
print "<div align=\"center\"><center>\n";
print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"2\" width=\"80%\" bordercolor=\"#FFFFFF\"\n";
print "style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><b><strong><font color=\"#FFFFFF\" face=\"Arial, Helvetica, sans-serif\" size=\"3\">Partner \n";
print "Name &amp; Email</font></strong></b></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><b><strong><font color=\"#FFFFFF\" face=\"Arial, Helvetica, sans-serif\" size=\"3\">Total \n";
print "# Of Posts Made</font></strong></b></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><b><strong><font color=\"#FFFFFF\" face=\"Arial, Helvetica, sans-serif\" size=\"3\">View \n";
print "Details &amp; Modify</font></strong></b></td>\n";
print "</tr>\n";
        my($query) = "SELECT * FROM DMtgppartners ORDER BY affname";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@part = $sth->fetchrow)  {
        $pname = $part[0];
        $pmail = $part[1];
        
        my $sth = $dbh->prepare("SELECT COUNT(affname) FROM DMtgppposts WHERE affname = '$pname'") or die "Unable to prepare query: ".$dbh->errstr;
		$sth->execute() or die "Unable to execute query: ".$sth->errstr;
		my $coun = $sth->fetchrow;
		
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"><b><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><a href=\"mailto:$pmail\">$pname</a></font></b></td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"><b><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\">$coun</font></b></td>\n";
print "<td width=\"20%\" bgcolor=\"silver\" align=\"center\"> \n";
print "<p> <b><font face=\"Arial, Helvetica, sans-serif\"><input type=\"hidden\" name=\"modusr\" value=\"$pname\">\n";
print "<input type=\"Submit\" value=\"View/Modify\" name=\"viewmodpartner\" style=\"background-color: rgb(72,72,111); color: rgb(255,255,255)\">\n";
print "</font></b></p>\n";
print "</td>\n";
print "</tr>\n";
print "</form> \n";
}
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "<p align=\"center\">&nbsp;</p>\n";
print "</body>\n";
print "</html>\n";

exit;
}

sub viewmodpartner {
        my($query) = "SELECT * FROM DMtgppartners WHERE affname = '$INPUT{'modusr'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@part = $sth->fetchrow)  {
        $pname = $part[0];
        $pmail = $part[1];
        $ppass = $part[2];
        $pppd = $part[3];
        $papp = $part[4];
        $pdra = $part[5];
        }
print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>View/Modify Parter: $INPUT{'modusr'}</title>\n";
print "</head>\n";
print "<body bgcolor=\"white\">\n";
print "<p align=\"left\"><font face=\"Arial, Helvetica, sans-serif\" size=\"6\">View/Modify Partner: $INPUT{'modusr'}</font></p>\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<font face=\"Arial, Helvetica, sans-serif\"> \n";
print "</font> \n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<table border=\"0\"\n";
print "cellpadding=\"0\" cellspacing=\"1\" width=\"55%\" style=\"border: 2px solid rgb(0,0,0)\">\n";
print "<tr> \n";
print "<td bgcolor=\"#48486F\" colspan=\"2\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#FFFFFF\"><strong>Partner \n";
print "Information:</strong></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Name</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\"\n";
print "name=\"name\" size=\"20\" value=\"$pname\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Email \n";
print "Address</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\"\n";
print "name=\"email\" size=\"30\" value=\"$pmail\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Password</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\" name=\"password\" value=\"$ppass\"\n";
print "size=\"30\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Max \n";
print "Submissions Per Day</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<input type=\"text\" name=\"msd\" value=\"$pppd\">\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Automatically \n";
print "Approve </b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<select name=\"app\">\n";
if ($papp eq "1"){ 
$rval = "Yes";
 } else {
 	$rval = "No";
 }
print "<option value=\"$papp\" selected>$rval</option>\n";
print "<option value=\"0\">No</option>\n";
print "<option value=\"1\">Yes</option>\n";
print "</select>\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\"><b>Default \n";
print "Rating</b></font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"><font face=\"Arial, Helvetica, sans-serif\"><b> \n";
print "<select name=\"drate\">\n";
if ($pdra eq "99"){ 
$rval2 = "Default";
 } else {
 	$rval2 = "$pdra";
 }
print "<option value=\"$pdra\" selected>$rval2</option>\n";
print "<option value=\"1\">1</option>\n";
print "<option value=\"2\">2</option>\n";
print "<option value=\"3\">3</option>\n";
print "<option value=\"4\">4</option>\n";
print "<option value=\"5\">5</option>\n";
print "<option value=\"6\">6</option>\n";
print "<option value=\"7\">7</option>\n";
print "<option value=\"8\">8</option>\n";
print "<option value=\"9\">9</option>\n";
print "<option value=\"10\">10</option>\n";
print "<option value=\"99\">Default</option>\n";
print "</select>\n";
print "</b></font></td>\n";
print "</tr>\n";
print "<tr bgcolor=\"#800000\"> \n";
print "<td bgcolor=\"#E6E7C9\" width=\"261\"><font color=\"#000000\" face=\"Arial, Helvetica, sans-serif\">.</font></td>\n";
print "<td bgcolor=\"#E6E7C9\" width=\"279\"> <font face=\"Arial, Helvetica, sans-serif\"> \n";
print "<input type=\"hidden\" name=\"user\" value=\"$INPUT{'modusr'}\"><input type=\"submit\" value=\"Modify Partner\" name=\"savemodpartner\">\n";
print "<input type=\"submit\" name=\"delpartner\" value=\"Delete Partner\">\n";
print "</font></td>\n";
print "</tr>\n";
print "</table>\n";
print "</center>\n";
print "</div>\n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<p>&nbsp;</p>\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Back to main menu\">\n";
print "</center>\n";
print "</div>\n";
print "<hr size=\"1\" align=\"left\" color=\"#800000\">\n";
print "<div align=\"center\"> \n";
print "<center>\n";
print "<p>&nbsp;</p>\n";
print "</center>\n";
print "</form>\n";


print "<p align=\"left\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\"><b>View \n";
print "posts made by this user by time period:</b></font></p>\n";
print "<table width=\"35%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
print "<tr bgcolor=\"#48486F\"> \n";
print "<td> \n";
print "<div align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial, Helvetica, sans-serif\">Year</font></b></font></div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial, Helvetica, sans-serif\">Month</font></b></font></div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial, Helvetica, sans-serif\">Day</font></b></font></div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"><font color=\"#FFFFFF\"><b><font face=\"Arial, Helvetica, sans-serif\">View</font></b></font></div>\n";
print "</td>\n";
print "</tr>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<tr bgcolor=\"silver\"> \n";
print "<td> \n";
print "<div align=\"center\"> \n";
print "<select name=\"yr\">\n";
print "<option value=\"2002\" selected>2002</option>\n";
print "<option value=\"2003\">2003</option>\n";
print "<option value=\"2004\">2004</option>\n";
print "<option value=\"2005\">2005</option>\n";
print "</select>\n";
print "</div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"> \n";
print "<select name=\"mo\">\n";
print "<option value=\"1\" selected>1</option>\n";
print "<option value=\"2\">2</option>\n";
print "<option value=\"3\">3</option>\n";
print "<option value=\"4\">4</option>\n";
print "<option value=\"5\">5</option>\n";
print "<option value=\"6\">6</option>\n";
print "<option value=\"7\">7</option>\n";
print "<option value=\"8\">8</option>\n";
print "<option value=\"9\">9</option>\n";
print "<option value=\"10\">10</option>\n";
print "<option value=\"11\">11</option>\n";
print "<option value=\"12\">12</option>\n";
print "</select>\n";
print "</div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"> \n";
print "<select name=\"da\">\n";
print "<option value=\"1\" selected>1</option>\n";
print "<option value=\"2\">2</option>\n";
print "<option value=\"3\">3</option>\n";
print "<option value=\"4\">4</option>\n";
print "<option value=\"5\">5</option>\n";
print "<option value=\"6\">6</option>\n";
print "<option value=\"7\">7</option>\n";
print "<option value=\"8\">8</option>\n";
print "<option value=\"9\">9</option>\n";
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
print "</select>\n";
print "</div>\n";
print "</td>\n";
print "<td> \n";
print "<div align=\"center\"><input type=\"hidden\" name=\"user\" value=\"$INPUT{'modusr'}\">\n";
print "<input type=\"submit\" name=\"viewpartsubs\" value=\"Submit\">\n";
print "</div>\n";
print "</td>\n";
print "</tr>\n";
print "</form>\n";
print "</table>\n";
print "</body>\n";
print "</html>\n";
exit;
}

sub savemodpartner {
	my $qy = "UPDATE DMtgppartners SET email = '$INPUT{'email'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgppartners SET passw = '$INPUT{'password'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgppartners SET ppd = '$INPUT{'msd'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgppartners SET app = '$INPUT{'app'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgppartners SET drate = '$INPUT{'drate'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
	my $qy = "UPDATE DMtgppartners SET affname = '$INPUT{'name'}' WHERE affname ='$INPUT{'user'}'";
	$dbh->do($qy);
&partnermenu;
}

sub viewpartsubs {

print "<html>\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">\n";
print "<title>Partner Galleries</title>\n";
print "</head>\n";
print "<body bgcolor=\"#FFFFFF\">\n";
print "<div align=\"center\"><center>\n";
print "<p align=\"left\"><b><font face=\"Arial, Helvetica, sans-serif\" size=\"4\">View \n";
print "Posts From $INPUT{'user'} for $INPUT{'mo'}-$INPUT{'da'}-$INPUT{'yr'}</font></b></p>\n";
print "<hr>\n";
print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"80%\" bordercolor=\"#FFFFFF\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial\" size=\"3\"\n";
print "color=\"#FFFFFF\"><b>URL</b></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#48486F\" align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"4\"><b><font color=\"#FFFFFF\">Date</font></b></font></td>\n";
print "</tr>\n";

        my($query) = "SELECT * FROM DMtgppposts WHERE DAYOFMONTH(date) = '$INPUT{'da'}' AND MONTH(date) = '$INPUT{'mo'}' AND YEAR(date) = '$INPUT{'yr'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        while(@partp = $sth->fetchrow)  {
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print "<input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<tr> \n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"left\"><font face=\"Verdana\" size=\"1\"\n";
print "color=\"#800000\"><a href=\"$partp[1]\" target=\"_blank\">$partp[1]</a></font></td>\n";
print "<td width=\"20%\" bgcolor=\"#DCDDD9\" align=\"center\">$partp[2]</td>\n";
print "</tr>\n";
print "</form>\n";

}
print "</table>\n";
print "</center></div>\n";
print "<hr width=\"100%\" size=\"1\" align=\"center\" color=\"#800000\">\n";
print "</body>\n";
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
print "name=\"adminpass\" value=\"$adminpwd\">";
print "<table\n";
print "width=\"50%\" border=\"0\" style=\"border: 2px solid rgb(0,0,0)\" cellspacing=\"1\"\n";
print "cellpadding=\"2\">\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#48486F\" colspan=\"3\"><font color=\"#FFFFFF\" face=\"Arial\"><strong>TGPBase \n";
print "Options :</strong></font></td>\n";
print "</tr>\n";
print "<tr> \n";
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Currently \n";
print "a TGPBase.com PAID member?<BR>TGPBase.com </font></td>\n";
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
print "<td width=\"100%\" bgcolor=\"#E6E7C9\" colspan=\"2\"><font face=\"Verdana\" color=\"#000000\">Default \n";
print "rating for galleries from TGPBase.com. </font></td>\n";
print "<td width=\"19%\" bgcolor=\"#E6E7C9\"> \n";
print "<select name=\"dratetgpb\">\n";
if ($tgp5 eq "99"){ 
$rval2 = "Default";
 } else {
 	$rval2 = "$tgp5";
 }
print "<option value=\"$tgp5\" selected>$rval2</option>\n";
print "<option value=\"1\">1</option>\n";
print "<option value=\"2\">2</option>\n";
print "<option value=\"3\">3</option>\n";
print "<option value=\"4\">4</option>\n";
print "<option value=\"5\">5</option>\n";
print "<option value=\"6\">6</option>\n";
print "<option value=\"7\">7</option>\n";
print "<option value=\"8\">8</option>\n";
print "<option value=\"9\">9</option>\n";
print "<option value=\"10\">10</option>\n";
print "<option value=\"99\">Default</option>\n";
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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
print "name=\"adminpass\" value=\"$adminpwd\">";
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
                open(Q, ">$tgpoptions_db") || print "Cant open $tgpoptions_db REASON ($!)";
                print Q "$INPUT{'member'}::$INPUT{'myusername'}::$INPUT{'mypassword'}::$INPUT{'autoapprove'}::$INPUT{'dratetgpb'}";
                close(Q);
                &domain;
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
#my $agent = new LWP::UserAgent;
my $agent = LWP::UserAgent->new; 
 
$agent->timeout(30); 
my $req = HTTP::Request->new(GET => "$pre$auth$location");
#$req->header('Accept' => 'text/html');
#if ($tgp1 eq "yes") {
$jc=$agent->request($req)->as_string;
if($jc =~ /Authorization Required/g) {
print "<div align=\"center\"><font face=\"Verdana\"><b>Sorry, access was denied. Contact \n";
print "  support\@mydomain.com if you feel this is an error.</b></font></div>\n";
#print "$jc\n";
exit;
}
#} 
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Click here to return to the main menu.\">\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
unlink gall;
exit;
}

    if (!$gurl){
        	print "</b></font></p>\n";
print "<p>&nbsp;</p>\n";
print "<p>&nbsp;</p>\n";
print "<p><b><font face=\"Arial, Helvetica, sans-serif\" size=\"4\" color=\"#FF0000\">ERROR!<BR> \n";
print "</font></b></p>\n";
print "<form name=\"form1\" method=\"post\" action=\"$adminurl\">\n";
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
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
      $sql = "INSERT INTO DMtgpgalleries VALUES('TGPBASE.COM','galleries\@tgpbase.com','$gurl','$gcat','$gpics','$gdesc','$gd','$gdc','$apstat',$newpid,'000.000.000.000','00000000','1','$isnow','$tgp5','0')";
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
print " <input type=\"hidden\" name=\"adminuser\" value=\"$adminname\"><input type=\"hidden\" name=\"adminpass\" value=\"$adminpwd\">\n";
print "<input type=\"submit\" name=\"loginadmin\" value=\"Click here to return to the main menu.\">\n";
print "</form>\n";
print "<p>&nbsp;</p>\n";
print "</div>\n";
print "</body>\n";
print "</html>\n";
unlink gall;

exit;
}

sub delpartner {
my $qy = "DELETE from DMtgppartners WHERE affname = '$INPUT{'user'}'";
$dbh->do($qy);
&partnermenu;
}

sub gloc {
$pre = MIME::Base64::decode("aHR0cDovLw==");
if ($tgp1 eq "yes") {
$auth="$tgp2\:$tgp3\@";
	$location = MIME::Base64::decode("d3d3LnRncGJhc2UuY29tL2RhdGEvcGFpZC9nYWxsZXJpZXMucGw=");
	} else {
	$location = MIME::Base64::decode("d3d3LnRncGJhc2UuY29tL2RhdGEvZnJlZS9nYWxsZXJpZXMucGw=");
	}
}


