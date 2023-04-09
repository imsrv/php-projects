<?
if ($HTTP_POST_VARS['todo'] != "backup" && $HTTP_GET_VARS['t'] != "download" && $HTTP_POST_VARS['todo'] != 
"sel_fields" && CRON_JOB!="yes")
{
	if (@ini_get('output_handler') == 'ob_gzhandler' || @get_cfg_var('output_handler') == 'ob_gzhandler' 
|| (@function_exists('ob_get_level') && ob_get_level() > 0))
	{}
    else 
	{
		ob_start("ob_gzhandler");
    }
}
/******************************************************************************
Server path settings (change these)
******************************************************************************/
define('HTTP_SERVER','http://localhost/php-jokesite_v2/');
define('DIR_SERVER_ROOT','c:\\arquivos de programas\\easyphp\\www\\php-jokesite_v2/');

/******************************************************************************
Directory settings
******************************************************************************/
define('HTTP_SERVER_ADMIN','http://localhost/php-jokesite_v2/admin/');
define('DIR_SERVER_ADMIN','c:\\arquivos de programas\\easyphp\\www\\php-jokesite_v2/admin/');

define("INCOMING", DIR_SERVER_ROOT."funny_images/");
define("HTTP_INCOMING", HTTP_SERVER."funny_images/");
define('HTTP_BANNERS',HTTP_SERVER.'banner_images/');
define('DIR_BANNERS',DIR_SERVER_ROOT.'banner_images/');
define('DIR_FUNCTIONS',DIR_SERVER_ROOT.'functions/');
define('DIR_FORMS',DIR_SERVER_ROOT.'forms/');
define('HTTP_LANGUAGES', HTTP_SERVER.'languages/');
define('DIR_LANGUAGES', DIR_SERVER_ROOT.'languages/');
define('HTTP_FLAG',HTTP_LANGUAGES.'flags/');
define('DIR_FLAG',DIR_LANGUAGES.'flags/');
define('DIR_IMAGES',HTTP_SERVER.'images/');
define('DIRS_IMAGES',DIR_SERVER_ROOT.'images/');
define('DIR_LOGS',DIR_SERVER_ROOT.'logs/');
define("BANNER_DIR",DIR_SERVER_ROOT."banners/"); 

define('DEFAULT_LANGUAGE','english');

/******************************************************************************
File settings
******************************************************************************/
define('FILENAME_INDEX','index.php');
define('FILENAME_ADD_JOKE','add_joke.php');	


/******************************************************************************
Database settings
******************************************************************************/
define('DB_SERVER_TYPE','mysql');
define('DB_SERVER','localhost');
define('DB_SERVER_USERNAME','root');
define('DB_SERVER_PASSWORD','');
define('DB_DATABASE','teste');
/******************************************************************************
Settings
******************************************************************************/
define('STORE_PAGE_PARSE_TIME', 1);
define('STORE_PAGE_PARSE_TIME_LOG', DIR_LOGS.'/parse_time_log');  
define('STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S');
if (STORE_PAGE_PARSE_TIME == '1') 
	$parse_start_time = microtime();

$imagemagick_executable = "convert";		//convert or mogrify
$today = date("Y-m-d"); 
/******************************************************************************
Include files (only what we need, no more)
******************************************************************************/
include(DIR_FUNCTIONS . 'database.php');
include(DIR_FUNCTIONS . 'general.php');
include(DIR_FUNCTIONS . 'sessions.php');
include (DIR_SERVER_ROOT."site_settings.php");
include (DIR_SERVER_ROOT."site_design_configuration.php");

/******************************************************************************
Database table name
******************************************************************************/
$bx_table_prefix = 'jokesite_';
$bx_db_table_joke_categories		= $bx_table_prefix.'category';
$bx_db_table_image_categories		= $bx_table_prefix.'fun_category';
$bx_db_table_censor_categories		= $bx_table_prefix.'censor_category';
$bx_db_table_newsletter_categories	= $bx_table_prefix.'newsletter_category';
$bx_db_table_jokes					= $bx_table_prefix.'jokes';
$bx_db_table_images					= $bx_table_prefix.'postcard_images';
$bx_db_table_rating					= $bx_table_prefix.'rating';
$bx_db_table_votes					= $bx_table_prefix.'votes';
$bx_db_table_postcard_messages		= $bx_table_prefix.'postcard_messages';
$bx_db_table_daily_newsletters		= $bx_table_prefix.'daily_newsletters';
$bx_db_table_newsletter_subscribers	= $bx_table_prefix.'newsletter_subscribers';

bx_db_connect() or die('Unable to connect to database server!');
/*****************************************************
Start session and select language and include the specific language file
******************************************************/
bx_session_start();
if ($HTTP_GET_VARS['language'])
{
	$language = $HTTP_GET_VARS['language'];
	setcookie("language", $language , mktime(0,0,0,0,0,2020), '/');
	bx_session_register('language');
}
else
{
	if (!bx_session_is_registered('language'))
	{
		if ($HTTP_COOKIE_VARS['language'])
		{
			$language = $HTTP_COOKIE_VARS['language'];
			bx_session_register('language');
		}
		else
		{
			$language = DEFAULT_LANGUAGE;
			setcookie("language", $language , mktime(0,0,0,0,0,2020), '/');
			bx_session_register('language');
		}
	}
	else
	{
		$language = $HTTP_SESSION_VARS['language'];
		if (!$HTTP_COOKIE_VARS['language'])
			setcookie("language", $HTTP_SESSION_VARS['language'] , mktime(0,0,0,0,0,2020), '/');
	}
}

$slng = "_".substr($language, 0,3);
include(DIR_LANGUAGES.$language.".php");

define('DIR_LNG', DIR_LANGUAGES.$language."/");
define('HTTP_LANG_IMAGES',HTTP_LANGUAGES.$language.'/images/');
define('DIR_LANG_IAMGES',DIR_LANGUAGES.$language.'/images/');

/* Make filenames */
preg_match_all("|.*/(.*)/$|i",DIR_SERVER_ADMIN,$match);
if(ereg($match[1][0]."/", ($HTTP_SERVER_VARS['PHP_SELF']), $regs))
{
	$this_file_name = HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF']);
	$this_file_form_name = HTTP_SERVER_ADMIN.basename(ereg_replace(".php", "", $HTTP_SERVER_VARS['PHP_SELF'])."_form.php");
}
else
{
	$this_file_name = HTTP_SERVER.basename($HTTP_SERVER_VARS['PHP_SELF']);
	$this_file_form_name = DIR_FORMS.basename(ereg_replace(".php", "", $HTTP_SERVER_VARS['PHP_SELF'])."_form.php");
}

define('MULTILANGUAGE_SUPPORT',$multilanguage_support);
define('USE_DIRTY_WORDS',$use_dirty_words);
define('DIRTY_WORDS',$dirty_words);
define('DIRTY_WORDS_REPLACEMENT',$dirty_words_replacement);
define('ENABLE_ANONYMOUS_POSTING',$enable_anonymous_posting);
define('USE_EXTRA_HEADER',$use_extra_header);
define('USE_EXTRA_FOOTER',$use_extra_footer);
define('SITE_SIGNATURE',$site_signature);
define('DEBUG_MODE', $debug_mode);
@header("Cache-Control: ;"); 
?>