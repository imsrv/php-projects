<?php 
include ("../config_file.php");
if($HTTP_POST_VARS['remember_values_img']=='1' && $HTTP_POST_VARS['img_form'])
{
	setcookie("remember_values_img", "1", mktime(0,0,0,0,0,2020), '/');
	setcookie("name_img", $HTTP_POST_VARS['name'], mktime(0,0,0,0,0,2020), '/');
	setcookie("email_img", $HTTP_POST_VARS['email'], mktime(0,0,0,0,0,2020), '/');
}
elseif($HTTP_POST_VARS['img_form'] && !$HTTP_COOKIE_VARS['remember_values_img'])
{
	setcookie("remember_values_img", "1", mktime(0,0,0,0,0,2000), '/');
	setcookie("name_img", $HTTP_POST_VARS['name'], mktime(0,0,0,0,0,2000), '/');
	setcookie("email_img", $HTTP_POST_VARS['email'], mktime(0,0,0,0,0,2000), '/');
}
else{}

include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

$database_table_name = $bx_db_table_images;

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
	if ($HTTP_POST_VARS['category_type']=="0") 
		$category_error="yes";        
	else 
		$category_error="no";

	if ($imagemagic != "yes")
	{
		if ($HTTP_POST_FILES['little_img']['tmp_name'] && $HTTP_POST_FILES['big_img']['tmp_name'] && $HTTP_POST_FILES['little_img']['tmp_name'] != "none" && $HTTP_POST_FILES['big_img']['tmp_name'] != "none" && $HTTP_POST_FILES['little_img']['tmp_name'] != "" && $HTTP_POST_FILES['big_img']['tmp_name'] != "" && bx_image_compare($HTTP_POST_FILES['little_img']['tmp_name'], "<", $little_photo_width, $little_photo_height, $little_photo_size) && bx_image_compare($HTTP_POST_FILES['big_img']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size))
			$img_error="no";        
		else 
			$img_error="yes";
	}
	else
	{
		if ($HTTP_POST_FILES['big_img']['tmp_name'] !="" && $HTTP_POST_FILES['big_img']['tmp_name'] != "none")
			$img_error="no";        
		else 
			$img_error="yes";
	}
	if ($HTTP_POST_VARS['comment']!="" && $HTTP_POST_VARS['img_lang']=='0' && MULTILANGUAGE_SUPPORT=="on") 
		$img_lang_error="yes";        
	else 
		$img_lang_error="no";

	if ($name_error=="no" && $email_error=="no" && $category_error=="no" && $img_error =="no" && $img_lang_error=="no" && $HTTP_POST_VARS['submit'])
	{
		bx_db_insert($database_table_name ,"category_id,name,email,comment,validate,slng,added,show_images_at_home", "'".$HTTP_POST_VARS['category_type']."','".$HTTP_POST_VARS['name']."', '".$HTTP_POST_VARS['email']."', '".$HTTP_POST_VARS['comment']."', '1', '".($HTTP_POST_VARS['img_lang'] ? $HTTP_POST_VARS['img_lang'] : $slng)."', '".$today."', '0'");
		
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		$id = bx_db_insert_id();

		if ($imagemagic != "yes")
		{
			if(bx_image_compare($HTTP_POST_FILES['little_img']['tmp_name'], "<", $little_photo_width, $little_photo_height, $little_photo_size))
			{
				copy($HTTP_POST_FILES['little_img']['tmp_name'], INCOMING.$id."_".$little_img_name);
				$little_name = $id."_".$little_img_name;
			}

			if(bx_image_compare($HTTP_POST_FILES['big_img']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size))
			{
				copy($HTTP_POST_FILES['big_img']['tmp_name'], INCOMING.$id."_".$big_img_name);
				$big_name = $id."_".$big_img_name;
			}
		}
		else
		{
			if($HTTP_POST_FILES['big_img']['tmp_name'] != "none" && $HTTP_POST_FILES['big_img']['tmp_name'] != "")
			{
				$big_name = $id."_1".$HTTP_POST_FILES['big_img']['name'];
				$little_name = $id."_2".$HTTP_POST_FILES['big_img']['name'];
				
				copy($HTTP_POST_FILES['big_img']['tmp_name'], INCOMING.$big_name);

				if(bx_image_compare_nosize($HTTP_POST_FILES['big_img']['tmp_name'], ">", $big_photo_width, $big_photo_height))
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
					else{echo "<br>You must choose between convert and mogrify for image manipulation!<br>";}
				}

				copy(INCOMING.$big_name, INCOMING.$little_name);
				if(bx_image_compare_nosize($HTTP_POST_FILES['big_img']['tmp_name'], ">", $little_photo_width, $little_photo_height))
				{
					if($imagemagick_executable=="convert")
					{
						$convert_command = $imagemagic_path."convert ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
						exec($convert_command);
						if(bx_image_compare_nosize(INCOMING.$little_name, ">", $little_photo_width, $little_photo_height))
						{
							echo "<br><center><b><font size=\"2\" color=\"#FF0000\">". $imagemagic_path."convert</font> </b>didn't make the little picture!<br>";
							$imageConvertError = 1;
							echo "<br>Trying with <font size=\"2\" color=\"#FF0000\"><b>".$imagemagic_path."mogrify</font></b> ...<br>";
							$mogrify_command = "mogrify ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
							exec($mogrify_command);
							if(bx_image_compare_nosize(INCOMING.$little_name, ">", $little_photo_width, $little_photo_height))
							{
								echo "<br>Mogrify didn't make the little picture!<br>";
								$imageConvertError = 1;
								echo "<br><b><font size=\"2\" color=\"#ff0000\">Error!</font></b><br> Maybe the path to ImageMagick is incorrect (you can set the path <a href=\"".HTTP_SERVER_ADMIN."admin_site_settings.php?imagemagick=1#imagemagick\">here</a>)<br> or<br> maybe the installed ImageMagick version is very old <br>or<br> maybe the ImageMagick isn't installed <br>or <br> the picture what you use cannot be converted, try with other images! ";
							}
							echo "</center>";
						}
					}
					elseif($imagemagick_executable=="mogrify")
					{
						$mogrify_command = "mogrify ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
						exec($mogrify_command);
						if(bx_image_compare_nosize(INCOMING.$little_name, ">", $little_photo_width, $little_photo_height))
						{
							echo "<br><center><b><font size=\"2\" color=\"#FF0000\">". $imagemagic_path."mogrify</font> </b>didn't make the little picture!<br>";
							$imageConvertError = 1;
							echo "<br>Trying with <font size=\"2\" color=\"#FF0000\"><b>".$imagemagic_path."convert</font></b> ...<br>";
							
							$convert_command = $imagemagic_path."convert ".INCOMING.$little_name." -resize ".$little_photo_width."x".$little_photo_height." ".INCOMING.$little_name;
							exec($convert_command);

							if(bx_image_compare_nosize(INCOMING.$little_name, ">", $little_photo_width, $little_photo_height))
							{
								echo "<br>Convert didn't make the little picture!<br>";
								$imageConvertError = 1;
								echo "<br><b><font size=\"2\" color=\"#ff0000\">Error!</font></b><br> Maybe the path to ImageMagick is incorrect (you can set the path <a href=\"".HTTP_SERVER_ADMIN."admin_site_settings.php?imagemagick=1#imagemagick\">here</a>)<br> or<br> maybe the installed ImageMagick version is very old <br>or<br> maybe the ImageMagick isn't installed <br>or <br> the picture what you use cannot be converted, try with other images! ";
							}
							echo "</center>";
						}
					}
					else
					{
						echo "<br>You must choose between convert and mogrify for image manipulation!<br>";
						$imageConvertError = 1;
					}
				}
				
			}
		}


		$updateSQL = "update $database_table_name set little_img_name='".$little_name."', big_img_name='".$big_name."' where img_id='".$id."'";
		$update_query = bx_db_query($updateSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		if($imageConvertError != 1)
			refresh(basename($HTTP_SERVER_VARS['PHP_SELF']));
		else
		{
			echo "<a href=\"javascript:history.go(-1)\">Go Back</a>";
			exit;
		}
?>
<script language="Javascript">
<!--
alert('All done');
//-->
</script>
<?
		exit;
	}
}
include(DIR_SERVER_ADMIN."admin_picture_form.php");
include (DIR_SERVER_ADMIN."admin_footer.php");
?>