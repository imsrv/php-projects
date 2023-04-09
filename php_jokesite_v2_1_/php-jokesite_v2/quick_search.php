<?
include ("config_file.php");
include (DIR_SERVER_ROOT."header.php");
include (DIR_SERVER_ROOT."site_settings.php");
$database_table_name = $bx_db_table_jokes;

$display_nr = isset($HTTP_GET_VARS['display_nr']) ? $HTTP_GET_VARS['display_nr'] : (isset($HTTP_POST_VARS['display_nr']) ? $HTTP_POST_VARS['display_nr'] : 10);

$search_for_string = "joke_text";
$search_for_string2 = "joke_title";

if($HTTP_POST_VARS['submit'] || $HTTP_POST_VARS['x']==1 || isset($HTTP_GET_VARS['from'])) 
{
	$SQL = "select * from $database_table_name";
	$condition = "";
	
	if ($HTTP_POST_VARS['search']) 
	{
	    $search_text=regexpsearch($HTTP_POST_VARS['search']);
		$search_text_print=$HTTP_POST_VARS['search'];
	}
	elseif($HTTP_GET_VARS['search']) 
	{
	    $search_text=regexpsearch($HTTP_GET_VARS['search']);
		$search_text_print=$HTTP_GET_VARS['search'];
	}
	else{}

	if(!empty($search_text))
	{
		$search_keywords = preg_split("/[\s,]+/",trim($search_text));
		for ($i=0;$i<sizeof($search_keywords);$i++) 
			$condition1.= "LCASE($search_for_string) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\" or LCASE($search_for_string2) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\" or ";

		$condition=substr($condition1,0,-3);
		$condition="(".$condition.")";
	
		if($condition == "")
			$SQL = $SQL." where slng='".$slng."' and validate='1'";
		else
			$SQL = $SQL." WHERE $condition  and slng='".$slng."' and validate='1'";
	}
	else
	{
		$SQL .= " where slng='".$slng."' and validate='1'";
	}

	if ($HTTP_POST_VARS['x']=="1") 
		$get_vars = "search=".urlencode(stripslashes($HTTP_POST_VARS['search']))."&display_nr=".$display_nr;	    
	else 
		$get_vars = "search=".urlencode(stripslashes($HTTP_GET_VARS['search']))."&display_nr=".$display_nr;

	$result_array = step($HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);
	$mode = "search";
	$database_table_name1 = $bx_db_table_joke_categories;
	include (DIR_FORMS."jokes_category_with_jokes_form.php");
	
}
	include (DIR_SERVER_ROOT."footer.php");
?>