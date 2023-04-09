<?
 /*
  Website Config
 */

// Site Safety --------------------------------------------------------------------------------------
 //tell site it can load
define('CONFIG', true);

// Site Database --------------------------------------------------------------------------------------
$DBNAME       = "{DB_NAME}";
$DBSERVERHOST = "{DB_HOST}";
$DBPASSWORD   = "{DB_PASS}";
$DBUSERNAME   = "{DB_USER}";

// Forum Database --------------------------------------------------------------------------------------
$DB_FORUM_NAME       = "{DBF_NAME}";
$DB_FORUM_SERVERHOST = "{DB_HOST}";
$DB_FORUM_USERNAME   = "{DBF_USER}";
$DB_FORUM_PASSWORD   = "{DBF_PASS}";

// Organization Data --------------------------------------------------------------------------------------
$site_dns      = "{SITE_DNS}";
$site_url      = "{SITE_URL}";
$site_name     = "{SITE_NAME}";
$site_email    = "{SITE_EMAIL}";

// Sequence Table Fields --------------------------------------------------------------------------------------
$DB_SEQ_TABLE = "table";
$DB_SEQ_INDEX = "index";
$DB_SEQ_NEXT  = "nextid";

// Generic DB API --------------------------------------------------------------------------------------
require_once 'code/class/db/{SQL_DB}.php';

// Site Locations --------------------------------------------------------------------------------------
$loc_images = "/pages/cache/images/"; //image db - (Cached)
$loc_images_default = "/pages/cache/images/0.gif"; //image db - default image for empty images

// Template --------------------------------------------------------------------------------------
$loc_tpl = "pages/"; //location of all templates
$loc_tpl_default = "pages/default/"; //location of default templates
$loc_cache = "/pages/cache/"; //location of cache must have /
$loc_tpl_images = "pages/open/images/"; //location of All Images (Non-Cached)
$loc_tpl_css = "pages/open/index.css";  //location of Index.css

// Load Forum Api --------------------------------------------------------------------------------------
require_once 'code/class/forum.inc.php'; //gotta load before
require_once 'code/class/forum/{FORUM_CLASS}.inc.php';

// Forum --------------------------------------------------------------------------------------
$forum_news    = "{FORUM_NEWS}"; //forum_id for news
$forum_prefix  = "{FORUM_PREFIX}"; //forum_id for news
$news_count    = 10; //number of news items to show

// Pages Array --------------------------------------------------------------------------------------
 //parse  = Php Parsed
 //static = Raw Template
 //list   = List of Links Under A Page - Listing is Recursive

 //User Pages --------------------------------------------------------------------------------------
 $pages["parse"]["profile"] = "./code/profile.inc.php";
 $pages["parse"]["logout"]  = "./code/logout.inc.php";
 //Website Policy --------------------------------------------------------------------------------------
 $pages["list"]["policy"] = "policy";
  $pages["policy"]["static"]["privacy"] = "policy_privacy.tpl";
  $pages["policy"]["static"]["user"]    = "policy_user.tpl";
  $pages["policy"]["static"]["signup"]  = "policy_signup.tpl";
 //Control panels --------------------------------------------------------------------------------------
 $pages["parse"]["updatenews"]    = "./code/news_update.inc.php";
 $pages["parse"]["teamcontrol"]   = "./code/team_panel.inc.php";
 $pages["parse"]["playercontrol"] = "./code/user_panel.inc.php";
 $pages["parse"]["playersignup"]  = "./code/user_signup.inc.php";
 $pages["parse"]["admin"]         = "./code/admin_panel.inc.php";
 //Player Help --------------------------------------------------------------------------------------
 $pages["parse"]["login"]     = "./code/user_login.inc.php";
 $pages["parse"]["reqtourny"] = "./code/tourny_signup.inc.php";
 //Tournament --------------------------------------------------------------------------------------
 $pages["parse"]["tourny"] = "./code/tourny.inc.php";

// Template Overides --------------------------------------------------------------------------------------
 //Completly New File Template Location
 //$tpages["index.tpl"] = "/open/newindex.tpl";
 //New Layout
 //$tpages["index.tpl"] = "open";
 $tpages["menu.tpl"] = "open";

?>