<?
include ("config_file.php");
include(DIR_LNG.'creat_postcard.php');
$display_nr = 10;
$type = "Pictures on ";

$show_picture_categories="yes";
include (DIR_SERVER_ROOT."header.php");

$database_table_name = $bx_db_table_images;
$database_table_name2 = $bx_db_table_postcard_messages;

isset($HTTP_POST_VARS['cat_id']) ? $cat_id = $HTTP_POST_VARS['cat_id'] : (isset($HTTP_GET_VARS['cat_id']) ? $cat_id = $HTTP_GET_VARS['cat_id'] : "");

isset($HTTP_POST_VARS['img_id']) ? $img_id = $HTTP_POST_VARS['img_id'] : (isset($HTTP_GET_VARS['img_id']) ? $img_id = $HTTP_GET_VARS['img_id'] : "");

if($HTTP_POST_VARS['postcard_message'] == '1')
{
	if(empty($HTTP_POST_VARS['sender_name']))
		$sender_name_error = 1;
	else
		$sender_name_error = 0;
	if(empty($HTTP_POST_VARS['sender_email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (verify($HTTP_POST_VARS['sender_email'],"string_int_email")==1))
		$sender_email_error = 1;
	else
		$sender_email_error = 0;
	if(empty($HTTP_POST_VARS['message']) || strlen($HTTP_POST_VARS['message']) > 250)
		$message_error = 1;
	else
		$message_error = 0;
	if(empty($HTTP_POST_VARS['sender_to_name']))
		$sender_to_name_error = 1;
	else
		$sender_to_name_error = 0;
	if(empty($HTTP_POST_VARS['sender_to_email']) ||  (!eregi("(@)(.*)",$HTTP_POST_VARS['sender_to_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['sender_to_email'],$regs)) || (verify($HTTP_POST_VARS['sender_to_email'],"string_int_email")==1))
		$sender_to_email_error = 1;
	else
		$sender_to_email_error = 0;
	if(empty($HTTP_POST_VARS['title']))
		$title_error = 1;
	else
		$title_error = 0;

	if(!$sender_name_error && !$sender_email_error && !$message_error && !$sender_to_name_error && !$sender_to_email_error  && !$title_error)
	{
		$success = 1;

		bx_db_insert($database_table_name2 ,"image_id,title,your_name,your_email,to_name,to_email,message", "'".$HTTP_POST_VARS['img_id']."', '".$HTTP_POST_VARS['title']."', '".$HTTP_POST_VARS['sender_name']."', '".$HTTP_POST_VARS['sender_email']."', '".$HTTP_POST_VARS['sender_to_name']."', '".$HTTP_POST_VARS['sender_to_email']."', '".$HTTP_POST_VARS['message']."'");
		
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		$pm_id = bx_db_insert_id();

	/*	if (MULTILANGUAGE_SUPPORT == "on") 
		{
		   $dirs = getFiles(DIR_FLAG);
		   for ($i=0; $i<count($dirs); $i++) 
		   {
			   $lngname = split("\.",$dirs[$i]);
			   if($select_result['slng'] == "_".substr($lngname[0], 0,3))
			   {
				   $use_language = $lngname[0];
				   break;
			   }
		   }
		}
		
		if($use_language =='')
			$use_language = DEFAULT_LANGUAGE;*/
		
		$use_language = $language;							//use that language email what is used by sender
		$mailfile = $use_language."/mail/send_postcard.txt";
		include(DIR_LANGUAGES.$mailfile.".cfg.php");
		if($html_mail=="on")
		$mailfile .= ".html";
		$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));

		$selectSQLnewsl = "select * from $bx_db_table_newsletter_categories where newsletter_category_id ='".$HTTP_POST_VARS['type']."'";
		$select_querynewsl = bx_db_query($selectSQLnewsl);
		$res_news = bx_db_fetch_array($select_querynewsl);
		
		$HTTP_POST_VARS['to_name'] = $HTTP_POST_VARS['sender_to_name'];
		$HTTP_POST_VARS['to_email'] = $HTTP_POST_VARS['sender_to_email'];
		$HTTP_POST_VARS['from_name'] = $HTTP_POST_VARS['sender_name'];
		$HTTP_POST_VARS['from_email'] = $HTTP_POST_VARS['sender_email'];
		$HTTP_POST_VARS['postcard_link'] = "<a href=\"".HTTP_SERVER."view_retrieve_postcard.php?pm_id=".md5($pm_id)."\">".HTTP_SERVER."view_retrieve_postcard.php?pm_id=".md5($pm_id)."</a>";

		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		while (list($h, $v) = each($fields))
		{
			$mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
			$file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
		}

		if($html_mail=="on")
		{
			if ($add_html_header == "on") {
				$mail_message = fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_header.html")).$mail_message;
			} 
			if ($add_html_footer == "on") {
				$mail_message .= fread(fopen(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$use_language."/html/html_email_message_footer.html"));
			} 
			$html_mail="yes";
		}
		else
		{
			if ($add_mail_signature == "on")
				$mail_message .= "\n".SITE_SIGNATURE;
			$html_mail="no";
		}
		bx_mail($site_name,$HTTP_POST_VARS['sender_to_name'],$HTTP_POST_VARS['to_email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
		//echo stripslashes($mail_message);
	}
}

if(isset($img_id) && $img_id != '0' && !$success)
{
	$condition = " where img_id=".$img_id." and validate='1'";
	$pictureSQL = "select * from $database_table_name ".$condition;
	$picture_query = bx_db_query($pictureSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$picture_result = bx_db_fetch_array($picture_query);
	include ($this_file_form_name);	
}
elseif ($success)
{
	echo "<tr><td align=\"center\"><br>".TEXT_POSTCARD_SENT."<br></td></tr>";
}
else
{
	include(DIR_FORMS. 'pictures_category_form.php');
}

include (DIR_SERVER_ROOT."footer.php");
?>

