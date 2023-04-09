<? 
include ("../config_file.php");
if($HTTP_POST_VARS['remember_values']=='1' && $HTTP_POST_VARS['joke_form'])
{
	setcookie("remember_values", "1", mktime(0,0,0,0,0,2020), '/');
	setcookie("name_joke", $HTTP_POST_VARS['name'], mktime(0,0,0,0,0,2020), '/');
	setcookie("email_joke", $HTTP_POST_VARS['email'], mktime(0,0,0,0,0,2020), '/');
}
elseif($HTTP_POST_VARS['joke_form'])
{
	setcookie("remember_values", "1", mktime(0,0,0,0,0,2000), '/');
	setcookie("name_joke", $HTTP_POST_VARS['name'], mktime(0,0,0,0,0,2000), '/');
	setcookie("email_joke", $HTTP_POST_VARS['email'], mktime(0,0,0,0,0,2000), '/');
}
else{}

include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");


if ($HTTP_POST_VARS['submit'])
{
    if ($HTTP_POST_VARS['name']=="") 
		$name_error="yes";        
	else 
		$name_error="no";

    if (empty($HTTP_POST_VARS['email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs)) || (verify($HTTP_POST_VARS['email'],"string_int_email")==1))
		$email_error="yes";
	else
		$email_error="no";
	if ($HTTP_POST_VARS['email'] == TEXT_ANONYMOUS)
		$email_error="no";
	if ($HTTP_POST_VARS['joke_text']=="") 
		$joke_text_error="yes";        
	else 
		$joke_text_error="no";
	if ($HTTP_POST_VARS['category_id'] == '0')
		$category_error = "yes";
	else
		$category_error = "no";
	if ($HTTP_POST_VARS['censor_category_id'] == '0' && $use_censor !="yes")
		$censor_category_error = "yes";
	else
		$censor_category_error = "no";
	if ($HTTP_POST_VARS['joke_title']=="") 
		$joke_title_error="yes";        
	else 
		$joke_title_error="no";
	if ($HTTP_POST_VARS['joke_lang']=="0") 
		$joke_lang_error="yes";        
	else 
		$joke_lang_error="no";


	if ($name_error=="no" && $email_error=="no" && $category_error=="no" && $joke_title_error == "no"  && $joke_text_error=="no" && $censor_category_error=="no" && $joke_lang_error=="no")
	{
		if (strlen($HTTP_POST_VARS['joke_text'])<=$mini_jokes_length)
			$joke_type="mini";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$mini_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$short_jokes_length)
			$joke_type="short";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$short_jokes_length && strlen($HTTP_POST_VARS['joke_text'])<=$medium_jokes_length)
			$joke_type="medium";
		elseif(strlen($HTTP_POST_VARS['joke_text'])>=$medium_jokes_length)
			$joke_type="long";
		else{}
    
		bx_db_insert($bx_db_table_jokes,"category_id,name,email,joke_text,joke_type,censor_type,rating_value,emailed_value,date_add,validate,joke_title,slng","'".$HTTP_POST_VARS['category_id']."','".$HTTP_POST_VARS['name']."','".$HTTP_POST_VARS['email']."','".$HTTP_POST_VARS['joke_text']."','".$joke_type."', '".$HTTP_POST_VARS['censor_category_id']."', '0', '0', now(),'1', '".$HTTP_POST_VARS['joke_title']."','".($HTTP_POST_VARS['joke_lang'] ? $HTTP_POST_VARS['joke_lang'] : $slng)."'");
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		refresh(basename($HTTP_SERVER_VARS['PHP_SELF']));
?>
<script language="Javascript">
<!--
alert('All Done');
//-->
</script>
<?
		exit;
	}
}
include(DIR_SERVER_ADMIN."admin_joke_form.php");
include (DIR_SERVER_ADMIN."admin_footer.php");
?>