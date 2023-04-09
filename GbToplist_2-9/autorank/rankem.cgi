#!/usr/bin/perl

$HTML_URL="http://www.yoursite.com/";
## You need to change $HTML_URL value so that it points to the URL of your toplist

print "Location: ".$HTML_URL."?".$ENV{QUERY_STRING}."\n\n";
