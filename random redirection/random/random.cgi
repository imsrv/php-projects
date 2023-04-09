#!/usr/bin/perl -w
use strict;
# ----------------------------------------------------------------------
# ----------------------------------------------------------------------
#
# random.cgi
#    --	Issues a random redirection to a URL selected from a list of URLs.
#	Use this program for random images, "random URL" links, maybe even
#	primitive load-balancing between servers.
#
# Copyright Collin Forbes 2000.  All rights reserved.
# This program is free software; you can redistribute it and/or modify
# it under the same terms as Perl itself.
#
# ----------------------------------------------------------------------
# ----------------------------------------------------------------------
#
# Summary:
# --------
#    When called, random.cgi will select a line with a URL from its
#    configuration file and issue a redirection response to that URL.
#
#    To use a particular file, take the file's URL and insert random.cgi's
#    URL before it.  For instance, if you installed the program as
#    "/cgi-bin/random.cgi" and your file is "/random/urls.txt", join
#    the two URLs and use "/cgi-bin/random.cgi/random/urls.txt".
#
# Version History:
# ----------------
#    * Version 1.2, released 20 April 2000
#      Minor touchups, and rewrote the documentation.
#    * Version 1.1, released 6 September 1996
#    * Version 1.0, released April 1996
#      Initial release.
#
# See Also:
# ---------
#    http://kuoi.asui.uidaho.edu/~collinf/scripts.html/random
#
# ----------------------------------------------------------------------
# ----------------------------------------------------------------------

use CGI::Carp qw(fatalsToBrowser);

# ----------------------------------------------------------------------

my $default_file = 'examples/urls.txt';
#
# $default_file is the path (either absolute or relative) to the file
# you want to use when you didn't ask for an explicit file as part
# of the URL.
#
# ----------------------------------------------------------------------

my $filename = $ENV{'PATH_TRANSLATED'} || $default_file || 'urls.txt';
$filename =~ s/[^\w\/\-\.]/_/g;	# lingering paranoia

my @choices;
if ( -f $filename and -r $filename ) {
    open( FILE, "<$filename" ) or confess( qq|opening file: "$filename", $!| );
    while( <FILE> ) {
	next if m/^#/;
	next if m/^\s*$/;

	chomp;
	push( @choices, $_ );
    }
}

srand( time );
print qq|Location: $choices[int(rand(scalar(@choices)))]\n\n|;
exit;

# ----------------------------------------------------------------------
# this program contains more comments than code

