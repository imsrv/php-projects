<?php
// SPARE USERS FROM USELESS WARNINGS
// see http://www.php.net/manual/en/function.error-reporting.php for more info on
// error reporting, and what you can make it do
error_reporting();

// BACKEND CONNECTION

$cfg_host	= 'localhost'; 
$cfg_user	= ''; // your mySQL database username
$cfg_pass	= ''; // your mySQL password
$cfg_db		= ''; // your mySQL database name


if (!mysql_pconnect($cfg_host, $cfg_user, $cfg_pass))
	die('FATAL: cannot connect to mySQL server');
if (!mysql_select_db($cfg_db))
	die('FATAL: cannot select MySQL database');

// set the maximum file size thatw fill be accepted
$maxfilesize = "100000";

// PATHS AND URLS
$cfg_app_url	= '/events';  // root path to the gallery script - NO trailing slash
$cfg_app_path	= '/usr/home/v1/a0011075/html/events'; // full path to the script - NO trailing slash
$cfg_include_path	= '/usr/home/v1/a0011075/html/events/inc'; // path to your includes directory - NO trailing slash
$cfg_site_home	= $cfg_app_url . '/index.php'; 
$cfg_admin_path = $cfg_app_path . '/admin';
$cfg_admin_url = $cfg_app_url . '/admin';
$cfg_admin_home = $cfg_admin_url . '/index.php';
$cfg_fullsizepics_path = $cfg_app_path . '/pics'; //  path to fullsize images directory - NO trailing slash
$cfg_fullsizepics_url = $cfg_app_url . '/pics'; // url of fullsize pics - NO trailing slash
$cfg_thumb_path = $cfg_app_path . '/thumbs'; // path to thumbs directory - NO trailing slash
$cfg_thumb_url = $cfg_app_url . '/thumbs'; // url of thumbs directory - NO trailing slash

// SOME CONFIGURABLE PARAMETERS
$cfg_thumb_width = "100"; // in pixels
$cfg_table_width = "600"; // in pixels
$cfg_img_border = "1";
$cfg_per_page = "20";
$cfg_max_cols = "5";
$cfg_cat_desc = "1"; // Use category descriptions -  yes=1, no=0
$print_sql = "0";
$use_dropdowns= "0";  //   yes=1, no=0 - if "0", will default to text menu
$cfg_resize_gifs= "0";  //   yes=1, no=0 - must have an older version of the gdlib
$cfg_use_resampling= "0";  //   yes=1, no=0 - must have newer version of php - Note: This function was added in PHP 4.0.6 and requires GD 1.8 or later
$show_thumb_stats = "1"; // show height and weight and thumbnail avail under images in thumb page
$cfg_must_addslashes = get_magic_quotes_gpc() ? 0 : 1;


?>
