#!/usr/bin/perl
#########################################################################################
# Chatologica show-log.pl - shows the access log file content
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
use strict;				# use strict pragma
my $path = $0;				# changing the current working directory to the directory
if($path =~ s{[/\\][^/\\]+$}{}) {	# where this script file resides
    chdir($path) || ((print "Content-type: text/html\n\nCouldn't navigate to '$path' directory!") && exit);	
};
chdir "../";
print "Content-type: text/plain\n\n";
open(F, '<logs/log.txt');	# read log file
my $line;
while (defined($line = <F>)) {
   $line =~ s/\n$/\r\n/;	# because of MS Internet Explorer
   print $line;			# send to browser current line
};
print "\r\n";		
close F;
