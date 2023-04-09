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
	'site_name' => 'DirectHit',			# site name
	'version' => '1',				# module version number
	'created_on' => '22 Apr 2000',			# date of creation
	'site_URL' => 'http://directhit.com',		# url to the site
	'addurl_page' => 'http://directhit.com/util/addurl.html',	# url to AddURL page
	'host' => 'directhit.com',			# remote host address
	'port' => '80',					# default remote port is 80
	'method' => 'GET',				# POST or GET http method
	'remote_path' => '/fcgi-bin/DirectHitWeb.fcg',		# path to the remote cgi script/page
);



$make_submit_data_code = sub {
    my(%in) = @_;   		# these are the parameters passed from the submission form
    my %variables = (		# variables to pass
	'keys' => substr($in{'all_keywords_as_string_with_commas'},0,60),
	'template' => 'addurl',
	'fmt' => 'disp',
	'email' => substr($in{'email'},0,40),
	'src' => 'DH_ADDURL',
	'URL' => substr($in{'url'},0,100),
	'submit' => 'Submit!',
    );
    return \%variables;    
};



1; # this library must return TRUE

