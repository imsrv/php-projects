#!/usr/bin/perl

use LWP::Simple; 

$source = get('http://' . $ENV['HTTP_HOST'] . '/livehelp/include/check_status.php');

print "Content-type: text/html\n\n";
print $source;
