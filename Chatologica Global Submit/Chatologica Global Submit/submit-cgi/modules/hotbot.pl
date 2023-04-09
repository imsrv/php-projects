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
	'site_name' => 'HotBot',			# site name
	'version' => '1',				# module version number
	'created_on' => '22 Apr 2000',			# date of creation
	'site_URL' => 'http://www.hotbot.com/',	# url to the site
	'addurl_page' => 'http://hotbot.lycos.com/addurl.asp', # AddURL page
	'host' => 'hotbot.lycos.com',			# remote host address
	'port' => '80',					# default remote port is 80
	'method' => 'get',				# POST or GET http method
	'remote_path' => '/addurl.asp',		# path to the remote cgi script/page
);



$make_submit_data_code = sub {
    my(%in) = @_;   		# these are the parameters passed from the submission form
    my %variables = (		# variables to pass
	'send' => 'Submit my site',
	'SOURCE' => 'hotbot',
	'redirect' => 'http://hotbot.lycos.com/addurl2.html',
	'success_page' => 'http://hotbot.lycos.com/addurl.asp',
	'ip' => $in{'ip'},
	'MM' => '1',
	'LIST' => '',
	'newurl' => $in{'url'},
	'ACTION' => 'subscribe',
	'failure_page' => 'http://hotbot.lycos.com/help/oops.asp',
	'email' => $in{'email'},
    );
    return \%variables;    
};



1; # this library must return TRUE

