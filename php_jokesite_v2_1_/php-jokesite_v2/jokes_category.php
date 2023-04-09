<?
include ("config_file.php");
include(DIR_LNG.'jokes_category.php');
$display_nr = $display_nr_joke_category;
$type = TEXT_JOKE_ON;
$jokes_file = 1;
$database_table_name1 = $bx_db_table_joke_categories;  
$database_table_name2 = $bx_db_table_jokes;            

$condition = " where ".($HTTP_GET_VARS['cat_id'] ? " category_id='".$HTTP_GET_VARS['cat_id']."' and " : "")." validate='1' and slng='".$slng."' ORDER BY rating_value DESC ";
$SQL = "select * from $database_table_name2 ".$condition;

if ($HTTP_GET_VARS['cat_id'])
{
	$show_joke_categories="yes";
}

include (DIR_SERVER_ROOT."header.php");

if (!$HTTP_GET_VARS['cat_id'])
{
	include (DIR_FORMS."jokes_category_form.php");	
}
else
{
	include (DIR_FORMS."jokes_category_with_jokes_form.php");
}

include (DIR_SERVER_ROOT."footer.php");
?>

