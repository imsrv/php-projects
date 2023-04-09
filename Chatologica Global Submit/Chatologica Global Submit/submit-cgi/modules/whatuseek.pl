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
	'site_name' => 'WhatUseek',			# site name
	'version' => '1',				# module version number
	'created_on' => '22 Apr 2000',			# date of creation
	'site_URL' => 'http://www.whatuseek.com',		# url to the site
	'addurl_page' => 'http://www.whatuseek.com/addurl-tableset.shtml',	# url to AddURL page
	'host' => 'www.whatuseek.com',			# remote host address
	'port' => '80',					# default remote port is 80
	'method' => 'get',				# POST or GET http method
	'remote_path' => '/cgi-bin/addurl.go',		# path to the remote cgi script/page
);



$make_submit_data_code = sub {
    my(%in) = @_;   		# these are the parameters passed from the submission form
    my %variables = (		# variables to pass
	'chk2' => '',
	'chk3' => '',
	'chk4' => '',
	'chk5' => '',
	'chk6' => '',
	'chk7' => '',
	'chk8' => '',
	'chk9' => '',
	'chk10' => '',
	'chk11' => '',
	'chk12' => '',
	'chk13' => '',
	'chk14' => '',
	'chk15' => '',
	'chk16' => '',
	'chk17' => '',
	'chk18' => '',
	'news_optout' => '1',
	'Clear' => 'Reset',
	'email' => $in{'email'},
	'url' => $in{'url'},
	'submit' => 'Add This URL',
	'chk1' => '',
    );
    return \%variables;    
};



1; # this library must return TRUE

