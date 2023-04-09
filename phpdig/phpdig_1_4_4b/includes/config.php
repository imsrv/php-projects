<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/

//-------------CONFIGURATION FILE-------
//-------------PHP DIG------------------

$phpdig_version = "1.4.4b";
$phpdig_language = "fr"; // options en - fr and more if avaible

define('PHPDIG_ADM_AUTH','1'); //turn on or off the http auth in admin. 1 is on
define('PHPDIG_ADM_USER','admin');
define('PHPDIG_ADM_PASS','admin');

//template file and style
$template = './templates/phpdig.html';
define('HIGHLIGHT_BACKGROUND','#FFCC00');
define('WEIGHT_IMGSRC','weight.gif');
define('WEIGHT_HEIGHT','5');
define('WEIGHT_WIDTH','50');
define('SEARCH_PAGE','index.php');

//---------DEFAULT VALUES
$search_default_limit        = 10; //results per page

$spider_max_limit            = 12; //max recurse levels in sipder
$spider_default_limit        = 1;  //default value
$respider_limit              = 4;  //recurse limit for update

$limit_days                  = 7; //default days before reindex a page
$small_words_size            = 2;  //words to not index
$max_words_size              = 30; //max word size

$title_weight                = 3;     //relative title weight
$chunk_size                  = 8000;  //chunk size for regex processing

$summary_length              = 500;     //length of results summary

define('TEXT_CONTENT_PATH','text_content/'); //dir of textual content (relative to phpdig path)
define('CONTENT_TEXT',1); //enable or not text content

define('FTP_ENABLE',0);//enable ftp content for distant PhpDig
define('FTP_HOST','<ftp host>'); //if distant PhpDig, ftp host;
define('FTP_PORT',21); //ftp port
define('FTP_PASV',1); //passive mode
define('FTP_PATH','<path to phpdig directory>'); //distant path from the ftp root
define('FTP_TEXT_PATH','text_content');//ftp path to text-content directory
define('FTP_USER','<ftp usename>');
define('FTP_PASS','<ftp password>');


//regular expression to ban useless external links in index
$banned = '^ad\.|banner|doubleclick';

//----------HTML ENTITIES
$spec = array( "&amp" => "&",
               "&agrave" => "à",
               "&egrave" => "è",
               "&ugrave" => "ù",
               "&oacute;" => "ó",
               "&eacute" => "é",
               "&icirc" => "î",
               "&ocirc" => "ô",
               "&ucirc" => "û",
               "&ecirc" => "ê",
               "&ccedil" => "ç",
               "&#156" => "oe",
               "&gt" => " ",
               "&lt" => " ",
               "&deg" => " ",
               "&apos" => "'",
               "&quot" => " ",
               "&acirc" => "â",
               "&iuml" => "ï",
               "&euml" => "ë",
               "&auml" => "ä",
               "&ouml" => "ö",
               "&uuml" => "ü",
               "&nbsp" => " ",
               "&szlig;" => "ß",
               "&iacute;" => "í",
               "&reg" => " ",
               "&copy" => " ",
               "&aacute" => "á",
               "&Aacute" => "Á",
               "&eth" => "ð",
               "&ETH" => "Ð",
               "&Eacute" => "É",
               "&Iacute" => "Í",
               "&Oacute" => "Ó",
               "&uacute" => "ú",
               "&Uacute" => "Ú",
               "&THORN" => "Þ",
               "&thorn" => "þ",
               "&aelig" => "ae",
               "&AELIG" => "AE",
               "&Ouml" => "Ö"
               );

//month names in iso dates
$month_names = array ('jan'=>1,
                      'feb'=>2,
                      'mar'=>3,
                      'apr'=>4,
                      'may'=>5,
                      'jun'=>6,
                      'jul'=>7,
                      'aug'=>8,
                      'sep'=>9,
                      'oct'=>10,
                      'nov'=>11,
                      'dec'=>12
                      );

//apache multi indexes parameters
$apache_indexes = array (  "?N=A" => 1,
                           "?N=D" => 1,
                           "?M=A" => 1,
                           "?M=D" => 1,
                           "?S=A" => 1,
                           "?S=D" => 1,
                           "?D=A" => 1,
                           "?D=D" => 1);


//includes language file
if (is_file("$relative_script_path/locales/$phpdig_language-language.php"))
    {include "$relative_script_path/locales/$phpdig_language-language.php";}
else
    {include "$relative_script_path/locales/en-language.php";}

//connection to database
if (is_file("$relative_script_path/includes/connect.php"))
    {
    include "$relative_script_path/includes/connect.php";
    }
else if(!isset($no_connect))
    {
    header("location:$relative_script_path/includes/install.php");
    }

//includes of librairies
include "$relative_script_path/libs/phpdig_functions.php";
include "$relative_script_path/libs/function_phpdig_form.php";
include "$relative_script_path/libs/mysql_functions.php";
?>