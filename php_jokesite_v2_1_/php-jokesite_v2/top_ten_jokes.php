<?
include ("config_file.php");
include(DIR_LNG.'top_ten_jokes.php');
$display_nr = $display_nr_top_joke;
$type = TEXT_TOP_TEN_JOKES_ON." ";
$database_table_name1 = $bx_db_table_joke_categories;  
$database_table_name2 = $bx_db_table_jokes;            
$jtype = "ten";

isset($HTTP_POST_VARS['cat_id']) ? $cat_id = $HTTP_POST_VARS['cat_id'] : (isset($HTTP_GET_VARS['cat_id']) ? $cat_id = $HTTP_GET_VARS['cat_id'] : "");

if(isset($cat_id) && $cat_id != '0')
	$condition = " where category_id='".$cat_id."' and validate='1' and slng='".$slng."' ORDER BY rating_value DESC limit 0, $display_nr";
else
	$condition = " where validate='1' and slng='".$slng."' ORDER BY rating_value DESC limit 0, $display_nr";

$SQL = "select * from $database_table_name2 ".$condition;

$show_joke_categories="yes";
include (DIR_SERVER_ROOT."header.php");
include (DIR_FORMS."jokes_category_with_jokes_form.php");
include (DIR_SERVER_ROOT."footer.php");
?>