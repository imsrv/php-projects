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
    require "arp-library.pl";
    require "arp-cookies.pl";
    require "arp-data.pl";
}; # eval

%g_settings = &data_Load("SET00000000");

if (! &ValidateOwner) {
    print "Autoresponse Plus: Unauthorized import\n";
    exit;
} # if

use CGI;
my ($req) = new CGI;
$file = $req->param("upload_file");

if (! $file) {
    &Redirect("$g_settings{'cgi_arplus_url'}/arplus.pl?a0=cam&a1=imp&m=Could_not_import_file");
    exit;
} # if

my ($newfile) = "$_data_path/import.csv";
open (FILE, ">$newfile");
if ($g_settings{'file_locking'}) {flock(FILE, 2)}

while ($bytes = read($file, $buffer, 2048)) {
    print FILE $buffer;
} # while

close FILE;
if ($g_settings{'file_locking'}) {flock(FILE, 8)}

&Redirect("$g_settings{'cgi_arplus_url'}/arplus.pl?a0=cam&a1=imp&a2=con");

exit;
