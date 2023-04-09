#!/usr/bin/perl

##################################################
##                                              ##
##             AUTORESPONSE PLUS (tm)           ##
##       Sequential Autoresponder System        ##
##                Version 2.12                  ##
##                                              ##
##   Copyright Gobots Internet Solutions, 2001  ##
##             All rights reserved              ##
##                                              ##
##  For support and latest product information  ##
##    visit http://www.autoresponseplus.com.    ##
##                                              ##
##  Use of AutoResponse Plus is subject to our  ##
##   license agreement and limited warranty.    ##
##  See the file license.txt for more details.  ##
##                                              ##
##################################################

eval {
    ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
    ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
 
    require "arp-paths.pl";
    require "arp-settings.pl";
    require "arp-library.pl";
    require "arp-data.pl";
    require "arp-login.pl";
    require "arp-autoresponders.pl";
    require "arp-display.pl";
    require "arp-cookies.pl";
    require "arp-validate.pl";
    require "arp-mail.pl";
    require "arp-trackingtags.pl";
    require "arp-setup.pl";
    require "arp-profile.pl";
    require "arp-campaigns.pl";
}; # eval

$g_thisscript = $ENV{"SCRIPT_NAME"};
$g_thisserver = $ENV{"SERVER_NAME"};
$g_browser = $ENV{"HTTP_USER_AGENT"};

%g_settings = &data_Load("SET00000000");

&ReadInput;
$g_a0 = $INFO{"a0"};
$g_a1 = $INFO{"a1"};
$g_a2 = $INFO{"a2"};
$g_a3 = $INFO{"a3"};
$g_a4 = $INFO{"a4"};

if ($g_a0 eq "log")
    {&Login}
elsif ($g_a0 eq "aut")
    {&Autoresponders}
elsif ($g_a0 eq "cam")
    {&Campaigns}
elsif ($g_a0 eq "tra")
    {&TrackingTags}
elsif ($g_a0 eq "pro")
    {&Profile}
elsif ($g_a0 eq "set")
    {&Setup}
else
    {&Login}

exit;
