<HTML><BODY>
<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: loadConfig.php3,v 1.3 2001/02/12 04:50:46 fluffy Exp $

include( 'sql/sql.php3' );
include( 'error/error.php3' );

function loadConfig() {
	include( 'includes/config.inc' );

	$db_conn = connectRWToCalendar();

	$foo = pg_exec( $db_conn, "BEGIN WORK" );

	if( !$foo ) {
		reportError( $php_errormsg, "while beginning to save the configuration to the database" );
	}

	pg_exec( $db_conn, "DELETE FROM srcConfig" );

	InsertConfigRow( "ssl_required", $config_ssl_required, "Set to a non-zero value to require SSL for logging in.", $db_conn );
	InsertConfigRow( "php_utils", $config_php_utils, "A full path to the directory containing any executables used by the calendar, such as the authentication utilities.  Changing this may change the values of other options such as getuidinfo, getpwinfo, and chkpass, so make sure those items are correctly set after modifying this setting.", $db_conn );
	InsertConfigRow( "getpwinfo", $config_getpwinfo, "The full path to an executable used by authentication modules to get user information based on a username. This setting may be modified automatically if either php_utils or auth_module is changed.", $db_conn );
	InsertConfigRow( "getuidinfo", $config_getuidinfo, "The full path to an executable used by authentication modules to get user information based on a user ID.  This setting may be modified automatically if either php_utils or auth_module is changed.", $db_conn );
	InsertConfigRow( "chkpass", $config_chkpass, "The full path to an executable used by authentication modules to verify a user''s password. This setting may be modified automatically if either php_utils or auth_module is changed.", $db_conn );
	InsertConfigRow( "fullname", $config_fullname, "The full name of the institution using the calendar.", $db_conn );
	InsertConfigRow( "shortname", $config_shortname, "A shortened name of the institution using the calendar.", $db_conn );
	InsertConfigRow( "homepage", "http://" . $config_homepage ."/", "A full URL to the institution''s homepage, included as a link in the calendar header.", $db_conn );
	InsertConfigRow( "domain", $config_domain, "A domain to use when constructing email addresses (username@domain) or in trying to auto-complete URLs in the info URL field of a submitted event.", $db_conn );
	InsertConfigRow( "account_host", $config_computername, "The name of the host containing user accounts.  Users should recognize this name, as it is used to remind them which account they need to use if they have more than one.", $db_conn );
	InsertConfigRow( "calendar_image", $config_calendar_image, "The path (relative to index.php3) to an image included in the header which links to the main calendar page.", $db_conn );
	InsertConfigRow( "webmaster", $config_webmaster, "The email address from which the calendar should send e-mail notifications of submitted/rejected events.", $db_conn );
	InsertConfigRow( "stylesheet", $config_stylesheet, "The path (relative to index.php3) to a stylesheet for the calendar.  If you do not have a stylesheet, leave this blank and the calendar will not try to include one.", $db_conn );
	InsertConfigRow( "homepage_image", $config_homepage_image, "The path (relative to index.php3) to an image included in the header which is a link to the institution''s homepage.", $db_conn );
	InsertConfigRow( "errormailto", $config_errormailto, "The e-mail address to which users should report errors encountered while using the calendar.", $db_conn );
	InsertConfigRow( "internaldomain", $config_internaldomain, "The domain that signifies \"on-campus\".  Users connecting to the calendar from this domain will be given the option to view unapproved events.", $db_conn );
	InsertConfigRow( "abbrvname", $config_abbrvname, "An abbreviated name for the institution using the calendar.", $db_conn );
	InsertConfigRow( "auth_module", $config_auth_module, "Which authentication module the calendar should use to login users. Changing this may change the values of other options such as getuidinfo, getpwinfo, and chkpass, so make sure those items are correctly set after modifying this setting.", $db_conn );

	$foo = pg_exec( $db_conn, "COMMIT WORK" );

	if( !$foo ) {
		reportError( $php_errormsg, "while finalizing the configuration changes" );
	}

	pg_close( $db_conn );
	echo( "Config update completed.\n" );
}

function InsertConfigRow( $key, $value, $description, $db_conn ) {
	$query = "INSERT INTO srcConfig (key, value, description) VALUES ( " .
		"'$key', " .
		( $value == "" ? "NULL, " : "'" . addSlashes($value) . "', " ) .
		"'$description' )";

	echo( $query . "<BR>\n" );
	$result_id = pg_exec( $db_conn, $query );
	if( !pg_cmdtuples( $result_id ) ) {
		reportError( $php_errormsg, "while inserting a config row" );
		pg_exec( $db_conn, "ROLLBACK WORK" );
		exit;
	}
}

if( isSet( $loadConfig ) ) {
	loadConfig();
} else {
?><FORM METHOD=GET>
<INPUT TYPE=hidden NAME="loadConfig" VALUE="go for it">
Click the submit button to load your configuration from
calendar/includes/config.inc into the database.<BR>
<INPUT TYPE=submit>
</FORM>
<?php
}
?>

</BODY></HTML>
