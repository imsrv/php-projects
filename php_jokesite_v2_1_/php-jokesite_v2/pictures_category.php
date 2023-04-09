<?
include ("config_file.php");
include(DIR_LNG.'pictures_category.php');
$display_nr = 10;
$type = TEXT_PICTURES_ON." ";

$database_table_name1 = $bx_db_table_image_categories;  
$database_table_name2 = $bx_db_table_images;            

isset($HTTP_POST_VARS['cat_id']) ? $cat_id = $HTTP_POST_VARS['cat_id'] : (isset($HTTP_GET_VARS['cat_id']) ? $cat_id = $HTTP_GET_VARS['cat_id'] : "");

if(isset($cat_id) && $cat_id != '0')
	$condition = " where ".($HTTP_GET_VARS['cat_id'] ? " category_id='".$HTTP_GET_VARS['cat_id']."' and " : "")." validate='1'";
else
	$condition = " where validate='1'";

$SQL = "select * from $database_table_name2 ".$condition;

$show_picture_categories="yes";
include (DIR_SERVER_ROOT."header.php");
if (!$cat_id)
{
	include (DIR_FORMS."pictures_category_form.php");	
}
else
{
	include (DIR_FORMS."pictures_category_with_images_form.php");
}

include (DIR_SERVER_ROOT."footer.php");
?>

