<?
/********************************************************

    conf/mysqlrc.inc
    
	PURPOSE:
		Provide central location for configuring MySQL-related variables.
        See MySQL/sql for recommended table structures.

********************************************************/

// MySQL connection/login info
$mysql_host="";
$mysql_user="";
$mysql_password="";

// MySQL database name
// ***REQUIRED***
$mysql_db="webmail";

// Users table name
// ***REQUIRED***
$mysql_users = "users";

// Sessions table name
// ***REQUIRED***
$mysql_sessions = "sessions";

// Contacts table name
//		Optional: Comment out to use file based backend
$mysql_contacts = "contacts";

// Prefs table name
//		Optional: Comment out to use file based backend
$mysql_prefs = "prefs";

// Colors table name
//		Optional: Comment out to use file based backend
$mysql_colors = "colors";

// Log table name
//		Optional: Comment out to use file based backend
//$mysql_log = "user_log";

// Use persistent connections
//		Optional: Set to 'true' to enable
$mysql_persistent = false;

?>
