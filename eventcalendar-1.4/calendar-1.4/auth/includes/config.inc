<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2000 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: config.inc,v 1.4 2001/05/27 23:27:02 fluffy Exp $  

// This is the configuration area for the Simon's Rock Calendar
// All configuration options should be changed here.
// (Actually, they should now be changed in the config table of the database.

// More thanks to Bruce Tenison for pulling a bunch of stuff
//  into this config file.


//====Auth config options
// Do we require SSL?
	$config_ssl_required=1;

// Name of authentication module to use.
// This is case sensitive.
	$config_auth_module="auth-shadow.php3";
//	$config_auth_module="auth-pam.php3";
//	$config_auth_module="auth-nis.php3";


// Path to php_utils
	$config_php_utils="/usr/local/php3/";

	if( substr( $config_php_utils, -1 ) != "/" ) {
		$config_php_utils .= "/";
	}

// Path to an exe that takes a user_id and returns gecos info
//  This is also used extensively by event.php3
// pam and shadow
	$config_getuidinfo=$config_php_utils . "getuidinfo";
//nis
//	$config_getuidinfo=$config_php_utils . "getpwinfo.pl";

// Path to an exe that takes a username and returns gecos info
//  This is also used by session.php3
// pam and shadow
	$config_getpwinfo=$config_php_utils . "getpwinfo";
//nis
//	$config_getpwinfo=$config_php_utils . "getpwinfo.pl";

// Path to an exe for checking passwords
// shadow
	$config_chkpass=$config_php_utils . "getshcrypt";
// pam
//	$config_chkpass=$config_php_utils . "chkpass";
// nis
//	$config_chkpass=$config_php_utils . "runshcrypt";

//====Names and domains
// A couple different forms of the name are used in various places
	$config_fullname="New York State Mental Institution";
	$config_shortname="Crazy House";
	$config_abbrvname="NYSMI";

// The header includes a link to the site home page
	$config_homepage="www.slashdot.org";

// What domain signifies "on-campus"
	$config_internaldomain="localhost";

// Domain to append to e-mail addresses and URLs
	$config_domain="localhost";

// The name of the system which contains user accounts
//  Probably should not be localhost.  People need to recognize this name.
	$config_computername="localhost";

// Where should users report error messages?
	$config_errormailto="webmaster@localhost";

// The event class sends e-mail notifications as webmaster
	$config_webmaster="webmaster@localhost";

//====Paths to files and stuff
// Path to the site's style sheets
	$config_stylesheet="../basic.css";

// Homepage image
	$config_homepage_image="../images/structural/srsmall.gif";

// Calendar home image
	$config_calendar_image="../images/topics/Calendar.gif";
?>
