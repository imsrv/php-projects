#!/usr/bin/perl
#############################################################################
#############################################################################
# Date          : 08/10/2003
# Author        : PageRipper.Com
# Program       : PageRipper
# Version       : 3.0
# Copyright     : http://www.pageripper.com/
# Variables     :
#
#
# DO NOT MODIFY THIS UTILITY.
# CHANGE THE CHMOD AND CALL THE SCRIPT
#
# COPYRIGHT
#
#
# To use the SSI call the script by placing the following HTML on your
# webpage      <!--#exec cgi="/cgi-bin/pageripper.cgi"-->
# Be sure to CHMOD script to 755 for script to work
#
#
#
# MAKE SURE THE PERL PATH ABOVE IS CORRECT OR IT WON'T WORK
# MUST HAVE LWP:USERAGENT INSTALLED
#
#
#=========By Installing This Script You agree to the terms, and disclaimer
#=========in the Readme.txt file along as on http://www.pageripper.com/faq.htm
#
# PageRipper may be modified free of charge by anyone so long as this
# copyright message and the above header remains intact. pageripper.cjb.net
# does not take any liability that might arise from the use of this script.
#############################################################################
#############################################################################
# DO NOT EDIT THIS SECTION.  ADVANCED USERS ONLY
#############################################################################
require LWP::UserAgent;
read(STDIN, $commandprompt, $ENV{'CONTENT_LENGTH'});
@theactualdata = split(/&/, $commandprompt);
$newcommandprompt = '';
foreach $actualdata (@theactualdata) {
($name, $value) = split(/=/, $actualdata);
if ($name ne 'page')
{ $newcommandprompt = $newcommandprompt . $actualdata } ;
$name  =~ tr/+/ /;
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/<([^>]|\n)*>//g;
$value =~ s/<//g;
$value =~ s/>//g;
$URL{$name} = $value;
}
print "Content-type: text/html\n\n";
$url            = $URL{'url'};

#############################################################################
#############################################################################
#===============================================================================
#  ####   VARIABLES THAT MUST BE CHANGED FOR SCRIPT TO WORK   ####
#===============================================================================
#############################################################################


#############################################################################
# 1 - MUST CHANGE - Change The URL below to the page you wish to begin extracting from
#############################################################################

$url = 'http://news.yahoo.com/';

#############################################################################
# 2 - Starting Point to extract from (must be exactly the way it is on the page)
#############################################################################

$start = 'World</td></tr></table>';

#############################################################################
# 3 - Ending HTML
#############################################################################

$finish = 'Technology</td></tr></table>';

#############################################################################
# 4 - If links don't work change the HTML below to reflect the link source (remove the #'s)
#############################################################################

 $sourcelink = 'href="/news';
 $newlink = 'target="_blank" href="http://news.yahoo.com/news';

#############################################################################
# 5 - If images don't work change the html below to reflect the image source (remove the #'s)
#############################################################################

# $sourceimage = 'img src=\"';
# $newimage = 'img src=\"http://www.pollstar.com/news';
#############################################################################

#############################################################################
# 6 - Do You want to save fetched HTML to file? If yes enter file name here
#############################################################################

$filename = '';        #   ie.. saved.txt or html.txt
#############################################################################


#############################################################################
# 7 - Do You want to include the starting and ending points in the final html
# Yes = 1   No = 0
#############################################################################

$addpoints = 0;        # 0 or 1 here
#############################################################################

#############################################################################
# 8 - SHOULD we add the BASE HREF statment to the fetched HTML.  This should
# resolve broken links or images in the fetched HTML
#############################################################################

$baseurl = '';

           # root URL your fetching from ie.. http://www.yahoo.com/
           # above fix should take care of broken images or links
           # leave blank to turn off
#############################################################################

#############################################################################
# 9 - Where should the visitor be redirected to if an error occurs or the variables change
#############################################################################

$errorurl = 'http://www.wdyl-wtn.com';

#############################################################################

# That's it.  UPLOAD and CHMOD to 755 Happy Ripping





























#############################################################################
#===============================================================================
#  NO NEED TO CHANGE ANY VARIABLES BELOW.  SCRIPT MAY NOT WORK PROPERLY
#         End of Variables Section - Upload and CHMOD TO 755
#===============================================================================
#############################################################################




#############################################################################
# Removes Spaces in Fetch HTML
#############################################################################
$start =~ s/ /\\s\+/;
$start =~ s/\//\\\//;
$finish =~s/ /\\s\+/;
$finish =~ s/\//\\\//;

#############################################################################
# print the HTML header
#############################################################################
print "<HTML><HEAD>";

if ($baseurl){
print "<BASE HREF=\"$baseurl\">";
}
print "</HEAD><BODY>";


#############################################################################
# has the user defined the URL
#############################################################################

if (!$url)
 { print "Enter the URL\n"; }
else
{
#############################################################################
# EXTRACT the page
   &getpage($url);
#############################################################################
# if error grabbing the page then print the return CODE RFC 2068.
# HTTP 1.1 Protocol
   if ($error)
   {  print "Error Getting Page : $url Code : $htmlcode<br>"; }

# ERROR or NO ERROR print whatever is grabbed.
   $t = $content;

# convert newline or return to blank spaces globally
   $t =~ s/\r/\n/gi;
   $t =~ s/\n/ /gi;

# convert multiple blanks to a single blank globally
   $t =~ s/  / /gi;

# convert tab to single blank globally
   $t =~ s/\t/ /gi;

#############################################################################
# get the HTML you specified
#############################################################################
   &gettags($t);

#############################################################################


# Displays the HTML

if ($addpoints eq 0){
print "$stuff";
}
else
{
print "$start$stuff$finish";
}

# Save The HTML to a text file

if ($filename){

open(OUTF,">$filename") or dienice("Can't open $filename for writing: $!");
print "Content-type:text/html\n\n";
print OUTF "$stuff";
close(OUTF);
}

#############################################################################

print "</body></html>";

}

#############################################################################
# GET THE HTML Sub
sub gettags {
        my $mmyurl = shift;
#############################################################################

# store the content to $body variable
        $stuff = $mmyurl;

#############################################################################

# get the page...
    $stuff = ($stuff =~s/$start(.+)$finish/ /i) ? $1 : 'No Content';

#############################################################################
# Replaces the Href and Img links to the correct variables
#############################################################################

$stuff =~ s/$sourcelink/$newlink/ig;
$stuff =~ s/$newlink$newlink/$newlink/ig;
$stuff =~ s/$sourceimage/$newimage/ig;

#############################################################################

#If the variables are incorrect or source page changes go to this url
$stuff =~ s/No\s+Content/\<script language = javascript>window.location=\'$errorurl\'\;<\/script>/ig;

#############################################################################

#############################################################################
#=========================================================================
# DO NOT CHANGE ANYTHING BELOW.  SCRIPT WILL NOT WORK
#=========================================================================
#############################################################################
}

#  GET THE PAGE
sub getpage {
        my $myurl = shift;
# $myurl stores the URL

# define the user agent
        my $ua = new LWP::UserAgent;

#        $cookies ="";

# define the timeout
        $ua->timeout(60);

# set the browser agent
        $ua->agent($agent);

# GET THE PAGE
        my $req = HTTP::Request->new(GET => $myurl);
        my $res = $ua->request($req);

# get the content of the page and the content type
        $content = $res->content;
        $contenttype = $res->content_type;

# if 200 success, then no error.
        if ($res->is_success) {
                $error =0;
                }

# get the HTML error code RFC 2068 and store in HTMLCODE var.
# dont forget to set the error flag.
        else {
                $htmlcode = $res->code();
                $error =1;
        }
}
#############################################################################
#End of Script
#############################################################################




