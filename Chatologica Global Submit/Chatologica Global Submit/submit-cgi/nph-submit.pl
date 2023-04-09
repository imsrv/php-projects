#!/usr/bin/perl
#####################################################################################
# Chatologica GlobalSubmit - nph-submit.pl - the main submit script
# All rights reserved (c) 2000; http://www.chatologica.com/
#####################################################################################

# DEFINING VARIABLES AND LOADING LIBRARIES, MODULES

use strict;				# use strict pragma
my $path = $0;				# changing the current working directory to the directory
if($path =~ s{[/\\][^/\\]+$}{}) {	# where this script file resides
    chdir($path) || ((print "Content-type: text/html\n\nCouldn't navigate to '$path' directory!") && exit);	
};
$| = 1;				# do not buffer the output
require 'parameters.pl';       	# loading this script parameters
require 'lib/common.pl';	# some frequently used procedures
require 'lib/cgi-handler.pl';	# handling the cgi input 
require 'lib/submit-lib.pl';	# custom subroutines
require 'lib/http.pl';		# http connection tools

# definition of variables mainly imported from parameters.pl and the modules:
use vars qw(
	$timeout
	$log_it
	$full_header
);
my %in;
&Parse_CGI_Input(\%in);
&check_input(%in);
if($in{'url'} =~ /chatologica\.com/) {
    &DieMsg("Please, submit your own web-site!",$full_header);
};
if($full_header) {	# this nph-script needs a full header sent to browser
	print "$ENV{'SERVER_PROTOCOL'} 200 OK\015\012";
    	print "Server: $ENV{'SERVER_SOFTWARE'} + Chatologica GlobalSubmit cgi script version 1.0; http://www.chatologica.com/\015\012";
};
print "Content-type: text/html\n\n";
open(STDERR, ">&STDOUT");			# to catch fatal errors in eval redirect STDERR to STDOUT
if($in{'action-server-side'}) {	# server-side submissoin requested
    my (@txt, $text, $header, $footer) = ();
    open(F,"<templates/server-side.htm");	# read template
    @txt = <F>;
    close(F);
    $text = join('',@txt);
    ($header,$footer) = split(/SplitHere/,$text);    # split in 2 parts 
    print $header;
    &prepare_input_data(\%in);
    &load_modules(%in);
    &submit;    		# searver-side submit
    print $footer;
} else {			# browser-based submission requested
    print 'This option is available in the registered version only.';
};

if($log_it) {		
    &logging(%in);		# save this submission data in log file
};



				# SOME SUBROUTINES BELOW #



sub check_input			# checking if cgi form input is correct
{
    if($in{'url'} !~ m{http://[^\s]+}i ) {
	&DieMsg('Please, enter correct URL!',$full_header);
    };
    if($in{'email'} !~ m{[^\s]+\@[^\s]+\.[^\s]+} ) {
	&DieMsg('Please, enter valid email address!',$full_header);
    };	
}



sub logging			# save this submission data in log file
{
    my(%in) = @_;
    my ($log_tag,$key,@data) = ();
    # start deleting some not-useful data fields:
    delete $in{'keywords'};
    delete $in{'more_keywords'};
    delete $in{'all_keywords'};   
    delete $in{'all_keywords_as_string_with_commas'};
    delete $in{'ip'};
    foreach $key (sort keys %in) {
	$in{$key} =~ s/\|/:/g;		# escape | symbol
	push @data, $in{$key};		# data as list
    };
    $log_tag = localtime(time) . '|' . join('|', @data);	# data as string
    open(F,">>logs/log.txt");
    eval("flock(F,2)");	# lock this file - we use eval because Windows does not support it
    print F "$log_tag\n";
    close F;
    eval("flock(F,8)");	# release lock
}


