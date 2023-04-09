<?
include ("config_file.php");
include(DIR_LNG.'new_jokes.php');
$display_nr = $display_nr_joke_category;
$type = TEXT_NEW_JOKES_ON." ";
$database_table_name1 = $bx_db_table_joke_categories;  
$database_table_name2 = $bx_db_table_jokes;            

$jtype = "new";

isset($HTTP_POST_VARS['cat_id']) ? $cat_id = $HTTP_POST_VARS['cat_id'] : (isset($HTTP_GET_VARS['cat_id']) ? $cat_id = $HTTP_GET_VARS['cat_id'] : "");

if(isset($cat_id) && $cat_id != '0')
	$condition = " where category_id='".$cat_id."' and validate='1' and slng='".$slng."' and (date_add between '".date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y')))."' and '".date('Y-m-d')."') ORDER BY rating_value DESC";
else
	$condition = " where validate='1' and slng='".$slng."' and (date_add between '".date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y')))."' and '".date('Y-m-d')."') ORDER BY rating_value DESC";

$SQL = "select * from $database_table_name2 ".$condition;

$show_joke_categories="yes";
include (DIR_SERVER_ROOT."header.php");
include (DIR_FORMS."jokes_category_with_jokes_form.php");
include (DIR_SERVER_ROOT."footer.php");
?>