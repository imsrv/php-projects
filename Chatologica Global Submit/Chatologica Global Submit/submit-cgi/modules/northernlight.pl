#########################################################################################
# Add-on module for Chatologica GlobalSubmit cgi script v1.0
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################

use strict;				# use strict style of programming
use vars qw(
	$make_submit_data_code
	%profile
);

%profile = (				# some basic information about this module
	'site_name' => 'NorthernLight',			# site name
	'version' => '1',				# module version number
	'created_on' => '22 Apr 2000',			# date of creation
	'site_URL' => 'http://www.northernlight.com',		# url to the site
	'addurl_page' => 'http://www.northernlight.com/docs/regurl_help.html',	# url to AddURL page
	'host' => 'urls.northernlight.com',			# remote host address
	'port' => '80',					# default remote port is 80
	'method' => 'POST',				# POST or GET http method
	'remote_path' => '/cgi-bin/urlsubmit.pl',		# path to the remote cgi script/page
);



$make_submit_data_code = sub {
    my(%in) = @_;   		# these are the parameters passed from the submission form
    my %variables = (		# variables to pass
	'contact' => "$in{'first_name'} $in{'last_name'}",
	'sb' => '',
	'page' => $in{'url'},
	'email' => $in{'email'},
    );
    return \%variables;    
};



1; # this library must return TRUE

