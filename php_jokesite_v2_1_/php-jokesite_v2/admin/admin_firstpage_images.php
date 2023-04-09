<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");


$database_table_name = $bx_db_table_images;
$this_file_name = "admin_firstpage_images.php";

$page_title = "First page images";
$primary_id_name = "img_id";
$primary_id = $HTTP_GET_VARS[$primary_id_name];

if ($show_images_at_home != "on")
{	
	$page_title2 = " Images will be displayed randomly on the images area.";
	$nr_of_cols = 3;
	$display_mode = "ramdom display to selected display ";
	}
else
{
	$page_title2 = " Selected images will be displayed on the pictures area.";
	$nr_of_cols = 2;
	$display_mode = " selected display to random display ";
}


if ($HTTP_GET_VARS['delete'] && $HTTP_GET_VARS['img_id']!='')
{
	$updateSQL = "update $bx_db_table_images set show_images_at_home='0' where img_id='".$HTTP_GET_VARS['img_id']."'";
	$update_query = bx_db_query($updateSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
}

$SQL = "select * from $bx_db_table_image_categories";

$from1 = $from;
$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, 100);

/***************************************************************************/
//Form is here
/***************************************************************************/
?>
<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<tr>
	<td>
<?
$count_query = bx_db_query($SQL);
echo "<br>To change from ".$display_mode." click <a href=\"".HTTP_SERVER_ADMIN."admin_site_settings.php#dislay_images\" target=\"_blank\">here</a> and press refresh button.<br>";
echo "<b>".$page_title2."</b><br><br>";
?>
	</td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="20%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Category</b></font></td>
			<td align="center" width="30%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Picture</b></font></td>
<?
if($show_images_at_home =="on")	
{
?>
			<td align="center" width="15%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Select</b></font></td>
<?}?>
		</tr>
		<form method=post action="<?=$this_file_name?>?<?=$always_get_vars?>" name="forms">
<?
if (sizeof($result_array) == 0)
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
			<td colspan="<?=$nr_of_cols?>" align="center">
				<b>There are no picture categories!</b>
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
&nbsp;				<b><?=$result_array[$i]['category_name'.$slng];?></b>
			</td>
			<td class="text" align="center">
<?
if($show_images_at_home !="on")	
{
	echo "Random display";
}
else
{
	$selectHomeSQL = "select * from $database_table_name where category_id='".$result_array[$i]['category_id']."' and show_images_at_home='1' and validate='1'";
	$selectHome_query = bx_db_query($selectHomeSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$selectHome_res = bx_db_fetch_array($selectHome_query);
	if(bx_db_num_rows($selectHome_query) !='0')
	{
	?>
<a onClick="window.open('admin_firstpage_select_category_images.php?cat_id=<?=$result_array[$i]['category_id']?>', 'images','scrollbars=1, toolbar=0, statusbar=0, width=660, height=505, left='+10+', top='+10);" href="#" ><img src="<?=HTTP_INCOMING.$selectHome_res['little_img_name']?>" border="0" alt=""></a>
<?	}
	else
	{
		echo "No selection";
	}
}
?>				
				<input type="hidden" name="<?=$primary_id_name?>[]" value="<?=$result_array[$i][$primary_id_name]?>">
			</td>
<?
if($show_images_at_home =="on")	
{
?>

			<td align="center">
				[<a onClick="window.open('admin_firstpage_select_category_images.php?cat_id=<?=$result_array[$i]['category_id']?>', 'images','scrollbars=1, toolbar=0, statusbar=0, width=660, height=505, left='+10+', top='+10);" href="#" >Change</a>]&nbsp;&nbsp;&nbsp;
<?
if($selectHome_res['img_id'] != '')
{
?>
				[<a href="<?=$this_file_name?>?img_id=<?=$selectHome_res['img_id']?>&delete=1" onClick="return confirm('Are you sure you want delete this entry?')">Delete</a>]
<?}?>
			</td>
<?}?>
		 </tr>
<?
}
?>

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

</table>
<br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>