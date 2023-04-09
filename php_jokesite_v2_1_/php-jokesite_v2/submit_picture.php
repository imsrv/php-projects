<?
include ("config_file.php");
include(DIR_LNG.'submit_picture.php');
$database_table_name1 = $bx_db_table_image_categories;
$database_table_name2 = $bx_db_table_images;
if ($HTTP_POST_VARS['submit_image'] == '1')
{
	if(empty($HTTP_POST_VARS['sender_name']))
		$sender_name_error = 1;

	if((ENABLE_ANONYMOUS_POSTING=="yes" && $HTTP_POST_VARS['sender_email'] != TEXT_ANONYMOUS) && (empty($HTTP_POST_VARS['sender_email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['sender_email'],$regs)) || (verify($HTTP_POST_VARS['sender_email'],"string_int_email")==1)))
		$sender_email_error = 1;

	if($HTTP_POST_VARS['image_category'] == '0')
		$image_category_error = 1;

	if(!bx_image_compare($HTTP_POST_FILES['photo']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size) && $imagemagic!="yes")
		$photo_error = 1;

	if($HTTP_POST_FILES['photo']['tmp_name']=='' || $HTTP_POST_FILES['photo']['tmp_name'] == 'none')
		$photo_error = 1;

	if(strlen($HTTP_POST_VARS['comment']) > $comment_max_length)
		$pict_text_error = 1;

	if (sizeof($advertiser_id)!=0  XOR !((empty($HTTP_POST_VARS['visitor_email'])) || (!eregi("(@)(.*)",$HTTP_POST_VARS['visitor_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['visitor_email'],$regs)) || (verify($HTTP_POST_VARS['visitor_email'],"string_int_email")==1)  ))
		$visitor_email_error = 1;

	if($imagemagic != "yes")
	{
		if (!$sender_name_error && !$sender_email_error && !$image_category_error && !$photo_error && !$visitor_email_error && !$pict_text_error)
		{
			$success = 1;
			
			bx_db_insert($database_table_name2,"category_id,name,email,comment,validate,slng", "'".$HTTP_POST_VARS['image_category']."', '".bx_dirty_words($HTTP_POST_VARS['sender_name'])."','".bx_dirty_words($HTTP_POST_VARS['sender_email'])."','".bx_dirty_words($HTTP_POST_VARS['comment'])."','".($need_picture_validation=='1' ? "0" : "1")."','".$slng."'");
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			
			$id = bx_db_insert_id();

			copy($HTTP_POST_FILES['photo']['tmp_name'], INCOMING.$id."_".$HTTP_POST_FILES['photo']['name']);
			$big_name = $id."_".$HTTP_POST_FILES['photo']['name'];

			$updateSQL = "update $database_table_name2 set big_img_name='".$big_name."' where img_id='".$id."'";
			$update_query = bx_db_query($updateSQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
	else
	{
		if (!$sender_name_error && !$sender_email_error && !$image_category_error && !$visitor_email_error && !$pict_text_error && !$photo_error)
		{
			$success = 1;

			bx_db_insert($database_table_name2,"category_id,name,email,comment,validate,slng", "'".$HTTP_POST_VARS['image_category']."', '".bx_dirty_words($HTTP_POST_VARS['sender_name'])."','".bx_dirty_words($HTTP_POST_VARS['sender_email'])."','".bx_dirty_words($HTTP_POST_VARS['comment'])."','".($need_picture_validation=='1' ? "0" : "1")."','".$slng."'");
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			
			$id = bx_db_insert_id();

			$big_name = $id."_1".$HTTP_POST_FILES['photo']['name'];
			$little_name = $id."_2".$HTTP_POST_FILES['photo']['name'];
			
			copy($HTTP_POST_FILES['photo']['tmp_name'], INCOMING.$big_name);

			if(bx_image_compare_nosize($HTTP_POST_FILES['photo']['tmp_name'], ">", $big_photo_width, $big_photo_height))
			{
				if($imagemagick_executable=="convert")
				{
					$convert_command = $imagemagic_path."convert ".INCOMING.$big_name." -resize ".$big_photo_width."x".$big_photo_height." ".INCOMING.$big_name;
					exec($convert_command);
				}
				elseif($imagemagick_executable=="mogrify")
				{
					$mogrify_command = "mogrify ".INCOMING.$big_name." -resize ".$big_photo_width."x".$big_photo_height." ".INCOMING.$big_name;
					exec($mogrify_command);
					
				}
				else{}
			}

			copy(INCOMING.$big_name, INCOMING.$little_name);
			if(bx_image_compare_nosize($HTTP_POST_FILES['photo']['tmp_name'], ">", $little_photo_width, $little_photo_height))
			{
				if($imagemagick_executable=="convert")
				{
					$convert_command = $imagemagic_path."convert ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
					exec($convert_command);
				}
				elseif($imagemagick_executable=="mogrify")
				{
					$mogrify_command = "mogrify ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
					exec($mogrify_command);
				}
				else{}
			}

			$updateSQL = "update $database_table_name2 set big_img_name='".$big_name."', little_img_name='".$little_name."' where img_id='".$id."'";
			$update_query = bx_db_query($updateSQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
}

if($success) 
{
	if($need_picture_validation)
		$message_to_user = TEXT_PICTURE_WILL_REVIEW;
	else
		$message_to_user = TEXT_PICTURE_HAVE_BEEN_ADDED;
}


include (DIR_SERVER_ROOT."header.php");

if(!$success)
{
	include ($this_file_form_name);
}



include (DIR_SERVER_ROOT."footer.php");
?>