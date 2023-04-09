<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

// Site HTTP URL Address ** WITH TRAILING SLASHED
$SITE_DIR  = 'http://localhost/fps/public_html/scripts/unsuported/';
$SITE_ABSOLUTE = 'C:\Inetpub\wwwroot\fps\public_html\scripts\unsuported\\';

//FAD Banner Manager Folder 
$FAD_DIR  = 'fad/'; 
//Images dirrectory
$IMAGEFOLDER =  'images/';

//Site Username
$USER_NAME = 'aziz';

//Site password
$PASS_WORD = '2598';

//Data Base Connection Information
define ('DB_USER', 'root');   // Database User Name
define ('DB_PASSWORD', '');    // Database User Password
define ('DB_HOST', 'localhost');   // Host Name (mostly localhost)
$dbc = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD);  // Establishes connection
mysql_select_db('tt');    // database name to connect to
?>