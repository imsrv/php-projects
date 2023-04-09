<?
#######################################################################
#                         Secret Messagex v1.0 by WDYL                       #
#######################################################################


//////////// EDIT ONLY THE FOLLOWING ////////////

$mysql_username = "";     // Your MySQL login
$mysql_password = "";    // Your MySQL password
$mysql_database = "";     // Your MySQL database
$mysql_host     = "localhost"; // No need to change

////////////// EDIT ONLY THE ABOVE //////////////

if (! mysql_connect($mysql_host, $mysql_username, $mysql_password)) {
	print "MySQL Error: " . mysql_error();
	exit;
	}

if (mysql_select_db($mysql_database)) {
	if ($action != 'config' && mysql_query ("SELECT * FROM messagex_text")) {
		list($header) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='header'"));
		list($footer) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='footer'"));
		list($verify_email)    = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='verify_email'"));
		list($secret_email)    = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='secret_email'"));
		list($matched_email)   = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='matched_email'"));
		list($verify_subject)  = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='verify_subject'"));
		list($secret_subject)  = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='secret_subject'"));
		list($matched_subject) = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='matched_subject'"));
		list($admin_email)     = mysql_fetch_row(mysql_query("SELECT content FROM messagex_text WHERE name='admin_email'"));
		}
	}
?>