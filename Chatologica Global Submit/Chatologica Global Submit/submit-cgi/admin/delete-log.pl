#!/usr/bin/perl
#########################################################################################
# Chatologica delete-log.pl - delete the access log file
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
use strict;				# use strict pragma
my $path = $0;				# changing the current working directory to the directory
if($path =~ s{[/\\][^/\\]+$}{}) {	# where this script file resides
    chdir($path) || ((print "Content-type: text/html\n\nCouldn't navigate to '$path' directory!") && exit);	
};
chdir "../";
require 'lib/common.pl';		# some frequently used procedures
my $deleted = 0;
$deleted = unlink('logs/log.txt');	# delete it
if($deleted) {
    &DieMsg("The log file was deleted successfully.");
} else {
    &DieMsg("Couldn't delete the log file. <BR>May be it is deleted already or '<I>logs</I>' directory <BR>is not write-enabled (chmod 777).");
};
