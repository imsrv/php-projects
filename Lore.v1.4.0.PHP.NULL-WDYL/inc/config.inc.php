<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

/*
   This is the configuration file for Lore. If you are installing Lore for
   the first time, you must edit the "Database Configuration Options" 
   below. Optionally, you can set the error handling and template engine 
   settings.
 */

//////////////////////////////////////////////////////////////////////
// DATABASE CONFIGURATION
//////////////////////////////////////////////////////////////////////

// Where your database server is located. Usually 'localhost'.
$CONFIG['db_host']			= 'localhost';

// Database username and password.
$CONFIG['db_username'] 			= 'username';
$CONFIG['db_password']			= 'password';

// Database that Lore will use.
$CONFIG['db_database']			= 'lore';

// Whether to use persistent database connections.
$CONFIG['use_persistent_connections']	= 1;

//////////////////////////////////////////////////////////////////////
// ERROR HANDLING
//////////////////////////////////////////////////////////////////////

// Whether to automatically email you when there is an error.
$CONFIG['email_on_error']		= 0;
$CONFIG['error_email']			= 'user@example.com';

//////////////////////////////////////////////////////////////////////
// TEMPLATE ENGINE
//////////////////////////////////////////////////////////////////////

// Whether to force templates to be compiled on every run.
// This slows down execution time considerably, so only 
// use this when making changes or debugging templates.
$CONFIG['force_compile']		= 0;

// Whether to check for changes in template files.
// This slows down execution time slightly, so if you are not
// making changes to the templates, you should turn this off.
$CONFIG['compile_check']		= 1;

// Whether to create subdirectories for compiled templates.
// This can help slightly with systems that are slow with directories
// that contain many files, but may not work with some PHP configurations
// (namely ones with safe_mode enabled).
$CONFIG['use_sub_dirs']			= 0;

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

/* !!!! IMPORTANT NOTE !!!
   
   DO NOT ENTER ANYTHING AFTER '?>' BELOW, NOT EVEN A SINGLE SPACE OR NEW LINE!
   BE CAREFUL AS SOME EDITORS AUTOMATICALLY INSERT A BLANK LINE AT THE END OF
   A FILE, THIS WILL CAUSE PROBLEMS. 
   
*/
?>
