#!/usr/bin/perl
#####################################################################################
# Chatologica GlobalSubmit - fetch.pl - url checking, fetching and form auto-filling
# All rights reserved (c) 2000; http://www.chatologica.com/
#####################################################################################

# DEFINING VARIABLES AND LOADING LIBRARIES, MODULES

use strict;				# use strict pragma
my $path = $0;				# changing the current working directory to the directory
if($path =~ s{[/\\][^/\\]+$}{}) {	# where this script file resides
    chdir($path) || ((print "Content-type: text/html\n\nCouldn't navigate to '$path' directory!") && exit);	
};
$| = 1;				# do not buffer the output
require 'parameters.pl';	# load current parameters
require 'lib/common.pl';	# some frequently used procedures
require 'lib/cgi-handler.pl';
require 'lib/http.pl';
use vars qw(
	$timeout
	$log_it
	$full_header
);
my %in;				# store here the cgi input
&Parse_CGI_Input(\%in);
&check_input(%in);

my ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1)
= &get_URL2($in{'url'}, $timeout+2);
my %out = ();			# the hash with output components
if($URL) {			# redirection to another URL
    &show_form($in{'url'}, $content1);
} else {			
    if($header && ($header =~ m/^.* (\d\d\d) (.*)$/m)) {
	if($1 != 200) {		# response code 200 means OK
	    $out{'error'} = "Error when trying to access: <A HREF=\"$in{'url'}\">$in{'url'}</A><BR> - $1 $2 -";
	};	
    };
    if($err) {			# error occured
	$err = ucfirst $err;
	$out{'error'} = "Error when trying to access: <A HREF=\"$in{'url'}\">$in{'url'}</A><BR> - $err -";
    };
    &show_form($in{'url'}, $content);
};



				# SOME SUBROUTINES BELOW #



sub show_form					# fill and show the submit form
{
    my($url, $page) = @_;    
    $out{'url'} = $url;				# Parse description meta tags:
    if($page =~ m{<meta[^>]*name=.description[^>]*content=([^>]*)>}is) {
	$out{'description'} = $1;
	$out{'description'} =~ s/\"//g;
	$out{'description'} =~ s/[\r\n]/ /g;	# page description in one line
    };						# Parse keywords meta tags:
    if($page =~ m{<meta[^>]*name=.keywords[^>]*content=([^>]*)>}is) {
	$out{'keywords'} = $1;
	$out{'keywords'} =~ s/\"//g;
	$out{'keywords'} =~ s/[\r\n,]/ /g;	# in one line
	my @words = split(m/ /,$out{'keywords'});
	my (%hash, $word) = ();
	foreach $word (@words) {		# make list of unique keywords
	    if($word !~ m/^\s*$/) {
	    	$hash{$word} = '';
	    };
	};
	$out{'keywords'} = join(' ', keys %hash);# keywords space separated
    };    
    my ($remote_path, $host) = &parse_URL($url);
    if($host =~ m{(^|\.)([^.]+)\.([^.]+)$}) {	# parse host name
	$out{'company'} = ucfirst $2;		# get company name from domain name
	if($out{'company'} =~ m/^\d+$/) {	# non-digits only
	    $out{'company'} = '';
	};
    };
    $out{'title'} = $out{'company'};
    if($page =~ m{<TITLE>([^<]*)</TITLE>}is) {	# getting Page Title
	$out{'title'} = $1;
	$out{'title'} =~ s/[\r\n]/ /g;
	$out{'title'} =~ s/\"/&quot;/g;
    };
    if($page =~ m{[>\s\r\n\t:\"]([^>\s\@\r\n\t:\"]+\@[^\s\r\@\.\n\t<]+\.[^\s\r\@\.\n\t<\"]+)[>\"\s\r\n\t]}) {
	$out{'email'} = $1;			# looking for email address in this page
    };
    open(F,'<templates/fetch.htm');		# open and read from template file
    my @txt = <F>;
    close F;		
    print "Content-type: text/html\n\n";	# send response header
    open(STDERR, ">&STDOUT");			# to catch fatal errors in eval redirect STDERR
    eval("print <<\"endofhtml\";\n@txt\nendofhtml\n");
};



sub check_input			# checking if cgi input is correct
{
    if($in{'url'} !~ m{http://[^\s]+\.[^\s]+}i ) {
	&DieMsg('Please, enter correct URL!');
    };
}


