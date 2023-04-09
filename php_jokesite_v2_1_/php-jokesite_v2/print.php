<?
include ("config_file.php");
include(DIR_LNG.'jokes.php');
/**********************************************************
Joke rating
**********************************************************/

$database_table_name1 = $bx_db_table_joke_categories;
$database_table_name2 = $bx_db_table_jokes;

include (DIR_FORMS."joke_form.php");

?>