#!/usr/bin/perl
###########################################################################
# DATE:                   September 11, 2000 ICSv4.0
# PROGRAM:                ICSengine.cgi
# DESCRIPTION:            Main Cloaking and spider detection engine.
#	       				  
#
# COPYRIGHT 2000 by ICS Avenue. No portion of this script may be offered
# for re-sale or re-distribution without express written permission.
#
# http://www.icsave.com      info@icsave.com
#
###########################################################################


#############################
# Set environment variables 
#############################
$AC = "$ENV{'HTTP_ACCEPT'}"; # image, application, etc.
$KA = "$ENV{'HTTP_CONNECTION'}"; #Keep-Alive
$RE = "$ENV{'HTTP_REFERER'}"; # Where visitor came from
$AL = "$ENV{'HTTP_ACCEPT_LANGUAGE'}"; # Accept what language
$RH = "$ENV{'HTTP_USER_AGENT'}"; #Mozilla, Scooter, etc.
$RA = "$ENV{'REMOTE_ADDR'}"; # IP address of visitor

#############################
# Get all variables         
#############################

eval {

require "default.cgi";
require "options.cgi";

};

if ($@) {
print "Error including required files: $@\n\n";
print "Make sure these files exist, permissions\n";
print "are set properly, and paths are set correctly.\n\n";
exit;
}

if($UsingURI eq "yes"){$PageRequested = $ENV{'REQUEST_URI'}}
if($UsingURI eq "no"){$PageRequested = "\/" . $ENV{'QUERY_STRING'}}

#######################################
#Determine the page location
#######################################
if($DirMirror eq "no"){
@pagename = split(/\//, $PageRequested);
if ($pagename[0] =~ /\./) {
   $PageRequested = "/$pagename[0]";
   }
if ($pagename[1] =~ /\./) {
   $PageRequested = "/$pagename[1]";
   }
if ($pagename[2] =~ /\./) {
   $PageRequested = "/$pagename[2]";
   }
if ($pagename[3] =~ /\./) {
   $PageRequested = "/$pagename[3]";
   }
if ($pagename[4] =~ /\./) {
   $PageRequested = "/$pagename[4]";
   }
}

if ($PageRequested eq "/") {
   if ($html eq "yes") {
   $PageRequested = "/index.html";
   }
   if ($html eq "no") {
   $PageRequested = "/index.htm";
   }
   if ($html eq "shtml") {
   $PageRequested = "/index.shtml";
   }
}

#############################################
# Eliminate 99% of human visitors if enabled
#############################################
$acscore = 0; 
$kascore = 0; 
$rescore = 0;
$alscore = 0;
$rhscore = 0;

if($MultiStage1 eq "Active"){
   if($AC){ $acscore = 1}
   if($KA =~ /Keep-Alive/i){ $kascore = 1}
   if($RE){ $rescore = 1}
   if($AL){ $alscore = 1}
   if($RH =~ /Mozilla|Opera|Konqueror|Lynx/){ $rhscore = 1}
   $totscore_stage1 = $acscore + $kascore + $rescore + $alscore + $rhscore;
   if($totscore_stage1 >= 4){
       $HowCaught3 = "Score calcutated at 4 or greater from MultiStage1 filter - serving human page";
       &Human;
       }
}
###########################################
# Save the class c of visitor to compare
#
# If we are here then the visitor has
# already failed the 99% human check
# if MultiStage1 has been enabled
###########################################
($IP1, $IP2, $IP3, $IP4) = split(/\./, $RA);
$classcOfRA = "$IP1.$IP2.$IP3.";

   open(IPENGINE,"$filepath/$IPDirectory/IPlist.pl") or &dienice("cannot open 
        $filepath/$IPDirectory/IPlist.pl");
   @iplst = <IPENGINE>;
   close (IPENGINE);


   foreach $entry(@iplst){
     $ipmatch = 0;
     $uamatch = 0;
     $kascore2 = 0; 
     $rescore2 = 0;
     $alscore2 = 0;
     $rhscore2 = 0;
     $classc = 0;
        chomp ($entry);
     ($IPaddress, $Directory, $Agent) = split(/=/, $entry);
     $IPaddress =~ s/\///g;
     $Agent =~ s/\s+$//;
     $Agent =~ s/&|\///g;


     if($RA =~ /$IPaddress/){ $ipmatch = 1}
     if($RH =~ /$Agent/){ $uamatch = 1}
     if($IPaddress =~ /$classcOfRA/){ $classc = 1}
     if($KA =~ /Keep-Alive/i){ $kascore2 = 1}
     if($RE){ $rescore2 = 1}
     if($AL){ $alscore2 = 1}
     if($RH =~/Mozilla|Opera|Konqueror|Lynx/){ $rhscore2 = 1}
     if($ServeAllFromHere eq "Active"){ $Directory = "$DefaultDir1"}

   # *IP STAGE1 Match Occurred*
   # if the IP Address matches and IPStage1 is on then let it have the cloaked page
     if(($ipmatch == 1) && ($IPStage1 eq "Active")){
        $GotIt = "yes";
        $HowCaught = "The IP Address of this spider was matched from the";
        $HowCaught1 = "ICS IP database. The cloaked page has been retrieved from";
        $HowCaught2 = "$filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***IP STAGE1 Detection Occurred***"; 
        &SendSpiderNotify;
        &SEMatch;
        }

   # *IP STAGE2 Match Occurred*
   # if the class c IP matches and UA matches and stage2 is on then serve cloaked page
     if(($classc == 1) && ($uamatch == 1) && ($IPStage2 eq "Active")){ 
        $GotIt = "yes";
        $HowCaught = "The IP Address of this spider matched the class \"c\"";
        $HowCaught1 = "of an IP address in the ICS database AND matched the user agent.";
        $HowCaught2 = "The cloaked page has been retrieved from $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***IP STAGE2 Detection Occurred***"; 
        &SendSpiderNotify;
        &SEMatch;
        }

   # *IP STAGE3 Match Occurred*
   # if the classc-referrer-keepalive match fp and stage3 is on then serve cloaked page
     if(($classc == 1) &&
        ($rescore2 == 0) &&
        ($KA =~ /close/i || $KA eq "") &&
        ($ENV{'HTTP_FROM'}) &&
        ($alscore2 == 0) &&
        ($IPStage3 eq "Active")){ 
        $GotIt = "yes";
        $HowCaught = "The IP Address of this spider matched the class \"c\"";
        $HowCaught1 = "of an IP address in the ICS database AND matched STAGE3 footprint.";
        $HowCaught2 = "The cloaked page has been retrieved from $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***IP STAGE3 Detection Occurred***"; 
        &SendSpiderNotify;
        &SEMatch;
        }

   # *UA STAGE1 Detection Occurred*
   # If user agent matches AND STAGE1 spider footprint detected serve cloaked page
     if(($uamatch == 1) &&
        ($alscore2 == 0) &&
        ($rescore2 == 0) &&
        ($KA =~ /close/i || $KA eq "") &&
        ($ENV{'HTTP_FROM'}) &&
        ($UAStage1 eq "Active")){ 
        $GotIt = "yes";
        $HowCaught = "UA STAGE1";
        $HowCaught1 = "multi stage spider detection occurred, the cloaked";
        $HowCaught2 = "page has been retrieved from\n $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***USER AGENT STAGE1 Detection Occurred***"; 
        if(($ipmatch == 0) && ($UAWarn1 eq "Active")){ &WarnNewIP}
        &SendSpiderNotify;
        &SEMatch; 
        }

   # *UA STAGE2 Detection Occurred*
   # If user agent matches AND STAGE2 spider footprint detected serve cloaked page
     if(($uamatch == 1) &&
        ($alscore2 == 0) &&
        ($rescore2 == 0) &&
        ($KA =~ /close/i || $KA eq "") &&
        ($UAStage2 eq "Active")){ 
        $GotIt = "yes";
        $HowCaught = "UA STAGE2";
        $HowCaught1 = "multi stage spider detection occurred, the cloaked";
        $HowCaught2 = "page has been retrieved from\n $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***USER AGENT STAGE2 Detection Occurred***"; 
        if(($ipmatch == 0) && ($UAWarn1 eq "Active")){ &WarnNewIP}
        &SendSpiderNotify;
        &SEMatch; 
        }

   # *UA STAGE3 Detection Occurred*
   # If user agent matches And serve by ua is on serve cloaked page
     if(($uamatch == 1) && ($UAStage3 eq "Active")){ 
        $GotIt = "yes";
        $HowCaught = "A User Agent match occurred, no other";
        $HowCaught1 = "Multi Stage spider detection occurred, the cloaked";
        $HowCaught2 = "page has been retrieved from\n $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***USER AGENT STAGE3 Detection Occurred***";
        if(($ipmatch == 0) && ($UAWarn1 eq "Active")){ &WarnNewIP} 
        &SendSpiderNotify;
        &SEMatch; 
        }
    
  sub WarnNewIP{
      # *UA Detection Occurred* 
      # If user agent matches AND Warning is on then
      # send a warning e-mail and show the human page.

        foreach $entry1(@iplst){
         chomp ($entry1);
         ($IPaddress1, $Directory1, $Agent1) = split(/=/, $entry1);
          $IPaddress1 =~ s/\///g;
            if($RA =~ /$IPaddress1/){ $ipmatchwarn = 1}
        }

     if(($uamatch == 1) && ($ipmatchwarn == 0) && ($UAWarn1 eq "Active")){
        $ETitle = "WARNING!! $Agent detected by User Agent\n\n";
        $HowWarn = "You have received this warning because you have";
        $HowWarn1 = "requested to be notified of Agents requesting pages for";
        $HowWarn2 = "which a known search engine IP Address was not found";
        $HowWarn3 = "***NEW IP By USER AGENT Detection Occurred***";  
        &SendNotify;
        }

    }

 }

   # *GE STAGE1 Match Occurred* needs to be outside loop - not dependent on iplist
   # if the lang-referrer-keepalive match fp and GE Stage1 is on, then serve cloaked page
     if(($alscore2 == 0) &&
        ($rescore2 == 0) &&
        ($KA =~ /close/i || $KA eq "" ) &&
        ($ENV{'HTTP_FROM'}) &&
        ($rhscore2 == 0) &&
        ($IPStage4 eq "Active")){
        $GotIt = "yes";
        $Directory = "$DefaultDir2"; 
        $HowCaught = "No IP address or UA match. ICS has detected a  full spider footprint,";
        $HowCaught1 = "but cannot determine which spider. Retrieving page content from  GE STAGE1 directory.";
        $HowCaught2 = "Cloaked page retrieved from $filepath/$Directories/$Directory$PageRequested";
        $HowCaught3 = "***GE STAGE1 Detection Occurred***"; 
        if(($ipmatch == 0) && ($UAWarn1 eq "Active")){ &WarnNewIP}
        &SendSpiderNotify;
        &SEMatch;
        }


     # IF *SpiderLike Enabled*
        if(($alscore2 == 0) &&
           ($rescore2 == 0) &&
           ($KA =~ /close/i || $KA eq "") &&
           ($rhscore2 == 0) &&
           ($GotIt ne "yes") &&
           ($SpiderLike eq "Active")){

           $when = localtime;
           open (SPIDERLIKE, ">>$filepath/$IPDirectory/footprints.log") or &dienice ("Cannot open $filepath/$IPdirectory/footprints.log");
                print SPIDERLIKE "$when -- ";
                print SPIDERLIKE "$ENV{'REMOTE_HOST'}|";
                if($ENV{'HTTP_FROM'}){
                             print SPIDERLIKE "**$ENV{'HTTP_USER_AGENT'}**|";
                         }else{
                             print SPIDERLIKE "$ENV{'HTTP_USER_AGENT'}|";
                              }
                if($ENV{'HTTP_FROM'}){
                          print SPIDERLIKE "**$ENV{'REMOTE_ADDR'}**|";
                         }else{
                             print SPIDERLIKE "$ENV{'REMOTE_ADDR'}|";
                              }
                print SPIDERLIKE "$ENV{'HTTP_REFERER'}|";
                print SPIDERLIKE "$DomainName$PageRequested\n";
                close (SPIDERLIKE);
                $FoundUnknown = "yes";

                }

 

sub SendNotify {
open (MAILW, "|$PathToMail -t");
print MAILW "To: $EmailAddy\n";
print MAILW "From: $EmailAddy (ICS4.0)\n";
print MAILW "Subject: $ETitle\n\n";
print MAILW "The User Agent: $RH\n visited using IP Address: $RA\n\n";
print MAILW "Looking for: $DomainName$PageRequested\n\n";
print MAILW "This IP address is NOT in the list of addresses that\n";
print MAILW "ICS currently matches for this Search Engine. It could be someone\n";
print MAILW "faking a user agent in an attempt to view your cloaked page,\n";
print MAILW "or a new valid IP address for $RH.\n If it is a valid ";
print MAILW "address for this user agent you may add it to the IP list\n";
print MAILW "in the script. You can check this IP at http://network-tools.com/\n";
print MAILW "to determine who the probable visitor might have been.\n\n";
print MAILW "You can also check the IP Tools at the ICS members only area\n";
print MAILW "and do a search on $RA to see if it was recently added to the list.\n\n";
print MAILW "In addition you can use the NS Lookup tool included with ICS to\n";
print MAILW "do a lookup on $RA and have the host name returned if one has been defined.\n\n";
print MAILW "$HowWarn\n";
print MAILW "$HowWarn1\n";
print MAILW "$HowWarn2\n\n";
print MAILW "$HowWarn3\n";
close(MAILW); 
}

sub SendSpiderNotify {
#Send an E-mail telling me the Spdider was here
# this opens an output stream and pipes it directly to sendmail
# Only send email if user option set to on
#
if ($DoSendEmail eq "Active") { 
    open (MAIL, "|$PathToMail -t");
    print MAIL "To: $EmailAddy\n";
    print MAIL "From: $EmailAddy (ICS4.0)\n";
    print MAIL "Subject: Detected: $RH\n\n";
    print MAIL "$RH was here to spider\n $DomainName$PageRequested\n\n";
    print MAIL "User Agent: $RH\n";
    print MAIL "IP Address: $RA\n\n";
    print MAIL "$HowCaught\n";
    print MAIL "$HowCaught1\n";
    print MAIL "$HowCaught2\n\n";
    print MAIL "$HowCaught3\n";
    close(MAIL);
    }
}


###############################################
# No Spider match so show the page for humans #
###############################################
&Human;
#----------------------------------------------------------------------------#
# Engine Detected by IP - now feed it it's optimized page
#----------------------------------------------------------------------------#
sub SEMatch { 

    print "Content-type: text/html\n\n";

    open(INPUT,"$filepath/$Directories/$Directory$PageRequested") or &dienice("cannot open $filepath/$Directories/$Directory$PageRequested");
         while (<INPUT>) {

            print $_,;
            }
    close (INPUT);

            if ($DoWriteLog eq "Active"){
                $when = localtime;
               open (STATSLOG, ">>$filepath/$IPDirectory/spider.log") or &dienice ("Cannot open $filepath/$IPdirectory/spider.log");

              print STATSLOG "$when -- ";
              print STATSLOG "$ENV{'REMOTE_HOST'}|";
              print STATSLOG "$ENV{'HTTP_USER_AGENT'}|";
              print STATSLOG "$ENV{'REMOTE_ADDR'}|";
              print STATSLOG "$ENV{'HTTP_REFERER'}|";
              print STATSLOG "$DomainName$PageRequested\n";
              close (STATSLOG);
              }


         exit;
         }

#----------------------------------------------------------------------------#
# The Human Page! komona closed - show them the pretty site with bogus 
# relevance and matching title and description meta tag.
#----------------------------------------------------------------------------#

sub Human { 
    print "Content-type: text/html\n\n";

    open(INPUT,"$filepath/$Directories/HumanVisitor$PageRequested") or &dienice("cannot open $filepath/$Directories/HumanVisitor$PageRequested");
         while (<INPUT>) {

            print $_,;
     }
         close (INPUT);

            if (($DoWriteVisitorLog eq "Active") && ($FoundUnknown ne "yes")){
                $when = localtime;
               open (VSTATSLOG, ">>$filepath/$IPDirectory/visitor.log") or &dienice ("Cannot open $filepath/$IPdirectory/visitor.log");

              print VSTATSLOG "$when --";
              print VSTATSLOG "$ENV{'REMOTE_HOST'}|";
              print VSTATSLOG "$ENV{'HTTP_USER_AGENT'}|";
              print VSTATSLOG "$ENV{'REMOTE_ADDR'}|";
              print VSTATSLOG "$ENV{'HTTP_REFERER'}|";
              print VSTATSLOG "$DomainName$PageRequested\n";
              close (VSTATSLOG);
              }

         exit;
         }
#-------------------------------------------------------------#
sub dienice {
    ($msg) = @_;
    print "<h2>Error!</h2>\n";
    print "$msg";
    exit;
}

