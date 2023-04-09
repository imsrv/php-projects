<?
include ("config_file.php");
include (DIR_SERVER_ROOT."header.php");
include(DIR_LNG.'advanced_search_form.php');
include (DIR_SERVER_ROOT."site_settings.php");
$database_table_name = $bx_db_table_jokes;

$display_nr = isset($HTTP_GET_VARS['display_nr']) ? $HTTP_GET_VARS['display_nr'] : (isset($HTTP_POST_VARS['display_nr']) ? $HTTP_POST_VARS['display_nr'] : 10);

if ($display_nr=='0')
{
	$display_nr = 100;
}
if(!isset($HTTP_GET_VARS['from']) && !isset($HTTP_POST_VARS['x']))
{
	include ($this_file_form_name);
}

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
    
	$posted_by = $HTTP_POST_VARS['posted_by'] ? $HTTP_POST_VARS['posted_by'] : ($HTTP_GET_VARS['posted_by'] ? $HTTP_GET_VARS['posted_by'] : "");
	if($posted_by != '')
		$posted_cond = " and name='".$posted_by."'";

	if(!empty($search_text))
	{
		//search conditions
		
		if ($HTTP_POST_VARS['type']=="all" || $HTTP_GET_VARS['type']=="all") 
		{
			$search_keywords = preg_split("/[\s,]+/",trim($search_text));
			for ($i=0;$i<sizeof($search_keywords);$i++) 
			{
				if ($HTTP_POST_VARS['case_']=="insensitive" || $HTTP_GET_VARS['case_']=="insensitive") 
				{
					$condition1.= "(LCASE($search_for_string) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\" or LCASE($search_for_string2) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\") and ";
				}
				else 
				{
					$condition1.= "($search_for_string REGEXP BINARY \"[[:<:]]".$search_keywords[$i]."[[:>:]]\" or $search_for_string2 REGEXP BINARY \"[[:<:]]".$search_keywords[$i]."[[:>:]]\") and ";
				}
			}
			$condition=substr($condition1,0,-4);
		}
		elseif ($HTTP_POST_VARS['type']=="any" || $HTTP_GET_VARS['type']=="any") 
		{
		   $search_keywords = preg_split("/[\s,]+/",trim($search_text));
			for ($i=0;$i<sizeof($search_keywords);$i++) 
			{
				if ($HTTP_POST_VARS['case_']=="insensitive" || $HTTP_GET_VARS['case_']=="insensitive") 
				{
					$condition1.= "(LCASE($search_for_string) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\" or LCASE($search_for_string2) REGEXP \"[[:<:]]".strtolower($search_keywords[$i])."[[:>:]]\") or ";
					#$condition1.= "LCASE(text) REGEXP \"".strtolower(regexpsearch($search_keywords[$i]))."\" or ";
				}
				else 
				{
					$condition1.= "($search_for_string REGEXP BINARY \"[[:<:]]".$search_keywords[$i]."[[:>:]]\" OR $search_for_string2 REGEXP BINARY \"[[:<:]]".$search_keywords[$i]."[[:>:]]\") or ";
				}
			}
			$condition=substr($condition1,0,-3); 
		}
		else 
		{	
			$search_keywords = preg_split("/[\s,]+/",trim($search_text));
			if (sizeof($search_keywords)>1) 
			{
				if ($HTTP_POST_VARS['case_']=="insensitive" || $HTTP_GET_VARS['case_']=="insensitive") 
					{
						$condition.= "(LCASE($search_for_string) like '%".strtolower($search_text)."%' or LCASE($search_for_string2) like '%".strtolower($search_text)."%')";
					}
					else 
					{
						$condition.= "($search_for_string like BINARY '%".$HTTP_POST_VARS['search']."%' or $search_for_string2 like BINARY '%".$HTTP_POST_VARS['search']."%')";
					}
			}
			else 
			{
			    if ($HTTP_POST_VARS['case_']=="insensitive" || $HTTP_GET_VARS['case_']=="insensitive") 
					{
						$condition1.= "(LCASE($search_for_string) REGEXP \"[[:<:]]".strtolower(trim($HTTP_POST_VARS['search']))."[[:>:]]\" or LCASE($search_for_string2) REGEXP \"[[:<:]]".strtolower(trim($HTTP_POST_VARS['search']))."[[:>:]]\") or ";
					}
					else 
					{
						$condition1.= "($search_for_string REGEXP BINARY \"[[:<:]]".trim($HTTP_POST_VARS['search'])."[[:>:]]\" or $search_for_string2 REGEXP BINARY \"[[:<:]]".trim($HTTP_POST_VARS['search'])."[[:>:]]\") or ";
					}
					$condition=substr($condition1,0,-3);
			}
			
		}
	
		if($condition == "")
			$SQL = $SQL." where slng='".$slng."' and validate='1' ".$posted_cond;
		else
			$SQL = $SQL." WHERE ($condition)  and validate='1' and slng='".$slng."' ".$posted_cond;
	}
	else
	{
		$SQL .= " where slng='".$slng."' and validate='1' ".$posted_cond;
	}

	if ($HTTP_GET_VARS['type']) 
	{
		$get_vars = "search=".urlencode(stripslashes($HTTP_GET_VARS['search']))."&type=".$HTTP_GET_VARS['type']."&case_=".$HTTP_GET_VARS['case_']."&display_nr=".$HTTP_GET_VARS['display_nr']."&posted_by=".$posted_by."&adv_search=".$HTTP_GET_VARS['adv_search'];
	}
	else 
	{
	    $get_vars = "search=".urlencode(stripslashes($HTTP_POST_VARS['search']))."&type=".$HTTP_POST_VARS['type']."&case_=".$HTTP_POST_VARS['case_']."&display_nr=".$HTTP_POST_VARS['display_nr']."&posted_by=".$posted_by."&adv_search=".($HTTP_POST_VARS['adv_search'] ? $HTTP_POST_VARS['adv_search'] : $HTTP_GET_VARS['adv_search']);
	}
	$result_array = step($HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);
	$mode = "search";
	$database_table_name1 = $bx_db_table_joke_categories;
	$type= TEXT_SEARCH_IN." ";
	include (DIR_FORMS."jokes_category_with_jokes_form.php");
}
	include (DIR_SERVER_ROOT."footer.php");
?>