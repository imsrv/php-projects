<?php



// License Key. A unique license key is required for each hostname (domain name)

// for which you want to use SnippetMaster PRO. To obtain a license key, please

// purchase the program. Volume discounts are available.

	$LICENSE_KEY = "d4986412a37555a1d29562788ec7f8ca";



// Set the default language.  The language you specify here MUST have a

// corresponding php language file in the languages folder.  

// (ie: $PATH/languages/English.php)  File names are CASE SENSITIVE.

	$DEFAULT_LANGUAGE = "English";



// This is the FULL path to the directory where the SnippetMaster program files

// are located.  DO NOT add a trailing slash.

	$PATH = "/home/snippetm/public_html/snippetmaster";



// This is the FULL path to the directory where your website files are 

// located on your server (Your web root). DO NOT add a trailing slash.

	$ROOT = "/home/snippetm/public_html";



// Set to the full url to access the value you set for $ROOT

	$PREVIEW = "http://www.snippetmaster.com";



// Set to the full url to access the value you set for $PATH. 

	$URL = "http://www.snippetmaster.com/snippetmaster";



// Specify a list of folders to ignore when browsing for SnippetMaster files.

	$IGNORE = array("stats","images","includes","cgi-bin","Templates","click","polls","forums","newsletter","location1","location2","order","faq","admin");



// What kind of file types should be visible to the users when browsing for

// images using the WYSIWYG editor?  (The extensions you specify MUST be 

// for an image filetype or you will get javascript errors.)

	$VALID_IMAGE_FILE_TYPES =  array("gif","jpg","jpeg","png");



// What kind of file types should be visible to the users when browsing for

// links using the WYSIWYG editor? 

	$VALID_LINK_FILE_TYPES =  array("html","htm","doc","pdf","xls","ppt","txt","jpg","gif","png");



// Set to 1 to use authentication, otherwise set to 0.

// NOTE: If  you don't need password protection, set AUTH to 0.

	$AUTH = 1;

	$USER = "demo";

	$PASS = "demo";



// Set the email address to be used for error reporting. 

// NOTE: (Must be set, even if $REPORT is set to 0)

	$EMAIL = "your_email@domain.com";



// To turn off SnippetMaster errors from appearing in your email inbox, 

// set to 0.

	$REPORT = 1;



// What is the maximum size of an editable file in bytes? 

	$MAXSIZE = 1000000;



// Set to 1 to enabling printing of WYSIWYG debug messages, otherwise 

// set to 0 

	$DEBUG = 0;



// You can specify an unlimited number of upload locations for your users. To

// add more locations, just follow the variable pattern.  (Be sure to increment

// the array number for each new location.)

// PATH - The _full_ path to the destination directory. (DO NOT add a trailing 

//      slash.) This directory MUST already exist and have permissions of 777.

// NAME  - The text users will see in the Upload window for this location.

// OVERWRITE - For this location, allow files that already exist to be 

//             overwritten? For yes, set to 1; for no, set to 0.

// If you don't want to use at least three locations, just delete the lines you 

// don't need.  (They are for example only, anyway..)

	$UPLOAD_INFO[1]['PATH'] = "/home/snippetm/public_html/location1";

	$UPLOAD_INFO[1]['NAME'] = "Upload Location #1";

	$UPLOAD_INFO[1]['OVERWRITE'] = 1;

	$UPLOAD_INFO[2]['PATH'] = "/home/snippetm/public_html/location2";

	$UPLOAD_INFO[2]['NAME'] = "Upload Location #2";

	$UPLOAD_INFO[2]['OVERWRITE'] = 0;

	$UPLOAD_INFO[3]['PATH'] = "/home/snippetm/public_html/location3";

	$UPLOAD_INFO[3]['NAME'] = "Upload Location #3";

	$UPLOAD_INFO[3]['OVERWRITE'] = 1;



// Do you want to limit the acceptable extensions of uploaded file types?

// To enable set to 1; to disable change to 0.

	$LIMIT_UPLOAD_FILE_TYPES = 1;



// If enabled, specify a list of acceptable file types for the upload function.

	$VALID_UPLOAD_FILE_TYPES =  array("gif","jpg","jpeg","png");



// Do you want to set a size limit for uploaded files?  

// To enable set to 1; to disable change to 0.

	$UPLOAD_FILE_SIZE_LIMIT = 1;



// If enabled, specify the size limit (in bytes) for uploaded files.

	$UPLOAD_FILE_MAX_SIZE = 200000;



?>