<?
/***********************************************************************
1.config file path; 2.admin settinfg file or whereis inside; 3.page title, 
href=display_nr/display_nr/get_kene_lenne_jo ,from=item_back_from
a form is kell vigye ezeket
***********************************************************************/
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

define ("DEBUG","0");
if(DEBUG)
{
	echo "<font style=\"color:#FF0000;font-family:verdana\"><center><b>*****************DEBUG mode*****************</b></center></font>";
	postvars($HTTP_POST_VARS);
}

$database_table_name = $bx_db_table_images;
$this_file_name = "admin_edit_delete_pictures.php";

$page_title = "Edit/Delete Pictures";
$primary_id_name = "img_id";
$primary_id = $HTTP_GET_VARS[$primary_id_name];

$nr_of_cols = 4;

$get_vars = $HTTP_POST_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_POST_VARS['display_nr'] : ($HTTP_GET_VARS['display_nr'] ? "display_nr=".$display_nr=$HTTP_GET_VARS['display_nr'] : "display_nr=".$display_nr);
$get_vars .= isset($HTTP_GET_VARS['order_by']) ? "&order_by=".$HTTP_GET_VARS['order_by']."&order_type=".$HTTP_GET_VARS['order_type'] : "&order_by=".$primary_id_name."&order_type=asc";

if ($HTTP_POST_VARS['delete_button'] == "Delete Checked" || $HTTP_GET_VARS['delete_this'])	//delete via ID
{

	for( $i = 0 ; $i < sizeof($HTTP_POST_VARS[$primary_id_name]); $i++ )
	{
		if ($HTTP_POST_VARS['cycle'.$i] == "on")
		{
			$select_deleted_picture_SQL = "select * from $database_table_name where $primary_id_name='".${$primary_id_name}[$i]."'";
			$select_deleted_picture_query = bx_db_query($select_deleted_picture_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			$select_deleted_picture_result = bx_db_fetch_array($select_deleted_picture_query);

			$delete_SQL = "delete from $database_table_name where $primary_id_name='".$HTTP_POST_VARS[$primary_id_name][$i]."'";
			
			if(DEBUG)
			{
				echo INCOMING.$select_deleted_picture_result['little_img_name']."<br>";
				echo INCOMING.$select_deleted_picture_result['big_img_name'];
				echo "<br>".$delete_SQL."<br>";
			}
			else
			{
				if (file_exists(INCOMING.$select_deleted_picture_result['little_img_name']) && $select_deleted_picture_result['little_img_name'] != "")
					unlink((INCOMING.$select_deleted_picture_result['little_img_name']));
				if (file_exists(INCOMING.$select_deleted_picture_result['big_img_name']) && $select_deleted_picture_result['big_img_name'] != "")
					unlink((INCOMING.$select_deleted_picture_result['big_img_name']));
				$delete_query = bx_db_query($delete_SQL);
			}
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
	}
	
	if ($HTTP_GET_VARS['delete_this'])
	{
		//delete old pictures
		$select_deleted_picture_SQL = "select * from $database_table_name where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";
		$select_deleted_picture_query = bx_db_query($select_deleted_picture_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$select_deleted_picture_result = bx_db_fetch_array($select_deleted_picture_query);	

		$delete_SQL = "delete from $database_table_name where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";

		if(DEBUG)
		{
			echo INCOMING.$select_deleted_picture_result['little_img_name']."<br>";
			echo INCOMING.$select_deleted_picture_result['big_img_name'];
			echo "<br>".$delete_SQL."<br>";
		}
		else
		{
			if (file_exists(INCOMING.$select_deleted_picture_result['little_img_name']) && $select_deleted_picture_result['little_img_name'] != "")
				unlink((INCOMING.$select_deleted_picture_result['little_img_name']));
			if (file_exists(INCOMING.$select_deleted_picture_result['big_img_name']) && $select_deleted_picture_result['big_img_name'] != "")
				unlink((INCOMING.$select_deleted_picture_result['big_img_name']));
			$delete_query = bx_db_query($delete_SQL);
		}
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}

}
elseif (($HTTP_GET_VARS[$primary_id_name] || $HTTP_POST_VARS['submit']) && !$HTTP_GET_VARS['edit'])	//update via ID
{
	if ($HTTP_GET_VARS[$primary_id_name] && $HTTP_POST_VARS['submit'])
	{
		if ($HTTP_POST_VARS['name']=="") 
			$name_error="yes";        
		else 
			$name_error="no";

		if (empty($HTTP_POST_VARS['email'])  || (!eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs)) || (verify($HTTP_POST_VARS['email'],"string_int_email")==1))
			$email_error="yes";
		else
			$email_error="no";
		if($HTTP_POST_VARS['email'] == TEXT_ANONYMOUS)
			$email_error="no";

		if ($HTTP_POST_VARS['category_type']=="0") 
			$category_error="yes";        
		else 
			$category_error="no";
		
		if ($HTTP_POST_VARS['comment']!="" && $HTTP_POST_VARS['img_lang']=='0'  && MULTILANGUAGE_SUPPORT=="on") 
			$img_lang_error="yes";        
		else 
			$img_lang_error="no";


		$img_error ="no";

		if ($imagemagic != "yes")
		{
			if(($HTTP_POST_FILES['little_img']['tmp_name'] == "none" && $HTTP_POST_FILES['big_img']['tmp_name'] == "none") || ($HTTP_POST_FILES['little_img']['tmp_name'] == "" && $HTTP_POST_FILES['big_img']['tmp_name'] == ""))
				$img_error="no";        
			elseif ($HTTP_POST_FILES['little_img']['tmp_name'] != "none" &&  bx_image_compare($HTTP_POST_FILES['little_img']['tmp_name'], "<", $little_photo_width, $little_photo_height, $little_photo_size) && $HTTP_POST_FILES['big_img']['tmp_name'] != "none" &&  bx_image_compare($HTTP_POST_FILES['big_img']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size))
				$img_error="no";
			elseif ($HTTP_POST_FILES['little_img']['tmp_name'] != "none" &&  bx_image_compare($HTTP_POST_FILES['little_img']['tmp_name'], "<", $little_photo_width, $little_photo_height, $little_photo_size))
				$img_error="no";
			elseif ($HTTP_POST_FILES['big_img']['tmp_name'] != "none" &&  bx_image_compare($HTTP_POST_FILES['big_img']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size))
				$img_error="no";
			else 
				$img_error="yes";
		}

		if ($name_error=="no" && $email_error=="no" && $category_error=="no" && $img_error =="no"  && $img_lang_error=="no")
		{
			//delete old pictures
			$select_deleted_picture_SQL = "select * from $database_table_name where $primary_id_name='".$HTTP_GET_VARS[$primary_id_name]."'";
			$select_deleted_picture_query = bx_db_query($select_deleted_picture_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			$select_deleted_picture_result = bx_db_fetch_array($select_deleted_picture_query);

			if ($imagemagic != "yes")
			{
				if(bx_image_compare($HTTP_POST_FILES['little_img']['tmp_name'], "<", $little_photo_width, $little_photo_height, $little_photo_size))
				{
					if (file_exists(INCOMING.$select_deleted_picture_result['little_img_name']) && $select_deleted_picture_result['little_img_name'] != "")
						unlink(INCOMING.$select_deleted_picture_result['little_img_name']);
					copy($HTTP_POST_FILES['little_img']['tmp_name'], INCOMING.$select_deleted_picture_result['img_id']."_".$HTTP_POST_FILES['little_img']['name']);
					$update_img = " little_img_name='". $select_deleted_picture_result['img_id']."_".$HTTP_POST_FILES['little_img']['name']."', ";
				}
				if(bx_image_compare($HTTP_POST_FILES['big_img']['tmp_name'], "<", $big_photo_width, $big_photo_height, $big_photo_size))
				{
					if (file_exists(INCOMING.$select_deleted_picture_result['big_img_name']) && $select_deleted_picture_result['big_img_name'] != "")
						unlink(INCOMING.$select_deleted_picture_result['big_img_name']);
					copy($HTTP_POST_FILES['big_img']['tmp_name'], INCOMING.$select_deleted_picture_result['img_id']."_".$HTTP_POST_FILES['big_img']['name']);
					$update_img .= " big_img_name='". $select_deleted_picture_result['img_id']."_".$HTTP_POST_FILES['big_img']['name']."', ";
				}

					
				$update_SQL = "update $database_table_name set ".$update_img." category_id='".$HTTP_POST_VARS['category_type']."', name='".$HTTP_POST_VARS['name']."', email='".$HTTP_POST_VARS['email']."', comment='".$HTTP_POST_VARS['comment']."', validate='1' where ".$primary_id_name."='".$HTTP_GET_VARS[$primary_id_name]."'";
			}
			else
			{
				if($HTTP_POST_FILES['big_img']['tmp_name'] != "none" && $HTTP_POST_FILES['big_img']['tmp_name'] != "")
				{
					$big_name = $select_deleted_picture_result['img_id']."_1".$HTTP_POST_FILES['big_img']['name'];
					$little_name = $select_deleted_picture_result['img_id']."_2".$HTTP_POST_FILES['big_img']['name'];
					
					if (file_exists(INCOMING.$select_deleted_picture_result['big_img_name']) && $select_deleted_picture_result['big_img_name'] != "")
						unlink(INCOMING.$select_deleted_picture_result['big_img_name']);

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
						else{}
					}
					
					if (file_exists(INCOMING.$select_deleted_picture_result['little_img_name']) && $select_deleted_picture_result['little_img_name'] != "")
						unlink(INCOMING.$select_deleted_picture_result['little_img_name']);

					copy(INCOMING.$big_name, INCOMING.$little_name);
					if(bx_image_compare_nosize($HTTP_POST_FILES['big_img']['tmp_name'], ">", $little_photo_width, $little_photo_height))
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
					
					
					$update_SQL = "update $database_table_name set big_img_name='".$big_name."', little_img_name='".$little_name."', ".$update_img." category_id='".$HTTP_POST_VARS['category_type']."', name='".$HTTP_POST_VARS['name']."', email='".$HTTP_POST_VARS['email']."', comment='".$HTTP_POST_VARS['comment']."', validate='1', slng='".$HTTP_POST_VARS['img_lang']."' where ".$primary_id_name."='".$HTTP_GET_VARS[$primary_id_name]."'";
				}
				else
				{
					$update_SQL = "update $database_table_name set category_id='".$HTTP_POST_VARS['category_type']."', name='".$HTTP_POST_VARS['name']."', email='".$HTTP_POST_VARS['email']."', comment='".$HTTP_POST_VARS['comment']."', validate='1', slng='".$HTTP_POST_VARS['img_lang']."' where ".$primary_id_name."='".$HTTP_GET_VARS[$primary_id_name]."'";
				}

			}

			if(DEBUG)
				echo $update_SQL;
			else
				$update_query = bx_db_query($update_SQL);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		}
		else
			$HTTP_GET_VARS['edit'] = "edit_delete";
	}
	else{}
}
else{}

$select_position_SQL = "select * from $database_table_name";
$select_position_query = bx_db_query($select_position_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

if ($HTTP_GET_VARS['from'] > floor((bx_db_num_rows($select_position_query)-1)/$display_nr)*$display_nr)
	$from = $HTTP_GET_VARS['from'] = $HTTP_GET_VARS['from'] - $display_nr;

$always_get_vars = "&amp;from=".$always_get_vars= $HTTP_POST_VARS['from'] ? $HTTP_POST_VARS['from'] : ($HTTP_GET_VARS['from'] ? $HTTP_GET_VARS['from'] : $from)."&".$get_vars;

$condition = " where validate='1' ";

if ($HTTP_GET_VARS['order_by'] && $HTTP_GET_VARS['order_type'])
	$condition = $condition."order by ".$HTTP_GET_VARS['order_by']." ".$HTTP_GET_VARS['order_type'];

$SQL = "select * from $database_table_name ".$condition;


$from1 = $from;
$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

/***************************************************************************/
//Form is here
/***************************************************************************/
?>
<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<?
if($HTTP_GET_VARS['edit'])
{
?>
<tr>
	<td>
		<? include (DIR_SERVER_ADMIN."admin_picture_form.php");?><br>
	</td>
</tr>
<?
}
?>
<tr>
	<td>
<?
$count_query = bx_db_query($SQL);
echo "Total number of ".$page_title." <b>".bx_db_num_rows($count_query)."</b>.<br><br>";
?>
	</td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="7%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b><a href="<?=$this_file_name."?".$always_get_vars?>&order_by=<?=$primary_id_name?>&order_type=<?=$HTTP_GET_VARS['order_by'] == $primary_id_name ? ($HTTP_GET_VARS['order_type'] == "asc" ? "desc" : "asc") :  "asc"; ?>&from=0" style="color:#ffffff">ID</a></b></font></td>
			<td align="center" width="60%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Pictures</b></font></td>
			<td align="center" width="30%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Action</b></font></td>
			<td align="center" width="15%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Select</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>?<?=$always_get_vars?>" name="forms">
<?
if (sizeof($result_array) == 0)
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
			<td colspan="<?=$nr_of_cols?>" align="center">
				<b>There are no pictures!</b>
			</td>
		</tr>
<?
}

for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td class="text">
				<input type="hidden" name="display_nr" value="<?=$display_nr?>">
				<?=$result_array[$i][$primary_id_name];?>
			</td>
			<td class="text" align="center">
				<a  href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&edit=edit_delete"><img src="<?=HTTP_INCOMING.$result_array[$i]['little_img_name']?>" border="0" alt=""></a>
				<input type="hidden" name="<?=$primary_id_name?>[]" value="<?=$result_array[$i][$primary_id_name]?>">
			</td>
			<td align="center">
				[<a  href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&edit=edit_delete">View/Edit</a>]&nbsp;&nbsp;&nbsp;
				
				[<a href="<?=$this_file_name?>?<?=$always_get_vars?>&<?=$primary_id_name?>=<?=$result_array[$i][$primary_id_name];?>&delete_this=1" onClick="return confirm('Are you sure you want delete this entry?')">Delete</a>]

			</td>
			<td align="center">
				<input type="checkbox" name="cycle<?=$i?>">
			</td>
		 </tr>
<?
}
?>

		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="<?=$nr_of_cols?>" height="40">
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
				<td width="17%">
					&nbsp;
				</td>
				<td>
				</td>
				<td align="right">
				</td>
				<td align="right">
					<input type="submit" name="delete_button" value="Delete Checked" class="button" onClick="return confirm('Are you sure want delete these entries?\n This will afected jokes displaying!\nTry to rename it, it is a better solution!');" style="width:112">
				</td>
									

				</tr>
				</table>
			</td>

			</form>
		</tr>
		<tr>
			<td bgcolor="#efefef" colspan="<?=$nr_of_cols?>">
<?
	make_next_previous_with_number( $from, $SQL, $this_file_name, $get_vars ,$display_nr);
?>
			</td>
		</tr>   
		</table>
	</td>
</tr>
<tr>
	<td>
		<form method=post action="<?=$this_file_name?>?order_by=<?=$primary_id_name?>&order_type=asc">
			<br>Total number display: 
			<input type="text" name="display_nr" value="<?=$display_nr?>" class="">
			<input type="submit" name="go" value="Go" class="button">
		</form>
	</td>
</tr>
</table>
<br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>